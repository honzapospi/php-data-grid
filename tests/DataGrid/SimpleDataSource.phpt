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

\Tester\Assert::true(count($simpleDataResource->page(1, 10)) === 2);
