<?php
/*
 *  location: catalog/controller/extension/module/d_social_share.php
 */

class ControllerExtensionModuleDSocialShare extends Controller
{

    private $route = 'extension/module/d_social_share';
    private $id = 'd_social_share';
    private $setting = array();
    private $error = array();
    private $js_folde;
    private $css_folder;

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->setting = $this->config->get($this->id . '_setting');
        $this->language->load($this->route);
        $this->load->model($this->route);
        $this->load->model('extension/d_opencart_patch/load');
        $this->load->model('setting/setting');
        $this->js_folder = 'catalog/view/theme/default/javascript/' . $this->id;
        $this->css_folder = 'catalog/view/theme/default/stylesheet/' . $this->id;
    }


    public function index()
    {
        $data = array();
        if (!$this->setting) {
            $this->session->data['d_social_share_error']['setting_error'] = 'could not load settings';
        }
        if (!$this->config->get($this->id . '_status')) {
            return false;
        }
        $this->document->addStyle($this->css_folder.'/styles.css');
        $this->document->addScript($this->js_folder.'/jquery.social-buttons.js','footer');

        $buttons = $this->setting['buttons'];
        //load languages text
        foreach ($buttons as $key => $button) {
            $text = $this->language->get($button['text']);
            $title = $this->language->get($button['title']);
            $buttons[$key]['text'] = $text;
            $buttons[$key]['title'] = $title;
        }
        $data['buttons'] = $buttons;

        $data['design'] = $this->setting['design'];
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
