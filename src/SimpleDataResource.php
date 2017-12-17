<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace JP\DataGrid;

/**
 * SimpleDataResource
 * @author Jan Pospisil
 */

class SimpleDataResource extends \Nette\Object implements IDataResource {

	private $data = array();
	private $paginator;

	public function page($page, $itemsPerPage) {
		$return = array();
		$start = ($page - 1) * $itemsPerPage;
		$limit = $page * $itemsPerPage;
		for($i = $start; $i < $limit; $i++){
			if(isset($this->data[$i]))
				$return[$i] = $this->data[$i];
		}
		return $return;
	}

	public function addRowData($id, array $data){
		$this->data[] = new Row($id, $data);
	}

	public function setPaginator(Paginator $paginator){
		$this->paginator = $paginator;
	}

	/**
	 * @return Paginator
	 */
	public function getPaginator(){
		if(!$this->paginator)
			$this->paginator = new Paginator(1, 1000, 1000);
		return $this->paginator;
	}

}
