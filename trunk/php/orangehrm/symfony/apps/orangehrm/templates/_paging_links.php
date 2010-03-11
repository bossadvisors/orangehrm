<?php
/*
// OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
// all the essential functionalities required for any enterprise.
// Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com

// OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
// the GNU General Public License as published by the Free Software Foundation; either
// version 2 of the License, or (at your option) any later version.

// OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
// without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU General Public License for more details.

// You should have received a copy of the GNU General Public License along with this program;
// if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
// Boston, MA  02110-1301, USA
*/

echo link_to_unless($pager->getPage() == 1, __('First'), $url, array('query_string' => 'page=1')).' | ';
echo link_to_unless($pager->getPreviousPage() == $pager->getPage(), 
	__('Previous'), $url, array('query_string' => 'page=' . $pager->getPreviousPage() )).' | ';  

foreach ($pager->getLinks() as $page):
	echo link_to_unless($page == $pager->getPage(), $page, $url, array('query_string' => 'page=' . $page));
endforeach;

echo '| '.link_to_unless($pager->getNextPage() == $pager->getPage(), 
	__('Next'), $url, array('query_string' => 'page=' . $pager->getNextPage() )).' | ';
echo link_to_unless($pager->getLastPage() == $pager->getPage(), 
	__('Last'), $url, array('query_string' => 'page=' . $pager->getLastPage() ));
