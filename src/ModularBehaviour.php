<?php

namespace LeKoala\ModularBehaviour;

use SilverStripe\Forms\FormField;
use SilverStripe\View\Requirements;

trait ModularBehaviour
{
    /**
     * @var boolean
     */
    protected $modularLazy = false;

    public static function modularRequirements()
    {
        Requirements::javascript("lekoala/silverstripe-modular-behaviour: client/modular-behaviour.min.js", ["type" => "module"]);
        // Ideally this should be supported by your backend provider (see Defer Backend)
        Requirements::javascript("lekoala/silverstripe-modular-behaviour: client/fallback.js", ["nomodule" => true]);
    }

    /**
     * @return boolean
     */
    public function getModularLazy()
    {
        return $this->modularLazy;
    }

    /**
     * @param boolean $v
     * @return $this
     */
    public function setModularLazy($v)
    {
        $this->modularLazy = $v;
        return $this;
    }

    /**
     * Prevent watching the global scope
     * @return boolean
     */
    public function getModularManual()
    {
        return false;
    }

    /**
     * Dynamically importable path
     * @return string
     */
    public function getModularSrc()
    {
        return null;
    }

    /**
     * Custom selector if element is not the first child
     * @return string
     */
    public function getModularSelector()
    {
        return null;
    }

    /**
     * Name of the alternative function to initialize the element
     * @return string
     */
    public function getModularFunc()
    {
        return null;
    }

    /**
     * The name of the constructor function in the global scope
     * @return string
     */
    public function getModularName()
    {
        if ($this->getModularSrc()) {
            return null;
        }
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * A JSON or JS script
     * @return string
     */
    public function getModularConfig()
    {
        return null;
    }

    /**
     * Name of the js variable as injected in the global scope in
     * getModularConfig
     * @return string
     */
    public function getModularConfigName()
    {
        return null;
    }

    /**
     * Call this in your getField method to return a wrapped field
     *
     * @param array $properties
     * @return FormField
     */
    public function getModularField($properties = [])
    {
        // Requirements
        if (ModularFormField::config()->enable_modular_requirements) {
            self::modularRequirements();
        }

        $field = parent::Field($properties);

        // Build attrs
        $attrs = [];
        if ($this->getModularName()) {
            $attrs['name'] = $this->getModularName();
        }
        $selector = $this->getModularSelector();
        if ($selector) {
            $attrs['selector'] = $selector;
        }
        $configName = $this->getModularConfigName();
        if ($configName) {
            $attrs['config'] = $configName;
        }
        $scriptSrc = $this->getModularSrc();
        if ($scriptSrc) {
            $attrs['src'] = $scriptSrc;
        }
        $arr = [];
        foreach ($attrs as $k => $v) {
            $arr[] = "$k=\"$v\"";
        }
        if ($this->modularLazy) {
            $arr[] = "lazy";
        }
        if ($this->getModularManual()) {
            $arr[] = "manual";
        }
        $htmlAttrs = implode(" ", $arr);

        // This can be a json array or a js script if config name is set
        $config = $this->getModularConfig();
        if ($config) {
            $config = '<template class="modular-behaviour-config">' . $config . '</template>';
        }

        // Wrap
        $v = $field->getValue();
        $v = '<modular-behaviour ' . $htmlAttrs . '>' . $v . $config . '</modular-behaviour>';
        $field->setValue($v);

        return $field;
    }
}
