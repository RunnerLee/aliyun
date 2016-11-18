<?php
/**
 * @author: runnerlee
 * @email: runnerleer@gmail.com
 * @time: 2016-11-18 上午11:36
 */

namespace Runner\Aliyun\Core;

use Runner\Aliyun\Signer\SignerInterface;
use Runner\Aliyun\Signer\CommonSigner;

abstract class AbstractApi
{

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var SignerInterface
     */
    protected $signer;


    /**
     * AbstractApi constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client->setApi($this);
        $this->signer = $this->setSigner();
    }


    /**
     * @return string
     */
    abstract public function getUrl();


    /**
     * @return string
     */
    abstract public function getAction();


    /**
     * @return string
     */
    abstract public function getVersion();


    /**
     * @return SignerInterface
     */
    public function setSigner()
    {
        return new CommonSigner();
    }


    /**
     * @return SignerInterface
     */
    public function getSigner()
    {
        return $this->signer;
    }


    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }


    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setParameters($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }


    /**
     * @return Response
     */
    public function send()
    {
        return $this->client->send();
    }


    /**
     * @param string $name
     * @param array $arguments
     * @return AbstractApi
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if('set' == substr($name, 0, 3)) {
            $key = preg_replace_callback('/[A-Z]/', function($match) {
                return '_' . strtolower($match[0]);
            }, lcfirst(substr($name, 3)));

            return $this->setParameters($key, $arguments[0]);
        }

        throw new \Exception('what the fuck');
    }

}
