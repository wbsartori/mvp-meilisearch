<?php

use MvpMeilisearch\Services\MeilisearchClient;

require dirname(__DIR__) . 'vendor/autoload.php';

$client = (new MeilisearchClient())
    ->setIndex('customers')
    ->init();

$documents = [
    ['id' => 1,  'title' => 'Carol', 'genres' => ['Romance, Drama']],
    ['id' => 2,  'title' => 'Wonder Woman', 'genres' => ['Action, Adventure']],
    ['id' => 3,  'title' => 'Life of Pi', 'genres' => ['Adventure, Drama']],
    ['id' => 4,  'title' => 'Mad Max: Fury Road', 'genres' => ['Adventure, Science Fiction']],
    ['id' => 5,  'title' => 'Moana', 'genres' => ['Fantasy, Action']],
    ['id' => 6,  'title' => 'Philadelphia', 'genres' => ['Drama']],
];

$client->addDocuments($documents);