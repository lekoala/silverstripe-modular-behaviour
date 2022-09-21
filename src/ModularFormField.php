<?php

namespace LeKoala\ModularBehaviour;

use SilverStripe\Forms\FormField;

/**
 * A base class for modular fields
 */
class ModularFormField extends FormField
{
    use ModularBehaviour;

    public function Field($properties = [])
    {
        return $this->getModularField($properties);
    }
}
