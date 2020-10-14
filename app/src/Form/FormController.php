<?php

namespace App\Form;

use App\Email\Mailer;
use App\Model\MessageSettings;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\Convert;
use SilverStripe\Security\SecurityToken;

class FormController extends Controller
{
    private static $allowed_actions = [
        'ContactForm',
        'SignInForm',
        'SignOutForm',
        'LogOutForm',
        'LunchOutForm',
        'LunchInForm',
        'AppointmentOutForm',
        'AppointmentInForm',
        'getSession',
        'handleemail',
        'handlelogin',
        'handlelogout',
        'handlelunchout',
        'handlelunchin',
        'handleappointmentout',
        'handleappointmentin',
        'handleresponse',
        'handleerrorresponse'
    ];

    private static $url_segment = '/_formsubmit';

    public function init()
    {
        parent::init();
    }

    public function ContactForm()
    {
        return ContactForm::create($this, __FUNCTION__);
    }

    public function SignInForm()
    {
        return SignInForm::create($this, __FUNCTION__);
    }

    public function SignOutForm($disabled = false)
    {
        return SignOutForm::create($this, __FUNCTION__, $disabled);
    }

    public function LogOutForm($isNavigation = false)
    {
        return LogOutForm::create($this, __FUNCTION__, $isNavigation);
    }

    public function LunchOutForm($disabled = false)
    {
        return LunchOutForm::create($this, __FUNCTION__, $disabled);
    }

    public function LunchInForm($disabled = false)
    {
        return LunchInForm::create($this, __FUNCTION__, $disabled);
    }

    public function AppointmentOutForm($disabled = false)
    {
        return AppointmentOutForm::create($this, __FUNCTION__, $disabled);
    }

    public function AppointmentInForm($disabled = false)
    {
        return AppointmentInForm::create($this, __FUNCTION__, $disabled);
    }

    public function getLoggedInEmployee()
    {
        return $this->getRequest()->getSession()->get('Employee');
    }

    public function handleemail($success, $submission, $subject, $formSettings, $attachments = [])
    {
        if (!$success) {
            return false;
        }

        // Send admin email
        $adminRecipients = $formSettings->EmailRecipients()->column('Email');

        if (count($adminRecipients)) {
            $to = $adminRecipients;

            Mailer::sendNewSubmissionToAdmin($submission, $to, $subject, null, $attachments);
        }

        // Send autoresponder to user
        if ($formSettings->AutoresponderEnabled) {
            $subject = $formSettings->AutoresponderSubject;
            $body = $formSettings->AutoresponderContent;

            Mailer::sendAutoresponderToUser($submission->Email, $subject, $body);
        }
    }

