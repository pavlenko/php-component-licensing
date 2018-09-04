<?php

namespace PE\Component\Licensing\Repository;

use PE\Component\Licensing\Model\LicenseInterface;

interface LicenseRepositoryInterface
{
    /**
     * @return LicenseInterface[]
     */
    public function findLicenses(): array;

    /**
     * @param string $key
     *
     * @return null|LicenseInterface
     */
    public function findLicenseByKey(string $key): ?LicenseInterface;

    /**
     * @param string $id
     *
     * @return null|LicenseInterface
     */
    public function findLicenseByID(string $id): ?LicenseInterface;

    /**
     * @return LicenseInterface
     */
    public function createLicense(): LicenseInterface;

    /**
     * @param LicenseInterface $license
     */
    public function updateLicense(LicenseInterface $license): void;

    /**
     * @param LicenseInterface $license
     */
    public function deleteLicense(LicenseInterface $license): void;
}