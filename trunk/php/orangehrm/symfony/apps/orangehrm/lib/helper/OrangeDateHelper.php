<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */

/**
 * Formats date using current date format.
 *
 * @param Date $date in YYYY-MM-DD format
 * @return formatted date.
 */
function ohrm_format_date($date) {
    $context = sfContext::getInstance();
    $context->getConfiguration()->loadHelpers('Date');
    $dateFormat = $context->getUser()->getDateFormat();

    return format_date($date, $dateFormat);
}

function get_js_date_format($symfonyDateFormat) {
    $jsDateFormat = "";

    $len = strlen($symfonyDateFormat);

    for ($i = 0; $i < $len; $i++) {
        $char = $symfonyDateFormat{$i};
        switch ($char) {
            case 'M':
                $jsDateFormat .= 'm';
                break;
            default:
                $jsDateFormat .= $char;
                break;
        }
    }

    // Replace yy with y
    $jsDateFormat = str_replace('yy', 'y', $jsDateFormat);

    return($jsDateFormat);
}