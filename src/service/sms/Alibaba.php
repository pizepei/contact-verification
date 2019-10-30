<?php
/**
 * Class Alibaba
 * 阿里云通道
 */
namespace pizepei\contactVerification\service\sms;

use AlibabaCloud\Client\AlibabaCloud;

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
     * @param int $phone
     * @param $data
     * @title  路由标题
     * @throws \Exception
     */
    public function send(int $phone,array$data):array
    {

        return [];
    }

    public function request(array $options)
    {
        $options['regionId'] = $this->config['regionId'];
        AlibabaCloud::accessKeyClient($config['accessKeyId'], $config['accessKeySecret'])
            ->regionId($this->config['regionId'])
            ->asDefaultClient();
        try {
            $result = AlibabaCloud::rpc()
                ->product($this->config['Dysmsapi'])
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
            print_r($result->toArray());
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }

    }


    public function balanceInquiry():int
    {
        
    }

}