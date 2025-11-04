<?php

return [
    'html' => function ($tag) {
        $url = $tag->value;
        return sprintf('
<div class="map-responsive">
<iframe src="%s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
 </div>
 
 ', $url);
    }
];