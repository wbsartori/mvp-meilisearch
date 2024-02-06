<?php

namespace MvpMeilisearch\Examples;

use Exception;
use MvpMeilisearch\DataSearch;

class DataSearchExample
{
    /**
     * @var DataSearch
     */
    private $dataSearch;

    public function __construct()
    {
        $this->dataSearch = new DataSearch();
    }

    /**
     * @param string $documentId
     * @param string $masterKey
     * @param string $occurrence
     * @param array $queryParams
     * @return array|void
     */
    public function getDocumentsByString(string $documentId, string $masterKey, string $occurrence, array $queryParams = [])
    {
        try {
            $this->dataSearch->setMasterkey($masterKey);
            $this->dataSearch->setIndexKey($documentId);
            return $this->dataSearch->getDocumentsByString($occurrence, $queryParams);

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param string $documentId
     * @param array $query
     * @param string $masterKey
     * @return array|void
     */
    public function getDocuments(string $documentId, string $masterKey, array $query = [])
    {
        try {
            $this->dataSearch->setMasterkey($masterKey);
            $this->dataSearch->setIndexKey($documentId);
            return $this->dataSearch->getDocuments($query);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}