    public function handleresponse($success, $formSettings = null)
    {
        if (Director::is_ajax($this->getRequest())) {
            if (!SecurityToken::inst()->checkRequest($this->getRequest())) {
                return $this->httpError(400);
            }

            if ($success) {
                $message = $formSettings->SubmitSuccessMessage;
            } else {
                $message = 'Sorry, there was a problem with your submission';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handlelogin($success, $employee = null, $showMessage = false)
    {
        if (Director::is_ajax($this->getRequest())) {
            if (!SecurityToken::inst()->checkRequest($this->getRequest())) {
                return $this->httpError(400);
            }

            $settings = MessageSettings::current_settings();

            $firstName = $employee->FirstName;
            $lastName = $employee->LastName;
            $fullName = $employee->FullName;

            if ($success) {
                $message = $settings->SignInMessage;
                $message = preg_replace('/\[FirstName\]/', $firstName, $message);
                $message = preg_replace('/\[LastName\]/', $lastName, $message);
                $message = preg_replace('/\[FullName\]/', $fullName, $message);
            } else {
                $message = 'Incorrect PIN';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            if ($showMessage) {
                $response = [
                    'success' => $success,
                    'message' => $message,
                ];
            } else {
                $response = [
                    'success' => $success,
                    'message' => null,
                ];
            }

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handlelogout($success)
    {
        if (Director::is_ajax($this->getRequest())) {
            if ($success) {
                $message = 'Logged Out';
            } else {
                $message = 'Sorry, there was a problem with your submission';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message,
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handlesignout($success, $employee)
    {
        if (Director::is_ajax($this->getRequest())) {
            if (!SecurityToken::inst()->checkRequest($this->getRequest())) {
                return $this->httpError(400);
            }

            $settings = MessageSettings::current_settings();

            $firstName = $employee->FirstName;
            $lastName = $employee->LastName;
            $fullName = $employee->FullName;

            if ($success) {
                $message = $settings->SignOutMessage;
                $message = preg_replace('/\[FirstName\]/', $firstName, $message);
                $message = preg_replace('/\[LastName\]/', $lastName, $message);
                $message = preg_replace('/\[FullName\]/', $fullName, $message);
            } else {
                $message = 'Oops. Something went wrong.';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message,
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handlelunchout($success, $employee)
    {
        if (Director::is_ajax($this->getRequest())) {
            $settings = MessageSettings::current_settings();

            $firstName = $employee->FirstName;
            $lastName = $employee->LastName;
            $fullName = $employee->FullName;

            if ($success) {
                $message = $settings->LunchOut;
                $message = preg_replace('/\[FirstName\]/', $firstName, $message);
                $message = preg_replace('/\[LastName\]/', $lastName, $message);
                $message = preg_replace('/\[FullName\]/', $fullName, $message);
            } else {
                $message = 'Sorry, there was a problem with this action';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message,
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handlelunchin($success, $employee)
    {
        if (Director::is_ajax($this->getRequest())) {
            $settings = MessageSettings::current_settings();

            $firstName = $employee->FirstName;
            $lastName = $employee->LastName;
            $fullName = $employee->FullName;

            if ($success) {
                $message = $settings->LunchIn;
                $message = preg_replace('/\[FirstName\]/', $firstName, $message);
                $message = preg_replace('/\[LastName\]/', $lastName, $message);
                $message = preg_replace('/\[FullName\]/', $fullName, $message);
            } else {
                $message = 'Sorry, there was a problem with this action';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message,
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handleappointmentout($success, $employee)
    {
        if (Director::is_ajax($this->getRequest())) {
            $settings = MessageSettings::current_settings();

            $firstName = $employee->FirstName;
            $lastName = $employee->LastName;
            $fullName = $employee->FullName;

            if ($success) {
                $message = $settings->AppointmentOut;
                $message = preg_replace('/\[FirstName\]/', $firstName, $message);
                $message = preg_replace('/\[LastName\]/', $lastName, $message);
                $message = preg_replace('/\[FullName\]/', $fullName, $message);
            } else {
                $message = 'Sorry, there was a problem with this action';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message,
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handleappointmentin($success, $employee)
    {
        if (Director::is_ajax($this->getRequest())) {
            $settings = MessageSettings::current_settings();

            $firstName = $employee->FirstName;
            $lastName = $employee->LastName;
            $fullName = $employee->FullName;

            if ($success) {
                $message = $settings->AppointmentIn;
                $message = preg_replace('/\[FirstName\]/', $firstName, $message);
                $message = preg_replace('/\[LastName\]/', $lastName, $message);
                $message = preg_replace('/\[FullName\]/', $fullName, $message);
            } else {
                $message = 'Sorry, there was a problem with this action';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message,
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function handleerrorresponse($message, $fieldErrors = [])
    {
        if (Director::is_ajax($this->getRequest())) {
            if (!SecurityToken::inst()->checkRequest($this->getRequest())) {
                return $this->httpError(400);
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => false,
                'message' => $message,
                'field_errors' => $fieldErrors
            ];

            return Convert::array2json($response);
        }

        return $this->redirectBack();
    }

    public function getSession()
    {
        $session = $this->getRequest()->getSession();
        return $session;
    }
}
