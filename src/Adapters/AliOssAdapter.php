<?php

namespace Due\Fast\Adapters;

use Jacobcyl\AliOSS\AliOssAdapter as OriginAliOssAdapter;

/**
 * 阿里云OSS适配器
 * @package Due\Fast\Adapters
 */
class AliOssAdapter extends OriginAliOssAdapter
{
    /**
     * 获取URL
     *
     * @param string $path 路径
     * @return string URL地址
     */
    public function getUrl($path)
    {
        return ($this->ssl ? 'https://' : 'http://') . ($this->isCname ? ($this->cdnDomain == '' ? $this->endPoint : $this->cdnDomain) : $this->bucket . '.' . $this->endPoint) . '/' . ltrim($path, '/');
    }
}
