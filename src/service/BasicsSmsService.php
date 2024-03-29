<?php
/**
 * 短信通道
 */
namespace pizepei\contactVerification\service;

use pizepei\basics\service\microservice\BasicsMicroserviceAppsService;
use pizepei\contactVerification\model\AppsSmsConfigModel;
use pizepei\contactVerification\service\sms\Alibaba;
use pizepei\contactVerification\service\sms\Sms;

class BasicsSmsService
{
    /**
     * 通道
     * @var array
     */
    private $Channel = [
        'Alibaba'=>Alibaba::class,
      ];
    /**
     * apps应用配置
     * @var array
     */
    private $appsConfig = [];
    /**
     *通道配置
     * @var array|mixed
     */
    private $AppsSmsConfig = [];

    /**
     *
     * BasicsSmsService constructor.
     * @param $appid    appsAppid
     * @param $AppsSmsConfigId   通道配置id
     * @throws \Exception
     */
    public function __construct($appsid,$AppsSmsConfigId)
    {
        # 通过appid 获取配置
        $this->appsConfig = BasicsMicroserviceAppsService::getFarAppsConfig($appsid);
        if (empty($this->appsConfig)){ throw new \Exception('appsConfig  inexistence');}

        # 获取通道配置
        $this->AppsSmsConfig =  AppsSmsConfigModel::table()->cache(['Microservice:AppsSmsConfig',$appsid],120)->get($AppsSmsConfigId);
        if (empty($this->AppsSmsConfig)){ throw new \Exception('AppsSmsConfig  inexistence');}
    }


    /**
     * 发送
     * @param $data
     * @return mixed
     */
    public function send($data)
    {
        # 通道
        $sms =  new $this->Channel[$this->AppsSmsConfig['channel']]($this->AppsSmsConfig['config']);
        $res = $sms->send($data);
        if (isset($res['error'])){
            # 准备错误日志
        }
        # 写入发送日志

        return $res;

    }

    /**
     * 添加apps sms通道配置
     * @param string $appid  apps appid
     * @param array $data   具体数据
     * @return array
     * @throws \Exception
     */
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