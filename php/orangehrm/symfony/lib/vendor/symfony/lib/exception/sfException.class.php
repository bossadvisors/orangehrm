<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) 2004-2006 Sean Kerr <sean@code-box.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfException is the base class for all symfony related exceptions and
 * provides an additional method for printing up a detailed view of an
 * exception.
 *
 * @package    symfony
 * @subpackage exception
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <sean@code-box.org>
 * @version    SVN: $Id: sfException.class.php 18492 2009-05-20 14:19:35Z nicolas $
 */
class sfException extends Exception
{
  protected
    $wrappedException = null;

  /**
   * Wraps an Exception.
   *
   * @param Exception $e An Exception instance
   *
   * @return sfException An sfException instance that wraps the given Exception object
   */
  static public function createFromException(Exception $e)
  {
    $exception = new sfException(sprintf('Wrapped %s: %s', get_class($e), $e->getMessage()));
    $exception->setWrappedException($e);

    return $exception;
  }

  /**
   * Changes the wrapped exception.
   *
   * @param Exception $e An Exception instance
   */
  public function setWrappedException(Exception $e)
  {
    $this->wrappedException = $e;
  }

  /**
   * Prints the stack trace for this exception.
   */
  public function printStackTrace()
  {
    $exception = is_null($this->wrappedException) ? $this : $this->wrappedException;

    if (!sfConfig::get('sf_test'))
    {
      // log all exceptions in php log
      error_log($exception->getMessage());

      // clean current output buffer
      while (ob_get_level())
      {
        if (!ob_end_clean())
        {
          break;
        }
      }

      ob_start();

      header('HTTP/1.0 500 Internal Server Error');
    }

    try
    {
      $this->outputStackTrace($exception);
    }
    catch (Exception $e)
    {
    }

    if (!sfConfig::get('sf_test'))
    {
      exit(1);
    }
  }

  /**
   * Gets the stack trace for this exception.
   */
  static protected function outputStackTrace(Exception $exception)
  {
    $format = 'html';
    $code   = '500';
    $text   = 'Internal Server Error';

    if (class_exists('sfContext', false) && sfContext::hasInstance() && is_object($request = sfContext::getInstance()->getRequest()) && is_object($response = sfContext::getInstance()->getResponse()))
    {
      $dispatcher = sfContext::getInstance()->getEventDispatcher();

      if (sfConfig::get('sf_logging_enabled'))
      {
        $dispatcher->notify(new sfEvent($exception, 'application.log', array($exception->getMessage(), 'priority' => sfLogger::ERR)));
      }

      $event = $dispatcher->notifyUntil(new sfEvent($exception, 'application.throw_exception'));
      if ($event->isProcessed())
      {
        return;
      }

      if ($response->getStatusCode() < 300)
      {
        // status code has already been sent, but is included here for the purpose of testing
        $response->setStatusCode(500);
      }

      $response->setContentType('text/html');

      if (!sfConfig::get('sf_test'))
      {
        foreach ($response->getHttpHeaders() as $name => $value)
        {
          header($name.': '.$value);
        }
      }

      $code = $response->getStatusCode();
      $text = $response->getStatusText();

      $format = $request->getRequestFormat();
      if (!$format)
      {
        $format = 'html';
      }

      if ($mimeType = $request->getMimeType($format))
      {
        $response->setContentType($mimeType);
      }
    }
    else
    {
      // a backward compatible default
      if (!sfConfig::get('sf_test'))
      {
        header('Content-Type: text/html; charset='.sfConfig::get('sf_charset', 'utf-8'));
      }
    }

    // send an error 500 if not in debug mode
    if (!sfConfig::get('sf_debug'))
    {
      if ($template = self::getTemplatePathForError($format, false))
      {
        include $template;
        return;
      }
    }

    $message = is_null($exception->getMessage()) ? 'n/a' : $exception->getMessage();
    $name    = get_class($exception);
    $traces  = self::getTraces($exception, 'html' != $format || 0 == strncasecmp(PHP_SAPI, 'cli', 3) ? 'plain' : 'html');

    // dump main objects values
    $sf_settings = '';
    $settingsTable = $requestTable = $responseTable = $globalsTable = $userTable = '';
    if (class_exists('sfContext', false) && sfContext::hasInstance())
    {
      $context = sfContext::getInstance();
      $settingsTable = self::formatArrayAsHtml(sfDebug::settingsAsArray());
      $requestTable  = self::formatArrayAsHtml(sfDebug::requestAsArray($context->getRequest()));
      $responseTable = self::formatArrayAsHtml(sfDebug::responseAsArray($context->getResponse()));
      $userTable     = self::formatArrayAsHtml(sfDebug::userAsArray($context->getUser()));
      $globalsTable  = self::formatArrayAsHtml(sfDebug::globalsAsArray());
    }

    if ($template = self::getTemplatePathForError($format, true))
    {
      include $template;
      return;
    }
  }

