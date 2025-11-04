<?php if (isset($item['title'])) : ?>
    <h4 class="video-title mb-2"> <?= $item['title'] ?></h4>
<?php endif; ?>
<?php if (isset($item['subtitle'])) : ?>
    <h5 class="opacity-80 mb-2 text-[1rem] ">
        <?= $item['subtitle'] ?>
    </h5>
<?php endif; ?>
<?php if (isset($item['url'])) : ?>
    <div>
        <?php snippet('youtube-embed', ['url' => $item['url']]); ?>
    </div>
<?php endif; ?>