<?php

namespace pizepei\contactVerification\controller;

use AlibabaCloud\Client\AlibabaCloud;
use pizepei\contactVerification\service\BasicsSmsService;
use pizepei\contactVerification\service\sms\Alibaba;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class BasicsMail extends Controller
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
     * @router post send/:appid[uuid]
     */
    public function test(Request $Request)
    {
        return $this->succeed((new BasicsSmsService($Request->path('appid'),$Request->post('configId')))->send($Request->post()));
    }

}