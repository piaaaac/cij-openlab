<?php

Kirby::plugin('your/plugin', [
  'tags' => [
    'fancyquote' => require_once __DIR__ . '/tags/fancyquote.php'
  ]
]);