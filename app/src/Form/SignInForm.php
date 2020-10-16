<?php

namespace App\Form;

use App\Model\CalendarSettings;
use App\Model\Employee;
use App\Model\LateSignIn;
use App\Page\HomePage;
use App\Util\Util;
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
            // TextField::create('PIN', '')
            //     ->setAttribute('inputmode', 'numeric')
            //     ->addExtraClass('text-center text-xl tracking-widest')
            //     ->setAttribute('pattern', '\d{4}')
            TextField::create('PIN1', '')
                ->setAttribute('inputmode', 'numeric')
                ->addExtraClass('text-center text-xl md:text-3xl')
                ->setAttribute('pattern', '\d{1}')
                ->setAttribute('min', 0)
                ->setAttribute('max', '9')
                ->setAttribute('data-pin-input', true),
            TextField::create('PIN2', '')
                ->setAttribute('inputmode', 'numeric')
                ->addExtraClass('text-center text-xl md:text-3xl')
                ->setAttribute('pattern', '\d{1}')
                ->setAttribute('min', 0)
                ->setAttribute('max', '9')
                ->setAttribute('data-pin-input', true),
            TextField::create('PIN3', '')
                ->setAttribute('inputmode', 'numeric')
                ->addExtraClass('text-center text-xl md:text-3xl')
                ->setAttribute('pattern', '\d{1}')
                ->setAttribute('min', 0)
                ->setAttribute('max', '9')
                ->setAttribute('data-pin-input', true),
            TextField::create('PIN4', '')
                ->setAttribute('inputmode', 'numeric')
                ->addExtraClass('text-center text-xl md:text-3xl')
                ->setAttribute('pattern', '\d{1}')
                ->setAttribute('min', 0)
                ->setAttribute('max', '9')
                ->setAttribute('data-pin-input', true)
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
        $pin = "{$data['PIN1']}{$data['PIN2']}{$data['PIN3']}{$data['PIN4']}";
        $employee = Employee::getEmployeeByPin($pin);

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
                $time = $time->setTimestamp($timestamp);
                $time = $time->format('H:i');
                $timesheet = $employee->getTodaysTimesheet();
                $timesheet->SignInTime = $time;
                $timesheet->write();
                $showMessage = true;
                $settings = CalendarSettings::current_settings();

                // Setup late sign in
                $dayOfWeek = date("l", strtotime($time));
                $mondayTime = $settings->MondayStart;
                $tuesdayTime = $settings->TuesdayStart;
                $wednesdayTime = $settings->WednesdayStart;
                $thursdayTime = $settings->ThursdayStart;
                $fridayTime = $settings->FridayStart;
                $subject = 'Late Sign-In Notification';
                $formSettings = ContactFormSettings::current_settings();
                switch ($dayOfWeek) {
                    case 'Sunday':
                        if ($time > $sundayTime) {
                            $this->controller->handleemail($success, $employee, $subject, $formSettings);
                            $this->createLateSignIn($employee);
                        }
                        break;
                    case 'Monday':
                        if ($time > $mondayTime) {
                            $this->controller->handleemail($success, $employee, $subject, $formSettings);
                            $this->createLateSignIn($employee);
                        }
                        break;
                    case 'Tuesday':
                        if ($time > $tuesdayTime) {
                            $this->controller->handleemail($success, $employee, $subject, $formSettings);
                            $this->createLateSignIn($employee);
                        }
                        break;
                    case 'Wednesday':
                        if ($time > $wednesdayTime) {
                            $this->controller->handleemail($success, $employee, $subject, $formSettings);
                            $this->createLateSignIn($employee);
                        }
                        break;
                    case 'Thursday':
                        if ($time > $thursdayTime) {
                            $this->controller->handleemail($success, $employee, $subject, $formSettings);
                            $this->createLateSignIn($employee);
                        }
                        break;
                    case 'Friday':
                        if ($time > $fridayTime) {
                            $this->controller->handleemail($success, $employee, $subject, $formSettings);
                            $this->createLateSignIn($employee);
                        }
                        break;
                    case 'Saturday':
                        if ($time > $saturdayTime) {
                            $this->controller->handleemail($success, $employee, $subject, $formSettings);
                            $this->createLateSignIn($employee);
                        }
                        break;
                    default:
                        break;
                }
            }
        } else {
            $success = false;
            $showMessage = false;
        }

        return $this->controller->handlelogin($success, $employee, $showMessage);
    }

    public function createLateSignIn($employee)
    {
        $late = LateSignIn::create();
        $late->Date = Util::getTodaysDate();
        $employee->LateSignIns()->add($late);
        $employee->write();
    }
}
