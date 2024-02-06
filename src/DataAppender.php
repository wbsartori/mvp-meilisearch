<?php

namespace MvpMeilisearch;

use Exception;
use Meilisearch\Contracts\DeleteTasksQuery;
use Meilisearch\Contracts\DocumentsQuery;
use Meilisearch\Contracts\DocumentsResults;
use Meilisearch\Endpoints\Indexes;
use MvpMeilisearch\Services\MeilisearchClient;

class DataAppender
{
    /**
     * @var MeilisearchClient
     */
    private MeilisearchClient $meilisearchClient;
    /**
     * @var string
     */
    private string $hostname;
    /**
     * @var string
     */
    private string $port;
    /**
     * @var string
     */
    private string $masterkey;
    /**
     * @var string
     */
    private string $indexKey;

    /**
     * @return Indexes
     */
    private function run(): Indexes
    {
        $this->setMeilisearchClient(new MeilisearchClient());
        $meilisearch = $this->getMeilisearchClient();
        $meilisearch->init(
            $this->getHostname(),
            $this->getPort(),
            $this->getMasterkey(),
            $this->getIndexKey()
        );
        return $meilisearch->getClient()->index($meilisearch->getIndex());
    }

    /**
     * @return DocumentsResults
     * @throws Exception
     */
    public function getDocuments(): DocumentsResults
    {
        $query = new DocumentsQuery();
        return $this->run()->getDocuments($query);
    }

    /**
     * @param array $documents
     * @return string
     * @throws Exception
     */
    public function addNewDocuments(array $documents): string
    {
        $response = $this->run()->addDocuments($documents);
        if ($response) {
            return Constants::SUCCESS_DOCUMENTS;
        }

        throw new Exception(Constants::ERROR_DOCUMENTS);
    }

    /**
     * @param array $document
     * @return string
     * @throws Exception
     */
    public function updateDocument(array $document): string
    {
        $updateDocument = $this->run()->updateDocuments($document);

        if ($updateDocument) {
            return Constants::SUCCESS_DOCUMENTS;
        }

        throw new Exception(Constants::ERROR_DOCUMENTS);
    }

    /**
     * @param string $documentId
     * @return string
     * @throws Exception
     */
    public function deleteDocumentById(string $documentId): string
    {
        $response = $this->run()->deleteDocument($documentId);

        if ($response['taskUid'] > 0) {
            return Constants::SUCCESS_DOCUMENTS;
        }

        throw new Exception(Constants::ERROR_DOCUMENTS);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function deleteAllDocumentsOfIndex(): string
    {
        $response = $this->run()->deleteAllDocuments();

        if ($response['taskUid'] > 0) {
            return Constants::SUCCESS_DOCUMENTS;
        }

        throw new Exception(Constants::ERROR_DOCUMENTS);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function deleteAllDocuments(): string
    {
        $response = $this->run()->delete();

        if ($response['taskUid'] > 0) {
            return Constants::SUCCESS_DOCUMENTS;
        }

        throw new Exception(Constants::ERROR_DOCUMENTS);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function tasksDelete(): string
    {
        $tasks = $this->run()->getTasks();

        foreach ($tasks->getIterator() as $task) {
            $newTask[] = $task['uid'];
        }

        $deletaTaskQuery = new DeleteTasksQuery();
        $deletaTaskQuery->setUids($newTask);
        $response = $this->run()->deleteTasks($deletaTaskQuery);

        if ($response['taskUid'] > 0) {
            return Constants::SUCCESS_DOCUMENTS;
        }

        throw new Exception(Constants::ERROR_DOCUMENTS);
    }

    /**
     * @param MeilisearchClient $meilisearchClient
     * @return void
     */
    public function setMeilisearchClient(MeilisearchClient $meilisearchClient)
    {
        $this->meilisearchClient = $meilisearchClient;
    }

    /**
     * @return MeilisearchClient
     */
    public function getMeilisearchClient(): MeilisearchClient
    {
        return $this->meilisearchClient;
    }

    /**
     * @param string $hostname
     * @return void
     */
    public function setHostname(string $hostname): DataAppender
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        if (empty($this->hostname)) {
            $this->setHostname(Constants::SERVER_NAME);
        }
        return $this->hostname;
    }

    /**
     * @param string $port
     * @return $this
     */
    public function setPort(string $port): DataAppender
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        if (empty($this->port)) {
            $this->setPort(Constants::SERVER_PORT);
        }
        return $this->port;
    }

    /**
     * @param string $masterkey
     * @return $this
     */
    public function setMasterkey(string $masterkey): DataAppender
    {
        $this->masterkey = $masterkey;
        return $this;
    }

    /**
     * @return string
     */
    public function getMasterkey(): string
    {
        if (empty($this->masterkey)) {
            $this->setMasterkey('');
        }
        return $this->masterkey;
    }

    /**
     * @param string $indexKey
     * @return $this
     */
    public function setIndexKey(string $indexKey): DataAppender
    {
        $this->indexKey = $indexKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndexKey(): string
    {
        if (empty($this->indexKey)) {
            $this->setIndexKey(Constants::PATTERN_INDEX);
        }
        return $this->indexKey;
    }
}
