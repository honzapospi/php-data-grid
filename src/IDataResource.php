<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace JP\DataGrid;

/**
 * IDataResource
 * @author Jan Pospisil
 */

interface IDataResource  {

	public function page($page, $itemsPerPage);

}
