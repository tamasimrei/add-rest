<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Helpers;

/**
 * Static helper class for HTTP related things
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class HttpHelper
{
    /**
     * Exit PHP process with a specific HTTP/HTTPS code and message
     *
     * @param int $code
     * @param string $message
     */
    public static function exitWithStatus($code, $message)
    {
        $code = intval($code);
        header($_SERVER['SERVER_PROTOCOL'] . " {$code} {$message}", true, $code);
        header("Status: {$code} {$message}");
        $_SERVER['REDIRECT_STATUS'] = $code;
        exit;
    }
}
