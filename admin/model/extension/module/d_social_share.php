<?php
/*
 *	location: admin/model
 */

class ModelExtensionModuleDSocialShare extends Model
{
    private $codename = 'd_social_share';
    private $route = 'extension/module/d_social_share';

    public function installDatabase()
    {

    }

    public function uninstallDatabase()
    {
    }

    public function initState()
    {
        $this->config->load($this->codename);
        $config = $this->config->get($this->codename);
        //loading from config init data
        $state = array();
        $state['custom_url'] = $config['custom_url'];
        $state['buttons'] = $this->loadButtons($this->codename);
        $state['design'] = $config['design'];
        $state['config'] = $config['config'];
        return $state;
    }
    public function getTextField(){
        $this->config->load($this->codename);
        $config = $this->config->get($this->codename);
        $text_sizes = array();
        $this->load->language($this->route);
        foreach ($config['design']['sizes'] as $key => $value ) {
            $text_sizes['sizes'][$key]=$this->language->get('text_'.$key);
        }
        foreach ($config['design']['styles'] as $key => $value ) {
            $text_sizes['styles'][$key]=$this->language->get('text_'.$key);
        }
        foreach ($config['config']['shareIns'] as $value ) {
            $text_sizes['shareIns'][$value]=$this->language->get('text_'.$value);
        }
        return $text_sizes;

    }

    public function scan_dir($dir, &$arr_files)
    {

        if (is_dir($dir)) {
            $handle = opendir($dir);
            while ($file = readdir($handle)) {
                if ($file == '.' or $file == '..') continue;
                if (is_file($file)) $arr_files[] = "$dir/$file";
                else $this->scan_dir("$dir/$file", $arr_files);
            }
            closedir($handle);
        } else {
            $arr_files[] = $dir;
        }
    }

    public function move_dir($souce, $dest, &$result)
    {

        $files = scandir($souce);

        foreach ($files as $file) {

            if ($file == '.' || $file == '..' || $file == '.DS_Store') continue;

            if (is_dir($souce . $file)) {
                if (!file_exists($dest . $file . '/')) {
                    mkdir($dest . $file . '/', 0777, true);
                }
                $this->move_dir($souce . $file . '/', $dest . $file . '/', $result);
            } elseif (rename($souce . $file, $dest . $file)) {
                $result['success'][] = str_replace(DIR_ROOT, '', $dest . $file);
            } else {
                $result['error'][] = str_replace(DIR_ROOT, '', $dest . $file);
            }
        }

        $this->delete_dir($souce);
    }

    public function delete_dir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") $this->delete_dir($dir . "/" . $object);
                    else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function loadButtons($id)
    {
        $providers = array();
        $dir_files = array();
        $this->scan_dir(DIR_CONFIG . $id, $dir_files);
        foreach ($dir_files as $file) {
            $provider_name = basename($file, ".php");
            $this->config->load($id . '/' . $provider_name);
            $provider = $this->config->get($id . "_" . $provider_name);
            if ($provider) {
                $providers = array_merge($providers, $provider);
            }

        }
        return $providers;
    }

    public function escape($data)
    {
        return $data;
    }

}
