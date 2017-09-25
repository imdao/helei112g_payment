<?php
namespace Payment\Common\Ali\Data\Charge;
use Payment\Utils\ArrayUtil;

/**
 * @author: helei
 * @createTime: 2016-07-25 14:49
 * @description: 生成支付宝app 支付所需的请求数据
 * @link      https://www.gitbook.com/book/helei112g1/payment-sdk/details
 * @link      https://helei112g.github.io/
 */
class OldAppChargeData extends ChargeBaseData
{

    /**
     * @author: imdao
     * @description: 覆盖父类方法
     * @return string
     */
    protected function getBizContent()
    {
        
        return $content;
    }

    /**
    * @author: imdao
    * @description: 覆盖父类方法
    */
    public function getData()
    {
        return $this->retData;
    }

    /**
     * 构建 支付 加密数据
     * @author: imdao
     */
    protected function buildData()
    {   
        $signData = [
            // 公共参数设置
            'partner'       => $this->partner,
            'seller_id'     => $this->seller_id,
            'out_trade_no'  => strval($this->order_no),
            'subject'       => strval($this->subject),
            'body'          => strval($this->body),   
            'total_fee'  => strval($this->amount),         
            'notify_url'  => 'http://api.yundaolan.com/v2/alipay/notify',
            'service'   => 'mobile.securitypay.pay',
            'payment_type' => '1',
            'it_b_pay'=>'10m',
            // 'app_id'        => $this->appId,
            // 'method'        => $this->method,
            // 'format'        => $this->format,
            '_input_charset'       => strtolower($this->charset),
            // 'sign_type'     => $this->signType,
            // 'timestamp'     => $this->timestamp,
            // 'version'       => $this->version,
            // 'notify_url'    => $this->notifyUrl,
        ];

        // 电脑支付  wap支付添加额外参数
        if (in_array($this->method, ['alipay.trade.page.pay', 'alipay.trade.wap.pay'])) {
            $signData['return_url'] = $this->returnUrl;
        }

        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($signData);
    }
}
