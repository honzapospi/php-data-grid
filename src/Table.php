<?php

namespace JP\DataGrid;

/**
 * Table
 * @author Jan Pospisil
 * @property array $columns
 */

class Table extends \Nette\Object {

	private $dataResource;
	private $columns = array();
	private $renderer;
	private $page = 1;
	private $itemsPerPage = 20;
	public $renderHeader = true;

	/**
	 * @param IDataResource $dataResource
	 */
	public function setDataResource(IDataResource $dataResource){
		$this->dataResource = $dataResource;
	}

	/**
	 * @param IRenderer $renderer
	 */
	public function setRenderer(IRenderer $renderer){
		$this->renderer = $renderer;
	}

	/**
	 * @param array $columns
	 */
	public function setColumns(array $columns){
		$this->columns = $columns;
	}

	/**
	 * @return array
	 */
	public function getColumns(){
		return $this->columns;
	}

	/**
	 * Render table
	 */
	public function render(){
		echo $this->toString();
	}

	public function setItemsPerPage($int){
		$this->itemsPerPage = $int;
	}

	public function page($page){
		$this->page = $page;
	}

	public function getRows(){
		if(!$this->dataResource)
			throw new \Exception('DataResource must be set to render table.');
		return $this->dataResource->page($this->page, $this->itemsPerPage);
	}

	/**
	 * @return string
	 */
	public function toString(){
		return $this->getRenderer()->toString($this);
	}

	public function getRenderer(){
		if(!$this->renderer)
			$this->renderer = new DefaultRenderer(new RowPrototype());
		return $this->renderer;
	}

	public function getRowPrototype(){
		return $this->getRenderer()->getRowPrototype();
	}

}
