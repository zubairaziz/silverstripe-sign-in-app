<?php

namespace App\Model;

use App\Extension\Sluggable;
use App\Form\Field\PINField;
use App\Page\DashboardPage;
use App\Security\APIPermissionProvider;
use App\Util\Util;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class Employee extends DataObject
{
    use APIPermissionProvider;

    private static $api_access = true;

    private static $table_name = 'Employee';

    private static $extensions = [
        Sluggable::class
    ];

    private static $db = [
        'FirstName' => 'Varchar',
        'LastName' => 'Varchar',
        'Email' => 'Varchar',
        'Phone' => 'Varchar',
        'Birthday' => 'Date',
        'BirthdayMonth' => 'Int',
        'BirthdayDate' => 'Int',
        'Anniversary' => 'Date',
        'AnniversaryMonth' => 'Int',
        'AnniversaryDate' => 'Int',
        'PIN' => 'Int',
        'ActiveEmployee' => 'Boolean'
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $has_many = [
        'Timesheets' => Timesheet::class,
        'LateSignIns' => LateSignIn::class
    ];

    private static $default_sort = '"ActiveEmployee", "LastName", "FirstName"';

    private static $indexes = [
        'Email' => true,
        'PIN' => true
    ];

    private static $searchable_fields = [
        'FirstName',
        'LastName',
        'Email',
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
        'FullName' => 'Name',
        'ActiveEmployee.Nice' => 'Active Employee',
        'CurrentStatus' => 'Status'
    ];

    public function populateDefaults()
    {
        $newPin = $this->generateAvailablePIN();
        $this->PIN = $newPin;
        $this->Anniversary = date('Y-m-d');
        $this->ActiveEmployee = true;
        parent::populateDefaults();
    }

    public function getTitle()
    {
        return $this->getFullName();
    }

    public function getFullName()
    {
        return "{$this->FirstName} {$this->LastName}";
    }

    public function getWeeklySnapshotData($fromDate = null, $toDate = null)
    {
        if (is_null($fromDate) && is_null($toDate)) {
            $monday = strtotime("last monday");
            $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
            $sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
            $fromDate = date("Y-m-d", $monday);
            $toDate = date("Y-m-d", $sunday);
        }

        $filters = [
            'Date:LessThanOrEqual' => $toDate,
            'Date:GreaterThanOrEqual' => $fromDate,
        ];
        $records = $this->Timesheets()->filter($filters)->sort('Date', 'ASC');
        return $records;
    }

    public static function getEmployeeByPin($pin)
    {
        $employee = null;
        if (self::get()->filter('PIN', $pin)->first()) {
            $employee = self::get()->filter('PIN', $pin)->first();
        }
        return $employee;
    }

    public function generateAvailablePIN()
    {
        $pin = $this->generatePIN();
        if ($this->checkPinAvailability($pin)) {
            return $pin;
        } else {
            $this->generateAvailablePIN();
        }
    }

    public function getTodaysTimesheet()
    {
        if ($timesheet = $this->Timesheets()->filter(['Date' => Util::getTodaysDate()])->first()) {
            return $timesheet;
        }
        return false;
    }

    public function generateTimesheet()
    {
        if (!$this->Timesheets()->filter(['Date' => Util::getTodaysDate()])->count()) {
            $timesheet = Timesheet::create();
            $timesheet->EmployeeID = $this->ID;
            $timesheet->write();
            $this->Timesheets()->add($timesheet);
        }
        return;
    }

    public function hasSignedIn()
    {
        $this->generateTimesheet();
        $today = $this->getTodaysTimesheet();
        return $today->SignInTime;
    }

    public function hasSignedOut()
    {
        $this->generateTimesheet();
        $today = $this->getTodaysTimesheet();
        return $today->SignOutTime;
    }

    public function IsLunch()
    {
        $this->generateTimesheet();
        $today = $this->getTodaysTimesheet();
        return $today->LunchOutTime && !$today->LunchInTime;
    }

    public function IsAppointment()
    {
        $this->generateTimesheet();
        $today = $this->getTodaysTimesheet();
        return $today->AppointmentOutTime && !$today->AppointmentInTime;
    }

    public function AppointmentOrLunch()
    {
        $this->generateTimesheet();
        $today = $this->getTodaysTimesheet();
        return
            ($today->AppointmentOutTime && !$today->AppointmentInTime) ||
            ($today->LunchOutTime && !$today->LunchInTime);
    }

    public function generatePIN()
    {
        $pin = null;
        $digits = 4;
        $pin = rand(pow(10, $digits-1), pow(10, $digits)-1);
        return $pin;
    }

    public function getCurrentStatus()
    {
        $this->generateTimesheet();
        $today = $this->getTodaysTimesheet();
        $status = 'Not Signed In';
        if ($this->OOTO) {
            $status = 'Out of the Office';
            if ($this->OOTOReason) {
                $status = $this->OOTOReason;
            }
        }
        if ($today->SignInTime) {
            $status = 'Signed In';
        }
        if ($today->LunchOutTime && !$today->LunchInTime) {
            $status = 'Out to Lunch';
        }
        if ($today->AppointmentOutTime && !$today->AppointmentInTime) {
            $status = 'Out to Appointment';
        }
        if ($today->SignOutTime) {
            $status = 'Signed Out';
        }
        return $status;
    }

    public function getCurrentStatusColor()
    {
        $this->generateTimesheet();
        $today = $this->getTodaysTimesheet();
        $color = 'red';
        if ($this->OOTO) {
            $color = 'red';
            if ($this->OOTOReason) {
                $color = $this->OOTOReason;
            }
        }
        if ($today->SignInTime && !$today->SignOutTime) {
            $color = 'green';
        }
        if ($today->LunchOutTime && !$today->LunchInTime) {
            $color = 'red';
        }
        if ($today->AppointmentOutTime && !$today->AppointmentInTime) {
            $color = 'red';
        }
        if ($today->SignOutTime) {
            $status = 'red';
        }
        return $color;
    }

    public function getBirthdayMonth()
    {
    }

    public function checkPinAvailability($pin)
    {
        if (self::get()->exclude('ID', $this->ID)->filter('PIN', $pin)->first()) {
            return false;
        }
        return true;
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            FieldGroup::create(
                'Active',
                CheckboxField::create(
                    'ActiveEmployee',
                    'Active Employee?'
                )
            ),
            UploadField::create('Image', 'Headshot')->setAllowedFileCategories('image')->setFolderName('Headshots'),
            TextField::create('FirstName', 'First Name'),
            TextField::create('LastName', 'Last Name'),
            EmailField::create('Email'),
            TextField::create('Phone'),
            DateField::create('Birthday'),
            DateField::create('Anniversary', 'Work Anniversary Date'),
            PINField::create('PIN')
        );

        return $fields;
    }

    public function getCMSValidator()
    {
        return RequiredFields::create([
            'FirstName',
            'LastName',
            'PIN'
        ]);
    }

    public function getEmailFields()
    {
        $fields = [
            'Name' => $this->getTitle(),
            'Sign-In Time' => $this->getTodaysTimesheet()->dbObject('SignInTime')->Format('h:m a'),
            'Date' => $this->getTodaysTimesheet()->dbObject('Date')->Nice(),
        ];

        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        if (!($this->checkPinAvailability($this->PIN))) {
            $result->addFieldError('PIN', 'PIN is already in use. PIN must be unique for each employee');
        }

        return $result;
    }

    public function AbsoluteLink()
    {
        return Director::absoluteURL($this->Link());
    }

    public function Link($action = null)
    {
        if ($holderPage = DashboardPage::get()->first()) {
            return Controller::join_links(
                $holderPage->Link(),
                'employee',
                $this->URLSegment,
                $action
            );
        }
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $birthday = $this->Birthday;
        $bDate = date_parse_from_format("Y-m-d", $birthday);
        $anniversary = $this->Anniversary;
        $aDate = date_parse_from_format("Y-m-d", $anniversary);

        $this->Email = trim($this->Email);
        $this->BirthdayMonth = $bDate["month"];
        $this->BirthdayDate = $bDate["day"];
        $this->AnniversaryMonth = $aDate["month"];
        $this->AnniversaryDate = $aDate["day"];
    }

    public function onAfterWrite()
    {
        $birthday = $this->Birthday;
        $bDate = date_parse_from_format("Y-m-d", $birthday);
        $anniversary = $this->Anniversary;
        $aDate = date_parse_from_format("Y-m-d", $anniversary);

        $this->BirthdayMonth = $bDate["month"];
        $this->BirthdayDate = $bDate["day"];
        $this->AnniversaryMonth = $aDate["month"];
        $this->AnniversaryDate = $aDate["day"];

        parent::onAfterWrite();
    }
}
