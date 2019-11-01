<?php
/**
 * apps 应用 Mail 配置表
 */
namespace pizepei\contactVerification\model;


use pizepei\model\db\Model;

class AppsMailConfigModel extends Model
{

    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'name'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'配置名称',
        ],
        'appid'=>[
            'TYPE'=>"uuid", 'DEFAULT'=>false, 'COMMENT'=>'apps的appid',
        ],
        'remark'=>[
            'TYPE'=>"varchar(600)", 'DEFAULT'=>'', 'COMMENT'=>'配置备注',
        ],
        'channel'=>[
            'TYPE'=>"varchar(600)", 'DEFAULT'=>false, 'COMMENT'=>'通道配置',
        ],
        'config'=>[
            'TYPE'=>"json", 'DEFAULT'=>false, 'COMMENT'=>'配置',
        ],
        'extend'=>[
            'TYPE'=>"json", 'DEFAULT'=>false, 'COMMENT'=>'扩展',
        ],
        'status'=>[
            'TYPE'=>"ENUM('1','2','3','4','5')", 'DEFAULT'=>'1', 'COMMENT'=>'状态1等待审核、2正常3、禁用4、保留',
        ],
        /**
         * UNIQUE 唯一
         * SPATIAL 空间
         * NORMAL 普通 key
         * FULLTEXT 文本
         */
        'INDEX'=>[
            ['TYPE'=>'UNIQUE','FIELD'=>'name,appid','NAME'=>'name,appid','USING'=>'BTREE','COMMENT'=>'确定唯一'],
        ],//索引 KEY `ip` (`ip`) COMMENT 'sss 'user_name
        'PRIMARY'=>'id',//主键
    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = 'apps应用sms配置表';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 0;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [
    ];
    /**
     * 初始化数据：表不存在时自动创建表然后自动插入$initData数据
     *      支持多条
     * @var array
     */
    protected $initData = [
    ];
}