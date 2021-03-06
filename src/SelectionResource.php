<?php
namespace JP\DataGrid;
use Nette\Database\Table\Selection;
use Nette\SmartObject;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * SelectionResource
 * @author Jan Pospisil
 */

class SelectionResource implements IDataResource {
	use SmartObject;

	/**
	 * @var Selection $selection
	 */
	private $selection;
	private $paginator;

	public function setSelection(Selection $selection){
		$this->selection = $selection;
	}

	public function page($page, $itemsPerPage) {
		$total = $this->selection->count();
		$result = $this->selection->page($page, $itemsPerPage);
		$return = new DatabaseSelection($result);
		$this->paginator = new Paginator($page, $itemsPerPage, $total);
		return $return;
	}


	public function getPaginator() {
		return $this->paginator;
	}
}
