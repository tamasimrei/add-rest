<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Exceptions\Http;

/**
 * Exception thrown to return a HTTP 404 Not Found status
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class HttpNotFoundException extends HttpException
{
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        // Forcing message and code
        parent::__construct('Not Found', 404, $previous);
    }
}
