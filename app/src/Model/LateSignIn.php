<?php

namespace App\Model;

use App\Security\APIPermissionProvider;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class LateSignIn extends DataObject
{
    use APIPermissionProvider;

    protected $instanceDate;
    private static $api_access = true;

    private static $table_name = 'LateSignIn';
    private static $default_sort = 'Date DESC';

    private static $db = [
        'Date' => 'Date',
    ];

    private static $has_one = [
        'Owner' => Employee::class,
    ];

    private static $summary_fields = [
        'Title' => 'Title',
    ];

    public function searchableFields()
    {
        return [
            'Title' => [
                'filter' => 'PartialMatchFilter',
                'title' => 'Name',
                'field' => TextField::class,
            ]
        ];
    }

    public function populateDefaults()
    {
        $this->Date = date('Y-m-d 00:00:00');

        parent::populateDefaults();
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TabSet::create('Root')
        );

        $fields->addFieldsToTab('Root.Main', [
            ReadonlyField::create('Date'),
            ReadonlyField::create('Employee', 'Employee', 'Owner.Title')
        ]);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function getTitle()
    {
        return "{$this->Owner()->Title} - {$this->dbObject('Date')->Nice()}";
    }
}
