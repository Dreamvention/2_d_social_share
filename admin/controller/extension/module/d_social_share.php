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


        //may be shopunity knows what add is this work for lib to add himself
        // what about awesome lib?
        $this->document->addStyle('view/javascript/d_bootstrap_switch/css/bootstrap-switch.css');
        $this->document->addScript('view/javascript/d_bootstrap_switch/js/bootstrap-switch.min.js');
        $this->document->addStyle('view/stylesheet/d_bootstrap_extra/bootstrap.css');
        $this->document->addStyle('view/javascript/d_bootstrap_colorpicker/css/bootstrap-colorpicker.css');
        $this->document->addScript('view/javascript/d_bootstrap_colorpicker/js/bootstrap-colorpicker.js');
        //  $this->document->addScript('view/javascript/d_tinysort/tinysort.js');
//        $this->document->addScript('view/javascript/d_tinysort/jquery.tinysort.min.js');

        $this->document->addStyle('view/stylesheet/'.$this->codename.'/styles.css');

        // Todo: place for style from admin_style.
        //        $this->document->addStyle('view/stylesheet/d_admin_style/core.css');
        //        compiled riot tags and lib
        $this->document->addScript('view/javascript/' . $this->codename . '/compiled/core_and_libs.min.js');
        $this->document->addScript('view/template/extension/' . $this->codename . '/compiled/compiled.js');
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
        $this->load->language($this->route);


        $this->document->setTitle($this->language->get('heading_title_main'));
        
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

        // Variable
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // GET STATE
        $data['state'] = $this->load_state();
        $template_path = 'extension/' . $this->codename . '/' . $this->codename;
        $this->response->setOutput($this->model_extension_d_opencart_patch_load->view($template_path, $data));
//        $data = array_merge($data, $this->getTextFields());


    }

    public function load_state()
    {
        $state = $this->model_extension_module_d_social_share->init_state();
        $state['heading_title'] = $this->language->get('heading_title_main');

        $state['text_edit'] = $this->language->get('text_edit');
        $state['text_enabled'] = $this->language->get('text_enabled');
        $state['text_disabled'] = $this->language->get('text_disabled');
        $state['text_important'] = $this->language->get('text_important');
        $state['text_warning'] = sprintf($this->language->get('text_warning'), $this->model_extension_d_opencart_patch_url->link('extension/module/' . $this->codename));
        $state['text_yes'] = $this->language->get('text_yes');
        $state['text_no'] = $this->language->get('text_no');
        $state['text_buttons'] = $this->language->get('text_buttons');
        $state['text_design'] = $this->language->get('text_design');
        $state['text_settings'] = $this->language->get('text_settings');
        $state['text_help_me'] = $this->language->get('text_help_me');

        $state['text_button_label'] = $this->language->get('text_button_label');
        $state['text_button_icon'] = $this->language->get('text_button_icon');
        $state['text_colors'] = $this->language->get('text_colors');
        $state['text_color_text'] = $this->language->get('text_color_text');
        $state['text_color_background_text'] = $this->language->get('text_color_background_text');
        $state['text_color_background_hover_text'] = $this->language->get('text_color_background_hover_text');
        $state['text_color_background_active_text'] = $this->language->get('text_color_background_active_text');
        $state['text_native'] = $this->language->get('text_native');

        $state['entry_name'] = $this->language->get('entry_name');
        $state['entry_description'] = $this->language->get('entry_description');
        $state['entry_status'] = $this->language->get('entry_status');

        $state['button_save_and_stay'] = $this->language->get('button_save_and_stay');
        $state['button_save'] = $this->language->get('button_save');
        $state['button_cancel'] = $this->language->get('button_cancel');

        $state['version'] = $this->extension['version'];
        $state['codename'] = $this->codename;

        $state['breadcrumbs'] = array();

        $state['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->model_extension_d_opencart_patch_url->ajax('common/dashboard')
        );

        $state['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->model_extension_d_opencart_patch_url->getExtensionAjax('module')
        );

        if (!isset($this->request->get['module_id'])) {
            $state['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title_main'),
                'href' => $this->model_extension_d_opencart_patch_url->ajax($this->route)
            );
        } else {
            $state['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title_main'),
                'href' => $this->model_extension_d_opencart_patch_url->ajax($this->route, 'module_id=' . $this->request->get['module_id'])
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $state['action'] = $this->model_extension_d_opencart_patch_url->link($this->route);
        } else {
            $state['action'] = $this->model_extension_d_opencart_patch_url->link($this->route, 'module_id=' . $this->request->get['module_id']);
        }

        $state['cancel'] = $this->model_extension_d_opencart_patch_url->getExtensionAjax('module');
        $state['get_cancel'] = $this->model_extension_d_opencart_patch_url->getExtensionAjax('module');
        $state['module_link'] = $this->model_extension_d_opencart_patch_url->link($this->route);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_d_opencart_patch_module->getModule($this->request->get['module_id']);
            $state['module_id'] = $this->request->get['module_id'];
        }

        if (isset($this->request->post['name'])) {
            $state['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $state['name'] = $module_info['name'];
        } else {
            $state['name'] = '';
        }

        if (isset($this->request->post['status'])) {
            $state['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $state['status'] = $module_info['status'];
        } else {
            $state['status'] = '';
        }
        $state['module_link'] = $this->model_extension_d_opencart_patch_url->ajax($this->route);
        // Navigation
        $state['navigation'] = array(
            'buttons' => array('active' => True, 'href' => $state['module_link'].'#buttons', 'icon' => 'fa fa-tachometer', 'text' => $state['text_buttons'], 'disabled' => False),
            'design'      => array('active' => False, 'href' => $state['module_link'].'#desing', 'icon' => 'fa fa-search', 'text' => $state['text_design'], 'disabled' => False),
            'setting'   => array('active' => False, 'href' => $state['module_link'].'#setting', 'icon' => 'fa fa-cog', 'text' => $state['text_settings'], 'disabled' => False),
            'help_me'   => array('active' => False, 'href' => $state['module_link'].'#help_me', 'icon' => 'fa fa-life-ring', 'text' => $state['text_help_me'], 'disabled' => False)
        );


        $state['token'] = $this->model_extension_d_opencart_patch_user->getUrlToken();
        return $state;
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
