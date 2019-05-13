<?php

namespace TheWebmen\Formbuilder\Forms;

use SilverStripe\Forms\TextareaField;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use TheWebmen\Formbuilder\Fields\ModelDropdownField;

class FormbuilderFieldsField extends TextareaField {

    private $_fields;

    public function __construct($name, $title = null, $value = null)
    {
        // Initialize default fields
        $this->_fields = ArrayList::create();
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Textfield',
                                                'Field' => 'textfield',
                                                'Label' => i18n::_t('Formbuilder.TEXTFIELD', 'Textfield')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Textarea',
                                                'Field' => 'textarea',
                                                'Label' => i18n::_t('Formbuilder.TEXTAREA', 'Textarea')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Emailfield',
                                                'Field' => 'emailfield',
                                                'Label' => i18n::_t('Formbuilder.EMAILFIELD', 'Emailfield')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Phonefield',
                                                'Field' => 'phonefield',
                                                'Label' => i18n::_t('Formbuilder.PHONEFIELD', 'Phonefield')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Checkbox',
                                                'Field' => 'checkbox',
                                                'Label' => i18n::_t('Formbuilder.CHECKBOX', 'Checkbox')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Checkboxset',
                                                'Field' => 'checkboxset',
                                                'Label' => i18n::_t('Formbuilder.CHECKBOXSET', 'Checkboxset')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Radiogroup',
                                                'Field' => 'radiogroup',
                                                'Label' => i18n::_t('Formbuilder.RADIOGROUP', 'Radiogroup')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\Dropdown',
                                                'Field' => 'dropdown',
                                                'Label' => i18n::_t('Formbuilder.DROPDOWN', 'Dropdown')]));
        $this->_fields->push(ArrayData::create(['Template' => 'TheWebmen\\Formbuilder\\Fields\\ModelDropdown',
                                                'Field' => 'modeldropdown',
                                                'Label' => i18n::_t('Formbuilder.MODELDROPDOWN', 'Model Dropdown')]));

    parent::__construct($name, $title, $value);
    }

    public function Field($properties = array())
    {
        Requirements::css('thewebmen/silverstripe-formbuilder:resources/css/formbuilder.css');
        Requirements::javascript('thewebmen/silverstripe-formbuilder:resources/js/formbuilder.js');
        return $this->renderWith('TheWebmen\\Formbuilder\\FormbuilderFieldsTemplate');
    }

    public function Fields()
    {
        return $this->_fields;
    }

    public function RenderFields()
    {
        $output = '';
        foreach ($this->_fields as $field)
        {
            $output .= $this->renderWith($field->Template);
        }
        return $output;
    }

    public function AllowedModelDropdownModels()
    {
        return ModelDropdownField::get_allowed_models();
    }
}
