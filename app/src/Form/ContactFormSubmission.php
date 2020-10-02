<?php

namespace App\Form;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\Filters\PartialMatchFilter;
use SilverStripe\ORM\Search\SearchContext;

class ContactFormSubmission extends DataObject
{
    private static $default_sort = 'Created DESC';
    private static $table_name = 'ContactFormSubmission';

    private static $db = [
        'FirstName' => 'Varchar',
        'LastName' => 'Varchar'
    ];

    private static $summary_fields = [
        'Created.Nice' => 'Submit Date',
        'Title' => 'Name',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $sourcePageField = $fields->dataFieldByName('SourcePageID');
        $fields->replaceField('SourcePageID', $sourcePageField->performReadonlyTransformation());

        return $fields;
    }

    public function getTitle()
    {
        return sprintf('%s %s', $this->FirstName, $this->LastName);
    }

    public function getExportFields()
    {
        $fields = self::$summary_fields;

        return $fields;
    }

    public function getEmailFields()
    {
        $fields = [
            'Name' => $this->getTitle(),
        ];

        return $fields;
    }

    public function getDefaultSearchContext()
    {
        $fields = $this->scaffoldSearchFields();

        $filters = [
            'FirstName' => new PartialMatchFilter('FirstName'),
            'LastName' => new PartialMatchFilter('LastName'),
        ];

        return new SearchContext(
            self::class,
            $fields,
            $filters
        );
    }
}
