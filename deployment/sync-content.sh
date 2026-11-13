#!/usr/bin/env bash

set -euo pipefail

script_directory="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
release_directory="${FORGE_RELEASE_DIRECTORY:-}"
current_directory="${FORGE_SITE_PATH:-}"
state_directory="${CFC_DEPLOYMENT_STATE_PATH:-${HOME}/.cfc-deployment}"
php_binary="${FORGE_PHP:-php}"

if [[ -z "${release_directory}" || ! -d "${release_directory}/.git" ]]; then
    echo "FORGE_RELEASE_DIRECTORY must point to the new Forge release." >&2
    exit 1
fi

if [[ ! -L "${release_directory}/content" ]]; then
    echo "${release_directory}/content is not a symlink." >&2
    echo "Add content as a Forge shared directory before deploying." >&2
    exit 1
fi

production_directory="$(readlink -f "${release_directory}/content")"

if [[ -z "${production_directory}" || "${production_directory}" == "/" ]]; then
    echo "Could not resolve the persistent production content directory." >&2
    exit 1
fi

mkdir -p "${production_directory}" "${state_directory}"

lock_directory=""
if command -v flock >/dev/null 2>&1; then
    exec 9>"${state_directory}/content-sync.lock"
    if ! flock -w 60 9; then
        echo "Another content synchronization is already running." >&2
        exit 1
    fi
else
    lock_directory="${state_directory}/content-sync.lock.d"
    if ! mkdir "${lock_directory}" 2>/dev/null; then
        echo "Another content synchronization is already running." >&2
        exit 1
    fi
fi

temporary_directory="$(mktemp -d "${TMPDIR:-/tmp}/cfc-content-sync.XXXXXX")"
cleanup() {
    rm -rf "${temporary_directory}"
    if [[ -n "${lock_directory}" ]]; then
        rmdir "${lock_directory}" 2>/dev/null || true
    fi
}
trap cleanup EXIT

mkdir -p "${temporary_directory}/incoming"
git -C "${release_directory}" archive --format=tar HEAD content \
    | tar -xf - -C "${temporary_directory}/incoming"
incoming_directory="${temporary_directory}/incoming/content"

baseline_directory="${state_directory}/content-baseline"

if [[ ! -d "${baseline_directory}" ]]; then
    current_content="${current_directory}/content"

    if [[ -d "${current_content}" && "$(readlink -f "${current_content}")" != "${production_directory}" ]]; then
        if [[ -z "$(find "${production_directory}" -mindepth 1 -print -quit)" ]]; then
            echo "Seeding persistent content from the active production release."
            cp -a "${current_content}/." "${production_directory}/"
        fi

        mkdir -p "${temporary_directory}/baseline"
        git -C "${current_directory}" archive --format=tar HEAD content \
            | tar -xf - -C "${temporary_directory}/baseline"
        mv "${temporary_directory}/baseline/content" "${baseline_directory}"
    else
        echo "No previous release found; using the incoming Git content as the baseline."
        cp -a "${incoming_directory}" "${baseline_directory}"

        if [[ -z "$(find "${production_directory}" -mindepth 1 -print -quit)" ]]; then
            cp -a "${incoming_directory}/." "${production_directory}/"
        fi
    fi
fi

commit="$(git -C "${release_directory}" rev-parse HEAD)"

"${php_binary}" "${script_directory}/sync-content.php" \
    "${baseline_directory}" \
    "${incoming_directory}" \
    "${production_directory}" \
    "${state_directory}" \
    "${commit}"

printf '%s\n' "${commit}" > "${state_directory}/content-baseline-commit"
