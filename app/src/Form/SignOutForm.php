<?php

namespace App\Form;

use App\Page\HomePage;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

class SignOutForm extends Form
{
    public function __construct($controller, $name)
    {
        $page = HomePage::get()->first();

        $fields = null;

        $actions = FieldList::create(
            FormAction::create('submit', 'Cancel')->setUseButtonTag(true)->addExtraClass('button button-secondary')
        );

        $required = null;

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('sign-out-form');
        // $this->setAttribute('data-form-scroll', true);
        // $this->setAttribute('data-form-ajax', true);
        $this->setAttribute('data-form-hide-on-submit', true);
    }

    public function forTemplate()
    {
        return $this->renderWith('App/Form/SignOutForm');
    }

    public function submit($data, $form)
    {
        $success = true;

        $session = $this->controller->getSession();
        $session->set('LoggedIn', false);
        $session->set('EmployeeID', null);
        $session->set('Employee', null);

        return $this->controller->handlelogout();

        // return $this->controller->handleresponse($success);
    }
}
