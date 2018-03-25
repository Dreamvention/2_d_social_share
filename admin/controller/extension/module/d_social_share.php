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

        $this->document->addStyle('../catalog/view/javascript/d_social_share/jssocials/dist/jssocials.css');

        $this->document->addStyle('../catalog/view/javascript/d_social_share/jssocials/dist/jssocials.css');
        $this->document->addScript('../catalog/view/javascript/d_social_share/jssocials/dist/jssocials.js');
        $this->document->addStyle('view/stylesheet/' . $this->codename . '/styles.css');

        $admin_theme = 'light';
        $this->document->addStyle('view/stylesheet/d_admin_style/themes/' . $admin_theme . '/styles.css');
        //        compiled riot tags and lib
        $this->document->addScript('view/javascript/' . $this->codename . '/compiled/core_and_libs.min.js');
        $this->document->addScript('view/template/extension/' . $this->codename . '/compiled/compiled.js');

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


    }

    public function load_state()
    {
        $state = $this->model_extension_module_d_social_share->initState();
        $state['heading_title'] = $this->language->get('heading_title_main');

        $state['text_edit'] = $this->language->get('text_edit');
        $state['text_status'] = $this->language->get('text_status');
        $state['text_name'] = $this->language->get('text_name');
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
        $state['text_size'] = $this->language->get('text_size');
        $state['text_rounded'] = $this->language->get('text_rounded');
        $state['text_style'] = $this->language->get('text_style');
        $state['text_style_share'] = $this->language->get('text_style_share');
        $state['text_show_label'] = $this->language->get('text_show_label');
        $state['text_show_count'] = $this->language->get('text_show_count');
        $state['text_shareIn'] = $this->language->get('text_shareIn');
        $state['text_breakpoints'] = $this->language->get('text_breakpoints');
        $state['text_smallScreenWidth'] = $this->language->get('text_smallScreenWidth');
        $state['text_largeScreenWidth'] = $this->language->get('text_largeScreenWidth');

        $state['text_custom_url'] = $this->language->get('text_custom_url');

        $state['entry_name'] = $this->language->get('entry_name');
        $state['entry_description'] = $this->language->get('entry_description');
        $state['entry_status'] = $this->language->get('entry_status');

        $state['button_save_and_stay'] = $this->language->get('button_save_and_stay');
        $state['button_save'] = $this->language->get('button_save');
        $state['button_cancel'] = $this->language->get('button_cancel');
        $state['button_create_ticket'] = $this->language->get('button_create_ticket');
        $state['text_help_me_description'] = $this->language->get('text_help_me_description');
        $state['help_help_me'] = $this->language->get('help_help_me');

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

        if (isset($this->request->get['module_id'])) {
            $module_info = $this->model_extension_d_opencart_patch_module->getModule($this->request->get['module_id']);
        }
        if (isset($this->request->get['module_id'])) {
            $state['module_id'] = $this->request->get['module_id'];
        }
        if (isset($this->request->post['name'])) {
            $state['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $state['name'] = $module_info['name'];
        } else {
            $state['name'] = $this->codename;
        }
        if (isset($this->request->post['status'])) {
            $state['status'] = $this->request->post['status'];//=== 'true' ? true : false;
        } elseif (!empty($module_info)) {
            $state['status'] = $module_info['status'];//=== 'true' ? true : false;
        } else {
            $state['status'] = false;
        }
        if (isset($module_info) && !empty($module_info)) {
            $state['custom_url'] = $module_info['d_social_share_setting']['custom_url'];
            $state['buttons'] = $module_info['d_social_share_setting']['buttons'];
            $state['design'] = $module_info['d_social_share_setting']['design'];
            $state['config'] = $module_info['d_social_share_setting']['config'];
        }

        $state['module_link'] = $this->model_extension_d_opencart_patch_url->ajax($this->route);
        // Navigation
        $state['navigation'] = array(
            'buttons' => array('active' => True, 'href' => $state['module_link'] . '#buttons', 'icon' => 'fa fa-bullhorn', 'text' => $state['text_buttons'], 'disabled' => False),
            'design' => array('active' => False, 'href' => $state['module_link'] . '#desing', 'icon' => 'fa fa-paint-brush', 'text' => $state['text_design'], 'disabled' => False),
            'setting' => array('active' => False, 'href' => $state['module_link'] . '#setting', 'icon' => 'fa fa-cog', 'text' => $state['text_settings'], 'disabled' => False),
            'help_me' => array('active' => False, 'href' => $state['module_link'] . '#help_me', 'icon' => 'fa fa-life-ring', 'text' => $state['text_help_me'], 'disabled' => False)
        );
        $state['styles_link'] = array(
            'classic' => '../catalog/view/javascript/d_social_share/jssocials/dist/jssocials-theme-classic.css',
            'flat' => '../catalog/view/javascript/d_social_share/jssocials/dist/jssocials-theme-flat.css',
            'minimal' => '../catalog/view/javascript/d_social_share/jssocials/dist/jssocials-theme-minima.css',
            'plain' => '../catalog/view/javascript/d_social_share/jssocials/dist/jssocials-theme-plain.css'
        );
        $state['text'] = $this->model_extension_module_d_social_share->getTextField();
        $state['token'] = $this->model_extension_d_opencart_patch_user->getUrlToken();
        return $state;
    }

    public function save_setting()
    {
        $json = array();
        $this->load->model('setting/setting');
        $this->load->model('extension/d_opencart_patch/url');
        $this->load->model('extension/d_opencart_patch/module');
        $this->session->data['success'] = $this->language->get('text_success');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_d_opencart_patch_module->addModule($this->codename, json_decode(html_entity_decode($this->request->post['setting']), true));
                $this->request->get['module_id'] = $this->db->getLastId();
            } else {
                $this->model_extension_d_opencart_patch_module->editModule($this->request->get['module_id'], json_decode(html_entity_decode($this->request->post['setting']), true));
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['module_id'])) {
                $url .= '&module_id=' . $this->request->get['module_id'];
            }
            $json['redirect'] = str_replace('&amp;', '&', $this->model_extension_d_opencart_patch_url->link($this->route, $url));
            $json['success'] = 'success';
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }

    }

    public function validate()
    {
        return true;
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
