<?php

namespace Engine;

use Phalcon\DI;
use Phalcon\Exception as PhException;

/**
 * Default system exception.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Exception extends \Exception
{
    /**
     * Create exception.
     *
     * @param string     $message  Exception message.
     * @param array      $args     Message arguments (for placeholders, sprintf).
     * @param int        $code     Exception code.
     * @param \Exception $previous Previous exception.
     */
    public function __construct($message = "", $args = [], $code = 0, \Exception $previous = null)
    {
        parent::__construct(vsprintf($message, $args), $code, $previous);
    }

    /**
     * Log exception.
     *
     * @param \Exception $e Exception object.
     *
     * @return string
     */
    public static function logException($e)
    {
        return self::logError(
            'Exception',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString()
        );
    }

    /**
     * Log error.
     *
     * @param string      $type    Type name.
     * @param string      $message Message text.
     * @param string      $file    File path.
     * @param string      $line    Line info.
     * @param string|null $trace   Trace info.
     *
     * @throws Exception
     * @return string
     */
    public static function logError($type, $message, $file, $line, $trace = null)
    {
        // $this->logger->addDebug('SELECT * FROM users', array('db', 'time' => 0.012));
        $id = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);
        $di = DI::getDefault();
        $template = "<%s> [%s] %s (File: %s Line: [%s])";
        $logMessage = sprintf($template, $id, $type, $message, $file, $line);

        if ($trace) {
            $logMessage .= $trace . PHP_EOL;
        } else {
            $logMessage .= PHP_EOL;
        }

        // Log production
        $logger = $di->get('logger');
        $logger->error($logMessage);
    }
}
