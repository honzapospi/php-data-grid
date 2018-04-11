<?php
namespace JP\DataGrid;
use Nette\SmartObject;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * Iterator
 * @author Jan Pospisil
 */

class Iterator  {
	use SmartObject;

	private $counter = 0;

	public function run(){
		$this->counter++;
	}

	public function isEven(){
		return ($this->counter % 2) == 0;
	}

	public function isOdd(){
		return ($this->counter % 2) == 1;
	}

	public function getCounter(){
		return $this->counter;
	}

	public function isFirst(){
		return $this->counter === 1;
	}

}
