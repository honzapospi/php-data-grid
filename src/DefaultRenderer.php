<?php
namespace JP\DataGrid;
use Nette\Utils\Html;


/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * DefaultRenderer
 * @author Jan Pospisil
 */

class DefaultRenderer extends \Nette\Object implements IRenderer {

	private $rowPrototype;

	public function __construct(RowPrototype $rowPrototype) {
		$this->rowPrototype = $rowPrototype;
	}

	public function render(Table $table) {
		echo $this->toString();
	}

	public function toString(Table $table) {
		$container = Html::el('table');
		$container->class = 'list';
		$header = $this->toStringHeader($table);
		$body = $this->toStringBody($table);
		$footer = $this->toStringFooter($table);
		$container->addHtml($header);
		$container->addHtml($body);
		$container->addHtml($footer);
		return $container;
	}

	public function toStringHeader(Table $table){
		$container = Html::el('thead');
		$tr = Html::el('tr');
		if($this->rowPrototype->checkbox){
			$td = Html::el('th');
			$td->class = 'tbl-chbox';
			$tr->addHtml($td);
		}
		foreach($table->columns as $htmlClass => $name){
			$td = Html::el('th');
			$td->class = $htmlClass;
			if($name)
				$td->setHtml($name);
			$tr->addHtml($td);
		}
		if($this->rowPrototype->getButtons()){
			$td = Html::el('th');
			$td->class = 'tbl-buttons';
			$td->setHtml($this->getRowPrototype()->buttonsTitle);
			$tr->addHtml($td);
		}
		$container->addHtml($tr);
		return $container;
	}

	public function toStringBody(Table $table){
		$container = Html::el('tbody');
		$iterator = new Iterator();
		foreach($table->getRows() as $row){
			$iterator->run();
			$container->addHtml($this->toStringRow($row, $table, $iterator));
		}
		return $container;
	}

	public function toStringRow(Row $row, Table $table, Iterator $iterator){
		$rowPrototype = $this->rowPrototype;
		$container = Html::el('tr');
		if($rowPrototype->rowFormat){
			$closure = $rowPrototype->rowFormat;
			$closure($container, $row, $iterator);
		}
		if($rowPrototype->checkbox){
			$td = Html::el('td');
			$checkbox = Html::el('input')->setAttribute('type', 'checkbox');
			$td->addHtml($checkbox);
			$closure = $rowPrototype->checkbox;
			$closure($checkbox, $row, $iterator);
			$container->addHtml($td);
		}
		foreach($table->getColumns() as $column => $name){
			$td = Html::el('td');
			if(isset($this->rowPrototype->columnDecorator[$column]))
				$this->rowPrototype->columnDecorator[$column]($td, $row, $iterator);
			else
				$td->setHtml($row[$column]);
			$container->addHtml($td);
		}
		if($this->rowPrototype->getButtons()){
			$buttonsContainer = Html::el('td');
			foreach($this->rowPrototype->getButtons() as $buttonClosure){
				$button = Html::el('a');
				$buttonClosure($button, $row, $iterator);
				$buttonsContainer->addHtml($button);
			}
			$container->addHtml($buttonsContainer);
		}
		return $container;
	}

	public function getRowPrototype(){
		return $this->rowPrototype;
	}

	public function toStringFooter(Table $table){
		$container = Html::el('tfoot');
		return $container;
	}

}
