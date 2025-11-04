<?php



$items = [];
foreach ($block->sources()->toStructure() as $item) {
  $page = $item->source()->_page();
  if (!$page) continue;
  $pageId = $page->uuid()->id();
  if ($page instanceof BlogPage) {


    $filterTags = get('tags', []);
    $articles = $page->children()->unlisted()->template('article');
    if (!empty($filterTags)) {
      $articles = $articles->filter(function ($article) use ($filterTags) {
        return $article->hasTags($filterTags);
      });
    }

    $items[] = [
      'id' => $pageId,
      'type' =>  'blog',
      'title' => (string)$item->title()->or((string)$page->title()),
      'description' => (string)$item->description(),
      'articles' => $articles->sortBy('date', 'desc'),
      'tags' => $page->_tags(),
      'pagination' => [
        'limit' => 24,
        'id' => sprintf('%s_%s', $block->id(), $pageId)
      ]
    ];
  } else {
    $items[] = [
      'id' => $pageId,
      'tags' => [],
      'type' =>  'summaries',
      'title' => (string)$item->title()->or((string)$page->title()),
      'description' => (string)$item->description(),
      'source' => $page,
    ];
  }
}

?>

<div class="blog-index" data-controller="tabs">

  <?php if (count($items) > 0) : ?>
    <div class="button-toggles mb-8">
      <?php $i = 0;
      foreach ($items as $item) :
      ?>
        <a data-tab-toggle-id="source_<?= $item['id'] ?>" data-action="tabs#toggle" class="tab-toggle button <?= $i === 0 ? 'active' : '' ?>"><?= $item['title'] ?></a>
      <?php
        $i++;
      endforeach; ?>
    </div>
  <?php endif; ?>

  <?php $i = 0;
  foreach ($items as $item) : ?>

    <div class="article-list tab-item <?= $i === 0 ? 'active' : '' ?>" data-tab-item-id="source_<?= $item['id'] ?>">
      <div>
        <?= $item['description'] ?>
      </div>

      <?php if (!empty($item['tags'])): ?>
        <div data-controller="tag-filter" class="mt-6" data-items="<?= base64_encode(json_encode($filterTags ?? [])) ?>" data-container-id="<?= $item['id'] ?>">
          <select data-tag-filter-target="input" class="w-full" multiple="multiple" data-placeholder="Filter by tags">
            <?php foreach ($item['tags'] as $tag) : ?>
              <option value="<?= $tag['value'] ?>"><?= $tag['label'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif; ?>
      <div id="tag_<?= $item['id'] ?>">
        <?php if ($item['type'] === 'summaries'): ?>
          <?php snippet('blocks/event_summaries', ['source' => $item['source'], 'blockId' => $block->id()]) ?>
        <?php else: ?>
          <?php snippet('cards/index', ['items' => $item['articles'], 'pagination' => $item['pagination']]) ?>
        <?php endif; ?>
      </div>
    </div>
  <?php $i++;
  endforeach; ?>
</div>