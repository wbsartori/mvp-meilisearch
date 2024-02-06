<?php

namespace MvpMeilisearch\Services;

use MeiliSearch\Client;
use MvpMeilisearch\Constants;

class MeilisearchClient
{
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
    private string $masterKey;

    private Client $client;
    /**
     * @var string
     */
    private string $index;

    /**
     * @param string $hostname
     * @param string $port
     * @param string $masterkey
     * @param string $index
     * @return void
     */
    public function init(
        string $hostname = Constants::SERVER_NAME,
        string $port = Constants::SERVER_PORT,
        string $masterkey = Constants::SERVER_MASTER_KEY,
        string $index = Constants::PATTERN_INDEX
    ): void
    {
        $this->setHostname($hostname);
        $this->setPort($port);
        $this->setMasterKey($masterkey);
        $this->setIndex($index);
        $this->setClient();
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     * @return $this
     */
    public function setHostname(string $hostname): MeilisearchClient
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     * @return $this
     */
    public function setPort(string $port): MeilisearchClient
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getMasterKey(): string
    {
        return $this->masterKey;
    }

    /**
     * @param string $masterKey
     * @return $this
     */
    public function setMasterKey(string $masterKey): MeilisearchClient
    {
        $this->masterKey = $masterKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @param string $index
     * @return $this
     */
    public function setIndex(string $index): MeilisearchClient
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return void
     */
    public function setClient(): void
    {
        if (!$this->getHostname()) {
            $this->setHostname(Constants::SERVER_NAME);
        }

        if (!$this->getPort()) {
            $this->setPort(Constants::SERVER_PORT);
        }

        if (!$this->getMasterKey()) {
            $this->client = (new Client($this->getHostname() . ":" . $this->getPort()));
        } else {
            $this->client = (new Client($this->getHostname() . ":" . $this->getPort(), $this->getMasterKey()));
        }
    }
}
