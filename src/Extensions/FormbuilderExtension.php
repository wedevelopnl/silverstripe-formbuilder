<?php

namespace TheWebmen\Formbuilder\Extensions;

use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\TabSet;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use TheWebmen\Formbuilder\Forms\FormbuilderForm;
use TheWebmen\Formbuilder\Model\FormbuilderSubmission;
use TheWebmen\Formbuilder\Forms\FormbuilderFieldsField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

class FormbuilderExtension extends DataExtension {

    private static $save_submissions = true;

    private static $db = [
        'FormbuilderFields' => 'Text',
        'FormbuilderFormSender' => 'Varchar(155)',
        'FormbuilderFormReplyTo' => 'Varchar(155)',
        'FormbuilderFormReceiver' => 'Varchar(255)',
        'FormbuilderFormSubject' => 'Varchar',
        'FormbuilderAutoReplySender' => 'Varchar(155)',
        'FormbuilderAutoReplyReceiver' => 'Varchar(155)',
        'FormbuilderAutoReplySubject' => 'Varchar',
        'FormbuilderAutoReplyContent' => 'HTMLText',
        'FormbuilderSendButtonText' => 'Varchar',
    ];

    private static $has_many = [
        'FormbuilderSubmissions' => FormbuilderSubmission::class
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root', new TabSet('Form', _t(self::class . '.FORM', 'Form')));

        $fields->addFieldToTab('Root.Form.Fields', FormbuilderFieldsField::create('FormbuilderFields', _t(self::class . '.FORMBUILDER_FIELDS', 'Fields')));

        $fields->addFieldsToTab('Root.Form.Email', [
            TextField::create('FormbuilderFormSender', _t(self::class . '.FORMBUILDER_FORM_SENDER', 'Form email sender'))->setDescription(_t(self::class . '.FORMBUILDER_FORM_SENDER_DESCRIPTION', 'This could be an email adres or the title of an email form field if you want to use the users input as sender')),
            TextField::create('FormbuilderFormReplyTo', _t(self::class . '.FORMBUILDER_FORM_REPLY_TO', 'Form email replyto'))->setDescription(_t(self::class . '.FORMBUILDER_FORM_SENDER_DESCRIPTION', 'This could be an email adres or the title of an email form field if you want to use the users input as sender')),
            TextField::create('FormbuilderFormReceiver', _t(self::class . '.FORMBUILDER_FORM_RECEIVER', 'Form email receiver'))->setDescription(_t(self::class . '.FORMBUILDER_FORM_RECEIVER_DESCRIPTION', 'Seperate with a ; to add multiple receivers')),
            TextField::create('FormbuilderFormSubject', _t(self::class . '.FORMBUILDER_FORM_SUBJECT', 'Form email subject'))
        ]);

        $fields->findOrMakeTab('Root.Form.Autoreply', _t(self::class . '.AUTOREPLY', 'Autoreply'));
        $fields->addFieldsToTab('Root.Form.Autoreply', [
            TextField::create('FormbuilderAutoReplySender', _t(self::class . '.FORMBUILDER_AUTOREPLY_SENDER', 'Autoreply email sender')),
            TextField::create('FormbuilderAutoReplyReceiver', _t(self::class . '.FORMBUILDER_AUTOREPLY_RECEIVER', 'Autoreply email receiver'))->setDescription(_t(self::class . '.FORMBUILDER_AUTOREPLY_RECEIVER_DESCRIPTION', 'Use the title of an email form field')),
            TextField::create('FormbuilderAutoReplySubject', _t(self::class . '.FORMBUILDER_AUTOREPLY_SUBJECT', 'Autoreply email subject')),
            HTMLEditorField::create('FormbuilderAutoReplyContent', _t(self::class . '.FORMBUILDER_AUTOREPLY_CONTENT', 'Autoreply email content'))->setDescription(_t(self::class . '.FORMBUILDER_AUTOREPLY_CONTENT_DESCRIPTION', 'You can use user input by wrapping the title of a field in brackets, for example: [Name]'))
        ]);
        
        $fields->addFieldToTab('Root.Form.Options', TextField::create('FormbuilderSendButtonText', _t(self::class . '.SEND_BUTTON_TEXT', 'Send button text')));

        if(Config::inst()->get(self::class, 'save_submissions')){
            $fields->findOrMakeTab('Root.Form.Submissions', _t(self::class . '.has_many_FormbuilderSubmissions', 'Submissions'));
            $fields->addFieldToTab('Root.Form.Submissions', $gfSubmissions = GridField::create('FormbuilderSubmissions', _t(self::class . '.FORMBUILDER_SUBMISSIONS', 'Submissions'), $this->owner->FormbuilderSubmissions(), GridFieldConfig_RecordViewer::create()));

            $gfcConfig = $gfSubmissions->getConfig();
            $gfcConfig->addComponent($gfebExportButton = new GridFieldExportButton('before'));
            $gfcConfig->addComponent(new GridFieldDeleteAction());

            $fields = [];
            if($fieldsData = $this->owner->FormbuilderFields){
                $fieldObjects = json_decode($fieldsData);
                foreach ($fieldObjects as $fieldObject)
                    $fields[] = $fieldObject->title;
            }

            $gfebExportButton->setExportColumns($fields);

        }else{
            $fields->removeByName('FormbuilderSubmissions');
        }

    }

    public function FormbuilderForm(){
        $fields = [];
        if($fieldsData = $this->owner->FormbuilderFields){
            $fields = json_decode($fieldsData);
        }
        return new FormbuilderForm('FormbuilderForm', $fields, $this->owner);
    }

}
