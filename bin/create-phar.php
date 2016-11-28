<?php
$srcRoot   = __DIR__.'/../src';
$buildRoot = __DIR__.'/../build';

$phar               = new Phar(
    $buildRoot.'/wsdl2php.phar',
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
    'myapp.phar'
);
$phar['index.php']  = file_get_contents($srcRoot."/index.php");
$phar->setStub($phar->createDefaultStub(__DIR__ . '/bin/wsdl2php'));

//copy($srcRoot."/config.ini", $buildRoot."/config.ini");
