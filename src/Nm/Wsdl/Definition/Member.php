<?php

namespace Nm\Wsdl\Definition;

class Member
{
    /** @var  string */
    protected $type;
    /** @var  string */
    protected $name;

    /**
     * Member constructor.
     *
     * @param string $type
     * @param string $name
     */
    public function __construct($type, $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
