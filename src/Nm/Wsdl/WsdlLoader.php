<?php

namespace Nm\Wsdl;

use Nm\Wsdl\Definition\Definition;
use Nm\Wsdl\Definition\Member;
use Nm\Wsdl\Definition\Operation;
use Nm\Wsdl\Definition\Parameter;
use Nm\Wsdl\Definition\Type;

class WsdlLoader
{
    /** @var  Definition */
    protected $definition;
    /** @var  \SoapClient */
    protected $client;
    /** @var  \DOMDocument */
    protected $document;
    /**
     * Parses the given WSDL file and returns a Definition
     *
     * @param string $wsdlFile The location of the WSDL file
     *
     * @return Definition
     * @throws \Nm\Wsdl\Exception\NoServiceFoundException
     * @throws \Nm\Wsdl\Exception\OperationMatchException
     */
    public function getDefinition($wsdlFile)
    {
        $this->definition = new Definition();

        $this->client = new \SoapClient($wsdlFile);

        $this->document = new \DOMDocument();
        $this->document->load($wsdlFile);

        $this->getServiceName();
        $this->getOperations();
        $this->getTargetNamespace();
        $this->getTypes();

        return $this->definition;
    }

    protected function getServiceName()
    {
        /** @var \DOMElement[] $service */
        $service = $this->document->getElementsByTagName('service');
        if (!count($service)) {
            throw new Exception\NoServiceFoundException();
        }
        $this->definition->setServiceName($service[0]->getAttribute('name'));
    }

    protected function getOperations()
    {
        $operations = $this->client->__getFunctions();
        foreach ($operations as $operation) {
            $this->definition->addOperation($this->parseOperationString($operation));
        }
    }

    protected function getTargetNamespace()
    {
        /** @var \DOMElement[] $definitions */
        $definitions = $this->document->getElementsByTagName('definitions');
        if (!count($definitions)) {
            throw new Exception\NoDefinitionsFoundException();
        }

        $this->definition->setTargetNamespace($definitions[0]->getAttribute('targetNamespace'));
    }

    protected function getTypes()
    {
        $types = $this->client->__getTypes();
        foreach ($types as $typeString) {
            list($baseType, $definition) = explode(' ', $typeString, 2);
            if ($baseType === 'struct') {
                $this->definition->addType($this->parseType($definition));
            }
        }
    }

    /**
     * Converts a string like 'GetWeatherInformationResponse GetWeatherInformation(GetWeatherInformation $parameters)'
     * to an Operation
     *
     * @param string $operationString The operation string
     *
     * @return Operation
     * @throws \Nm\Wsdl\Exception\OperationMatchException
     */
    protected function parseOperationString($operationString)
    {
        $pattern = '/^([\w]+) ([\w]+)\(([\w]+) \$([\w]+)\)$/';
        $matches = [];
        $does_match = preg_match($pattern, $operationString, $matches);

        if (!$does_match) {
            throw new Exception\OperationMatchException(sprintf(
                'Cannot match for operation \'%s\'',
                $operationString
            ));
        }

        $operation = new Operation();
        $operation->setName($matches[2]);
        $operation->setReturnType($matches[1]);
        $operation->addParameter(new Parameter($matches[3], $matches[4]));

        return $operation;
    }

    protected function parseType($definition)
    {
        $pattern = '/^(\w+) \{([^\{\}]+)+\}$/';
        $matches = [];
        $numMatches = preg_match_all($pattern, $definition, $matches);
        if (!$numMatches) {
            throw new Exception\InvalidTypeDefinitionException();
        }

        $typeName = $matches[1][0];
        $members = $matches[2][0];

        $type = new Type($typeName);

        $members = explode(';', $members);
        foreach ($members as $member) {
            $member = trim($member);
            if (!$member) {
                continue;
            }
            list($memberType, $memberName) = explode(' ', $member);
            $type->addMember(new Member($memberType, $memberName));
        }

        return $type;
    }
}
