<?php

namespace Nm\Writer;

use Nm\Wsdl\Definition\Definition;

class ServiceWriter
{
    /** @var  \Twig_Environment */
    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function write(Definition $definition, $directory)
    {
        $rendered = $this->twig->render('service.php.twig', [
            'serviceName'     => $definition->getServiceName(),
            'operations'      => $definition->getOperations(),
            'targetNamespace' => $definition->getTargetNamespace(),
            'namespace'       => $definition->getNamespace(),
            'types'           => $definition->getTypes(),
        ]);

        file_put_contents($directory.DIRECTORY_SEPARATOR.$definition->getServiceName().'.php', $rendered);
    }
}
