<?php

namespace TheWebmen\Formbuilder\Forms;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use TheWebmen\Formbuilder\Controllers\FormbuilderController;
use SilverStripe\Forms\HiddenField;

class FormbuilderForm extends Form
{

    private $_nameFilter = false;
    private $_names = [];

    public function __construct($name = self::DEFAULT_NAME, $fieldsJsonData, $pageID)
    {
        //Name filter
        $this->_nameFilter = new URLSegmentFilter();

        //Validator
        $validator = new RequiredFields();

        //Fields
        $fields = new FieldList();
        foreach ($fieldsJsonData as $fieldJsonData) {
            $field = false;
            $fieldName = $this->generateFieldName($fieldJsonData->title);
            switch ($fieldJsonData->type) {
                case 'textfield':
                    $field = TextField::create($fieldName, $fieldJsonData->title);
                    break;
                case 'emailfield':
                    $field = EmailField::create($fieldName, $fieldJsonData->title);
                    break;
                case 'checkbox':
                    $field = CheckboxField::create($fieldName, $fieldJsonData->title);
                    break;
            }
            if ($field) {
                $fields->push($field);
                if ($fieldJsonData->required) {
                    $validator->addRequiredField($fieldName);
                }
            }
        }

        $fields->push(HiddenField::create('FormPageID')->setValue($pageID));

        //Actions
        $actions = new FieldList(FormAction::create('handle', 'Send'));

        $controller = new FormbuilderController();
        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

    public function handle($data, Form $form)
    {
        $page = SiteTree::get()->byID($data['FormPageID']);
        var_dump($data);
        var_dump($page);
        die;
        //Create submission if enabled
        //Send mails
        //Show message or redirect of whatever? misschien via de class waar de extensie op zit laten lopen?
    }

    private function generateFieldName($title)
    {
        $name = $this->_nameFilter->filter($title);
        if(array_key_exists($name, $this->_names)){
            $this->_names[$name] = $this->_names[$name] + 1;
            $name = $name . $this->_names[$name];
        }else{
            $this->_names[$name] = 0;
        }
        return $name;
    }

}
