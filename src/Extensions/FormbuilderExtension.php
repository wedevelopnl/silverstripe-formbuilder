<?php

namespace TheWebmen\Formbuilder\Extensions;

use SilverStripe\Forms\TabSet;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use TheWebmen\Formbuilder\Model\FormbuilderSubmission;
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
        var_dump( $this->owner->hasMany() );
        die;

        $fields->addFieldsToTab('Root', new TabSet('Form'));



        $fields->addFieldsToTab('Root.Form.Email', [
            TextField::create('FormbuilderFormSender'),
            TextField::create('FormbuilderFormReceiver'),
            TextField::create('FormbuilderFormSubject')
        ]);

        $fields->addFieldsToTab('Root.Form.AutoReply', [
            TextField::create('FormbuilderAutoReplySender'),
            TextField::create('FormbuilderAutoReplyReceiver'),
            TextField::create('FormbuilderAutoReplySubject'),
            HTMLEditorField::create('FormbuilderAutoReplyContent')
        ]);

        $fields->addFieldToTab('Root.Form.Submissions', GridField::create('FormbuilderSubmissions', 'Submissions', $this->owner->FormbuilderSubmissions(), GridFieldConfig_RecordViewer::create()));
    }

}
