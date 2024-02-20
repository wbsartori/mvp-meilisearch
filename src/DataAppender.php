<?php

namespace MvpMeilisearch;

use Exception;
use Meilisearch\Endpoints\Indexes;
use MvpMeilisearch\Services\MeilisearchClient;

class DataAppender
{
    /**
     * @var MeilisearchClient
     */
    private $meilisearchClient;
    /**
     * @var string
     */
    private $hostname;
    /**
     * @var string
     */
    private $port;
    /**
     * @var string
     */
    private $masterkey;
    /**
     * @var string
     */
    private $indexKey;
    /**
     * @var array
     */
    private $filtedAttributes = [];

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
     * @param array $documents
     * @return string
     * @throws Exception
     */
    public function addNewDocuments(array $documents): string
    {
        $response = $this->run()->addDocuments($documents, Constants::PRIMARY_KEY);
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
        $updateDocument = $this->run()->updateDocuments($document, Constants::PRIMARY_KEY);

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
     * @return void
     * @throws Exception
     */
    public function addFilteredAttributes(): void
    {
        $this->run()->updateFilterableAttributes($this->filtedAttributes);
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

    /**
     * @param array $filtedAttributes
     * @return $this
     */
    public function setFiltedAttributes(array $filtedAttributes): DataAppender
    {
        $this->filtedAttributes = $filtedAttributes;
        return $this;
    }
}
