<?php

namespace TheWebmen\Formbuilder\Forms;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Parsers\URLSegmentFilter;
use TheWebmen\Formbuilder\Controllers\FormbuilderController;
use TheWebmen\Formbuilder\Extensions\FormbuilderExtension;
use TheWebmen\Formbuilder\Model\FormbuilderSubmission;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Control\Email\Email;

class FormbuilderForm extends Form
{

    private $_nameFilter = false;
    private $_names = [];
    private $_labels = [];

    /**
     * FormbuilderForm constructor.
     * @param \SilverStripe\Control\RequestHandler|string $name
     * @param string $fieldsJsonData
     * @param FieldList $pageID
     */
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
            if (!isset($fieldJsonData->title) || $fieldJsonData->title == '') {
                continue;
            }
            $fieldName = $this->generateFieldName($fieldJsonData->title);
            switch ($fieldJsonData->type) {
                case 'textfield':
                    $field = TextField::create($fieldName, $fieldJsonData->title);
                    break;
                case 'textarea':
                    $field = TextareaField::create($fieldName, $fieldJsonData->title);
                    break;
                case 'emailfield':
                    $field = EmailField::create($fieldName, $fieldJsonData->title);
                    break;
                case 'checkbox':
                    $field = CheckboxField::create($fieldName, $fieldJsonData->title);
                    break;
                case 'checkboxset':
                    $options = $this->generateOptions($fieldJsonData->options);
                    $field = CheckboxSetField::create($fieldName, $fieldJsonData->title, $options);
                    break;
                case 'dropdown':
                    $options = $this->generateOptions($fieldJsonData->options);
                    $field = DropdownField::create($fieldName, $fieldJsonData->title, $options);
                    break;
                case 'radiogroup':
                    $options = $this->generateOptions($fieldJsonData->options);
                    $field = OptionsetField::create($fieldName, $fieldJsonData->title, $options);
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
        $actions = new FieldList(FormAction::create('handle', _t(self::class . '.SEND', 'Send')));

        $controller = new FormbuilderController();
        parent::__construct($controller, $name, $fields, $actions, $validator);

        if ($this->hasExtension('SilverStripe\SpamProtection\Extension\FormSpamProtectionExtension')) {
            $this->enableSpamProtection();
        }
        
        $this->extend('onAfterConstruct');
    }

    public function generateOptions($data)
    {
        $out = array();
        foreach ($data as $item) {
            if (isset($item->value) && isset($item->label) && $item->label != '') {
                $out[$item->value] = $item->label;
            }
        }
        return $out;
    }

    /**
     * Handle form submissions
     * @param $data
     * @param Form $form
     * @return \SilverStripe\Control\HTTPResponse
     */
    public function handle($data, Form $form)
    {
        //Get page
        $page = SiteTree::get()->byID($data['FormPageID']);

        //Remove data
        unset($data['FormPageID']);
        unset($data['SecurityID']);
        unset($data['action_handle']);

        //Submission
        if(Config::inst()->get(FormbuilderExtension::class, 'save_submissions')){
            $submission = new FormbuilderSubmission();
            $submission->SiteTreeID = $page->ID;
            $submission->Data = json_encode($data);
            $submission->write();
        }else{
            $submission = false;
        }

        //Email
        $emailReceivers = $page->FormbuilderFormReceiver;
        if ($emailReceivers) {
            $emailSubject = $page->FormbuilderFormSubject ? $page->FormbuilderFormSubject : _t(self::class . '.DEFAULT_SUBJECT', 'New email via the website');
            $emailSender = $page->FormbuilderFormSender;
            if (strpos($emailSender, '@') == FALSE) {
                $emailSender = $data[$this->generateFieldName($emailSender, true)];
                if (!$emailSender) {
                    $emailSender = 'no-email@found.com';
                }
            }
            $emailReceivers = explode(';', $emailReceivers);
            $emailData = new ArrayList();
            foreach($data as $key => $value){
                if(is_array($value)){
                    $value = implode(',', $value);
                }
                $emailData->push(new ArrayData([
                    'Value' => $value,
                    'Key' => $key,
                    'Label' => $this->_labels[$key]
                ]));
            }
            foreach ($emailReceivers as $receiver) {
                $email = Email::create();
                $email->setHTMLTemplate('Email\\FormbuilderEmail');
                $email->setData([
                    'FormData' => $emailData
                ]);
                $email->setFrom($emailSender);
                $email->setTo($receiver);
                $email->setSubject($emailSubject);
                $email->send();
            }
        }

        //Auto reply email
        if($page->FormbuilderAutoReplySender && $page->FormbuilderAutoReplyReceiver && $page->FormbuilderAutoReplySubject && $page->FormbuilderAutoReplyContent){
            $receiver = $data[$this->generateFieldName($page->FormbuilderAutoReplyReceiver, true)];
            if($receiver){
                $emailContent = $page->FormbuilderAutoReplyContent;
                foreach($data as $key => $value){
                    if(is_array($value)){
                        $value = implode(',', $value);
                    }
                    $stringToReplace = '['.$this->_labels[$key].']';
                    $emailContent = str_replace($stringToReplace, $value, $emailContent);
                }
                $email = Email::create();
                $email->setHTMLTemplate('Email\\FormbuilderAutoReplayEmail');
                $email->setData([
                    'Content' => DBField::create_field(DBHTMLText::class, $emailContent)
                ]);
                $email->setFrom($page->FormbuilderAutoReplySender);
                $email->setTo($receiver);
                $email->setSubject($page->FormbuilderAutoReplySubject);
                $email->send();
            }
        }

        //Finish
        if (method_exists($page, 'handleFormbuilderForm')) {
            $page->handleFormbuilderForm($this, $data, $submission);
        } else {
            $this->sessionMessage(_t(self::class . '.FORM_SEND_MESSAGE', 'Form send successfully'), 'good');
            return $this->controller->redirect($page->Link());
        }
    }

    /**
     * Generate a unique field name based on the title
     * @param $title
     * @return string
     */
    private function generateFieldName($title, $getExisting = false)
    {
        $name = $this->_nameFilter->filter($title);
        if ($getExisting) {
            return array_key_exists($name, $this->_names) ? $name : false;
        }
        if (array_key_exists($name, $this->_names)) {
            $this->_names[$name] = $this->_names[$name] + 1;
            $name = $name . $this->_names[$name];
        } else {
            $this->_names[$name] = 0;
        }
        $this->_labels[$name] = $title;
        return $name;
    }

}
