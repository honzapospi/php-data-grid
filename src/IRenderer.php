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
	public function render(Table $table);

	/**
	 * @return string
	 */
	public function toString(Table $table);
	
}
