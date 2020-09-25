<?php

namespace App\Model;

use App\Extension\AppSettings;
use App\Security\CMSPermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;

class MessageSettings extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'MessageSettings';
    private static $hide_from_form_admin = true;

    private static $extensions = [
        AppSettings::class
    ];

    private static $db = [
        'WelcomeMessage' => 'Text',
        'SignInMessage' => 'Text',
        'SignOutMessage' => 'Text',
        'LunchOut' => 'Text',
        'LunchIn' => 'Text',
        'AppointmentOut' => 'Text',
        'AppointmentIn' => 'Text',
        'BirthdayMessage' => 'Text',
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TabSet::create('Root')
        );

        $fields->addFieldsToTab('Root.Messages.Welcome', [
            TextareaField::create(
                'WelcomeMessage',
                'Welcome Message'
            ),
        ]);

        $fields->addFieldsToTab('Root.Messages.Sign In', [
            TextareaField::create(
                'SignInMessage',
                'Sign In Message'
            ),
            TextareaField::create(
                'SignOutMessage',
                'Sign Out Message'
            )
        ]);

        $fields->addFieldsToTab('Root.Messages.Lunch', [
            TextareaField::create(
                'LunchOut',
                'Out to Lunch Message'
            ),
            TextareaField::create(
                'LunchIn',
                'Back from Lunch Message'
            ),
        ]);

        $fields->addFieldsToTab('Root.Messages.Appointment', [
            TextareaField::create(
                'AppointmentOut',
                'Out to Appointment Message'
            ),
            TextareaField::create(
                'AppointmentIn',
                'Back from Appointment Message'
            ),
        ]);

        $fields->addFieldsToTab('Root.Messages.Birthday', [
            TextareaField::create(
                'BirthdayMessage',
                'Birthday Message'
            ),
        ]);


        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public static function current_settings()
    {
        $settings = DataObject::get_one(self::class);

        if ($settings) {
            return $settings;
        }

        return self::make_settings();
    }

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        $settings = DataObject::get_one(self::class);

        if (!$settings) {
            self::make_settings();
        }
    }

    public static function make_settings()
    {
        $settings = self::create();
        $settings->write();

        return $settings;
    }
}
