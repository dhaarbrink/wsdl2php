<?php

namespace Nm\Wsdl\Definition;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Definition
{
    /** @var Collection|Operation[] */
    protected $operations;
    /** @var  string */
    protected $serviceName;
    /** @var  string */
    protected $targetNamespace;
    /** @var  string */
    protected $namespace;
    /** @var  Collection|Type[] */
    protected $types;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->types = new ArrayCollection();
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * @param Collection|Operation[] $operations
     */
    public function setOperations(Collection $operations)
    {
        $this->operations = $operations;
    }

    public function addOperation(Operation $operation)
    {
        if (!$this->operations->containsKey($operation->getName())) {
            $this->operations->set($operation->getName(), $operation);
        }
    }

    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function setTargetNamespace($targetNamespace)
    {
        $this->targetNamespace = $targetNamespace;
    }

    /**
     * @return string
     */
    public function getTargetNamespace()
    {
        return $this->targetNamespace;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return Collection|Type[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param Collection|Type[] $types
     */
    public function setTypes($types)
    {
        $this->types = $types;
    }

    public function addType(Type $type)
    {
        if (!$this->types->containsKey($type->getName())) {
            $this->types->add($type);
        }
    }
}
