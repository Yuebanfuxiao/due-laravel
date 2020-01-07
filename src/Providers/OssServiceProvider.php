<?php

namespace Due\Fast\Providers;

use Jacobcyl\AliOSS\Plugins\PutFile;
use Jacobcyl\AliOSS\Plugins\PutRemoteFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Due\Fast\Adapters\AliOssAdapter;
use OSS\OssClient;
use Illuminate\Support\Arr;

/**
 * OSS服务器提供者
 * @package Due\Fast\Providers
 */
class OssServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('oss', function ($app, $config) {
            $accessId = $config['access_id'];
            $accessKey = $config['access_key'];
            $bucket = $config['bucket'];
            $endpoint = $config['endpoint'];
            $cdnDomain = Arr::get($config, 'cdnDomain', '');
            $ssl = Arr::get($config, 'ssl', false) ?: false;
            $isCname = Arr::get($config, 'isCName', false) ?: false;
            $debug = Arr::get($config, 'debug', false) ?: false;
            $root = Arr::get($config, 'root', null) ?: null;
            $endpointInternal = Arr::get($config, 'endpoint_internal', '') ?: '';

            $epInternal = $endpointInternal ? $endpointInternal : $endpoint;

            if ($debug) Log::debug('OSS config:', $config);

            $client = new OssClient($accessId, $accessKey, $epInternal, false);
            $adapter = new AliOssAdapter($client, $bucket, $endpoint, $ssl, $isCname, $debug, $cdnDomain, $root);

            $filesystem = new Filesystem($adapter);
            $filesystem->addPlugin(new PutFile());
            $filesystem->addPlugin(new PutRemoteFile());

            return $filesystem;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
