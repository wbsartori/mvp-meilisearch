<?php

namespace MvpMeilisearch;

use Exception;
use Meilisearch\Endpoints\Indexes;
use MvpMeilisearch\Services\MeilisearchClient;

class DataSearch
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
     * @param string $occurrence
     * @return string
     * @throws Exception
     */
    public function getDocumentsByString(string $occurrence): string
    {
        $response = $this->run()->search($occurrence);

        if (count($response->getHits()) > 0) {
            return json_encode(['data' => $response->getHits()]);
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
    public function setHostname(string $hostname): DataSearch
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
    public function setPort(string $port): DataSearch
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
    public function setMasterkey(string $masterkey): DataSearch
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
    public function setIndexKey(string $indexKey): DataSearch
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