<?php

require __DIR__.'/../bootstrap.php';

$connection = new \Nette\Database\Connection('mysql:host=127.0.0.1;dbname=test', 'test', 'test');
$cacheStorage = new \Nette\Caching\Storages\FileStorage(TEMP_DIR);
$structure = new \Nette\Database\Structure($connection, $cacheStorage);
$context = new \Nette\Database\Context($connection, $structure);

$selectionResource = new \JP\DataGrid\SelectionResource();
$selectionResource->setSelection($context->table('user'));

$table = new \JP\DataGrid\Table();
$table->setDataResource($selectionResource);
$table->columns = array(
	'name' => 'First Name',
	'surname' => 'Last Name',
	'country' => 'Country',
	'created' => 'Created'
);
$rowPrototype = $table->getRowPrototype();
$rowPrototype->columnDecorator['country'] = function(\Nette\Utils\Html $td, $rowData){
	$td->setHtml($rowData->name);
};
$rowPrototype->columnDecorator['created'] = function(\Nette\Utils\Html $td, $rowData){
	$td->setHtml($rowData->created->format('j.n.Y'));
};
$rowPrototype->columnDecorator['name'] = function(\Nette\Utils\Html $td, $rowData){
	$link = \Nette\Utils\Html::el('a')->setHtml($rowData->name)->setAttribute('href', 'fsdf');
	$td->setHtml($link);
};

$rowPrototype->addButton(function (\Nette\Utils\Html $button, $rowData){
	return $button->addAttributes(array('href' => $rowData->key))->setHtml($rowData->surname);
});

$rowPrototype->checkbox = function(\Nette\Utils\Html $checkbox, $rowData) {
	return $checkbox->addAttributes(array('name' => $rowData->key));
};

$rowPrototype->rowFormat = function(\Nette\Utils\Html $tr, $rowData, \JP\DataGrid\Iterator $iterator){
	$tr->class = $iterator->isEven() ? 'even' : 'odd';
};

$table->setItemsPerPage(2);
$table->page(1);
\Tester\Assert::true($table->toString() instanceof \Nette\Utils\Html);


