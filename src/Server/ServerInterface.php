<?php

namespace PE\Component\Licensing\Server;

use PE\Component\Licensing\Exception\ServerException;

interface ServerInterface
{
    /**
     * @param string $body
     *
     * @return null|string
     *
     * @throws ServerException
     */
    public function handleLicenseRequest(string $body): ?string;
}