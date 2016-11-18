<?php
/**
 * @author: runnerlee
 * @email: runnerleer@gmail.com
 * @time: 2016-11-18 下午2:24
 */

namespace Runner\Aliyun\Core;

class Response
{

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $content;


    /**
     * Response constructor.
     * @param int $statusCode
     * @param array $headers
     * @param string $content
     */
    public function __construct($statusCode, array $headers, $content)
    {
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->content = $content;
    }


    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    /**
     * @param $key
     * @return string
     * @throws \Exception
     */
    public function getHeader($key)
    {
        if (!array_key_exists($key, $this->headers)) {
            throw new \Exception('header not exists');
        }

        return $this->headers[$key];
    }


    public function getContent()
    {
        return $this->content;
    }

}