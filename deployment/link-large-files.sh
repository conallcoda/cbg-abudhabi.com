#!/usr/bin/env bash

set -euo pipefail

script_directory="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
project_directory="$(cd "${script_directory}/.." && pwd)"
manifest="${script_directory}/large-files.manifest"
deployment_directory="${FORGE_RELEASE_DIRECTORY:-${FORGE_SITE_PATH:-${project_directory}}}"
shared_directory="${CFC_SHARED_FILES_PATH:-${HOME}/shared-files}"

missing=0

while IFS='|' read -r shared_path deployed_path; do
    if [[ -z "${shared_path}" || "${shared_path}" == \#* ]]; then
        continue
    fi

    if [[ "${shared_path}" == /* || "${deployed_path}" == /* || "${shared_path}" == *..* || "${deployed_path}" == *..* ]]; then
        echo "Unsafe path in ${manifest}: ${shared_path}|${deployed_path}" >&2
        exit 1
    fi

    source_file="${shared_directory}/${shared_path}"
    destination_file="${deployment_directory}/${deployed_path}"

    if [[ ! -f "${source_file}" ]]; then
        echo "Missing shared file: ${source_file}" >&2
        missing=1
        continue
    fi

    mkdir -p "$(dirname "${destination_file}")"

    if [[ -e "${destination_file}" && ! -L "${destination_file}" ]]; then
        echo "Refusing to replace non-symlink: ${destination_file}" >&2
        exit 1
    fi

    ln -sfn "${source_file}" "${destination_file}"
    echo "Linked ${deployed_path}"
done < "${manifest}"

if [[ "${missing}" -ne 0 ]]; then
    echo "Upload the missing files to ${shared_directory} and deploy again." >&2
    exit 1
fi
