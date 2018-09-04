<?php

namespace PE\Component\Licensing\Client;

use PE\Component\Licensing\Exception\ClientException;
use PE\Component\Licensing\Exception\LicenseNotFoundException;
use PE\Component\Licensing\Model\LicenseInterface;

interface ClientInterface
{
    /**
     * @param string $key
     *
     * @return LicenseInterface
     *
     * @throws ClientException
     * @throws LicenseNotFoundException
     */
    public function requestLicenseForKey(string $key): LicenseInterface;
}