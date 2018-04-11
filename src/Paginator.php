<?php
namespace JP\DataGrid;
use Nette\SmartObject;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * Paginator
 * @property-read int $from
 * @property-read int $page
 * @property-read int $to
 * @property-read int $total
 * @property-read int $pages
 * @property-read int $last
  *
 * @author Jan Pospisil
 */

class Paginator {
	use SmartObject;

	private $page;
	private $itemsPerPage;
	private $total;

	public function __construct($page, $itemsPerPage, $total){
		$this->page = $page;
		$this->itemsPerPage = $itemsPerPage;
		$this->total = $total;
	}

	public function getFrom(){
		$return = (($this->page - 1) * $this->itemsPerPage) + 1;
		if($return > $this->getTotal()){
			return $this->getTotal();
		} else {
			return $return;
		}
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
