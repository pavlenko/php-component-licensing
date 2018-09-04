<?php

namespace PE\Component\Licensing\Server;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\CryptoException;
use Defuse\Crypto\Key;
use PE\Component\Licensing\Exception\ServerException;
use PE\Component\Licensing\Repository\LicenseRepositoryInterface;

class Server implements ServerInterface
{
    /**
     * @var LicenseRepositoryInterface
     */
    private $repository;

    /**
     * @var string
     */
    private $serverKey;

    /**
     * @param LicenseRepositoryInterface $repository
     * @param string                     $serverKey
     */
    public function __construct(LicenseRepositoryInterface $repository, string $serverKey)
    {
        $this->repository = $repository;
        $this->serverKey  = $serverKey;
    }

    /**
     * @inheritDoc
     */
    public function handleLicenseRequest(string $body): ?string
    {
        try {
            $serverKey = Key::loadFromAsciiSafeString($this->serverKey);
            $clientKey = Crypto::decrypt($body, $serverKey);

            $license = $this->repository->findLicenseByKey($clientKey);
            if (!$license) {
                return null;
            }

            return Crypto::encrypt(serialize($license), $serverKey);
        } catch (CryptoException $ex) {
            throw new ServerException('Cannot handle request', 0, $ex);
        }
    }
}