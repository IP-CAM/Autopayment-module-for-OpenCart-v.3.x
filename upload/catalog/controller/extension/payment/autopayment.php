<?php

class ControllerExtensionPaymentAutopayment extends Controller
{
    public function index()
    {
        $this->load->language('extension/payment/autopayment');

        $data['continue'] = $this->url->link('extension/payment/autopayment/checkout', '', true);

        return $this->load->view('extension/payment/autopayment', $data);
    }

    public function checkout()
    {
        if (
            (!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) ||
            (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))
        ) {
            $this->response->redirect($this->url->link('checkout/cart'));
        }

        $this->load->model('checkout/order');

        // Emulate create order
        $initial_status_id = $this->config->get('payment_autopayment_initial_status_id');
        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $initial_status_id);

        //Emulate after payout order
        $result_status_id = $this->config->get('payment_autopayment_result_status_id');
        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $result_status_id);

        $success = $this->config->get('payment_autopayment_payment_result');
        if ($success == 'success') {
            $this->response->redirect($this->url->link('checkout/success'));
        } else {
            $this->response->redirect($this->url->link('checkout/failure'));
        }
    }
}