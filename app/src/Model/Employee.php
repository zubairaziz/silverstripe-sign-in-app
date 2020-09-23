<?php

namespace App\Model;

use App\Form\Field\PINField;
use App\Security\CMSPermissionProvider;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
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
    use CMSPermissionProvider;

    private static $table_name = 'Employee';

    private static $db = [
        'FirstName' => 'Varchar',
        'LastName' => 'Varchar',
        'Email' => 'Varchar',
        'Phone' => 'Varchar',
        'Birthday' => 'Date',
        'Anniversary' => 'Date',
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
        'Timesheets' => Timesheet::class
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
        // 'Email',
        // 'Phone',
        'ActiveEmployee.Nice' => 'Active Employee'
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
        return sprintf('%s %s', $this->FirstName, $this->LastName);
    }

    public function getEmployeeByPin($pin)
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

    public function generatePIN()
    {
        $pin = null;
        $digits = 4;
        $pin = rand(pow(10, $digits-1), pow(10, $digits)-1);
        return $pin;
    }

    public function checkPinAvailability($pin)
    {
        if (self::get()->filter('PIN', $pin)->first()) {
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

    public function validate()
    {
        $result = parent::validate();

        if (!($this->checkPinAvailability($this->PIN))) {
            $result->addFieldError('PIN', 'PIN is already in use. PIN must be unique for each employee');
        }

        return $result;
    }
}
