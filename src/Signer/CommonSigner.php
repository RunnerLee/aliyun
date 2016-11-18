<?php
/**
 * @author: runnerlee
 * @email: runnerleer@gmail.com
 * @time: 2016-11-18 上午11:40
 */

namespace Runner\Aliyun\Signer;

class CommonSigner implements SignerInterface
{

    public function sign($string, $key)
    {
        return base64_encode(hash_hmac('sha1', $string, $key . '&', true));
    }

    public function getMethod()
    {
        return 'HMAC-SHA1';
    }

    public function getVersion()
    {
        return '1.0';
    }
}