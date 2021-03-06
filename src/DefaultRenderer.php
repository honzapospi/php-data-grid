<?php
namespace JP\DataGrid;
use Nette\Localization\ITranslator;
use Nette\Utils\Html;
use Tracy\Debugger;
use Nette\SmartObject;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * DefaultRenderer
 * @author Jan Pospisil
 */

class DefaultRenderer implements IRenderer {
	use SmartObject;

	private $rowPrototype;
	private $translator;
	private $tableContainer;
	public static $prevButtonName = 'Previous';
	public static $nextButtonName = 'Next';

	public function __construct(RowPrototype $rowPrototype) {
		$this->rowPrototype = $rowPrototype;
		$this->tableContainer = Html::el('table');
		$this->tableContainer->class = 'list';
	}

	public function setTableContainer(Html $html){
		$this->tableContainer = $html;
	}

	public function setTranslator(ITranslator $translator){
		$this->translator = $translator;
	}

	public function renderTable(Table $table) {
		echo $this->toStringTable();
	}

	public function toStringTable(Table $table) {
		$container = $this->tableContainer;
		$header = $this->toStringHeader($table);
		$body = $this->toStringBody($table);
		$footer = $this->toStringFooter($table);
		$container->addHtml($header);
		$container->addHtml($body);
		$container->addHtml($footer);
		return $container;
	}

	public function toStringHeader(Table $table){
		$container = Html::el('thead');
		if($table->renderHeader){
			$tr = Html::el('tr');
			if($this->rowPrototype->checkbox){
				$td = Html::el('th');
				$td->class = 'tbl-chbox';
				$tr->addHtml($td);
			}
			foreach($table->columns as $htmlClass => $name){
				$td = Html::el('th');
				$td->class = $htmlClass;
				if($name)
					$td->setHtml($this->translator ? $this->translator->translate($name) : $name);
				$tr->addHtml($td);
			}
			if($this->rowPrototype->getButtons()){
				$td = Html::el('th');
				$td->class = 'tbl-buttons';
				$td->setHtml($this->getRowPrototype()->buttonsTitle);
				$tr->addHtml($td);
			}
			$container->addHtml($tr);
		}
		return $container;
	}

	public function toStringBody(Table $table){
		$container = Html::el('tbody');
		$iterator = new Iterator();
		foreach($table->getRows() as $row){
			$iterator->run();
			$container->addHtml($this->toStringRow($row, $table, $iterator));
		}
		return $container;
	}

	public function toStringRow(Row $row, Table $table, Iterator $iterator){
		$rowPrototype = $this->rowPrototype;
		$container = Html::el('tr');
		if($rowPrototype->rowFormat){
			$closure = $rowPrototype->rowFormat;
			$closure($container, $row, $iterator);
		}
		if($rowPrototype->checkbox){
			$td = Html::el('td');
			$checkbox = Html::el('input')->setAttribute('type', 'checkbox');
			$td->addHtml($checkbox);
			$closure = $rowPrototype->checkbox;
			$closure($checkbox, $row, $iterator);
			$container->addHtml($td);
		}
		foreach($table->getColumns() as $column => $name){
			$td = Html::el('td');
			if(isset($this->rowPrototype->columnDecorator[$column]))
				$this->rowPrototype->columnDecorator[$column]($td, $row, $iterator);
			else
				$td->setHtml($this->translator ? $this->translator->translate($row[$column]) : $row[$column]);
			$container->addHtml($td);
		}
		if($this->rowPrototype->getButtons()){
			$buttonsContainer = Html::el('td');
			foreach($this->rowPrototype->getButtons() as $buttonClosure){
				$button = Html::el('a');
				$button->setAttribute('class', 'btn-table');
				$buttonClosure($button, $row, $iterator);
				$buttonsContainer->addHtml($button);
			}
			$container->addHtml($buttonsContainer);
		}
		return $container;
	}

	public function getRowPrototype(){
		return $this->rowPrototype;
	}

	public function toStringFooter(Table $table){
		$container = Html::el('tfoot');
		return $container;
	}


	public function toStringPaginator(Paginator $paginator, ILinkBuilder $linkBuilder) {
		$container = Html::el('ul')->setAttribute('class', 'pagination');

		// prev
		$prevClass = 'paginate_button previous';
		$prevLink = Html::el('a')->setHtml($this->translator ? $this->translator->translate(self::$prevButtonName) : self::$prevButtonName);
		if($paginator->isFirst())
			$prevClass.= ' disabled';
		else
			$prevLink->setAttribute('href', $linkBuilder->link($paginator->page - 1));
		$prew = Html::el('li')->setAttribute('class', $prevClass);
		$prew->addHtml($prevLink);
		$container->addHtml($prew);

		// pages
		for($i = 1; $i <= $paginator->getLast(); $i++){
			$itemClass = 'paginate_button';
			if($paginator->page == $i)
				$itemClass .= ' active';
			$item = Html::el('li')->setAttribute('class', $itemClass);
			$itemLink = Html::el('a')->setHtml($i)->setAttribute('href', $linkBuilder->link($i));
			$item->addHtml($itemLink);
			$container->addHtml($item);
		}

		// next
		$nextClass = 'paginate_button next';
		$nextLink = Html::el('a')->setHtml($this->translator ? $this->translator->translate(self::$nextButtonName) : self::$nextButtonName);
		if($paginator->isLast())
			$nextClass .= ' disabled';
		else
			$nextLink->setAttribute('href', $linkBuilder->link($paginator->page + 1));
		$next = Html::el('li')->setAttribute('class', $nextClass);
		$next->addHtml($nextLink);
		$container->addHtml($next);
		return $container;
	}
}
