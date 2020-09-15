<?php

namespace App\Extension;

use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\ORM\DataExtension;

class Sluggable extends DataExtension
{
    private static $db = [
        'URLSegment' => 'Varchar'
    ];

    private static $indexes = [
        'URLSegment' => true
    ];

    public function onBeforeWrite()
    {
        if (!$this->owner->URLSegment || ($this->owner->URLSegment && $this->owner->isChanged('Title'))) {
            $this->owner->URLSegment = URLSegmentFilter::create()->filter($this->owner->Title);

            $class = get_class($this->owner);
            $hasOne = $this->owner->hasOne();

            $filter = [
                'URLSegment' => $this->owner->URLSegment
            ];

            if (isset($hasOne['Parent'])) {
                $filter['ParentID'] = $this->owner->ParentID;
            }

            $count = 1;
            while ($class::get()->filter($filter)->exclude('ID', $this->owner->ID)->exists()) {
                $this->owner->URLSegment = $this->owner->URLSegment . '-' . $count++;
                $filter['URLSegment'] = $this->owner->URLSegment;
            }
        }
    }
}
