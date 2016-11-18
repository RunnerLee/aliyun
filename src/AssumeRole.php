<?php
/**
 * @author: runnerlee
 * @email: runnerleer@gmail.com
 * @time: 2016-11-18 下午3:49
 */
namespace Runner\Aliyun;

use Runner\Aliyun\Core\AbstractApi;

class AssumeRole extends AbstractApi
{
    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://sts.aliyuncs.com/';
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return 'AssumeRole';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '2015-04-01';
    }


    public function setRoleArn($value)
    {
        return $this->setParameters('RoleArn', $value);
    }


    public function setRoleSessionName($value)
    {
        return $this->setParameters('RoleSessionName', $value);
    }


    public function setDurationSeconds($value)
    {
        return $this->setParameters('DurationSeconds', $value);
    }
}