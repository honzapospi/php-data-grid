<?php
namespace JP\DataGrid;
use Nette\MemberAccessException;
use Nette\SmartObject;

/**
 * Row
 * @author Jan Pospisil
 */

class Row implements IRow, \ArrayAccess {
	use SmartObject;

	private $data;
	private $key;

	public function __construct($key, $data) {
		$this->key = $key;
		$this->data = $data;
	}

	public function &__get($name) {
		if($name == 'key')
			return $this->key;
		$return = $this->data[$name];
		return $return;
	}

	public function offsetExists($offset) {
		return isset($this->data[$offset]);
	}

	public function offsetGet($offset) {
		return $this->data[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->data[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}

}
