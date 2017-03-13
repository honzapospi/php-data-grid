<?php
namespace JP\DataGrid;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * Paginator
 * @author Jan Pospisil
 */

class Paginator extends \Nette\Object {

	private $page;
	private $itemsPerPage;
	private $total;

	public function __construct($page, $itemsPerPage, $total){
		$this->page = $page;
		$this->itemsPerPage = $itemsPerPage;
		$this->total = $total;
	}

	public function getFrom(){
		return (($this->page - 1) * $this->itemsPerPage) + 1;
	}

	public function getTo(){
		$return = $this->getFrom() + $this->itemsPerPage - 1;
		return $return < $this->getTotal() ? $return : $this->getTotal();
	}

	public function getTotal(){
		return $this->total;
	}

	public function getPages(){
		return $this->getLast();
	}

	public function isFirst(){
		return $this->page == 1;
	}

	public function isLast(){
		return $this->page == $this->getLast();
	}

	public function getLast(){
		return ceil($this->total / $this->itemsPerPage);
	}

	public function getPage(){
		return $this->page;
	}
}
