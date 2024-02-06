<?php

namespace MvpMeilisearch\Examples;

use Exception;
use MvpMeilisearch\DataSearch;

class DataSearchExample
{
    public function run()
    {
        try {
            $dataSearch = new DataSearch();
            $dataSearch->getDocumentsById('chave');
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}

