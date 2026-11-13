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

The site runs on the Forge server `cfc` (157.90.160.165, PHP 8.5) as an isolated site with user `cfc-abudhabi-web`,
deployed in place from `main` like the St. Moritz website: the checkout in `/home/cfc-abudhabi-web/<domain>` is both
the Git working copy and the live site, so `content`, `media`, `site/accounts`, `site/sessions`, `site/logs`,
`site/config/.license` and `.env` simply stay where they are between deployments. It moved from Hostpoint in
November 2026.

Quick deploy is off. After pushing to `main`, trigger the site's Forge deploy hook (or deploy from Forge).

### Deployment script

```bash
set -euo pipefail

cd "$FORGE_SITE_PATH"

git fetch origin "$FORGE_SITE_BRANCH"
git checkout "$FORGE_SITE_BRANCH"
git pull --ff-only origin "$FORGE_SITE_BRANCH"

$FORGE_COMPOSER install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

bash deployment/link-large-files.sh

if [ -d site/cache ]; then
    find site/cache -mindepth 1 -delete
fi
```

Content is in Git and is also edited in the Panel on the server. The pull is fast-forward only, so if editors changed
content on the server, commit and push those changes from the server first (or merge them) before deploying.

Files kept out of Git and copied over by hand: `site/accounts`, `site/config/.license`, form submissions
(`content/**/submissions/*`), `assets/lg` and `assets/video/cfc_landscape.mp4`.

### nginx

nginx ignores `.htaccess`, so the site's nginx config blocks Kirby's folders and the repository's own files and lets
Kirby answer instead:

```nginx
rewrite ^/(content|site|kirby|app|data|deployment|docs|scripts|tests|vendor|releases)(/|$) /index.php last;
rewrite ^/(?!favicon\.ico$|index\.php$)[^/]+\.[A-Za-z0-9]+$ /index.php last;
```

`deployment/sync-content.sh` (a three-way content merge for zero-downtime releases) is not used by this setup.

### Swoole

Forge enables Swoole, which defines a global `go()` function, so `index.php` disables Kirby's `go()` helper. Use
`Kirby\Cms\Response::go()` for redirects.
