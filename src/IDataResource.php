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

	/**
	 * @param $page
	 * @param $itemsPerPage
	 * @return mixed
	 */
	public function page($page, $itemsPerPage);

	/**
	 * @return Paginator
	 */
	public function getPaginator();

}
