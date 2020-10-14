<?php

namespace App\Form;

use App\Model\Employee;
use App\Page\HomePage;
use DateTime;
use DateTimeZone;
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
                ->setAttribute('inputmode', 'numeric')
                ->addExtraClass('text-center text-xl tracking-widest')
                ->setAttribute('data-mask', '####')
                // ->setAttribute('placeholder', '____')
                // ->setAttribute('type', 'number')
                // ->setAttribute('maxlength', 4)
                // ->setAttribute('max', '9999')
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
        // $this->setAttribute('data-form-ajax', true);
        $this->setAttribute('data-form-hide-on-submit', true);
    }

    public function forTemplate()
    {
        return $this->renderWith('App/Form/SignInForm');
    }

    public function submit($data, $form)
    {
        $success = false;

        $employeeID = null;
        $employee = Employee::getEmployeeByPin($data['PIN']);

        if ($employee) {
            $success = true;
            $showMessage = false;
            $session = $this->controller->getSession();
            if ($employee->hasSignedIn()) {
                $employeeID = $employee->ID;
                $session->set('LoggedIn', true);
                $session->set('EmployeeID', $employeeID);
                $session->set('Employee', $employee);
            } else {
                $tz = 'America/New_York';
                $timestamp = time();
                $time = new DateTime("now", new DateTimeZone($tz));
                $time->setTimestamp($timestamp);
                $timesheet = $employee->getTodaysTimesheet();
                $timesheet->SignInTime = $time->format('H:i');
                $timesheet->write();
                $showMessage = true;
            }
        } else {
            $success = false;
            $showMessage = false;
        }

        return $this->controller->handlelogin($success, $employee, $showMessage);
    }
}
