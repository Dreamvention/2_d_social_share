<?php
/*
 *  location: catalog/controller/extension/module/d_social_share.php
 */

class ControllerExtensionModuleDSocialShare extends Controller
{

    private $route = 'extension/module/d_social_share';
    private $codename = 'd_social_share';
    private $setting = array();
    private $error = array();
    private $js_folde;
    private $css_folder;

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->setting = $this->config->get($this->codename . '_setting');
        $this->language->load($this->route);
        $this->load->model($this->route);
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('setting/setting');
        $this->js_folder = 'catalog/view/javascript/' . $this->codename;
        $this->css_folder = 'catalog/view/theme/default/stylesheet/' . $this->codename;
    }


    public function index()
    {
        $data = array();
        if (!$this->setting) {
            $this->session->data['d_social_share_error']['setting_error'] = 'could not load settings';
        }
        if (!$this->config->get($this->codename . '_status')) {
            return false;
        }
        $this->document->addStyle($this->css_folder.'/styles.css');
        $this->document->addScript($this->js_folder.'/jssocials/dist/jssocials.min.js');
        $this->document->addStyle($this->js_folder.'/jssocials/dist/jssocials.css');
        $this->document->addStyle($this->js_folder.'/jssocials/dist/jssocials-theme-'.$this->setting['design']['style'].'.css');
        //load languages text
        $buttons =array();
        foreach ($this->setting['buttons'] as $key => $button) {
            $buttons[$key] = $button;
            $buttons[$key]['text'] = $this->language->get($button['text']);
            $buttons[$key]['title'] = $this->language->get($button['title']);
        }
        $data['buttons'] = $buttons;
//        print_r($this->setting);
        $data['design'] = $this->setting['design'];
        $data['share'] = $this->setting['share'];
        //add fab
        //$this->document->addStyle('https://use.fontawesome.com/releases/v5.0.6/css/all.css');

        //show error
        if (isset($this->session->data['d_social_share_error'])) {
            $data['error'] = $this->session->data['d_social_share_error'];
            unset($this->session->data['d_social_share_error']);
        }
        return $this->model_extension_d_opencart_patch_load->view($this->route, $data);
    }
}
