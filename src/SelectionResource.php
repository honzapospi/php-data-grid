<?php
namespace JP\DataGrid;
use Nette\Database\Table\Selection;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * SelectionResource
 * @author Jan Pospisil
 */

class SelectionResource extends \Nette\Object implements IDataResource {

	/**
	 * @var Selection $selection
	 */
	private $selection;

	public function setSelection(Selection $selection){
		$this->selection = $selection;
	}

	public function page($page, $itemsPerPage) {
		return new DatabaseSelection($this->selection->page($page, $itemsPerPage));
	}


}
