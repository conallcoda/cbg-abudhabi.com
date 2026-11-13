# CfC St. Moritz Abu Dhabi

The [cfc-abudhabi.com](https://cfc-abudhabi.com) website, built with [Kirby](https://getkirby.com) 5.

## Local development

Requirements: PHP 8.3 (the site is served by [Herd](https://herd.laravel.com), isolated to 8.3), Composer, Node and
[Mailpit](https://mailpit.axllent.org).

```bash
composer install
npm ci
cp .env.example .env     # then fill in the keys (see below)
herd link cfc-abudhabi --secure --isolate=8.3
mailpit                  # inbox at http://127.0.0.1:8025
```

The site runs at https://cfc-abudhabi.test, the Panel at https://cfc-abudhabi.test/panel.

Large original images need more than PHP's default 128M to be resized into thumbnails; set
`memory_limit = 256M` in the php.ini of Herd's PHP 8.3 (the production server uses 256M).

### Front-end assets

`app/main.js` and `app/main.css` are bundled with Parcel into `assets/dist`, which is committed and served as is.

```bash
npm run dev     # watch and rebuild
npm run build   # production build
```

## Environment configuration

All environment-specific configuration is read from `.env` by
[`bnomei/kirby3-dotenv`](https://plugins.getkirby.com/bnomei/dotenv) in `site/config/config.php`. `.env.example`
lists every setting; `.env` itself is never committed.

- **`APP_ENV`** is `local`, `staging` or `production`. Debug output is only possible when it is `local`, Google
  Analytics only loads in `production`, and everything except production (and the Panel everywhere) is sent with
  `X-Robots-Tag: noindex`. The Panel shows a coloured environment marker (`assets/panel`).
- **Email.** Production sends through Mailgun (`MAIL_MAILER=mailgun`). Local and staging must use
  `MAIL_MAILER=mailpit` — the site refuses to start otherwise — so no email reaches a real person.
  `FORM_EMAIL_ENABLED=false` turns form emails off entirely, `FORM_EMAIL_OVERRIDE_TO` sends all of them to one address.
- **Mailchimp.** The newsletter form subscribes to the real list (`MAILCHIMP_LIST_ID`) in every environment.

Production needs at minimum:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://cfc-abudhabi.com
KIRBY_PANEL_INSTALL=false
KIRBY_CACHE_PAGES=true
MAIL_MAILER=mailgun
```

plus the Stripe, Mailgun and Mailchimp keys from `.env.example`.

## Deployment (Laravel Forge)

The site is moving from Hostpoint to Forge. Pushing to `main` (production) or `staging` triggers the Forge deploy hook
from `.github/workflows/deploy.yml`; until the `FORGE_ABUDHABI_PRODUCTION_DEPLOY_HOOK` /
`FORGE_ABUDHABI_STAGING_DEPLOY_HOOK` repository secrets are set the job skips with a notice.

### Persistent Kirby data

Configure these Forge zero-downtime shared paths in the site's deployment settings (Forge shares `.env`
automatically; do not share `site/cache`):

| Persistent source | Release path | Type |
| --- | --- | --- |
| `content` | `content` | Directory |
| `media` | `media` | Directory |
| `site/accounts` | `site/accounts` | Directory |
| `site/sessions` | `site/sessions` | Directory |
| `site/logs` | `site/logs` | Directory |
| `site/config/.license` | `site/config/.license` | File |

Before enabling them for the first time, copy the live data (from Hostpoint) into the persistent source paths.

### Deployment script

```bash
$CREATE_RELEASE()

cd "$FORGE_RELEASE_DIRECTORY"

$FORGE_COMPOSER install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

bash deployment/sync-content.sh
bash deployment/link-large-files.sh

$ACTIVATE_RELEASE()
```

`sync-content.sh` does a three-way comparison between the previous Git baseline, the incoming Git commit and the
persistent production content, because editors change content in the Panel while developers change it in Git:

- Git-only changes are applied to production; Panel-only changes are left untouched.
- If Git and the Panel changed the same path differently, the deployment stops before activation and production is
  not modified. The report is at `$HOME/.cfc-deployment/conflicts/latest.txt`; merge the production file into Git,
  commit and deploy again.
- Before Git overwrites or deletes an unchanged production file, its previous version is copied below
  `$HOME/.cfc-deployment/backups/`.

Its scenarios are tested by `php deployment/tests/sync-content.php`.

`link-large-files.sh` symlinks large binaries kept out of Git (below `$HOME/shared-files`) into each release, as
listed in `deployment/large-files.manifest` (currently empty). A missing shared file fails the deployment before
activation.

### Swoole

Forge enables Swoole, which defines a global `go()` function, so `index.php` disables Kirby's `go()` helper. Use
`Kirby\Cms\Response::go()` for redirects.
