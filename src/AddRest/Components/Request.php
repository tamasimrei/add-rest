<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Components;

/**
 * Request class, mapping incoming HTTP request into an object
 *
 * Now it only implements handling some of the $_SERVER variables and
 * the GET params. Could be extended to also for handle POST variables,
 * cookies, request headers, etc.
 */
class Request
{
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PUT = 'PUT';
    const HTTP_DELETE = 'DELETE';

    /**
     * @var string the HTTP method used ($_SERVER['REQUEST_METHOD'])
     */
    protected $httpMethod;

    /**
     * @var string the path specified after the current script's name
     *             ($_SERVER['PATH_INFO'])
     */
    protected $pathInfo;

    /**
     * @var array HTTP GET parameters
     */
    protected $httpGetParams = array();

    /**
     * @param array $serverVariables server variables ($_SERVER array)
     * @param array $httpGetParams HTTP GET parameters ($_GET array)
     */
    public function __construct(array $serverVariables, array $httpGetParams)
    {
        $this->httpMethod = (isset($serverVariables['REQUEST_METHOD'])) ?
            $serverVariables['REQUEST_METHOD'] : self::HTTP_GET;

        $this->pathInfo = (! empty($serverVariables['PATH_INFO'])) ?
            $serverVariables['PATH_INFO'] : '/';

        $this->httpGetParams = $httpGetParams;
    }

    /**
     * Return a HTTP GET parameter by name
     *
     * @param string $name
     * @return string
     */
    public function getHttpGetParam($name)
    {
        if (! array_key_exists($name, $this->httpGetParams)) {
            return null;
        }

        return $this->httpGetParams[$name];
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getPathInfo()
    {
        return $this->pathInfo;
    }
}
