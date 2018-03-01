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

        $this->language->load($this->route);
        $this->load->model($this->route);
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('setting/setting');
        $this->js_folder = 'catalog/view/javascript/' . $this->codename;
        $this->css_folder = 'catalog/view/theme/default/stylesheet/' . $this->codename;
//for test
        $this->load->config($this->codename);
        $this->setting = $this->config->get($this->codename);
        $this->setting['buttons'] = $this->model_extension_module_d_social_share->loadButtons($this->codename);

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

        // css js loading
        $this->document->addStyle($this->css_folder . '/styles.css');
        $this->document->addScript($this->js_folder . '/jquery.social-buttons.js');

        if ($this->setting['cdn_lib']) {
            $this->document->addScript('https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js');
            if ($this->setting['design']['style']!=='custom') {
                $this->document->addStyle('https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css');
                $this->document->addStyle('https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-' . $this->setting['design']['style'] . '.css');
            }
        } else {
            $this->document->addScript($this->js_folder . '/jssocials/dist/jssocials.js');
            if ($this->setting['design']['style']!=='custom') {
                $this->document->addStyle($this->js_folder . '/jssocials/dist/jssocials.css');
                $this->document->addStyle($this->js_folder . '/jssocials/dist/jssocials-theme-' . $this->setting['design']['style'] . '.css');
            }
        }
        //show error
        if (isset($this->session->data['d_social_share_error'])) {
            $data['error'] = $this->session->data['d_social_share_error'];
            unset($this->session->data['d_social_share_error']);
        }

        //load languages text
        $buttons = array();
        foreach ($this->setting['buttons'] as $key => $button) {
            $buttons[$key] = $button;
            $buttons[$key]['text'] = $this->language->get($button['text']);
            $buttons[$key]['title'] = $this->language->get($button['title']);
        }

        $data['buttons'] = $buttons;
        $data['design'] = $this->setting['design'];
        $data['share'] = $this->setting['share'];
        if ($this->setting['custom_url']){
            $data['custom_url'] = ($this->setting['custom_url']);
        }
        $data['id_placement'] = ($this->setting['id_placement'])?($this->setting['id_placement']):'#d_social_share';
        $data['native'] = $this->setting['native'];


        return $this->model_extension_d_opencart_patch_load->view($this->route, $data);
    }
}
