<?php

namespace App\Form;

use App\Model\Employee;
use App\Page\HomePage;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

class SignOutForm extends Form
{
    public function __construct($controller, $name, $disabled = false)
    {
        $page = HomePage::get()->first();

        $fields = null;

        if ($disabled) {
            $actions = FieldList::create(
                FormAction::create('submit', 'End Of Day')
                ->setUseButtonTag(true)
                ->addExtraClass('button button-disabled disabled my-1')
                ->setAttribute('formaction', $this->Link('submit'))
                ->setAttribute('disabled', true)
            );
        } else {
            $actions = FieldList::create(
                FormAction::create('submit', 'End Of Day')
                    ->setUseButtonTag(true)
                    ->addExtraClass('button button-primary my-1')
            );
        }

        $required = null;

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('sign-out-form');
        $this->setAttribute('data-form-ajax', true);

        $this->setTemplate('App/Form/SingleActionForm');
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
            $tz = 'America/New_York';
            $timestamp = time();
            $time = new DateTime("now", new DateTimeZone($tz));
            $time->setTimestamp($timestamp);
            $timesheet = $employee->getTodaysTimesheet();
            $timesheet->SignOutTime = $time->format('H:i');
            $timesheet->write();
            $showMessage = true;
        } else {
            $success = false;
            $showMessage = false;
        }

        return $this->controller->handlelogin($success, $employeeID, $showMessage);
    }

    public function Link($action = null)
    {
        return Controller::join_links(
            '_formsubmit',
            $action
        );
    }
}
