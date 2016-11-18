<?php
/**
 * @author: runnerlee
 * @email: runnerleer@gmail.com
 * @time: 2016-11-18 上午11:37
 */

namespace Runner\Aliyun\Signer;

interface SignerInterface
{

    /**
     * @param string $string
     * @param string $key
     * @return string
     */
    public function sign($string, $key);


    public function getMethod();


    public function getVersion();

}