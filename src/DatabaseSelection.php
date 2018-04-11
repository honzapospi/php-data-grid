<?php
namespace JP\DataGrid;
use Nette\Database\Table\Selection;
use Nette\SmartObject;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * DatabaseSelection
 * @author Jan Pospisil
 */

class DatabaseSelection implements \Iterator {
	use SmartObject;

	private $selection;

	public function __construct(Selection $selection) {
		$this->selection = $selection;
	}

	public function current() {
		$c = $this->selection->current();
		return new Row($this->key(), $c);
	}

	public function next() {
		$this->selection->next();
	}

	public function key() {
		return $this->selection->key();
	}

	public function valid() {
		return $this->selection->valid();
	}

	public function rewind() {
		$this->selection->rewind();
	}

}
