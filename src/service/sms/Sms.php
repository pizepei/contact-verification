<?php
/**
 * 短信接口类
 */
namespace pizepei\contactVerification\service\sms;


interface Sms
{
    /**
     * 通常包括了加密参数和模板参数
     * Alibaba constructor.
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @Author 皮泽培
     * @Created 2019/10/30 15:27
     * @param int $phone
     * @param array $data
     * @title  路由标题
     * @throws \Exception
     */
    public function send(int $phone,array $data):array ;

    /**
     * @Author 皮泽培
     * @Created 2019/10/30 15:36
     * @title  查询当前账号剩余数量（服务商账号）
     * @return mixed
     */
    public function balanceInquiry():int ;
}