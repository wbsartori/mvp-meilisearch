<?php

namespace MvpMeilisearch\Services;

use MeiliSearch\Client;
use MvpMeilisearch\Constants;

class MeilisearchClient
{
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
    private $masterKey;

    private $client;
    /**
     * @var string
     */
    private $index;

    /**
     * @param string $hostname
     * @param string $port
     * @param string $masterkey
     * @param string $index
     * @return void
     */
    public function init(
        string $hostname = '',
        string $port = '',
        string $masterkey = '',
        string $index = ''
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
        if(empty($hostname)) {
            $this->hostname = Constants::SERVER_NAME;
        } else {
            $this->hostname = $hostname;
        }
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
        if(empty($port)) {
            $this->port = Constants::SERVER_PORT;
        } else{
            $this->port = $port;
        }
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
        if(empty($masterKey)) {
            $this->masterKey = Constants::SERVER_MASTER_KEY;
        } else {
            $this->masterKey = $masterKey;
        }
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
        if(empty($index)) {
            $this->index = Constants::PATTERN_INDEX;
        } else {
            $this->index = $index;
        }
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
        $this->client = (new Client($this->getHostname() . ":" . $this->getPort(), $this->getMasterKey()));
    }
}