  /**
   * Returns the path for the template error message.
   *
   * @param string  $format The request format
   * @param Boolean $debug  Whether to return a template for the debug mode or not
   *
   * @return string|Boolean false if the template cannot be found for the given format,
   *                        the absolute path to the template otherwise
   */
  static public function getTemplatePathForError($format, $debug)
  {
    $templatePaths = array(
      sfConfig::get('sf_app_config_dir').'/error',
      sfConfig::get('sf_config_dir').'/error',
      dirname(__FILE__).'/data',
    );

    $template = sprintf('%s.%s.php', $debug ? 'exception' : 'error', $format);
    foreach ($templatePaths as $path)
    {
      if (!is_null($path) && is_readable($file = $path.'/'.$template))
      {
        return $file;
      }
    }

    return false;
  }

  /**
   * Returns an array of exception traces.
   *
   * @param Exception $exception An Exception implementation instance
   * @param string    $format    The trace format (plain or html)
   *
   * @return array An array of traces
   */
  static protected function getTraces($exception, $format = 'plain')
  {
    $traceData = $exception->getTrace();
    array_unshift($traceData, array(
      'function' => '',
      'file'     => $exception->getFile() != null ? $exception->getFile() : 'n/a',
      'line'     => $exception->getLine() != null ? $exception->getLine() : 'n/a',
      'args'     => array(),
    ));

    $traces = array();
    if ($format == 'html')
    {
      $lineFormat = 'at <strong>%s%s%s</strong>(%s)<br />in <em>%s</em> line %s <a href="#" onclick="toggle(\'%s\'); return false;">...</a><br /><ul id="%s" style="display: %s">%s</ul>';
    }
    else
    {
      $lineFormat = 'at %s%s%s(%s) in %s line %s';
    }
    for ($i = 0, $count = count($traceData); $i < $count; $i++)
    {
      $line = isset($traceData[$i]['line']) ? $traceData[$i]['line'] : 'n/a';
      $file = isset($traceData[$i]['file']) ? $traceData[$i]['file'] : 'n/a';
      $shortFile = preg_replace(array('#^'.preg_quote(sfConfig::get('sf_root_dir')).'#', '#^'.preg_quote(realpath(sfConfig::get('sf_symfony_lib_dir'))).'#'), array('SF_ROOT_DIR', 'SF_SYMFONY_LIB_DIR'), $file);
      $args = isset($traceData[$i]['args']) ? $traceData[$i]['args'] : array();
      $traces[] = sprintf($lineFormat,
        (isset($traceData[$i]['class']) ? $traceData[$i]['class'] : ''),
        (isset($traceData[$i]['type']) ? $traceData[$i]['type'] : ''),
        $traceData[$i]['function'],
        self::formatArgs($args, false, $format),
        $shortFile,
        $line,
        'trace_'.$i,
        'trace_'.$i,
        $i == 0 ? 'block' : 'none',
        self::fileExcerpt($file, $line)
      );
    }

    return $traces;
  }

  /**
   * Returns an HTML version of an array as YAML.
   *
   * @param array $values The values array
   *
   * @return string An HTML string
   */
  static protected function formatArrayAsHtml($values)
  {
    return '<pre>'.self::escape(@sfYaml::dump($values)).'</pre>';
  }

  /**
   * Returns an excerpt of a code file around the given line number.
   *
   * @param string $file A file path
   * @param int    $line The selected line number
   *
   * @return string An HTML string
   */
  static protected function fileExcerpt($file, $line)
  {
    if (is_readable($file))
    {
      $content = preg_split('#<br />#', highlight_file($file, true));

      $lines = array();
      for ($i = max($line - 3, 1), $max = min($line + 3, count($content)); $i <= $max; $i++)
      {
        $lines[] = '<li'.($i == $line ? ' class="selected"' : '').'>'.$content[$i - 1].'</li>';
      }

      return '<ol start="'.max($line - 3, 1).'">'.implode("\n", $lines).'</ol>';
    }
  }

  /**
   * Formats an array as a string.
   *
   * @param array   $args   The argument array
   * @param boolean $single
   * @param string  $format The format string (html or plain)
   *
   * @return string
   */
  static protected function formatArgs($args, $single = false, $format = 'html')
  {
    $result = array();

    $single and $args = array($args);

    foreach ($args as $key => $value)
    {
      if (is_object($value))
      {
        $formattedValue = ($format == 'html' ? '<em>object</em>' : 'object').sprintf("('%s')", get_class($value));
      }
      else if (is_array($value))
      {
        $formattedValue = ($format == 'html' ? '<em>array</em>' : 'array').sprintf("(%s)", self::formatArgs($value));
      }
      else if (is_string($value))
      {
        $formattedValue = ($format == 'html' ? sprintf("'%s'", self::escape($value)) : "'$value'");
      }
      else if (is_null($value))
      {
        $formattedValue = ($format == 'html' ? '<em>null</em>' : 'null');
      }
      else
      {
        $formattedValue = $value;
      }
      
      $result[] = is_int($key) ? $formattedValue : sprintf("'%s' => %s", self::escape($key), $formattedValue);
    }

    return implode(', ', $result);
  }
  
  /**
   * Escapes a string value with html entities
   *
   * @param  string  $value
   *
   * @return string
   */
  static protected function escape($value)
  {
    if (!is_string($value))
    {
      return $value;
    }
    
    return htmlspecialchars($value, ENT_QUOTES, sfConfig::get('sf_charset', 'UTF-8'));
  }
}
