<?php

namespace PE\Component\Licensing\Model;

interface LicenseInterface
{
    /**
     * @return string
     */
    public function getID();

    /**
     * @param string $id
     *
     * @return self
     */
    public function setID($id);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param string $key
     *
     * @return self
     */
    public function setKey($key);

    /**
     * @return null|\DateTime
     */
    public function getExpiredAt();

    /**
     * @param \DateTime $expiredAt
     *
     * @return self
     */
    public function setExpiredAt(\DateTime $expiredAt);
}