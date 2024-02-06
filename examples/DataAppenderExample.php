<?php

namespace MvpMeilisearch\Examples;

use Exception;
use MvpMeilisearch\DataAppender;

class DataAppenderExample
{
    /**
     * @param string $documentId
     * @param string $masterKey
     * @return array|void
     */
    public function getDocument(string $documentId, string $masterKey = '')
    {
        try {
            $dataAppender = new DataAppender();
            $dataAppender->setMasterkey($masterKey);
            $dataAppender->setIndexKey($documentId);
            $response = $dataAppender->getDocuments();

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
            $dataAppender = new DataAppender();
            $dataAppender->setMasterkey($masterKey);
            $dataAppender->setIndexKey($documentId);
            echo $dataAppender->addNewDocuments($data);
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
            $dataAppender = new DataAppender();
            $dataAppender->setMasterkey($masterKey);
            $dataAppender->setIndexKey($documentId);
            echo $dataAppender->updateDocument($data);
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
            $dataAppender = new DataAppender();
            $dataAppender->setMasterkey($masterKey);
            $dataAppender->setIndexKey($documentId);
            echo $dataAppender->deleteAllDocuments();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}

