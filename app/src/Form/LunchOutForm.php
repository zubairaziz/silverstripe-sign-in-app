<?php

namespace App\Form;

use App\Page\HomePage;
use DateTime;
use DateTimeZone;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

class LunchOutForm extends Form
{
    public function __construct($controller, $name)
    {
        $page = HomePage::get()->first();

        $fields = null;

        $actions = FieldList::create(
            FormAction::create('lunchout', 'Lunch')
                ->setUseButtonTag(true)
                ->addExtraClass('button button-primary my-1')
                ->setAttribute('formaction', $this->Link('lunchout'))
        );

        $required = null;

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('lunch-form');
        $this->setAttribute('data-form-ajax', true);
    }

    public function forTemplate()
    {
        return $this->renderWith('App/Form/SingleActionForm');
    }

    public function lunchout()
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
            $timesheet->LunchOutTime = $time->format('H:i');
            $timesheet->write();
        }

        return $this->controller->handlelunchout($success);
    }

    public function Link($action = null)
    {
        return Controller::join_links(
            '_formsubmit',
            $action
        );
    }
}
