<?php

require __DIR__.'/../bootstrap.php';

$simpleDataResource = new \JP\DataGrid\SimpleDataResource();
$simpleDataResource->addRowData(1, array(
	'name' => 'John',
	'surname' => 'Dee'
));
$simpleDataResource->addRowData(2, array(
	'name' => 'Peter',
	'surname' => 'Person'
));

$table = new \JP\DataGrid\Table();
\Tester\Assert::exception(function () use ($table){
	$table->render();
}, 'RuntimeException');

$table->columns = array(
	'name' => 'First Name',
	'surname' => 'SurName'
);
$table->setDataResource($simpleDataResource);
\Tester\Assert::true($table->toString() instanceof \Nette\Utils\Html);