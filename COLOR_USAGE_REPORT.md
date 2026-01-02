# Tailwind Color Usage Report

This document summarizes all usages of custom Tailwind colors defined in `tailwind.config.js`.

---

## Color Definitions (from tailwind.config.js)

| Color Name       | Hex Value   |
|------------------|-------------|
| black            | #000000     |
| transparent      | transparent |
| current          | currentColor|
| white            | #ffffff     |
| grey             | #EFEFEF     |
| gold             | #FD993C     |
| darkGold         | #C97B3A     |
| darkGrey         | #737373     |
| lightGrey        | #ebebeb     |
| red              | #ff0000     |
| goldHover        | #E8862F     |

### Removed Colors (Cleanup Dec 2025)

The following unused colors were removed:
- **charcoal** (#121212) - Never used in content
- **ligghtRed** (#fca5a5) - Never used (also had typo)
- **lightGreyHover** (#A0A0A0) - Only CSS variable, never used
- **darkGreyHover** (#E1E1E1) - Only CSS variable, never used
- **blackHover** (#323232) - Only CSS variable, never used

---

## Tailwind Class Usages by Color

### black (`#000000`)
**Tailwind Classes:** `text-black`, `bg-black`, `border-black`, `focus:border-black`

| File | Usage |
|------|-------|
| [site/snippets/social.php](site/snippets/social.php) | `bg-black` |
| [site/snippets/on_off.php](site/snippets/on_off.php) | `bg-black` |
| [site/snippets/footer.php](site/snippets/footer.php) | `bg-black`, `text-black` |
| [site/snippets/footer copy.php](site/snippets/footer copy.php) | `bg-black`, `text-black` |
| [site/snippets/header.php](site/snippets/header.php) | `bg-black` |
| [site/snippets/menu-desktop.php](site/snippets/menu-desktop.php) | `text-black` |
| [site/snippets/cookie.php](site/snippets/cookie.php) | `button black` (custom class) |
| [site/snippets/drawer.php](site/snippets/drawer.php) | `bg-black`, `text-black`, `button black` |
| [site/snippets/nav.php](site/snippets/nav.php) | `bg-black` |
| [site/snippets/apply-button.php](site/snippets/apply-button.php) | `text-black` |
| [site/snippets/form/select.php](site/snippets/form/select.php) | `focus:border-black` |
| [site/snippets/form/input.php](site/snippets/form/input.php) | `focus:border-black` |
| [site/snippets/form/date.php](site/snippets/form/date.php) | `focus:border-black` |
| [site/snippets/form/survey_checkboxes.php](site/snippets/form/survey_checkboxes.php) | `text-black` |
| [site/snippets/form/nationality.php](site/snippets/form/nationality.php) | `focus:border-black` |
| [site/snippets/blocks/button.php](site/snippets/blocks/button.php) | `text-black`, default button style |
| [site/snippets/blocks/form_jam_session.php](site/snippets/blocks/form_jam_session.php) | `text-black` |
| [site/snippets/blocks/form_next_step_button.php](site/snippets/blocks/form_next_step_button.php) | `button black` |
| [site/snippets/blocks/form_seat_options.php](site/snippets/blocks/form_seat_options.php) | `bg-black` |
| [site/snippets/blocks/home_header.php](site/snippets/blocks/home_header.php) | `bg-black` |
| [site/snippets/blocks/form_dietary_requirements.php](site/snippets/blocks/form_dietary_requirements.php) | `text-black` |
| [site/snippets/blocks/divider.php](site/snippets/blocks/divider.php) | `bg-black` |
| [site/snippets/blocks/form_accept_terms.php](site/snippets/blocks/form_accept_terms.php) | `text-black` |
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Maps `bg-black` |
| [site/plugins/cfc/panel/components/blocks/Divider.vue](site/plugins/cfc/panel/components/blocks/Divider.vue) | `tw-bg-black` |

---

### white (`#ffffff`)
**Tailwind Classes:** `text-white`, `bg-white`, `border-white`, `hover:text-white`

| File | Usage |
|------|-------|
| [site/templates/form.php](site/templates/form.php) | `hover:text-white` |
| [site/snippets/social.php](site/snippets/social.php) | `text-white`, `hover:text-gold` |
| [site/snippets/on_off.php](site/snippets/on_off.php) | `text-white`, `hover:text-gold` |
| [site/snippets/footer.php](site/snippets/footer.php) | `text-white`, `border-white`, `bg-white` |
| [site/snippets/footer copy.php](site/snippets/footer copy.php) | `text-white`, `border-white`, `bg-white` |
| [site/snippets/header.php](site/snippets/header.php) | `text-white` |
| [site/snippets/menu-desktop.php](site/snippets/menu-desktop.php) | `text-white`, `bg-white` |
| [site/snippets/drawer.php](site/snippets/drawer.php) | `text-white`, `border-white`, `bg-white` |
| [site/snippets/nav.php](site/snippets/nav.php) | `text-white` |
| [site/snippets/blocks/home_header.php](site/snippets/blocks/home_header.php) | `text-white` (multiple) |
| [site/snippets/blocks/form_seat_options.php](site/snippets/blocks/form_seat_options.php) | `text-white` |
| [site/snippets/blocks/home_why_join.php](site/snippets/blocks/home_why_join.php) | `bg-white` |
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Maps `text-white` |

---

### charcoal (`#121212`)
**Tailwind Classes:** `bg-charcoal`

| File | Usage |
|------|-------|
| [tailwind.config.js](tailwind.config.js) | Safelist: `bg-charcoal` |
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Maps `bg-charcoal` for dark backgrounds |

---

### grey (`#EFEFEF`)
**Tailwind Classes:** `bg-grey`

| File | Usage |
|------|-------|
| [site/snippets/form/select.php](site/snippets/form/select.php) | `bg-grey` |
| [site/snippets/form/input.php](site/snippets/form/input.php) | `bg-grey` |
| [site/snippets/form/date.php](site/snippets/form/date.php) | `bg-grey` |
| [site/snippets/form/survey_text.php](site/snippets/form/survey_text.php) | `bg-grey` |
| [site/snippets/form/nationality.php](site/snippets/form/nationality.php) | `bg-grey` |
| [site/snippets/blocks/form_payment.php](site/snippets/blocks/form_payment.php) | `bg-grey` |
| [site/snippets/blocks/home_why_join.php](site/snippets/blocks/home_why_join.php) | `bg-grey` |
| [site/templates/profiles.php](site/templates/profiles.php) | `button grey` (custom class) |
| [site/snippets/blocks/profiles.php](site/snippets/blocks/profiles.php) | `button grey` (custom class) |

---

### gold (`#FD993C`)
**Tailwind Classes:** `text-gold`, `bg-gold`, `border-gold`, `hover:text-gold`, `hover:bg-gold`

| File | Usage |
|------|-------|
| [site/snippets/social.php](site/snippets/social.php) | `hover:text-gold` |
| [site/snippets/apply-button.php](site/snippets/apply-button.php) | `bg-gold`, `hover:bg-goldHover` |
| [site/snippets/on_off.php](site/snippets/on_off.php) | `text-gold`, `hover:text-gold` |
| [site/snippets/footer.php](site/snippets/footer.php) | `text-gold` |
| [site/snippets/footer copy.php](site/snippets/footer copy.php) | `text-gold` |
| [site/snippets/cards/default.php](site/snippets/cards/default.php) | `hover:bg-gold` |
| [site/snippets/blocks/button.php](site/snippets/blocks/button.php) | `bg-gold`, `hover:bg-goldHover` |
| [site/snippets/blocks/form_seat_options.php](site/snippets/blocks/form_seat_options.php) | `bg-gold` |
| [site/snippets/blocks/home_header.php](site/snippets/blocks/home_header.php) | `text-gold` |
| [site/snippets/blocks/home_agenda.php](site/snippets/blocks/home_agenda.php) | `border-gold` |

---

### darkGold (`#C97B3A`)
**Tailwind Classes:** `text-darkGold`, `group-[.light-background]:text-darkGold`

| File | Usage |
|------|-------|
| [site/templates/profile.php](site/templates/profile.php) | `text-darkGold` |
| [site/snippets/blocks/profiles.php](site/snippets/blocks/profiles.php) | `text-darkGold`, `group-[.light-background]:text-darkGold` |

---

### darkGrey (`#737373`)
**Tailwind Classes:** `text-darkGrey`, `border-darkGrey`, `group-[.dark-background]:bg-darkGrey`

| File | Usage |
|------|-------|
| [site/snippets/cards/event_day_item.php](site/snippets/cards/event_day_item.php) | `text-darkGrey` |
| [site/snippets/cards/article.php](site/snippets/cards/article.php) | `text-darkGrey` |
| [site/snippets/cards/default.php](site/snippets/cards/default.php) | `group-[.dark-background]:bg-darkGrey` |
| [site/snippets/cards/event.php](site/snippets/cards/event.php) | `text-darkGrey` |
| [site/snippets/payment-summary.php](site/snippets/payment-summary.php) | `border-darkGrey` |
| [site/snippets/blocks/profiles.php](site/snippets/blocks/profiles.php) | `text-darkGrey` |

---

### lightGrey (`#ebebeb`)
**Tailwind Classes:** `bg-lightGrey`, `border-lightGrey`

| File | Usage |
|------|-------|
| [site/snippets/cards/default.php](site/snippets/cards/default.php) | `bg-lightGrey` |
| [site/snippets/cards/index.php](site/snippets/cards/index.php) | `border-lightGrey` |

---

### red (`#ff0000`)
**Tailwind Classes:** `text-red`

| File | Usage |
|------|-------|
| [site/templates/form.php](site/templates/form.php) | `text-red` |
| [site/templates/newsletter.php](site/templates/newsletter.php) | `text-red` |
| [site/snippets/blocks/form_payment.php](site/snippets/blocks/form_payment.php) | `text-red` |
| [site/snippets/blocks/newsletter.php](site/snippets/blocks/newsletter.php) | `text-red` |

---

### ligghtRed (`#fca5a5`)
**No usages found** - Note: This appears to be a typo in the config (double 'g')

---

### transparent
**Tailwind Classes:** `border-transparent`

| File | Usage |
|------|-------|
| [site/snippets/form/select.php](site/snippets/form/select.php) | `border-transparent` |
| [site/snippets/form/input.php](site/snippets/form/input.php) | `border-transparent` |
| [site/snippets/form/date.php](site/snippets/form/date.php) | `border-transparent` |
| [site/snippets/form/nationality.php](site/snippets/form/nationality.php) | `border-transparent` |

---

### goldHover (`#E8862F`)
**Tailwind Classes:** `hover:bg-goldHover`

| File | Usage |
|------|-------|
| [site/snippets/apply-button.php](site/snippets/apply-button.php) | `hover:bg-goldHover` |
| [site/snippets/blocks/button.php](site/snippets/blocks/button.php) | `hover:bg-goldHover` |

---

### lightGreyHover (`#A0A0A0`)
**No Tailwind class usages found** - Only defined as CSS variable

---

### darkGreyHover (`#E1E1E1`)
**No Tailwind class usages found** - Only defined as CSS variable

---

### blackHover (`#323232`)
**No Tailwind class usages found** - Only defined as CSS variable

---

## Direct Hex Color Usages

### #000000 / #000 (black)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-black` |
| [app/assets/css/choices.css](app/assets/css/choices.css) | Box shadow, background, border colors |
| [app/controllers/form/field/StripePayment.js](app/controllers/form/field/StripePayment.js) | Stripe element styling |
| [app/custom.css](app/custom.css) | CSS variable `--cfc-black` |
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Color mapping |
| [site/plugins/cfc/panel/components/blocks/Hero.vue](site/plugins/cfc/panel/components/blocks/Hero.vue) | Text shadow |
| [site/blueprints/blocks/button.yml](site/blueprints/blocks/button.yml) | Button color option |
| [site/blueprints/fields/blocks/layout-settings.yml](site/blueprints/fields/blocks/layout-settings.yml) | Layout background option |

---

### #ffffff / #fff (white)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-white` |
| [app/assets/css/choices.css](app/assets/css/choices.css) | Background colors |
| [app/assets/css/flatpickr.css](app/assets/css/flatpickr.css) | Background, border colors |
| [app/assets/css/croppie.css](app/assets/css/croppie.css) | Border, background |
| [app/custom.css](app/custom.css) | CSS variable `--cfc-white` |
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Color mapping |
| [site/blueprints/blocks/button.yml](site/blueprints/blocks/button.yml) | Button color option |
| [site/blueprints/fields/blocks/layout-settings.yml](site/blueprints/fields/blocks/layout-settings.yml) | Layout background option |
| [site/snippets/blocks/button.php](site/snippets/blocks/button.php) | Color mapping |

---

### #121212 (charcoal)

| File | Context |
|------|---------|
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Color mapping |
| [app/assets/fonts/remix_full/remixicon.symbol.svg](app/assets/fonts/remix_full/remixicon.symbol.svg) | SVG icon color |

---

### #EFEFEF / #efefef (grey)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-grey` |
| [app/custom.css](app/custom.css) | CSS variable `--cfc-grey` |
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Color mapping |
| [site/blueprints/fields/blocks/layout-settings.yml](site/blueprints/fields/blocks/layout-settings.yml) | Layout background option |
| [content/home/home.txt](content/home/home.txt) | Content configuration |

---

### #FD993C / #fd993c (gold)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-gold`, link color |
| [app/assets/css/typography.css](app/assets/css/typography.css) | Prose bullet color |
| [app/custom.css](app/custom.css) | CSS variable `--cfc-gold` |
| [site/plugins/cfc/src/Util/StyleMapper.php](site/plugins/cfc/src/Util/StyleMapper.php) | Color mapping |
| [site/blueprints/blocks/button.yml](site/blueprints/blocks/button.yml) | Button color option |
| [site/snippets/blocks/button.php](site/snippets/blocks/button.php) | Color mapping |
| [content/1_pre-sale/form.txt](content/1_pre-sale/form.txt) | Content configuration |

---

### #C97B3A (darkGold)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-dark-gold` |

---

### #737373 (darkGrey)

| File | Context |
|------|---------|
| Only defined in tailwind.config.js and compiled CSS | |

---

### #ebebeb (lightGrey)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-light-grey` |

---

### #ff0000 (red)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-red` |

---

### #fca5a5 (ligghtRed)

| File | Context |
|------|---------|
| Only defined in tailwind.config.js | No usages found |

---

### #A0A0A0 (lightGreyHover)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-light-grey-hover` |

---

### #E1E1E1 (darkGreyHover)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-dark-grey-hover` |

---

### #E8862F (goldHover)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-gold-hover` |

---

### #323232 (blackHover)

| File | Context |
|------|---------|
| [app/assets/css/general.css](app/assets/css/general.css) | CSS variable `--cfc-black-hover` |

---

## Summary Statistics

| Color | Tailwind Class Usages | Hex Usages | Total Files |
|-------|----------------------|------------|-------------|
| black | 25+ | 8+ | 30+ |
| white | 15+ | 8+ | 20+ |
| gold | 10+ | 6+ | 15+ |
| grey | 9+ | 5+ | 12+ |
| darkGrey | 6 | 1 | 7 |
| darkGold | 3 | 1 | 4 |
| lightGrey | 2 | 2 | 4 |
| red | 4 | 1 | 5 |
| charcoal | 2 | 2 | 3 |
| goldHover | 2 | 1 | 3 |
| transparent | 4 | 0 | 4 |
| lightGreyHover | 0 | 1 | 1 |
| darkGreyHover | 0 | 1 | 1 |
| blackHover | 0 | 1 | 1 |
| ligghtRed | 0 | 0 | 0 |

---

## Notes & Observations

1. **Typo in config:** `ligghtRed` has a typo (double 'g') and is never used in the codebase.

2. **Hover colors underutilized:** `lightGreyHover`, `darkGreyHover`, and `blackHover` are only defined as CSS variables but never used as Tailwind classes.

3. **Most used colors:** `black`, `white`, and `gold` are the most frequently used colors throughout the codebase.

4. **CSS Variables:** Most colors are also defined as CSS custom properties in `app/assets/css/general.css` for use outside of Tailwind classes.

5. **Duplicate file:** `site/snippets/footer copy.php` appears to be a duplicate of `site/snippets/footer.php`.

6. **Panel styling:** The Kirby panel uses `tw-` prefixed classes (e.g., `tw-bg-black`) in Vue components.

---

*Report generated: December 2025*
