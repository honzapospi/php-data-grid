<?php
// name - value table

require __DIR__.'/../bootstrap.php';

$simpleDataResource = new \JP\DataGrid\SimpleDataResource();
$simpleDataResource->addRowData(1, array(
	'name' => 'Name',
	'value' => 'John'
));
$simpleDataResource->addRowData(2, array(
	'name' => 'Surname',
	'value' => 'Person'
));

$table = new \JP\DataGrid\Table();
$table->setDataResource($simpleDataResource);
$table->columns = array(
	'name' => '',
	'value' => ''
);

$table->renderHeader = FALSE;
$table->getRenderer()->getRowPrototype()->columnDecorator['name'] = function (\Nette\Utils\Html $td, $row, $iterator){
	$td->setName('th');
	$td->setHtml($row['name']);
};


$table->render();