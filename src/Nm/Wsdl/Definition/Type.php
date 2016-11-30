<?php

namespace Nm\Wsdl\Definition;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Type
{
    /** @var  string */
    protected $name;
    /** @var  Collection|Member[] */
    protected $members;

    /**
     * Type constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->members = new ArrayCollection();
    }

    public function addMember(Member $member)
    {
        $this->members->add($member);
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

    /**
     * @return Collection|Member[]
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param Collection|Member[] $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }


}
