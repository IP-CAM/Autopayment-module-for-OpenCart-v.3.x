<?php

class ModelExtensionPaymentAutopayment extends Model
{
    public function getMethod()
    {
        $this->load->language('extension/payment/autopayment');

        return [
            'code' => 'autopayment',
            'title' => $this->language->get('text_title'),
            'terms' => '',
            'sort_order' => $this->config->get('payment_autopayment_sort_order')
        ];
    }
}