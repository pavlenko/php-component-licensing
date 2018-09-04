<?php

namespace PE\Component\Licensing\Client;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\CryptoException;
use Defuse\Crypto\Key;
use PE\Component\Licensing\Exception\ClientException;
use PE\Component\Licensing\Exception\LicenseNotFoundException;
use PE\Component\Licensing\Model\LicenseInterface;
use Psr\SimpleCache\CacheInterface;

class Client implements ClientInterface
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * @var string
     */
    private $serverKey;

    /**
     * @var string
     */
    private $serverURL;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var int
     */
    private $cacheTTL;

    /**
     * @param \GuzzleHttp\Client $http
     * @param string             $serverKey
     * @param string             $serverURL
     * @param CacheInterface     $cache
     * @param int                $cacheTTL
     */
    public function __construct(
        \GuzzleHttp\Client $http,
        string $serverKey,
        string $serverURL,
        CacheInterface $cache,
        int $cacheTTL = 3600
    ) {
        $this->http      = $http;
        $this->serverKey = $serverKey;
        $this->serverURL = $serverURL;
        $this->cache     = $cache;
        $this->cacheTTL  = $cacheTTL;
    }

    /**
     * @inheritDoc
     */
    public function requestLicenseForKey(string $key): LicenseInterface
    {
        try {
            $license = $this->cache->get($key);

            if (!$license) {
                $serverKey = Key::loadFromAsciiSafeString($this->serverKey);

                $response = $this->http->request('POST', $this->serverURL, [
                    'body' => Crypto::encrypt($key, $serverKey)
                ]);

                $body = (string) $response->getBody();

                $license = $body
                    ? unserialize(Crypto::decrypt($body, $serverKey))
                    : null;

                if (!$license) {
                    throw new LicenseNotFoundException();
                }

                if (is_object($license) && !($license instanceof LicenseInterface)) {
                    throw new ClientException('Invalid data');
                }

                $this->cache->set($key, $license, $this->cacheTTL);
            }

            return $license;
        } catch (\Psr\SimpleCache\InvalidArgumentException $ex) {
            throw new ClientException('Check failed', 0, $ex);
        } catch (\GuzzleHttp\Exception\GuzzleException $ex) {
            throw new ClientException('Check failed', 0, $ex);
        } catch (CryptoException $ex) {
            throw new ClientException('Check failed', 0, $ex);
        }
    }
}