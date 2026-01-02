<?php
/**
 * Unified button component
 *
 * @param string $text Button text
 * @param string $url URL for the button (can be a Kirby link field or raw URL)
 * @param string $theme Button theme: gold, sand, black, grey, white, neutral, zinc, auto (default: auto)
 * @param bool $newTab Open in new tab (default: false)
 * @param bool $rounded Apply rounded-3xl styling (default: false, true for gold)
 * @param bool $uppercase Apply uppercase styling (default: false, true for gold)
 * @param string $customClass Additional CSS classes
 * @param array $dataAttributes Data attributes as key => value pairs
 * @param string $element Element type: 'a' or 'button' (default: 'a')
 * @param string $action Stimulus action attribute value
 * @param string $icon Icon class (e.g., 'ri-arrow-left-line')
 * @param string $iconPosition Icon position: 'left' or 'right' (default: 'left')
 */

$text = $text ?? 'Click here';
$url = $url ?? '#';
$theme = $theme ?? 'auto';
$newTab = $newTab ?? false;
$rounded = $rounded ?? ($theme === 'gold');
$uppercase = $uppercase ?? ($theme === 'gold');
$customClass = $customClass ?? '';
$dataAttributes = $dataAttributes ?? [];
$element = $element ?? 'a';
$action = $action ?? null;
$icon = $icon ?? null;
$iconPosition = $iconPosition ?? 'left';

// Build data attributes string
$dataString = '';
if ($action) {
    $dataString .= ' data-action="' . htmlspecialchars($action) . '"';
}
foreach ($dataAttributes as $key => $value) {
    $dataString .= ' data-' . $key . '="' . htmlspecialchars($value) . '"';
}

// Target attribute (only for links)
$target = ($element === 'a' && $newTab) ? ' target="_blank" rel="noopener noreferrer"' : '';

// Build class string
$classes = 'button ' . $theme;
if ($rounded) {
    $classes .= ' rounded-3xl';
}
if ($uppercase) {
    $classes .= ' uppercase';
}
if ($theme === 'gold') {
    $classes .= ' !text-xs !font-bold';
}
if ($customClass) {
    $classes .= ' ' . $customClass;
}

// Build content with optional icon
$iconHtml = $icon ? '<i class="' . htmlspecialchars($icon) . '"></i>' : '';
$content = $iconPosition === 'left'
    ? ($iconHtml ? $iconHtml . ' ' : '') . '<span>' . $text . '</span>'
    : '<span>' . $text . '</span>' . ($iconHtml ? ' ' . $iconHtml : '');

if ($element === 'button'): ?>
<button class="<?= $classes ?>"<?= $dataString ?>><?= $content ?></button>
<?php else: ?>
<a href="<?= $url ?>" class="<?= $classes ?>"<?= $target ?><?= $dataString ?>><?= $content ?></a>
<?php endif; ?>
