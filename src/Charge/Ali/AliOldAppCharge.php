<?php
namespace Payment\Charge\Ali;

use Payment\Common\Ali\AliBaseStrategy;
use Payment\Common\Ali\Data\Charge\OldAppChargeData;
use Payment\Utils\ArrayUtil;
use Payment\Utils\StrUtil;

/**
 * @author: helei
 * @createTime: 2016-07-14 18:20
 * @description: 支付宝移动支付接口
 * @link      https://www.gitbook.com/book/helei112g1/payment-sdk/details
 * @link      https://helei112g.github.io/
 */
class AliOldAppCharge extends AliBaseStrategy
{
    // app 支付接口名称
    protected $method = 'alipay.trade.app.pay';

    /**
     * 获取支付对应的数据完成类
     * @return string
     * @author helei
     */
    public function getBuildDataClass()
    {
        $this->config->method = $this->method;
        // 以下两种方式任选一种
        return OldAppChargeData::class;
    }


    /**
     * 处理支付宝的返回值并返回给客户端
     * @author: imdao
     * @param array $data
     * @return string|array
     * @author helei
     */
    protected function retData(array $data)
    {
        $sign = $data['sign'];
        $data = ArrayUtil::removeKeys($data, ['sign']);

        //为兼容公司客户端支付参数，强制取消参数排序
        //$data = ArrayUtil::arraySort($data);

        // 支付宝新版本  需要转码
        foreach ($data as &$value) {
            $value = StrUtil::characet($value, $this->config->charset);
        }

        $data['sign'] = $sign;// sign  需要放在末尾
        
        //为兼容公司客户端支付参数，强制防止在末尾
        //$data['sign_type'] = 'RSA';
        $data['sign_type'] = $this->signType;

        // 组装成 key=value&key=value 形式返回
        return http_build_query($data);
    }
}
