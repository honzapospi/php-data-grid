<?php

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer install`';
	exit(1);
}

// configure environment
//Tester\Environment::setup();
\Tracy\Debugger::enable();
date_default_timezone_set('Europe/Prague');

require  __DIR__.'/../src/IRenderer.php';
require  __DIR__.'/../src/DefaultRenderer.php';
require  __DIR__.'/../src/IRow.php';
require  __DIR__.'/../src/DatabaseSelection.php';
require  __DIR__.'/../src/RowPrototype.php';
require  __DIR__.'/../src/Iterator.php';
require  __DIR__.'/../src/DataList.php';

// create temporary directory
define('TEMP_DIR', __DIR__ . '/tmp/' . lcg_value());
@mkdir(TEMP_DIR, 0777, TRUE); // @ - base directory may already exist
register_shutdown_function(function () {
	Tester\Helpers::purge(TEMP_DIR);
	rmdir(TEMP_DIR);
});

function test(\Closure $function)
{
	$function();
}

