<?php

namespace TheWebmen\Formbuilder\Controllers;

use SilverStripe\Control\Controller;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use TheWebmen\Formbuilder\Forms\FormbuilderForm;

class FormbuilderController extends Controller {

    private static $url_segment = 'FormbuilderController';
    private static $allowed_actions = array(
        'FormbuilderForm'
    );

    public function index(){
        $this->httpError(404);
    }

    public function FormbuilderForm(){
        $r = $this->getRequest();
        if(!$r->isPOST()){
            $this->httpError(404);
        }

        $formOwnerID = $r->postVar('OwnerID');
        $formOwnerClass = $r->postVar('OwnerClass');
        if(!$formOwnerID || !$formOwnerClass || !$owner = $formOwnerClass::get()->byID($formOwnerID)){
            $this->httpError(404);
        }
        $fields = [];
        if($fieldsData = $owner->FormbuilderFields){
            $fields = json_decode($fieldsData);
        }
        return new FormbuilderForm('FormbuilderForm', $fields, $owner);
    }

}
