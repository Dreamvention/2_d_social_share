<?php

class ControllerExtensionModuleDSocialShare extends Controller
{
    private $codename = 'd_social_share';
    private $route = 'extension/module/d_social_share';
    private $error = array();
    private $store_id = 0;

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->language($this->route);
        $this->load->model($this->route);
        $this->load->config($this->codename);
        $this->load->model('design/layout');
        $this->load->model('setting/setting');
        $this->store_id = (isset($this->request->get['store_id'])) ? $this->request->get['store_id'] : 0;
        $this->d_shopunity = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_shopunity.json'));
        $this->d_opencart_patch = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_opencart_patch.json'));
        $this->extension = json_decode(file_get_contents(DIR_SYSTEM . 'library/d_shopunity/extension/' . $this->codename . '.json'), true);
        $this->d_twig_manager = (file_exists(DIR_SYSTEM . 'library/d_shopunity/extension/d_twig_manager.json'));
    }

    public function index()
    {

        if ($this->d_shopunity) {
            $this->load->model('extension/d_shopunity/mbooth');
            $this->model_extension_d_shopunity_mbooth->validateDependencies($this->codename);
        }

        if ($this->d_twig_manager) {
            $this->load->model('extension/module/d_twig_manager');
            if (!$this->model_extension_module_d_twig_manager->isCompatible()) {
                $this->model_extension_module_d_twig_manager->installCompatibility();
                $this->session->data['success'] = $this->language->get('success_twig_compatible');
                $this->response->redirect($this->model_extension_d_opencart_patch_url->getExtensionLink('module'));
            }
        }
        $this->load->model('customer/customer_group');
        $this->load->model('extension/d_opencart_patch/module');
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('extension/d_opencart_patch/user');

        $this->load->language($this->route);

        $this->document->addStyle('view/javascript/d_bootstrap_switch/css/bootstrap-switch.css');
        $this->document->addScript('view/javascript/d_bootstrap_switch/js/bootstrap-switch.min.js');
        $this->document->addStyle('view/javascript/d_bootstrap_colorpicker/css/bootstrap-colorpicker.css');
        $this->document->addScript('view/javascript/d_bootstrap_colorpicker/js/bootstrap-colorpicker.js');
        $this->document->addScript('view/javascript/d_tinysort/tinysort.js');
        $this->document->addScript('view/javascript/d_tinysort/jquery.tinysort.min.js');


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $config[$this->codename . '_setting'] = $this->config->get($this->codename);

            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_d_opencart_patch_module->addModule($this->codename, $this->request->post);
                $this->request->get['module_id'] = $this->db->getLastId();
            }
            $this->request->post['module_id'] = $this->request->get['module_id'];

            $this->model_extension_d_opencart_patch_module->editModule($this->request->get['module_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module'));
        }

        $data['version'] = $this->extension['version'];

        $this->document->setTitle($this->language->get('heading_title_main'));
        $data['heading_title'] = $this->language->get('heading_title_main');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_important'] = $this->language->get('text_important');
        $data['text_warning'] = sprintf($this->language->get('text_warning'), $this->model_extension_d_opencart_patch_url->link('extension/module/' . $this->codename));
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->link('common/dashboard')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module')
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title_main'),
                'href' => $this->model_extension_d_opencart_patch_url->link($this->route)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title_main'),
                'href' => $this->model_extension_d_opencart_patch_url->link($this->route, 'module_id=' . $this->request->get['module_id'])
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->model_extension_d_opencart_patch_url->link($this->route);
        } else {
            $data['action'] = $this->model_extension_d_opencart_patch_url->link($this->route, 'module_id=' . $this->request->get['module_id']);
        }

        $data['cancel'] = $this->model_extension_d_opencart_patch_url->link('marketplace/extension', 'type=module');

        $data['module_link'] = $this->model_extension_d_opencart_patch_url->link($this->route);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_d_opencart_patch_module->getModule($this->request->get['module_id']);
            $data['module_id'] = $this->request->get['module_id'];
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }
        $data['token'] = $this->model_extension_d_opencart_patch_user->getUrlToken();
        // Variable
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // GET STATE
        $data['state'] = $this->something_with_state(True);

        $template_path = 'extension/'.$this->codename.'/'.$this->codename;
        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view($template_path, $data));

//        $data = array_merge($data, $this->getTextFields());
        //load  config from config dir
        //      $this->config->load($this->codename);
        //    $config = $this->config->get($this->codename);
        //check if exist config in db
        //inherit users data
//        $data['setting'] = array_replace_recursive($config, $data['setting']);
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
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
            $this->model_extension_d_shopunity_mbooth->installDependencies($this->codename);
        }
    }

    public function uninstall()
    {
        $this->load->model($this->route);
        $this->load->model('extension/d_opencart_patch/modification');
    }

}

?>
