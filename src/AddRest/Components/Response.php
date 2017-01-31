<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Components;

/**
 * Simple Response class to return HTTP header and string content to the
 * client
 *
 * Could be extended to handle HTTP status and cookies, etc.
 */
class Response
{
    /**
     * @var array HTTP headers to be sent
     */
    protected $headers = array();

    /**
     * @var string Response body; data to be output after the headers
     */
    protected $body = '';

    public function __construct($body = '', $headers = [])
    {
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * Send the whole Response, headers and contents
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    /**
     * Send the HTTP headers, if they were not sent already
     *
     * @return bool true on success, false if headers were already sent
     */
    public function sendHeaders()
    {
        if (headers_sent()) {
            return false;
        }

        foreach ($this->headers as $header => $value) {
            header("{$header}: {$value}");
        }

        return true;
    }

    /**
     * Output the body contents
     */
    public function sendBody()
    {
        echo $this->body;
    }

    /**
     * Add an HTTP header to the output
     *
     * @param string $header
     * @param string $value
     */
    public function addHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     * Return the array of headers
     *
     * @return array 'header' => 'value' format
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Return the body of the response
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the content to be sent
     *
     * @param string $bodyString
     */
    public function setBody($bodyString)
    {
        $this->body = $bodyString;
    }
}
