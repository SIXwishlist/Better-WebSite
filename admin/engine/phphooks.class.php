<?php

/*
 * Tecflare Corporation Property
 */

define('PLUGINS_FOLDER', '../plugins/');
class Phphooks
{
    /*
     * plugins option data
     * @var array
     */
    public $plugins = [];
    /*
     * UNSET means load all plugins, which is stored in the plugin folder. ISSET just load the plugins in this array.
     * @var array
     */
    public $active_plugins = null;
    /*
     * all plugins header information array.
     * @var array
     */
    public $plugins_header = [];
    /*
     * hooks data
     * @var array
     */
    public $hooks = [];

    /**
     * register hook name/tag, so plugin developers can attach functions to hooks.
     *
     * @since 1.0
     * 
     * @param string $tag. The name of the hook.
     */
    public function set_hook($tag)
    {
        $tag = trim($tag);
        $this->hooks[$tag] = '';
    }

    /**
     * register multiple hooks name/tag.
     *
     * @since 1.0
     * 
     * @param array $tags. The name of the hooks.
     */
    public function set_hooks($tags)
    {
        foreach ($tags as $tag) {
            $this->set_hook($tag);
        }
    }

    /**
     * write hook off.
     *
     * @since 1.0
     * 
     * @param string $tag. The name of the hook.
     */
    public function unset_hook($tag)
    {
        $tag = trim($tag);
        unset($this->hooks[$tag]);
    }

    /**
     * write multiple hooks off.
     *
     * @since 1.0
     * 
     * @param array $tags. The name of the hooks.
     */
    public function unset_hooks($tags)
    {
        foreach ($tags as $tag) {
            $this->unset_hook($tag);
        }
    }

    /**
     * load plugins from specific folder, includes *.plugin.php files.
     *
     * @since 1.0
     * 
     * @param string $from_folder optional. load plugins from folder, if no argument is supplied, a 'plugins/' constant will be used
     */
    public function load_plugins($from_folder = PLUGINS_FOLDER)
    {
        if ($handle = @opendir($from_folder)) {
            while ($file = readdir($handle)) {
                if (is_file($from_folder.$file)) {
                    if (($this->active_plugins == null || in_array($file, $this->active_plugins)) && strpos($from_folder.$file, '.plugin.php')) {
                        require_once $from_folder.$file;
                        $this->plugins[$file]['file'] = $file;
                    }
                } elseif ((is_dir($from_folder.$file)) && (substr($file, 0, 1) != '.')) {
                    $this->load_plugins($from_folder.$file.'/');
                }
            }
            closedir($handle);
        }
    }

    /**
     * return the all plugins ,which is stored in the plugin folder, header information.
     * 
     * @since 1.1
     *
     * @param string $from_folder optional. load plugins from folder, if no argument is supplied, a 'plugins/' constant will be used
     *
     * @return array. return the all plugins ,which is stored in the plugin folder, header information.
     */
    public function get_plugins_header($from_folder = PLUGINS_FOLDER)
    {
        if ($handle = @opendir($from_folder)) {
            while ($file = readdir($handle)) {
                if (is_file($from_folder.$file)) {
                    if (strpos($from_folder.$file, '.plugin.php')) {
                        $fp = fopen($from_folder.$file, 'r');
                        // Pull only the first 8kiB of the file in.
                        $plugin_data = fread($fp, 8192);
                        fclose($fp);
                        preg_match('|Plugin Name:(.*)$|mi', $plugin_data, $name);
                        preg_match('|Plugin URI:(.*)$|mi', $plugin_data, $uri);
                        preg_match('|Version:(.*)|i', $plugin_data, $version);
                        preg_match('|Description:(.*)$|mi', $plugin_data, $description);
                        preg_match('|Author:(.*)$|mi', $plugin_data, $author_name);
                        preg_match('|Author URI:(.*)$|mi', $plugin_data, $author_uri);
                        foreach (['name', 'uri', 'version', 'description', 'author_name', 'author_uri'] as $field) {
                            if (!empty(${$field})) {
                                ${$field} = trim(${$field}[1]);
                            } else {
                                ${$field} = '';
                            }
                        }
                        $plugin_data = ['filename' => $file, 'Name' => $name, 'Title' => $name, 'PluginURI' => $uri, 'Description' => $description, 'Author' => $author_name, 'AuthorURI' => $author_uri, 'Version' => $version];
                        $this->plugins_header[] = $plugin_data;
                    }
                } elseif ((is_dir($from_folder.$file)) && (substr($file, 0, 1) != '.')) {
                    $this->get_plugins_header($from_folder.$file.'/');
                }
            }
            closedir($handle);
        }

        return $this->plugins_header;
    }

    /**
     * attach custom function to hook.
     *
     * @since 1.0
     * 
     * @param string $tag.      The name of the hook.
     * @param string $function. The function you wish to be called.
     * @param int    $priority  optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     */
    public function add_hook($tag, $function, $priority = 10)
    {
        $tag = trim($tag);
        if (!isset($this->hooks[$tag])) {
            die("There is no such place ($tag) for hooks.");
        } else {
            $this->hooks[$tag][$priority][] = $function;
        }
    }

    /**
     * check whether any function is attached to hook.
     *
     * @since 1.0
     * 
     * @param string $tag The name of the hook.
     */
    public function hook_exist($tag)
    {
        $tag = trim($tag);

        return ($this->hooks[$tag] == '') ? false : true;
    }

    /**
     * execute all functions which are attached to hook, you can provide argument (or arguments via array).
     *
     * @since 1.0
     * 
     * @param string $tag. The name of the hook.
     * @param mix    $args optional.The arguments the function accept (default none)
     */
    public function execute_hook($tag, $args = '')
    {
        $tag = trim($tag);
        if (isset($this->hooks[$tag])) {
            $these_hooks = $this->hooks[$tag];
            uksort($these_hooks, [$this, 'my_sort']);
            foreach ($these_hooks as $hooks) {
                foreach ($hooks as $hook) {
                    call_user_func($hook, $args);
                }
            }
        } else {
            die("There is no such place ($tag) for hooks.");
        }
    }

    /**
     * filter $args and after modify, return it. (or arguments via array).
     *
     * @since 1.0
     * 
     * @param string $tag. The name of the hook.
     * @param mix    $args optional.The arguments the function accept to filter(default none)
     *
     * @return array. The $args filter result.
     */
    public function filter_hook($tag, $args)
    {
        $tag = trim($tag);
        if (isset($this->hooks[$tag])) {
            $these_hooks = $this->hooks[$tag];
            uksort($these_hooks, [$this, 'my_sort']);
            foreach ($these_hooks as $hooks) {
                foreach ($hooks as $hook) {
                    $args = call_user_func($hook, $args);
                }
            }

            return $args;
        } else {
            die("There is no such place ($tag) for hooks.");
        }
    }

    /**
     * register plugin data in $this->plugin.
     *
     * @since 1.0
     * 
     * @param string $plugin_id. The name of the plugin.
     * @param array  $data       optional.The data the plugin accessorial(default none)
     */
    public function register_plugin($plugin_id, $data = '')
    {
        foreach ($data as $key => $value) {
            $this->plugins[$plugin_id][$key] = $value;
        }
    }

    /**
     * sort hooks priority.
     */
    public function my_sort($a, $b)
    {
        if ($a == $b) {
            return 0;
        }

        return ($a < $b) ? -1 : 1;
    }
}
