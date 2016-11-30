<?php

namespace Nm;

use Nm\Command\Wsdl2phpCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as App;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Application extends App
{
    /** @var  ContainerInterface */
    protected $container;
    /** @var array Command[] */
    protected $custom_commands = [];

    public function getDefaultCommands()
    {
        $this->custom_commands = [
            new Wsdl2phpCommand(),
        ];

        return array_merge($this->custom_commands, parent::getDefaultCommands());
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__ . '/../../resources'));
        $loader->load('services.yml');

        foreach ($this->custom_commands as $command) {
            if ($command instanceof ContainerAwareInterface) {
                $command->setContainer($this->container);
            }
        }

        return parent::run($input, $output);
    }
}
