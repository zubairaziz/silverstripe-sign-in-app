<?php

namespace App\Model;

use App\Security\CMSPermissionProvider;
use Cake\Chronos\Chronos;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use When\When;

class Holiday extends DataObject
{
    use CMSPermissionProvider;

    protected $instanceDate;

    private static $table_name = 'Holiday';
    private static $default_sort = 'Start DESC';

    private static $db = [
        'Title' => 'Varchar',
        'Start' => 'Datetime',
        'End' => 'Datetime',
    ];

    private static $has_one = [
        'Owner' => DataObject::class,
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Start.Nice' => 'Start',
        'End.Nice' => 'End',
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
        $this->Start = date('Y-m-d 00:00:00');
        $this->End = date('Y-m-d 00:00:00');

        parent::populateDefaults();
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TabSet::create('Root')
        );

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title'),
            FieldGroup::create(
                'Date',
                DatetimeField::create('Start')->addExtraClass('date-range--start'),
                DatetimeField::create('End')->addExtraClass('date-range--end')
            )->addExtraClass('is-date-range'),
        ]);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function getCMSValidator()
    {
        return RequiredFields::create([
            'Title',
            'Start',
            'End',
        ]);
    }

    public function getNiceTimeRange()
    {
        if ($this->IsAllDay) {
            return 'All Day';
        }

        if ($this->Start == $this->End) {
            return strtolower("{$this->obj('Start')->format('h:mma')}");
        }

        return strtolower("{$this->obj('Start')->format('h:mma')} - {$this->obj('End')->format('h:mma')}");
    }

    public function getIsMultipleDays()
    {
        return $this->obj('Start')->format('YYYY-MM-dd') != $this->obj('End')->format('YYYY-MM-dd');
    }

    public function getIsMultipleMonths()
    {
        return $this->obj('Start')->format('YYYY-MM') != $this->obj('End')->format('YYYY-MM');
    }

    public function getDisplayStart()
    {
        if ($this->instanceDate) {
            return DBField::create_field('Datetime', $this->instanceDate->format('Y-m-d'));
        }

        return $this->obj('Start');
    }

    public function getDisplayEnd()
    {
        if ($this->instanceDate) {
            return DBField::create_field('Datetime', $this->instanceDate->format('Y-m-d'));
        }

        return $this->obj('End');
    }

    public static function getActiveHolidays()
    {
        $upcomingHolidays = self::get()
            ->exclude('IsRecurring', true)
            ->filter('End:GreaterThanOrEqual', date('Y-m-d 00:00:00'));

        $upcoming = ArrayList::create();

        $upcoming->merge($upcomingHolidays);

        $upcomingHolidaysRecurring = self::get()->filter('IsRecurring', true);

        foreach ($upcomingHolidaysRecurring as $holiday) {
            $recurringHolidays = $holiday->getRecurringHolidays();

            $upcoming->merge($holiday->getRecurringHolidays());
        }

        return $upcoming->sort('Start ASC');
    }

    public function getFeaturedImage()
    {
        if ($this->Images()->count()) {
            return $this->Images()->first()->Image();
        }
    }

    public function getSummary()
    {
        if ($this->LeadIn) {
            return $this->dbObject('LeadIn');
        }

        return $this->dbObject('Content')->LimitCharactersToClosestWord(250);
    }

    public function getNiceRecurring()
    {
        return $this->RRule ? 'Yes' : 'No';
    }

    public function getRecurringEvents()
    {
        $start = new \DateTime();
        $end = (new \DateTime())->modify('+6 months');

        $occurrences = ArrayList::create();

        $pattern = '/(UNTIL=\d+)/i';
        $replacement = '${1}T235959Z';
        $rrule = preg_replace($pattern, $replacement, $this->RRule);

        $when = (new When)->startDate(new \DateTime($this->Start))->rrule($rrule);

        $dayBeforeStart = clone $start;
        $dayAfterEnd = clone $end;
        $dayBeforeStart = $dayBeforeStart->modify('-1 day')->setTime(23, 59, 59);
        $dayAfterEnd = $dayAfterEnd->modify('+1 day')->setTime(0, 0, 0);

        $dates = $when->getOccurrencesBetween($dayBeforeStart, $dayAfterEnd);

        $endDate = new Chronos($this->End);

        foreach ($dates as $date) {
            $clone = clone $this;
            $clone->Start = $date->format('Y-m-d H:i:s');
            $clone->End = $date->setTime($endDate->hour, $endDate->minute, 0)->format('Y-m-d H:i:s');
            $clone->setInstanceDate($date);
            $occurrences->push($clone);
        }

        return $occurrences;
    }

    public function setInstanceDate(\DateTime $date)
    {
        $this->instanceDate = $date;
    }

    public function getStructuredData()
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'location' => [
                '@type' => 'Place',
                'address' => $this->Location
            ],
            'name' => $this->MetaTitle ?: $this->Title,
            'startDate' => date('c', strtotime($this->Start)),
            'endDate' => date('c', strtotime($this->End))
        ];

        if ($this->LeadIn) {
            $data['description'] = $this->MetaDescription ?: $this->obj('LeadIn')->Plain();
        } else {
            $data['description'] = $this->MetaDescription ?: $this->obj('Content')->Plain();
        }

        return json_encode($data);
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if ($this->IsAllDay) {
            $this->End = $this->obj('End')->format('YYYY-MM-dd') . ' 00:00:00';
        }
    }

    public function IsExpired()
    {
        if ($this->End < date('Y-m-d')) {
            return true;
        }
        return false;
    }

    // Search
    public function getShowInSearch()
    {
        return true;
    }

    public function getAbstract()
    {
        return $this->getSummary();
    }
}
