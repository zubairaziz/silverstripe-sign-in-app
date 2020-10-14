<?php

namespace App\Model;

use App\Security\CMSPermissionProvider;
use App\Util\Util;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\ORM\DataObject;

class Timesheet extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'Timesheet';

    private static $db = [
        'Date' => 'Date',
        'SignInTime' => 'Time',
        'SignOutTime' => 'Time',
        'LunchInTime' => 'Time',
        'LunchOutTime' => 'Time',
        'AppointmentInTime' => 'Time',
        'AppointmentOutTime' => 'Time',
        'OOTO' => 'Boolean',
        'OOTOReason' => 'Varchar',
        'TotalHours' => 'Int'
    ];

    private static $has_one = [
        'Employee' => Employee::class
    ];

    private static $default_sort = 'Date';

    private static $indexes = [
        'Date' => true,
    ];

    private static $searchable_fields = [
        'Date',
    ];

    private static $summary_fields = [
        'Date.Nice' => 'Date',
        'Employee.FullName' => 'Employee',
    ];

    public function getTitle()
    {
        return "{$this->dbObject('Date')->Nice()} - {$this->Employee()->getTitle()}";
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            ReadonlyField::create('Date.Nice', 'Date', $this->dbObject('Date')->Nice()),
            ReadonlyField::create('Name', 'Name', $this->Employee()->getTitle()),
            FieldGroup::create(
                'Sign In',
                ReadonlyField::create('SignInTime'),
                ReadonlyField::create('SignOutTime')
            ),
            FieldGroup::create(
                'Lunch',
                ReadonlyField::create('LunchOutTime'),
                ReadonlyField::create('LunchInTime')
            ),
            FieldGroup::create(
                'Appointment',
                ReadonlyField::create('AppointmentOutTime'),
                ReadonlyField::create('AppointmentInTime')
            ),
        );

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (!$this->Date) {
            $date = Util::getTodaysDate();
            $this->Date = $date;
        }
    }
}
