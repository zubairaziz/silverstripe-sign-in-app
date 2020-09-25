<?php

namespace App\Model;

use App\Extension\AppSettings;
use App\Security\CMSPermissionProvider;
use App\Util\Util;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TimeField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class CalendarSettings extends DataObject
{
    use CMSPermissionProvider;

    private static $table_name = 'CalendarSettings';
    private static $hide_from_form_admin = true;

    private static $extensions = [
        AppSettings::class
    ];

    private static $db = [
        'MondayActive' => 'Boolean',
        'MondayStart' => 'Time',
        'MondayEnd' => 'Time',
        'TuesdayActive' => 'Boolean',
        'TuesdayStart' => 'Time',
        'TuesdayEnd' => 'Time',
        'WednesdayActive' => 'Boolean',
        'WednesdayStart' => 'Time',
        'WednesdayEnd' => 'Time',
        'ThursdayActive' => 'Boolean',
        'ThursdayStart' => 'Time',
        'ThursdayEnd' => 'Time',
        'FridayActive' => 'Boolean',
        'FridayStart' => 'Time',
        'FridayEnd' => 'Time',
        'SaturdayActive' => 'Boolean',
        'SaturdayStart' => 'Time',
        'SaturdayEnd' => 'Time',
        'SundayActive' => 'Boolean',
        'SundayStart' => 'Time',
        'SundayEnd' => 'Time',
    ];

    private static $has_many = [
        'Events' => Event::class,
        'Holidays' => Holiday::class,
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TabSet::create('Root')
        );

        $fields->addFieldsToTab('Root.BusinessHours', [
            FieldGroup::create(
                'Monday',
                CheckboxField::create(
                    'MondayActive',
                    'Open on Mondays'
                )
            ),
            Wrapper::create(
                FieldGroup::create(
                    'Monday Hours',
                    TimeField::create('MondayStart', 'Start'),
                    TimeField::create('MondayEnd', 'End')
                )
            )->displayIf('MondayActive')->isChecked()->end(),
            FieldGroup::create(
                'Tuesday',
                CheckboxField::create(
                    'TuesdayActive',
                    'Open on Tuesdays'
                )
            ),
            Wrapper::create(
                FieldGroup::create(
                    'Tuesday Hours',
                    TimeField::create('TuesdayStart', 'Start'),
                    TimeField::create('TuesdayEnd', 'End')
                )
            )->displayIf('TuesdayActive')->isChecked()->end(),
            FieldGroup::create(
                'Wednesday',
                CheckboxField::create(
                    'WednesdayActive',
                    'Open on Wednesdays'
                )
            ),
            Wrapper::create(
                FieldGroup::create(
                    'Wednesday Hours',
                    TimeField::create('WednesdayStart', 'Start'),
                    TimeField::create('WednesdayEnd', 'End')
                )
            )->displayIf('WednesdayActive')->isChecked()->end(),
            FieldGroup::create(
                'Thursday',
                CheckboxField::create(
                    'ThursdayActive',
                    'Open on Thursdays'
                )
            ),
            Wrapper::create(
                FieldGroup::create(
                    'Thursday Hours',
                    TimeField::create('ThursdayStart', 'Start'),
                    TimeField::create('ThursdayEnd', 'End')
                )
            )->displayIf('ThursdayActive')->isChecked()->end(),
            FieldGroup::create(
                'Friday',
                CheckboxField::create(
                    'FridayActive',
                    'Open on Fridays'
                )
            ),
            Wrapper::create(
                FieldGroup::create(
                    'Friday Hours',
                    TimeField::create('FridayStart', 'Start'),
                    TimeField::create('FridayEnd', 'End')
                )
            )->displayIf('FridayActive')->isChecked()->end(),
            FieldGroup::create(
                'Saturday',
                CheckboxField::create(
                    'SaturdayActive',
                    'Open on Saturdays'
                )
            ),
            Wrapper::create(
                FieldGroup::create(
                    'Saturday Hours',
                    TimeField::create('SaturdayStart', 'Start'),
                    TimeField::create('SaturdayEnd', 'End')
                )
            )->displayIf('SaturdayActive')->isChecked()->end(),
            FieldGroup::create(
                'Sunday',
                CheckboxField::create(
                    'SundayActive',
                    'Open on Sundays'
                )
            ),
            Wrapper::create(
                FieldGroup::create(
                    'Sunday Hours',
                    TimeField::create('SundayStart', 'Start'),
                    TimeField::create('SundayEnd', 'End')
                )
            )->displayIf('SundayActive')->isChecked()->end(),
        ]);

        $fields->addFieldsToTab('Root.Events', [
            GridField::create(
                'Events',
                'Events',
                $this->Events(),
                Util::getRecordEditorConfig(false)
            )
        ]);

        $fields->addFieldsToTab('Root.Holidays', [
            GridField::create(
                'Holidays',
                'Holidays',
                $this->Holidays(),
                Util::getRecordEditorConfig(false)
            )
        ]);

        $birthdays = new ArrayList();
        $employees = Employee::get()->filter(['ActiveEmployee' => true]);
        foreach ($employees as $employee) {
            $birthdays->add(
                new ArrayData([
                    'Name' => $employee->getTitle(),
                    'Birthday' => $employee->Birthday,
                    'NiceBirthday' => sprintf(
                        '%s %s',
                        $employee->dbObject('Birthday')->Month(),
                        $employee->dbObject('Birthday')->DayOfMonth()
                    ),
                    'Day' => $employee->dbObject('Birthday')->DayOfMonth(),
                    'Month' => $employee->dbObject('Birthday')->Month()
                ])
            );
        }

        $birthdays = $birthdays->sort('Month');

        $birthdayGrid = GridField::create(
            'Birthdays',
            'Birthdays',
            $birthdays,
        );

        $config = $birthdayGrid->getConfig();
        $dataColumns = $config->getComponentByType(GridFieldDataColumns::class);

        $dataColumns->setDisplayFields([
            'Name' => 'Name',
            'Birthday' => 'Birthday',
        ]);

        $fields->addFieldsToTab('Root.Birthdays', [
            $birthdayGrid
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
