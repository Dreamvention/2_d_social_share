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

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->setting = $this->config->get($this->id . '_setting');
        $this->language->load($this->route);
        $this->load->model($this->route);
        $this->load->model('extension/d_opencart_patch/load');
    }


    public function index()
    {

        $this->setting = $this->config->get($this->id . '_setting');
        if (!$this->config->get($this->id . '_status')) {
            return false;
        }
        $this->document->addStyle('catalog/view/theme/default/stylesheet/d_social_share/styles.css');
        //   $this->initialize($setting);
        $data = array();
        if (isset($this->session->data['d_social_share_error'])) {
            $data['error'] = $this->session->data['d_social_share_error'];
            unset($this->session->data['d_social_share_error']);
        }
        //load  config from config dir
        return $this->model_extension_d_opencart_patch_load->view($this->route, $data);
    }

}
