<?php

namespace PE\Component\Licensing\Model;

class License implements LicenseInterface
{
    protected $id;
    protected $key;
    protected $expiredAt;

    /**
     * @inheritDoc
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * @inheritDoc
     */
    public function setExpiredAt(\DateTime $expiredAt)
    {
        $this->expiredAt = $expiredAt;
        return $this;
    }
}