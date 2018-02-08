<?php

class ControllerExtensionModuleDSocialShare extends Controller
{
    private $id = 'd_social_share';
    private $route = 'extension/module/d_social_share';
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->language($this->route);
        $this->load->model($this->route);
        $this->load->model('design/layout');
        $this->load->model('setting/setting');
        $this->load->model('customer/customer_group');
        $this->load->model('extension/d_opencart_patch/module');
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('extension/d_opencart_patch/user');
        $this->d_shopunity = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_shopunity.json'));
        $this->d_opencart_patch = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_opencart_patch.json'));
        $this->extension = json_decode(file_get_contents(DIR_SYSTEM . 'library/d_shopunity/extension/' . $this->id . '.json'), true);
        $this->d_twig_manager = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_twig_manager.json'));
    }

    public function index()
    {
        if ($this->d_shopunity) {
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->validateDependencies($this->id);
        }

        if ($this->d_twig_manager) {
            $this->load->model('extension/module/d_twig_manager');
            if (!$this->model_extension_module_d_twig_manager->isCompatible()) {
                $this->model_extension_module_d_twig_manager->installCompatibility();
                $this->session->data['success'] = $this->language->get('success_twig_compatible');
                $this->response->redirect($this->model_extension_d_opencart_patch_url->getExtensionLink('module'));
            }
        }
        $this->load->language($this->route);

        // Scripts
        $this->document->addStyle('view/stylesheet/d_bootstrap_extra/bootstrap.css');
        $this->document->addStyle('view/javascript/d_bootstrap_switch/css/bootstrap-switch.css');
        $this->document->addScript('view/javascript/d_bootstrap_switch/js/bootstrap-switch.min.js');
        $this->document->addStyle('view/javascript/d_bootstrap_colorpicker/css/bootstrap-colorpicker.css');
        $this->document->addScript('view/javascript/d_bootstrap_colorpicker/js/bootstrap-colorpicker.js');
        $this->document->addScript('view/javascript/d_tinysort/tinysort.js');
        $this->document->addScript('view/javascript/d_tinysort/jquery.tinysort.min.js');
        $this->document->addScript('view/javascript/d_social_share/bootstrap-sortable.js');
        $this->document->addStyle('view/stylesheet/d_social_share/styles.css');

        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];
        } else {
            $store_id = 0;
        }

        // Saving
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            // 3.x fix
            if (VERSION >= '3.0.0.0') {
                $sl_post_array = array();
                if ($this->request->post[$this->id . '_status'] == 0) {
                    $sl_post_array['module_' . $this->id . '_status'] = 0;
                } elseif ($this->request->post[$this->id . '_status'] == 1) {
                    $sl_post_array['module_' . $this->id . '_status'] = 1;
                }
                $this->model_setting_setting->editSetting('module_' . $this->id, $sl_post_array, $store_id);
            }

            $this->model_setting_setting->editSetting($this->id, $this->request->post, $store_id);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->model_extension_d_opencart_patch_url->getExtensionLink('module'));
        }

        // Status
        if (isset($this->request->post[$this->id . '_status'])) {
            $data[$this->id . '_status'] = $this->request->post[$this->id . '_status'];
        } else {
            $data[$this->id . '_status'] = $this->config->get($this->id . '_status');
        }

        // Status
        $data['d_quickcheckout_status'] = $this->config->get('d_quickcheckout_status');

        // Error
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // Url
        $url = '';
        if (isset($this->request->get['store_id'])) {
            $url .= '&store_id=' . $store_id;
        }

        // Heading
        $this->document->setTitle($this->language->get('heading_title_main'));

        // Variable
        $data['id'] = $this->id;
        $data['route'] = $this->route;
        $data['store_id'] = $store_id;
        $data['version'] = $this->extension['version'];
        $data['token'] = $this->model_extension_d_opencart_patch_user->getUrlToken();
        $data['d_shopunity'] = $this->d_shopunity;
        $data['entry_get_update'] = sprintf($this->language->get('entry_get_update'), $data['version']);

        $data = array_merge($data, $this->getTextFields());

        // Buttons
        $data['button_save'] = $this->language->get('button_save');
        $data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_module_add'] = $this->language->get('button_module_add');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_clear_debug_file'] = $this->language->get('button_clear_debug_file');

        // Action
        $data['module_link'] = $this->model_extension_d_opencart_patch_url->link($this->route);
        $data['action'] = $this->model_extension_d_opencart_patch_url->link($this->route, $url);
        $data['cancel'] = $this->model_extension_d_opencart_patch_url->getExtensionLink('module');
        $data['clear_debug_file'] = $this->model_extension_d_opencart_patch_url->link($this->route . '/clearDebugFile');

        // Setting
        //load  config from config dir
        $this->config->load($this->id);
        $config = $this->config->get($this->id);
        //check if exist config in db
        if ($this->model_setting_setting->getSetting($this->id)) {
            $setting = $this->model_setting_setting->getSetting($this->id);
            $data['setting'] = ($setting) ? $setting[$this->id . '_setting'] : array();
        } else {
            $data['setting'] = array();
        }
        //inherit users data
        $data['setting'] =array_replace_recursive($config, $data['setting']);

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->link('common/dashboard')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->model_extension_d_opencart_patch_url->getExtensionLink('modules')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->model_extension_d_opencart_patch_url->link($this->route)
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view($this->route, $data));
    }
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (isset($this->request->post['config'])) {
            return false;
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    public function install()
    {
        if ($this->d_shopunity) {
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->installDependencies($this->id);
        }
        $this->load->model($this->route);
        $this->load->model('extension/d_opencart_patch/modification');
        $this->model_extension_d_opencart_patch_modification->setModification('d_social_share.xml', 1);
        $this->model_extension_d_opencart_patch_modification->refreshCache();
//        $this->model_extension_module_d_social_share->installDatabase();
    }
    public function uninstall()
    {
        $this->load->model($this->route);
        $this->load->model('extension/d_opencart_patch/modification');
        $this->model_extension_d_opencart_patch_modification->setModification('d_social_share.xml', 0);
        $this->model_extension_d_opencart_patch_modification->refreshCache();
//        $this->model_extension_module_d_social_share->uninstallDatabase();
    }
    public function getZone() {
        $json = $this->model_extension_module_d_social_share->getZonesByCountryId($this->request->get['country_id']);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    private function getTextFields()
    {
        $data = array();
        $data['heading_title'] = $this->language->get('heading_title_main');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_module'] = $this->language->get('text_module');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_same_q_checkout'] = $this->language->get('entry_same_q_checkout');
        $data['text_payment_address'] = $this->language->get('text_payment_address');
        $data['text_shipping_address'] = $this->language->get('text_shipping_address');
        $data['text_display'] = $this->language->get('text_display');
        $data['text_require'] = $this->language->get('text_require');
        $data['text_defualt'] = $this->language->get('text_defualt');
        $data['text_register'] = $this->language->get('text_register');
        $data['text_content_top'] = $this->language->get('text_content_top');
        $data['text_content_bottom'] = $this->language->get('text_content_bottom');
        $data['text_column_left'] = $this->language->get('text_column_left');
        $data['text_column_right'] = $this->language->get('text_column_right');
        $data['text_input_radio'] = $this->language->get('text_input_radio');
        $data['text_input_select'] = $this->language->get('text_input_select');
        $data['text_input_list'] = $this->language->get('text_input_list');
        $data['text_type'] = $this->language->get('text_type');
        $data['text_icon'] = $this->language->get('text_icon');
        $data['text_title'] = $this->language->get('text_title');
        $data['help_icon'] = $this->language->get('help_icon');
        $data['help_title'] = $this->language->get('help_title');
        $data['entry_new_field'] = $this->language->get('entry_new_field');
        $data['text_custom_field'] = $this->language->get('text_custom_field');
        $data['help_new_field'] = $this->language->get('help_new_field');
        $data['button_new_field'] = $this->language->get('button_new_field');
        $data['help_maskedinput'] = $this->language->get('help_maskedinput');
        return $data;
    }
}

?>
