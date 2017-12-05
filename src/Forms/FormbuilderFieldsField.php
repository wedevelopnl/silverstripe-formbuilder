<?php

namespace TheWebmen\Formbuilder\Forms;

use SilverStripe\Forms\TextareaField;
use SilverStripe\View\Requirements;

class FormbuilderFieldsField extends TextareaField {

    public function Field($properties = array())
    {
        Requirements::css('thewebmen/silverstripe-formbuilder:resources/css/formbuilder.css');
        Requirements::javascript('thewebmen/silverstripe-formbuilder:resources/js/formbuilder.js');
        return $this->renderWith('TheWebmen\\Formbuilder\\FormbuilderFieldsField');
    }

}
