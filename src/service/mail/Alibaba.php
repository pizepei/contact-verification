<?php
/**
 * Class Alibaba
 * 阿里云通道
 */
namespace pizepei\contactVerification\service\mail;

use AlibabaCloud\Client\AlibabaCloud;

class Alibaba implements Mail
{
    /**
     * 通道配置
     * @var array
     */
    protected $config = [
        'regionId'=>'cn-hangzhou',
        'version'=>'2015-11-23',
        'action'=>'SingleSendMail',
        'method'=>'POST',
        'host'=>'dm.aliyuncs.com',
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
            'AccountName' => $this->config['AccountName']['value'],
            'AddressType' => $this->config['AddressType']['value'],
            'ReplyToAddress' => false,
            'ToAddress' =>$data['mail'],
            'Subject' => $data['Subject'],
        ];
        if ($data['bodyType'] == 'HtmlBody'){
            $options['HtmlBody'] = $data['body'];
        }else{
            $options['HtmlBody'] = $data['body'];
        }
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