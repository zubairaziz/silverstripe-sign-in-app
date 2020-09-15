<?php

namespace App\Form;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\Filters\ExactMatchFilter;
use SilverStripe\ORM\Filters\PartialMatchFilter;
use SilverStripe\ORM\Search\SearchContext;

class ContactFormSubmission extends DataObject
{
    private static $default_sort = 'Created DESC';
    private static $table_name = 'ContactFormSubmission';

    private static $db = [
        'FirstName' => 'Varchar',
        'LastName' => 'Varchar',
        'Company' => 'Varchar',
        'JobTitle' => 'Varchar',
        'Phone' => 'Varchar',
        'Email' => 'Varchar',
    ];

    private static $has_one = [
        'SourcePage' => SiteTree::class
    ];

    private static $summary_fields = [
        'Created.Nice' => 'Submit Date',
        'Title' => 'Name',
        'Company' => 'Company',
        'Email' => 'Email',
        'Phone' => 'Phone',
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
            'Email' => $this->Email,
            'Phone' => $this->Phone,
            'Company' => $this->Company,
            'Title' => $this->JobTitle,
        ];

        return $fields;
    }

    public function getDefaultSearchContext()
    {
        $sources = array_filter(self::get()->columnUnique('SourcePageID'));
        $sources = array_unique($sources);

        $fields = $this->scaffoldSearchFields();
        $fields->removeByName('Created');
        $fields->removeByName('SourcePage__Title');

        if (!empty($sources)) {
            $fields->push(
                DropdownField::create('SourcePageID', 'Source')
                    ->setSource(SiteTree::get()->byIds($sources)->map('ID', 'Title'))
                    ->setEmptyString('Select a Source')
            );
        }

        $filters = [
            'FirstName' => new PartialMatchFilter('FirstName'),
            'LastName' => new PartialMatchFilter('LastName'),
            'Email' => new PartialMatchFilter('Email'),
            'Phone' => new PartialMatchFilter('Phone'),
            'SourcePageID' => new ExactMatchFilter('SourcePageID')
        ];

        return new SearchContext(
            self::class,
            $fields,
            $filters
        );
    }
}
