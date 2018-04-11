<?php
namespace JP\DataGrid;
use Nette\SmartObject;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * RowControl
 * @author Jan Pospisil
 */

class RowPrototype {
	use SmartObject;

	public $columnDecorator = array();
	public $rowFormat;
	public $checkbox;
	public $buttonsTitle;

	private $buttons = array();

	public function addButton($closure){
		$this->buttons[] = $closure;
	}

	public function getButtons(){
		return $this->buttons;
	}

}
