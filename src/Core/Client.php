<?php
/**
 * @author: runnerlee
 * @email: runnerleer@gmail.com
 * @time: 2016-11-18 上午11:12
 */
namespace Runner\Aliyun\Core;

use DateTime, DateTimeZone;
use Runner\Aliyun\Exceptions\MethodNotAllowedException;
use Runner\Aliyun\Exceptions\RequestException;

class Client
{

    /**
     * @var string
     */
    protected $accessKeyId;

    /**
     * @var string
     */
    protected $accessKeySecret;

    /**
     * @var string
     */
    protected $region;

    /**
     * @var AbstractApi
     */
    protected $api;

    /**
     * @var string
     */
    protected $format = 'JSON';

    /**
     * @var string
     */
    protected $timestampFormat = 'Y-m-d\TH:i:s\Z';

    /**
     * @var array
     */
    protected $allowFormat = [
        'JSON', 'XML'
    ];


    /**
     * Client constructor.
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $region
     */
    public function __construct($accessKeyId, $accessKeySecret, $region = 'ch-hangzhou')
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        $this->region = $region;
    }


    /**
     * @param AbstractApi $api
     * @return $this
     */
    public function setApi(AbstractApi $api)
    {
        $this->api = $api;

        return $this;
    }


    /**
     * @param string $format
     * @return $this
     * @throws MethodNotAllowedException
     */
    public function setFormat($format)
    {
        if (! in_array($this->allowFormat, ($format = strtoupper($format)))) {
            throw new MethodNotAllowedException("{$format} is not an allow format");
        }
        $this->format = $format;

        return $this;
    }


    /**
     * @return Response
     * @throws RequestException
     */
    public function send()
    {
        $parameters = array_merge($this->getCommonParameters(), $this->api->getParameters());
        $parameters['Signature'] = $this->buildCanonicalizedQueryString($parameters);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->buildRequestUrl($parameters),
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'x-sdk-client:php/2.0.0',
            ],
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
        ]);

        $response = curl_exec($curl);

        if (false === strpos($response, "\r\n\r\n") || !! curl_errno($curl)) {
            throw new RequestException();
        }

        list($headersRaw, $content) = explode("\r\n\r\n", $response, 2);

        $headers = [];
        foreach (explode("\r\n", ltrim(strstr($headersRaw, "\r\n"))) as $line) {
            list($key, $value) = explode(':', $line);
            $headers[$key] = trim($value);
        }

        return new Response(curl_getinfo($curl, CURLINFO_HTTP_CODE), $headers, $content);
    }


    protected function getCommonParameters()
    {
        return [
            'Format'            => $this->format,
            'Version'           => $this->api->getVersion(),
            'AccessKeyId'       => $this->accessKeyId,
            'Timestamp'         => (new DateTime('now', new DateTimeZone('UTC')))->format($this->timestampFormat),
            'SignatureMethod'   => $this->api->getSigner()->getMethod(),
            'SignatureVersion'  => $this->api->getSigner()->getVersion(),
            'SignatureNonce'    => uniqid(),
            'Action'            => $this->api->getAction(),
        ];
    }


    /**
     * @param array $parameters
     * @return string
     */
    protected function buildCanonicalizedQueryString(array $parameters)
    {
        ksort($parameters);

        return $this->api->getSigner()->sign('GET&%2F&' . rawurlencode(http_build_query($parameters)), $this->accessKeySecret);
    }


    /**
     * @param array $parameters
     * @return string
     */
    protected function buildRequestUrl(array &$parameters)
    {
        return rtrim($this->api->getUrl(), '/') . '/?' . http_build_query($parameters);
    }

}
