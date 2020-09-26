<?php

namespace App\Form;

use App\Model\Employee;
use App\Page\HomePage;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;

class SignInForm extends Form
{
    public function __construct($controller, $name)
    {
        $page = HomePage::get()->first();

        $fields = FieldList::create([
            TextField::create('PIN', '')
                ->setAttribute('placeholder', 'Insert 4 digit PIN')
                ->setAttribute('type', 'number')
                // ->setAttribute('pattern', '[0-9]{4}')
                ->setAttribute('minlength', 4)
                ->setAttribute('maxlength', 4)
                ->addExtraClass('text-center')
        ]);

        $actions = FieldList::create(
            FormAction::create('submit', 'Sign In')->setUseButtonTag(true)->addExtraClass('button button-secondary')
        );

        $requiredFields = [
            'PIN',
        ];

        $required = RequiredFields::create($requiredFields);

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('sign-in-form');
        $this->setAttribute('data-form-scroll', true);
        $this->setAttribute('data-form-ajax', true);
        $this->setAttribute('data-form-hide-on-submit', true);
    }

    public function forTemplate()
    {
        return $this->renderWith('App/Form/SignInForm');
    }

    public function submit($data, $form)
    {
        $success = true;

        $employee = Employee::getEmployeeByPin($data['PIN']);

        // Debug::show($employee);

        if ($employee) {
            $session = $this->controller->getSession();
            $session->set('LoggedIn', true);
            $session->set('EmployeeID', $employee->ID);
            $session->set('Employee', $employee);
            $employeeID = $employee->ID;
        }

        return $this->controller->handlelogin($success, $employeeID);
    }
}
