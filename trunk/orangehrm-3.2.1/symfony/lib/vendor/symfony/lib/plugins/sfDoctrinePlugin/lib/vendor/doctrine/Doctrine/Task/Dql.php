<?php
/*
 *  $Id: Dql.php 2761 2007-10-07 23:42:29Z zYne $
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
 * Doctrine_Task_Dql
 *
 * @package     Doctrine
 * @subpackage  Task
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.doctrine-project.org
 * @since       1.0
 * @version     $Revision: 2761 $
 * @author      Jonathan H. Wage <jwage@mac.com>
 */
class Doctrine_Task_Dql extends Doctrine_Task
{
    public $description          =   'Execute dql query and display the results',
           $requiredArguments    =   array('models_path'    =>  'Specify path to your Doctrine_Record definitions.',
                                           'dql_query'      =>  'Specify the complete dql query to execute.'),
           $optionalArguments    =   array('params'         =>  'Comma separated list of the params to replace the ? tokens in the dql');

    public function execute()
    {
        Doctrine_Core::loadModels($this->getArgument('models_path'));

        $dql = $this->getArgument('dql_query');

        $query = Doctrine_Query::create();

        $params = $this->getArgument('params');
        $params = $params ? explode(',', $params):array();

        $this->notify('executing: "' . $dql . '" (' . implode(', ', $params) . ')');

        $results = $query->query($dql, $params, Doctrine_Core::HYDRATE_ARRAY);

        $this->_printResults($results);
    }

    protected function _printResults($array)
    {
        $yaml = Doctrine_Parser::dump($array, 'yml');
        $lines = explode("\n", $yaml);

        unset($lines[0]);

        foreach ($lines as $yamlLine) {
            $line = trim($yamlLine);

            if ($line) {
                $this->notify($yamlLine);
            }
        }
    }
}