<?php

namespace LeKoala\ModularBehaviour;

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
}
