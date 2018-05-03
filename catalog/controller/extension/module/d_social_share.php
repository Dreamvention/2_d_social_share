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

    }

    public function index($setting)
    {
        $data = array();
        $this->setting = $this->loadSetting($setting);
        if (!$this->setting) {
            $this->session->data['d_social_share_error']['setting_error'] = 'could not load settings';
        }

        // css js loading
        $this->document->addStyle($this->css_folder . '/styles.css');
        $this->document->addScript($this->js_folder . '/jssocials/dist/jssocials.js');
        if ($this->setting['design']['style'] !== 'custom') {
            $this->document->addStyle($this->js_folder . '/jssocials/dist/jssocials.css');
            $this->document->addStyle($this->js_folder . '/jssocials/dist/jssocials-theme-' . $this->setting['design']['style'] . '.css');
        }
        //animation
        $this->document->addStyle('catalog/view/theme/default/stylesheet/'.$this->codename.'/animate.css');
        $this->document->addStyle('catalog/view/theme/default/stylesheet/'.$this->codename.'/styles.css');

        //show error
        if (isset($this->session->data['d_social_share_error'])) {
            $data['error'] = $this->session->data['d_social_share_error'];
            unset($this->session->data['d_social_share_error']);
        }
        //load languages text
        $buttons = array();
        foreach ($this->setting['buttons'] as $key => $button) {
            if ($button['enabled']) {
                $button['share']['label'] = $button['share']['label'][$this->config->get('config_language_id')];
                $buttons[$key] = $button;
            }
        }
        // sorting
        $sort_order = array();
        foreach ($buttons as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }
        array_multisort($sort_order, SORT_ASC, $buttons);


        $data['buttons'] = $buttons;
        $data['design'] = $this->setting['design'];
        $data['config'] = $this->setting['config'];
        $data['codename'] = $this->codename;
        if ($this->setting['custom_url']) {
            $data['custom_url'] = ($this->setting['custom_url']);
        }
        return $this->model_extension_d_opencart_patch_load->view($this->route, $data);
    }

    public function loadSetting($setting)
    {
        return $setting[$this->codename.'_setting'];
    }
    public function eventLoadSharesProduct(&$route, &$data, &$output){

    }
}
