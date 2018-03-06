<?php
/*
 *	location: admin/model
 */

class ModelExtensionModuleDSocialShare extends Model
{
    public function installDatabase()
    {

    }

    public function uninstallDatabase()
    {
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

    public function escape($data){
        return $data;
    }

}
