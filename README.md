# SilverStripe Formbuilder

## Introduction

Create basic forms in the CMS this module is intendended as light weight variant of the https://github.com/silverstripe/silverstripe-userforms module

## Requirements

* SilverStripe CMS ^4.0

## Installation

```
composer require "thewebmen/silverstripe-formbuilder" "dev-master"
```

Then add the "TheWebmen\Formbuilder\Extensions\FormbuilderExtension" extension the desired page type.

## Custom after form handling
A form message is displayed after a successful form submission you can add custom logic to successful submissions by adding a method called "handleFormbuilderForm" to the page with the formbuilder extension, this method receives the form, the data and the submission.

```
public function handleFormbuilderForm($form, $data, $submission){
    //Your logic here
}
```
This can be used to redirect users to a success page, this method is called after saving the submission and sending the emails.

## Spam protection
If the https://github.com/silverstripe/silverstripe-spamprotection module is installed then the form will add a spam protection field automatically


## The ModelDropdownfieldField type
There has been added a new input type called "Model Dropdownfield" which gives you the ability to fill a dropdown based on a dataobject model. One of the abilities you'll gain while using this input type, is the ability to link two dropdown/select items (eg. a province dropdown that updates another dropdown with cities from the selected province).

You can configure a field like this:

```
TheWebmen\Formbuilder\Fields\ModelDropdownField:
  models:
    - DataObjects\ModelDropdown\Provinces:
        class: 'DataObjects\ModelDropdown\Provinces'
        key: 'ID'
        value: 'Name'
        relation:
          relation: 'Locations'
          title: 'Vestiging'
          linked_by: 'ProvinceID'
          class: 'DataObjects\ModelDropdown\Locations'
          key: 'Code'
          value: 'Name'
```