<?php

namespace LeKoala\ModularBehaviour;

use SilverStripe\Forms\FormField;
use SilverStripe\View\Requirements;

/**
 * A base class for modular fields
 */
class ModularFormField extends FormField
{
    use ModularBehaviour;

    public function Field($properties = [])
    {
        // Requirements
        if ($this->config()->enable_modular_requirements) {
            self::modularRequirements();
        }

        $field = parent::Field();

        // Build attrs
        $attrs = [
            'name' => $this->getModularName(),
        ];
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
