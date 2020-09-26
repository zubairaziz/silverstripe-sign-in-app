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
        'getSession',
        'handleemail',
        'handlelogin',
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

    public function SignOutForm()
    {
        return SignOutForm::create($this, __FUNCTION__);
    }

    public function handleemail($success, $submission, $subject, $formSettings, $attachments = [])
    {
        if (!$success) {
            return false;
        }

        // Send admin email
        $adminRecipients = $formSettings->EmailRecipients()->column('Email');

        // Allow additional recipients
        if ($formSettings->AdditionalRecipients && $formSettings->AdditionalRecipients->count()) {
            $adminRecipients = array_merge($adminRecipients, $formSettings->AdditionalRecipients->column('Email'));
            $adminRecipients = array_unique($adminRecipients);
        }

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

    public function handlelogin($success, $employeeID)
    {
        if (Director::is_ajax($this->getRequest())) {
            if (!SecurityToken::inst()->checkRequest($this->getRequest())) {
                return $this->httpError(400);
            }

            $settings = MessageSettings::current_settings();

            if ($success) {
                $message = $settings->WelcomeMessage;
            } else {
                $message = 'Sorry, there was a problem with your submission';
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

    public function handlelogout()
    {
        if (Director::is_ajax($this->getRequest())) {
            if (!SecurityToken::inst()->checkRequest($this->getRequest())) {
                return $this->httpError(400);
            }

            if ($success) {
                $message = 'Logged In';
            } else {
                $message = 'Sorry, there was a problem with your submission';
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
