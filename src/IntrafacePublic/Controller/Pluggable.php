<?php
abstract class IntrafacePublic_Controller_Pluggable extends k_Component
{
    protected $plugins = array();

    public function triggerEvent($event, $input = NULL)
    {

        foreach ($this->getPlugins() AS $plugin) {
            if (method_exists($plugin, $event)) {
                $input = $plugin->$event($this, $input);
            }
        }

        return $input;
    }

    public function getPlugins()
    {
        if (!empty($this->plugins)) {
            return $this->plugins;
        } elseif(method_exists($this->context, 'getPlugins')) {
            return $this->context->getPlugins();
        }

        return array();
    }

    public function loadPlugin($plugin)
    {
        $name = get_class($plugin);
        $this->plugins[$name] = $plugin;
    }
}