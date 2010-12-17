<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfStopException is thrown when you want to stop action flow.
 *
 * @package    symfony
 * @subpackage exception
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfStopException.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfStopException extends sfException
{
  /**
   * Stops the current action.
   */
  public function printStackTrace()
  {
  }
}
