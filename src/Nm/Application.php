<?php

namespace Nm;

use Nm\Command\Wsdl2phpCommand;
use Symfony\Component\Console\Application as App;

class Application extends App
{
    public function getDefaultCommands()
    {
        return array_merge([
            new Wsdl2phpCommand(),
        ], parent::getDefaultCommands());
    }
}
