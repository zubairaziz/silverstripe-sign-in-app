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

    public function SignOutForm($isNavigation = false)
    {
        return SignOutForm::create($this, __FUNCTION__, $isNavigation);
    }

    public function LunchOutForm()
    {
        return LunchOutForm::create($this, __FUNCTION__);
    }

    public function LunchInForm()
    {
        return LunchInForm::create($this, __FUNCTION__);
    }

    public function AppointmentOutForm()
    {
        return AppointmentOutForm::create($this, __FUNCTION__);
    }

    public function AppointmentInForm()
    {
        return AppointmentInForm::create($this, __FUNCTION__);
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

    public function handlelogin($success, $employeeID = null)
    {
        if (Director::is_ajax($this->getRequest())) {
            if (!SecurityToken::inst()->checkRequest($this->getRequest())) {
                return $this->httpError(400);
            }

            $settings = MessageSettings::current_settings();

            if ($success) {
                $message = $settings->WelcomeMessage;
            } else {
                $message = 'Incorrect PIN';
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json');

            $response = [
                'success' => $success,
                'message' => $message,
                'employee' => $employeeID
            ];

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

    public function handlelunchout($success)
    {
        return $this->redirectBack();
    }

    public function handlelunchin($success)
    {
        if (Director::is_ajax($this->getRequest())) {
            $settings = MessageSettings::current_settings();

            if ($success) {
                $message = $settings->LunchIn;
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

    public function handleappointmentout($success)
    {
        if (Director::is_ajax($this->getRequest())) {
            $settings = MessageSettings::current_settings();

            if ($success) {
                $message = $settings->AppointmentOut;
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

    public function handleappointmentin($success)
    {
        if (Director::is_ajax($this->getRequest())) {
            $settings = MessageSettings::current_settings();

            if ($success) {
                $message = $settings->AppointmentIn;
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
        // Debug::show($session);
        return $session;
    }
}
