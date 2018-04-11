<?php
namespace JP\DataGrid;
use Nette\Localization\ITranslator;
use Nette\SmartObject;

/**
 * Table
 * @author Jan Pospisil
 * @property array $columns
 */

class Table {
	use SmartObject;

	/**
	 * @var IDataResource $dataResource
	 */
	private $dataResource;
	private $columns = array();
	private $renderer;
	private $page = 1;
	private $itemsPerPage = 20;
	public $renderHeader = true;
	private $translator;
	private $linkBuilder;

	/**
	 * @param IDataResource $dataResource
	 */
	public function setDataResource(IDataResource $dataResource){
		$this->dataResource = $dataResource;
	}

	public function setLinkBuilder(ILinkBuilder $linkBuilder){
		$this->linkBuilder = $linkBuilder;
	}

	public function setPage($page){
		$this->page = $page;
	}

	/**
	 * @return IDataResource
	 */
	public function getDataResource(){
		return $this->dataResource;
	}

	public function setTranslator(ITranslator $translator){
		$this->translator = $translator;
	}

	/**
	 * @param IRenderer $renderer
	 */
	public function setRenderer(IRenderer $renderer){
		$this->renderer = $renderer;
	}

	/**
	 * @param array $columns
	 */
	public function setColumns(array $columns){
		$this->columns = $columns;
	}

	/**
	 * @return array
	 */
	public function getColumns(){
		return $this->columns;
	}

	/**
	 * Render table
	 */
	public function renderTable(){
		echo $this->toStringTable();
	}

	public function setItemsPerPage($int){
		$this->itemsPerPage = $int;
	}

	public function page($page){
		$this->page = $page;
	}

	public function getRows(){
		if(!$this->dataResource)
			throw new \Exception('DataResource must be set to render table.');
		return $this->dataResource->page($this->page, $this->itemsPerPage);
	}

	/**
	 * @return string
	 */
	public function toStringTable(){
		return $this->getRenderer()->toStringTable($this);
	}

	public function getRenderer(){
		if(!$this->renderer){
			$this->renderer = new DefaultRenderer(new RowPrototype());
			if($this->translator)
				$this->renderer->setTranslator($this->translator);
		}
		return $this->renderer;
	}

	public function getRowPrototype(){
		return $this->getRenderer()->getRowPrototype();
	}

	public function renderPaginator(){
		echo $this->toStringPaginator();
	}

	public function toStringPaginator(){
		if($this->dataResource->getPaginator()->getPages() > 1)
			return $this->getRenderer()->toStringPaginator($this->dataResource->getPaginator(), $this->linkBuilder);
	}

}
