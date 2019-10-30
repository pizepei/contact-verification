<?php
/**
 * Class Alibaba
 * 阿里云通道
 */
namespace pizepei\contactVerification\service\sms;

use AlibabaCloud\Client\AlibabaCloud;
use app\test;

class Alibaba implements Sms
{
    /**
     * 通道配置
     * @var array
     */
    protected $config = [
        'regionId'=>'cn-hangzhou',
        'product'=>'Dysmsapi',
        'version'=>'2017-05-25',
        'action'=>'SendSms',
        'method'=>'POST',
        'host'=>'dysmsapi.aliyuncs.com',
    ];
    /**
     * 通常包括了加密参数和模板参数
     * Alibaba constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (!isset($config['accessKeyId']) || !isset($config['accessKeySecret'])){ throw new \Exception('error config',600001);}
        # 合并配置
        $this->config = array_merge($this->config,$config);
    }

    /**
     * @Author 皮泽培
     * @Created 2019/10/30 15:27
     * @param $data
     * @title  发送
     * @throws \Exception
     */
    public function send(array$data):array
    {
        # 配置数据
        $options = [
            'PhoneNumbers'=>$data['number'],
            'SignName' => $this->config['SignName']['value'],
            'TemplateCode' => $this->config['TemplateCode']['value'],
            'TemplateParam' => Helper()->json_encode($data['TemplateParam']),
        ];
        # 处理 TemplateParam
        return $this->request($options);
    }

    public function request(array $options)
    {
        $options['regionId'] = $this->config['regionId'];
        AlibabaCloud::accessKeyClient($this->config['accessKeyId']['value'], $this->config['accessKeySecret']['value'])
            ->regionId($this->config['regionId'])
            ->asDefaultClient();
        try {
            $result = AlibabaCloud::rpc()
                ->product($this->config['product'])
                 ->scheme('https') // https | http
                ->version($this->config['version'])
                ->action($this->config['action'])
                ->method($this->config['method'])
                ->host($this->config['host'])
                ->options([
                    'query' =>
                        $options
                ])
                ->request();
            return $result->toArray();
        } catch (ClientException $e) {
            return ['error'=>$e->getErrorMessage()];
        } catch (ServerException $e) {
            return ['error'=>$e->getErrorMessage()];
        }

    }


    public function balanceInquiry():int
    {
        
    }

}