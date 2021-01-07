<?php

class ControllerExtensionPaymentAutopayment extends Controller
{
    public function index()
    {
        $this->load->language('extension/payment/autopayment');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting('payment_autopayment', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/autopayment', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/autopayment', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['payment_autopayment_initial_status_id'])) {
            $data['payment_autopayment_initial_status_id'] = $this->request->post['payment_autopayment_initial_status_id'];
        } else {
            $data['payment_autopayment_initial_status_id'] = $this->config->get('payment_autopayment_initial_status_id');
        }

        if (isset($this->request->post['payment_autopayment_result_status_id'])) {
            $data['payment_autopayment_result_status_id'] = $this->request->post['payment_autopayment_result_status_id'];
        } else {
            $data['payment_autopayment_result_status_id'] = $this->config->get('payment_autopayment_result_status_id');
        }

        if (isset($this->request->post['payment_autopayment_payment_result'])) {
            $data['payment_autopayment_payment_result'] = $this->request->post['payment_autopayment_payment_result'];
        } else {
            $data['payment_autopayment_payment_result'] = $this->config->get('payment_autopayment_payment_result');
        }

        if (isset($this->request->post['payment_autopayment_status'])) {
            $data['payment_autopayment_status'] = $this->request->post['payment_autopayment_status'];
        } else {
            $data['payment_autopayment_status'] = $this->config->get('payment_autopayment_status');
        }

        if (isset($this->request->post['payment_autopayment_sort_order'])) {
            $data['payment_autopayment_sort_order'] = $this->request->post['payment_autopayment_sort_order'];
        } else {
            $data['payment_autopayment_sort_order'] = $this->config->get('payment_autopayment_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/autopayment', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/autopayment')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function install()
    {
    }

    public function uninstall()
    {
    }
}
