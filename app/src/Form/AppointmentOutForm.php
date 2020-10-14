<?php

namespace App\Form;

use App\Page\HomePage;
use App\Util\Util;
use DateTime;
use DateTimeZone;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

class AppointmentOutForm extends Form
{
    public function __construct($controller, $name, $disabled = false)
    {
        $page = HomePage::get()->first();

        $fields = null;

        if ($disabled) {
            $actions = FieldList::create(
                FormAction::create('appointmentout', 'Appointment')
                ->setUseButtonTag(true)
                ->addExtraClass('button button-disabled disabled my-1')
                ->setAttribute('formaction', $this->Link('appointmentout'))
                ->setAttribute('disabled', true)
            );
        } else {
            $actions = FieldList::create(
                FormAction::create('appointmentout', 'Appointment')
                ->setUseButtonTag(true)
                ->addExtraClass('button button-primary my-1')
                ->setAttribute('formaction', $this->Link('appointmentout'))
            );
        }

        $required = null;

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('appointment-form');
        $this->setAttribute('data-form-ajax', true);
        $this->setAttribute('data-form-hide-on-submit', true);
    }

    public function forTemplate()
    {
        return $this->renderWith('App/Form/SingleActionForm');
    }

    public function appointmentout()
    {
        $success = false;

        $employee = Controller::curr()->getLoggedInEmployee();

        if ($employee) {
            $success = true;
            $session = $this->controller->getSession();
            $tz = 'America/New_York';
            $timestamp = time();
            $time = new DateTime("now", new DateTimeZone($tz));
            $time->setTimestamp($timestamp);
            $timesheet = $employee->getTodaysTimesheet();
            $timesheet->AppointmentOutTime = $time->format('H:i');
            $timesheet->write();
        }

        Util::signOut();

        return $this->controller->handleappointmentout($success, $employee);
    }

    public function Link($action = null)
    {
        return Controller::join_links(
            '_formsubmit',
            $action
        );
    }
}
