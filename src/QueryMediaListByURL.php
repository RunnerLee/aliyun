<?php
/**
 * @author: runnerlee
 * @email: runnerleer@gmail.com
 * @time: 2016-11-18 下午5:54
 */

namespace Runner\Aliyun;

use Runner\Aliyun\Core\AbstractApi;

class QueryMediaListByURL extends AbstractApi
{

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://mts.cn-hangzhou.aliyuncs.com/';
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return 'QueryMediaListByURL';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '2014-06-18';
    }


    public function setFileURLs($value)
    {
        return $this->setParameters('FileURLs', $value);
    }


    public function setIncludePlayList($value)
    {
        return $this->setParameters('IncludePlayList', $value);
    }


    public function setIncludeSnapshotList($value)
    {
        return $this->setParameters('IncludeSnapshotList', $value);
    }


    public function setIncludeMediaInfo($value)
    {
        return $this->setParameters('IncludeMediaInfo', $value);
    }
}