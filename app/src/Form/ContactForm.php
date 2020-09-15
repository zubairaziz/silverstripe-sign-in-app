<?php

namespace App\Form;

use App\Page\HomePage;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;

class ContactForm extends Form
{
    public function __construct($controller, $name)
    {
        $settings = ContactFormSettings::current_settings();

        $page = HomePage::get()->first();

        $formButtonLabel = 'Submit';

        if ($page->FormButtonLabel) {
            $formButtonLabel = $page->FormButtonLabel;
        }

        $fields = FieldList::create([
            TextField::create('FirstName', 'First Name'),
            TextField::create('LastName', 'Last Name'),
            TextField::create('Company', 'Company'),
            TextField::create('JobTitle', 'Title'),
            TextField::create('Phone', 'Phone Number')
                ->setAttribute('type', 'tel')
                ->setAttribute('minlength', 7),
            EmailField::create('Email'),
        ]);

        $actions = FieldList::create(
            FormAction::create('submit', $formButtonLabel)->setUseButtonTag(true)->addExtraClass('btn btn-secondary')
        );

        $requiredFields = [
            'FirstName',
            'LastName',
            'Company',
            'Phone',
            'Email',
        ];

        $required = RequiredFields::create($requiredFields);

        $fields->push(HiddenField::create('SourcePageID', 'Source', Controller::curr()->ID));

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('contact-form form-control');
        $this->setAttribute('data-form-scroll', true);
        $this->setAttribute('data-form-ajax', true);
        $this->setAttribute('data-form-hide-on-submit', true);

        $this->enableSpamProtection([
            'mapping' => [
                'FirstName' => 'authorName',
                'Email' => 'authorMail',
            ]
        ]);

        // Setup fly labels
        foreach ($fields as $field) {
            $types = explode(' ', $field->Type());

            if (!empty(array_intersect($types, ['text', 'email', 'tel']))) {
                $field->enableFlyField();
            }
        }
    }

    public function setSource($sourcePage)
    {
        $this->Fields()->dataFieldByName('SourcePageID')->setValue($sourcePage->ID);
    }

    public function forTemplate()
    {
        return $this->renderWith('App/Form/ContactForm');
    }

    public function submit($data, $form)
    {
        $submission = ContactFormSubmission::create();
        $form->saveInto($submission);
        $success = $submission->write();
        $settings = ContactFormSettings::current_settings();

        $this->controller->handleemail(
            $success,
            $submission,
            'New Contact Form Submission',
            $settings
        );

        return $this->controller->handleresponse($success, $settings);
    }
}
