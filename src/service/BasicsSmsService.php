<?php
/**
 * 短信通道
 */
namespace pizepei\contactVerification\service;

use pizepei\basics\service\microservice\BasicsMicroserviceAppsService;
use pizepei\contactVerification\model\AppsSmsConfigModel;
use pizepei\contactVerification\service\sms\Alibaba;

class BasicsSmsService
{
      const Channel = [
        'Alibaba'=>Alibaba::class,
      ];
      private $appsConfig = [];
    public function __construct($appid)
    {
        # 通过appid 获取配置
        $this->appsConfig = BasicsMicroserviceAppsService::getFarAppsConfig($appid);
        var_dump($this->appsConfig);
    }

    public static function addAppsSmsConfig(string $appid,array $data)
    {
        $config = Helper()->json_decode($data['config']??'');
        if (empty($config)){throw  new \Exception('config error');}
        # 写入配置
        $appsConfig = BasicsMicroserviceAppsService::getFarAppsConfig($appid);
        if (empty($appsConfig)){ throw  new \Exception('apps  inexistence'); }
        $data['config'] = $config;
        $data['appid'] = $appid;
        # 写入配置
        return AppsSmsConfigModel::table()->add($data);
    }



}