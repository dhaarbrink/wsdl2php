<?php

namespace Nm\Command;

use Nm\Writer\ServiceWriter;
use Nm\Wsdl\WsdlLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Wsdl2phpCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this
            ->setName('create')
            ->addArgument('wsdl', InputArgument::REQUIRED, 'The WSDL file to parse')
            ->addArgument('out', InputArgument::REQUIRED, 'The directory to output file(s) to')
            ->addOption('namespace', 'ns', InputOption::VALUE_OPTIONAL, 'The namespace the generated classes should be in')
            ->setDescription('Creates classes based on a WSDL')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $wsdl = $input->getArgument('wsdl');
        $out_dir = $input->getArgument('out');
        $namespace = $input->getOption('namespace');

        /** @var WsdlLoader $loader */
        $loader = $this->container->get('wsdl.loader');
        $definition = $loader->getDefinition($wsdl);

        $definition->setNamespace($namespace);

        /** @var ServiceWriter $writer */
        $writer = $this->container->get('wsdl.writer');
        $writer->write($definition, $out_dir);

        $output->writeln('Done');
    }
}
