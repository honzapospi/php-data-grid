<?php
namespace JP\DataGrid;
use Nette\MemberAccessException;


/**
 * Row
 * @author Jan Pospisil
 */

class Row extends \Nette\Object implements IRow, \ArrayAccess {

	private $data;
	private $key;

	public function __construct($key, $data) {
		$this->key = $key;
		$this->data = $data;
	}

	public function &__get($name) {
		if($name == 'key')
			return $this->key;
		if(isset($this->data[$name])){
			$return = $this->data[$name];
			return $return;
		}
		throw new MemberAccessException('Value '.$name.' does not exist.');
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
