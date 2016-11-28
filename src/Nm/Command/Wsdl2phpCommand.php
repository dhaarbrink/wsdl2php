<?php

namespace Nm\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Wsdl2phpCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create')
            ->setDescription('Creates classes based on a WSDL')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing <comment>stuff</comment>');
    }
}
