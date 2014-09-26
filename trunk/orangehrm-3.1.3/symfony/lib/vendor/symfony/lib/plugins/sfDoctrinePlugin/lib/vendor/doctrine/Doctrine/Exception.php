<?php
/*
 *  $Id: Exception.php 7490 2010-03-29 19:53:27Z jwage $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

/**
 * Doctrine_Exception
 *
 * @package     Doctrine
 * @subpackage  Exception
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.doctrine-project.org
 * @since       1.0
 * @version     $Revision: 7490 $
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 */
class Doctrine_Exception extends Exception
{ 
    /**
     * @var array $_errorMessages       an array of error messages
     */
    protected static $_errorMessages = array(
                Doctrine_Core::ERR                    => 'unknown error',
                Doctrine_Core::ERR_ALREADY_EXISTS     => 'already exists',
                Doctrine_Core::ERR_CANNOT_CREATE      => 'can not create',
                Doctrine_Core::ERR_CANNOT_ALTER       => 'can not alter',
                Doctrine_Core::ERR_CANNOT_REPLACE     => 'can not replace',
                Doctrine_Core::ERR_CANNOT_DELETE      => 'can not delete',
                Doctrine_Core::ERR_CANNOT_DROP        => 'can not drop',
                Doctrine_Core::ERR_CONSTRAINT         => 'constraint violation',
                Doctrine_Core::ERR_CONSTRAINT_NOT_NULL=> 'null value violates not-null constraint',
                Doctrine_Core::ERR_DIVZERO            => 'division by zero',
                Doctrine_Core::ERR_INVALID            => 'invalid',
                Doctrine_Core::ERR_INVALID_DATE       => 'invalid date or time',
                Doctrine_Core::ERR_INVALID_NUMBER     => 'invalid number',
                Doctrine_Core::ERR_MISMATCH           => 'mismatch',
                Doctrine_Core::ERR_NODBSELECTED       => 'no database selected',
                Doctrine_Core::ERR_NOSUCHFIELD        => 'no such field',
                Doctrine_Core::ERR_NOSUCHTABLE        => 'no such table',
                Doctrine_Core::ERR_NOT_CAPABLE        => 'Doctrine backend not capable',
                Doctrine_Core::ERR_NOT_FOUND          => 'not found',
                Doctrine_Core::ERR_NOT_LOCKED         => 'not locked',
                Doctrine_Core::ERR_SYNTAX             => 'syntax error',
                Doctrine_Core::ERR_UNSUPPORTED        => 'not supported',
                Doctrine_Core::ERR_VALUE_COUNT_ON_ROW => 'value count on row',
                Doctrine_Core::ERR_INVALID_DSN        => 'invalid DSN',
                Doctrine_Core::ERR_CONNECT_FAILED     => 'connect failed',
                Doctrine_Core::ERR_NEED_MORE_DATA     => 'insufficient data supplied',
                Doctrine_Core::ERR_EXTENSION_NOT_FOUND=> 'extension not found',
                Doctrine_Core::ERR_NOSUCHDB           => 'no such database',
                Doctrine_Core::ERR_ACCESS_VIOLATION   => 'insufficient permissions',
                Doctrine_Core::ERR_LOADMODULE         => 'error while including on demand module',
                Doctrine_Core::ERR_TRUNCATED          => 'truncated',
                Doctrine_Core::ERR_DEADLOCK           => 'deadlock detected',
            );

    /**
     * Return a textual error message for a Doctrine error code
     *
     * @param   int|array   integer error code,
     *                           null to get the current error code-message map,
     *                           or an array with a new error code-message map
     *
     * @return  string  error message
     */
    public function errorMessage($value = null)
    {
        if (is_null($value)) {
            return self::$_errorMessages;
        }

        return isset(self::$_errorMessages[$value]) ?
           self::$_errorMessages[$value] : self::$_errorMessages[Doctrine_Core::ERR];
    }

}
