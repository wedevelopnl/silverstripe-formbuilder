<?php

namespace TheWebmen\Formbuilder\Extensions;

use SilverStripe\Forms\TabSet;
use SilverStripe\GraphQL\Controller;
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

    private static $db = [
        'FormbuilderFields' => 'Text',
        'FormbuilderFormSender' => 'Varchar(155)',
        'FormbuilderFormReceiver' => 'Varchar(255)',
        'FormbuilderFormSubject' => 'Varchar',
        'FormbuilderAutoReplySender' => 'Varchar(155)',
        'FormbuilderAutoReplyReceiver' => 'Varchar(155)',
        'FormbuilderAutoReplySubject' => 'Varchar',
        'FormbuilderAutoReplyContent' => 'HTMLText'
    ];

    private static $has_many = [
        'FormbuilderSubmissions' => FormbuilderSubmission::class
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root', new TabSet('Form'));

        $fields->addFieldToTab('Root.Form.Fields', FormbuilderFieldsField::create('FormbuilderFields'));

        $fields->addFieldsToTab('Root.Form.Email', [
            TextField::create('FormbuilderFormSender')->setDescription('This could be an email adres or the name of a email form field to use the users input as sender'),
            TextField::create('FormbuilderFormReceiver')->setDescription('Seperate with a ; to add multiple receivers'),
            TextField::create('FormbuilderFormSubject')
        ]);

        $fields->addFieldsToTab('Root.Form.AutoReply', [
            TextField::create('FormbuilderAutoReplySender'),
            TextField::create('FormbuilderAutoReplyReceiver')->setDescription('Use the name of a email form field'),
            TextField::create('FormbuilderAutoReplySubject'),
            HTMLEditorField::create('FormbuilderAutoReplyContent')
        ]);

        $fields->addFieldToTab('Root.Form.Submissions', GridField::create('FormbuilderSubmissions', 'Submissions', $this->owner->FormbuilderSubmissions(), GridFieldConfig_RecordViewer::create()));
    }

    public function FormbuilderForm(){
        $fields = [];
        if($fieldsData = $this->owner->FormbuilderFields){
            $fields = json_decode($fieldsData);
        }
        return new FormbuilderForm('FormbuilderForm', $fields, $this->owner->ID);
    }

}
