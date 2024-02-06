<?php

namespace MvpMeilisearch\Examples;

use Exception;
use MvpMeilisearch\DataAppender;
use MvpMeilisearch\DataSearch;

class DataAppenderExample
{
    /**
     * @var DataAppender
     */
    private $dataAppender;
    /**
     * @var DataSearch
     */
    private $dataSearch;

    public function __construct()
    {
        $this->dataAppender = new DataAppender();
        $this->dataSearch = new DataSearch();
    }

    /**
     * @param string $documentId
     * @param string $masterKey
     * @return array|void
     */
    public function getDocument(string $documentId, string $masterKey = '')
    {
        try {
            $this->dataAppender->setMasterkey($masterKey);
            $this->dataAppender->setIndexKey($documentId);
            $response = $this->dataAppender->getDocuments();

            return ['data' => $response->getIterator()];
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param string $documentId
     * @param array $data
     * @param string $masterKey
     * @return void
     */
    public function addDocument(string $documentId, array $data = [], string $masterKey = ''): void
    {
        try {
            $this->dataAppender->setMasterkey($masterKey);
            $this->dataAppender->setIndexKey($documentId);
            echo $this->dataAppender->addNewDocuments($data);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param string $documentId
     * @param array $data
     * @param string $masterKey
     * @return void
     */
    public function updateDocument(
        string $documentId,
        array  $data,
        string $masterKey = '')
    {
        try {
            $this->dataAppender->setMasterkey($masterKey);
            $this->dataAppender->setIndexKey($documentId);
            echo $this->dataAppender->updateDocument($data);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param string $documentId
     * @param string $masterKey
     * @return void
     */
    public function delete(string $documentId, string $masterKey = '')
    {
        try {
            $this->dataAppender->setMasterkey($masterKey);
            $this->dataAppender->setIndexKey($documentId);
            echo $this->dataAppender->deleteAllDocuments();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param string $documentId
     * @param string $occurrence
     * @param string $masterKey
     * @return string
     */
    public function search(string $documentId, string $occurrence, string $masterKey = ''): string
    {
        try {
            $this->dataSearch->setMasterkey($masterKey);
            $this->dataSearch->setIndexKey($documentId);
            return $this->dataSearch->getDocumentsByString($occurrence);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}
