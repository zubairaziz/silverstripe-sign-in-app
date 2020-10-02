<?php

namespace App\Form;

use App\Page\HomePage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;

class ContactForm extends Form
{
    public function __construct($controller, $name)
    {
        $settings = ContactFormSettings::current_settings();

        $page = HomePage::get()->first();

        $fields = FieldList::create([
            TextField::create('FirstName', 'First Name'),
            TextField::create('LastName', 'Last Name'),
        ]);

        $actions = FieldList::create(
            FormAction::create('submit', 'Submit')->setUseButtonTag(true)->addExtraClass('button button-secondary')
        );

        $requiredFields = [
            'FirstName',
            'LastName',
        ];

        $required = RequiredFields::create($requiredFields);

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('contact-form form-control');
        $this->setAttribute('data-form-scroll', true);
        $this->setAttribute('data-form-ajax', true);
        $this->setAttribute('data-form-hide-on-submit', true);
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
