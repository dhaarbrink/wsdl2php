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

        /** @var \Twig_Loader_Filesystem $loader */
        $loader = $twig->getLoader();
        $loader->addPath(ROOT_DIR . '/resources/templates');
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

        $fullPath = $directory.DIRECTORY_SEPARATOR.$definition->getServiceName().'.php';

        if (!is_writable($directory)) {
            throw new Exception\NotWritableException(sprintf(
                'Directory \'%s\' is not writable or does not exist',
                $directory
            ));
        }

        file_put_contents($fullPath, $rendered);
    }
}
