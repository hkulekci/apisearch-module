<?php
/**
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 * @license   MIT
 */
namespace Apisearch;


class Configuration
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $index;

    private function __construct(
        $host,
        $token = null,
        $appId = null,
        $index = null,
        $version = 'v1'
    ) {
        $this->host = $host;
        $this->token = $token;
        $this->appId = $appId;
        $this->index = $index;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getAppId(): ?string
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getIndex(): ?string
    {
        return $this->index;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param array $config
     * @return Configuration
     */
    public static function createFromArray(array $config): Configuration
    {
        return new Configuration(
            $config['host'] ?? 'http://127.0.0.1:8200/',
            $config['token'] ?? null,
            $config['appId'] ?? null,
            $config['index'] ?? null,
            $config['version'] ?? 'v1'
        );
    }
}
