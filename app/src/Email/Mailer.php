<?php

namespace App\Email;

use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\ArrayData;

class Mailer
{
    public static function sendAutoresponderToUser($to, $subject, $body)
    {
        $subject = $subject ?: 'Thank you for your submission';
        $email = StyledEmail::create($to, $subject);

        $body = ArrayData::create([
            'Subject' => $subject,
            'Body' => $body
        ])->renderWith('App/Email/GenericEmail');

        $email->build($body);

        return $email->send();
    }

    public static function sendNewSubmissionToAdmin(
        $submission,
        $to,
        $subject,
        $template = null,
        $attachments = []
    ) {
        if (is_null($template)) {
            $template = 'App/Email/AdminNewSubmission';
        }

        $email = StyledEmail::create($to, $subject);

        if (filter_var($submission->Email, FILTER_VALIDATE_EMAIL)) {
            $email->setReplyTo($submission->Email);
        }

        if (!empty($attachments)) {
            foreach ($attachments as $file) {
                if ((int) $file->ID === 0) {
                    continue;
                }

                $email->addAttachmentFromData(
                    $file->getString(),
                    $file->getFilename(),
                    $file->getMimeType()
                );
            }
        }

        $fieldData = ArrayList::create();
        $fields = $submission->getEmailFields();

        foreach ($fields as $key => $value) {
            if ($value) {
                $fieldData->push(ArrayData::create([
                    'DisplayName' => $key,
                    'Value' => $value
                ]));
            }
        }

        $body = ArrayData::create([
            'Subject' => $subject,
            'Fields' => $fieldData,
            'Submission' => $submission
        ])->renderWith($template);

        $email->build($body);

        return $email->send();
    }

    public static function sendSubscriptionNotification($notification, $to, $subject, $body, $footer)
    {
        $email = StyledEmail::create($to, $subject);

        $email->build($body, $footer);

        return $email->send();
    }

    /**
     * Donation Mailers
     */
    public static function sendNewDonationToAdmin(
        $donation,
        $to,
        $subject,
        $template = 'App/Donation/Email/AdminNewDonation'
    ) {
        $email = StyledEmail::create($to, $subject);

        if (filter_var($donation->Email, FILTER_VALIDATE_EMAIL)) {
            $email->setReplyTo($donation->Email);
        }

        $fieldData = ArrayList::create();
        $fields = $donation->getEmailFields();

        foreach ($fields as $key => $value) {
            if ($value) {
                $fieldData->push(ArrayData::create([
                    'DisplayName' => $key,
                    'Value' => $value
                ]));
            }
        }

        $body = ArrayData::create([
            'Subject' => $subject,
            'Fields' => $fieldData,
            'Donation' => $donation
        ])->renderWith($template);

        $email->build($body);

        return $email->send();
    }

    public static function sendDonationAutoresponderToUser($donation, $subject, $body)
    {
        $to = $donation->Email;
        $subject = $subject ?: 'Thank you for your donation';
        $email = StyledEmail::create($to, $subject);

        $body = ArrayData::create([
            'Subject' => $subject,
            'Body' => $body,
            'Donation' => $donation
        ])->renderWith('App/Donation/Email/UserNewDonation');

        $email->build($body);

        return $email->send();
    }

    public static function sendNewApplicationToAdmin(
        $application,
        $to,
        $subject,
        $template = 'App/Email/AdminNewScholarshipApplication'
    ) {
        $email = StyledEmail::create($to, $subject);

        if (filter_var($application->Email, FILTER_VALIDATE_EMAIL)) {
            $email->setReplyTo($application->Email);
        }

        $fieldData = ArrayList::create();
        $fields = $application->getEmailFields();

        foreach ($fields as $key => $value) {
            if ($value) {
                $fieldData->push(ArrayData::create([
                    'DisplayName' => $key,
                    'Value' => $value
                ]));
            }
        }

        $body = ArrayData::create([
            'Subject' => $subject,
            'Fields' => $fieldData,
            'Application' => $application
        ])->renderWith($template);

        $email->build($body);

        return $email->send();
    }
}
