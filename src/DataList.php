<?php

namespace JP\DataGrid;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * List
 * @author Jan Pospisil
 */

class DataList extends \Nette\Object {

	private $table;
	private $resource;
	private $counter = 1;
	private $columns = array();

	public function __construct(){
		$this->resource = new SimpleDataResource();
		$this->table = new Table();
		$this->table->setDataResource($this->resource);
	}

	public function addRow($name, $value){
		$data = func_get_args();
		$this->columns = count($data) > count($this->columns) ? $data : $this->columns;
		$this->resource->addRowData($this->counter, $data);
	}

	public function toString(){
		$this->table->renderHeader = FALSE;
		$this->table->columns = $this->columns;
		$first = key($this->columns);
		$this->table->getRenderer()->getRowPrototype()->columnDecorator[$first] = function (\Nette\Utils\Html $td, $row, $iterator) use ($first){
			$td->setName('th');
			$td->setHtml($row[$first]);
		};
		return $this->table->toString();
	}

	public function render(){
		echo $this->toString();
	}

}
