<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace JP\DataGrid;


/**
 * IRenderer
 * @author Jan Pospisil
 */

interface IRenderer  {

	/**
	 * Render table
	 */
	public function renderTable(Table $table);

	/**
	 * @return string
	 */
	public function toStringTable(Table $table);

	public function toStringPaginator(Paginator $paginator, ILinkBuilder $linkBuilder);
	
}
