<?php

namespace pizepei\contactVerification\controller;

use AlibabaCloud\Client\AlibabaCloud;
use pizepei\contactVerification\service\BasicsSmsService;
use pizepei\contactVerification\service\sms\Alibaba;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class BasicsSms extends Controller
{


    /**
     * @Author 皮泽培
     * @Created 2019/10/30 14:43
     * @param Request $Request
     *      path [object]
     *          appid [uuid required] apps应用appid
     *      post [object] 数据
     *          configId [uuid required]  配置id
     *          number [int required] 手机号码
     *          TemplateParam [object]
     *              code   [int required] 验证码
     * @return array [json] 定义输出返回数据
     *      data [raw]
     * @title  测试
     * @explain 路由功能说明
     * @authGroup basics.menu.getMenu:权限分组1,basics.index.menu:权限分组2
     * @authExtend UserExtend.list:拓展权限
     * @baseAuth MicroserviceAuth:initializeData
     * @resourceType microservice
     * @throws \Exception
     * @router post test/:appid[uuid]
     */
    public function test(Request $Request)
    {
        return $this->succeed((new BasicsSmsService($Request->path('appid'),$Request->post('configId')))->send($Request->post()));
    }

    /**
     * @Author 皮泽培
     * @Created 2019/10/30 17:35
     * @param Request $Request
     *   path [object] 路径参数
     *      appid [uuid] apps 应用的appid
     *   post [object] post参数
     *      name [string required] 配置名称
     *      remark [string required] 配置名称
     *      channel [string required] 配置名称
     *      config [raw] 配置名称
     *   rule [object] 数据流参数
     * @return array [json] 定义输出返回数据
     *      id [uuid] uuid
     *      name [object] 同学名字
     * @title  添加对应apps应用的sms配置
     * @explain 添加对应apps应用的sms配置
     * @authGroup basics.menu.getMenu:权限分组1,basics.index.menu:权限分组2
     * @authExtend UserExtend.list:拓展权限
     * @baseAuth Resource:public
     * @throws \Exception
     * @router post apps-config/:appid[uuid]
     */
    public function addAppsSmsConfig(Request $Request)
    {
        return BasicsSmsService::addAppsSmsConfig($Request->path('appid'),$Request->post());
    }
}