<?php

namespace Nm\Wsdl\Definition;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Operation
{
    /** @var  string */
    protected $name;
    /** @var  string */
    protected $returnType;
    /** @var  Collection|Parameter[] */
    protected $parameters;

    /**
     * Operation constructor.
     */
    public function __construct()
    {
        $this->parameters = new ArrayCollection();
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
     * @return string
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @param string $returnType
     */
    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;
    }

    /**
     * @return Collection|Parameter[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param Collection|Parameter[] $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function addParameter(Parameter $parameter)
    {
        $this->parameters->add($parameter);
    }
}
