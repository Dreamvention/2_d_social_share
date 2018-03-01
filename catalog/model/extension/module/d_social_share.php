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

    /*
    *	Mbooth
    */
    public function getVersion($mbooth_xml)
    {
        if (file_exists(DIR_SYSTEM . 'mbooth/xml/' . $mbooth_xml)) {
            $xml = new SimpleXMLElement(file_get_contents(DIR_SYSTEM . 'mbooth/xml/' . $mbooth_xml));
            return $xml->version;
        } else {
            return false;
        }
    }

    public function getMboothFile($id, $sub_versions)
    {
        $full = DIR_SYSTEM . 'mbooth/xml/mbooth_' . $id . '.xml';
        if (file_exists($full)) {
            return 'mbooth_' . $id . '.xml';
        } else {
            foreach ($sub_versions as $lite) {
                if (file_exists(DIR_SYSTEM . 'mbooth/xml/mbooth_' . $id . '_' . $lite . '.xml')) {
                    $this->prefix = '_' . $lite;
                    return 'mbooth_' . $id . '_' . $lite . '.xml';
                }
            }
        }
        return false;
    }

    public function isInstalled($code)
    {
        $extension_data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `code` = '" . $this->db->escape($code) . "'");
        if ($query->row) {
            return true;
        } else {
            return false;
        }
    }

    /*
    *	Get extension info by mbooth from server (Check for update)
    */
    public function getUpdateInfo($mbooth_xml, $status = 1)
    {
        $result = array();

        $current_version = $this->getVersion($mbooth_xml);
        $customer_url = HTTP_SERVER;
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE language_id = " . (int)$this->config->get('config_language_id'));
        $language_code = $query->row['code'];
        $ip = $this->request->server['REMOTE_ADDR'];

        $request = 'http://opencart.dreamvention.com/api/1/index.php?route=extension/check&mbooth=' . $mbooth_xml . '&store_url=' . $customer_url . '&module_version=' . $current_version . '&language_code=' . $language_code . '&opencart_version=' . VERSION . '&ip=' . $ip . '&status=' . $status;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result['data'] = curl_exec($curl);
        $result['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $result;
    }

    /*
    *	Get the version of this module
    */

    public function installDependencies($mbooth_xml)
    {
        define('DIR_ROOT', substr_replace(DIR_SYSTEM, '/', -8));
        foreach ($this->getDependencies($mbooth_xml) as $extension) {
            if (isset($extension['codename'])) {
                $this->download_extension($extension['codename'], $extension['version']);
                $this->extract_extension();
                if (file_exists(DIR_SYSTEM . 'mbooth/xml/' . $mbooth_xml)) {
                    $result = $this->backup_files_by_mbooth($mbooth_xml, 'update');
                }
                $this->move_dir(DIR_DOWNLOAD . 'upload/', DIR_ROOT, $result);
            }
        }
    }


    public function getDependencies($mbooth_xml)
    {
        if (file_exists(DIR_SYSTEM . 'mbooth/xml/' . $mbooth_xml)) {
            $xml = new SimpleXMLElement(file_get_contents(DIR_SYSTEM . 'mbooth/xml/' . $mbooth_xml));
            $result = array();
            $version = false;
            foreach ($xml->required as $require) {

                foreach ($require->require->attributes() as $key => $value) {
                    $version = false;
                    if ($key == 'version') {
                        $version = $value;
                    }
                }
                $result[] = array(
                    'codename' => $require->require,
                    'version' => $version
                );
            }
            return $result;
        } else {
            return false;
        }
    }

    public function download_extension($codename, $version, $filename = false)
    {
        if (!$filename) {
            $filename = DIR_DOWNLOAD . 'archive.zip';
        }
        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
        $ch = curl_init();
        $fp = fopen($filename, "w");
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_URL, 'http://opencart.dreamvention.com/api/1/extension/download/?codename=' . $codename . '&opencart_version=' . VERSION . '&extension_version=' . $version);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $page = curl_exec($ch);
        if (!$page) {
            exit;
        }
        curl_close($ch);

    }


    public function extract_extension($filename = false, $location = false)
    {
        if (!$filename) {
            $filename = DIR_DOWNLOAD . 'archive.zip';
        }
        if (!$location) {
            $location = DIR_DOWNLOAD;
        }

        $result = array();
        $zip = new ZipArchive;
        if (!$zip) {
            $result['error'][] = 'ZipArchive not working.';
        }

        if ($zip->open($filename) != "true") {
            $result['error'][] = $filename;
        }
        $zip->extractTo($location);
        $zip->close();

        unlink($filename);

        return $result;

    }


    public function get_files_by_mbooth($mbooth_xml)
    {

        $xml = new SimpleXMLElement(file_get_contents($mbooth_xml));

        if (isset($xml->id)) {
            $result['file_name'] = basename($mbooth_xml, '');
            $result['id'] = isset($xml->id) ? (string)$xml->id : '';
            $result['name'] = isset($xml->name) ? (string)$xml->name : '';
            $result['description'] = isset($xml->description) ? (string)$xml->description : '';
            $result['type'] = isset($xml->type) ? (string)$xml->type : '';
            $result['version'] = isset($xml->version) ? (string)$xml->version : '';
            $result['mbooth_version'] = isset($xml->mbooth_version) ? (string)$xml->mbooth_version : '';
            $result['opencart_version'] = isset($xml->opencart_version) ? (string)$xml->opencart_version : '';
            $result['author'] = isset($xml->author) ? (string)$xml->author : '';
            $files = $xml->files;
            $dirs = $xml->dirs;
            $required = $xml->required;
            $updates = $xml->update;

            foreach ($files->file as $file) {
                $result['files'][] = (string)$file;
            }

            if (!empty($dirs)) {

                $dir_files = array();

                foreach ($dirs->dir as $dir) {
                    $this->scan_dir(DIR_ROOT . $dir, $dir_files);
                }

                foreach ($dir_files as $file) {
                    $file = str_replace(DIR_ROOT, "", $file);
                    $result['files'][] = (string)$file;
                }
            }

            return $result;
        } else {
            return false;
        }

    }

    public function backup_files_by_mbooth($mbooth_xml, $action = 'install')
    {

        $zip = new ZipArchive();

        if (!file_exists(DIR_SYSTEM . 'mbooth/backup/')) {
            mkdir(DIR_SYSTEM . 'mbooth/backup/', 0777, true);
        }

        $mbooth = $this->get_files_by_mbooth(DIR_SYSTEM . 'mbooth/xml/' . $mbooth_xml);
        $files = $mbooth['files'];

        $zip->open(DIR_SYSTEM . 'mbooth/backup/' . date('Y-m-d.h-i-s') . '.' . $action . '.' . $mbooth_xml . '.v' . $mbooth['version'] . '.zip', ZipArchive::CREATE);


        foreach ($files as $file) {

            if (file_exists(DIR_ROOT . $file)) {

                if (is_file(DIR_ROOT . $file)) {
                    $zip->addFile(DIR_ROOT . $file, 'upload/' . $file);
                    $result['success'][] = $file;
                } else {
                    $result['error'][] = $file;
                }
            } else {
                $result['error'][] = $file;
            }
        }
        $zip->close();
        return $result;

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

    public function array_merge_recursive_distinct(array &$array1, array &$array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset ($merged [$key]) && is_array($merged [$key])) {
                $merged [$key] = $this->array_merge_recursive_distinct($merged [$key], $value);
            } else {
                $merged [$key] = $value;
            }
        }

        return $merged;
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
