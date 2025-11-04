<?php

return function ($config, $items) {


    $data = [
        'paginate' => false,
        'controllerAttr' => '',
        'containerAttr' => '',
        '_items' => $items
    ];

    if (empty($config)) {
        return $data;
    }

    $limit = (int)$config['limit'];
    $currentPage = get($config['id'] . '_page', 1);

    $totalItems = count($items);
    $totalPages = ceil($totalItems / $limit);
    $offset = ($currentPage - 1) * $limit;
    $items = $items->offset($offset)->limit($limit);

    $controllerConfig = [
        'id' => $config['id'],
        'page' => $currentPage,
        'total' => $totalPages,
    ];

    if ($totalPages > 1) {
        $data['paginate'] = true;
        $data['controllerAttr'] = implode(" ", [
            'data-controller="infinite-scroll"',
            sprintf('data-infinite-scroll-config="%s"', base64_encode(json_encode($controllerConfig))),
        ]);

        $data['containerAttr'] = implode(" ", [
            sprintf('id="scroll_%s"', $config['id']),
            'data-infinite-scroll-target="container"'
        ]);
        $data['_items'] = $items;
    }
    return $data;
};
