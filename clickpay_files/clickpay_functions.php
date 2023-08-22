<?php

function clickpay_error_log($message)
{
    logTransaction('clickpay', $message, 'Failure');
}


function clickpay_getApi($params)
{
    // Gateway Configuration Parameters
    $_endpoint = $params['Endpoint'];
    $_merchant_id = $params['MerchantId'];
    $_merchant_key = $params['MerchantKey'];

    $pt = ClickpayApi::getInstance($_endpoint, $_merchant_id, $_merchant_key);

    return $pt;
}


function clickpay_session_paypage($payment_url = null)
{
    if ($payment_url) {
        $_SESSION['clickpay_paypage_url'] = $payment_url;
        $_SESSION['clickpay_paypage_time'] = time();
    } else {
        $is_sessioned =
            array_key_exists('clickpay_paypage_url', $_SESSION) &&
            array_key_exists('clickpay_paypage_time', $_SESSION);

        if (!$is_sessioned) {
            return false;
        }

        $pp_time = $_SESSION['clickpay_paypage_time'];
        $diff = time() - $pp_time;
        if ($diff > 1 * 60) {
            return false;
        }

        $pp_payment_url = $_SESSION['clickpay_paypage_url'];
        return $pp_payment_url;
    }
}
