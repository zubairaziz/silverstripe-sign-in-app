<?php

namespace App\Form\Field;

use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

class RRuleField extends TextField
{
    public function __construct($name, $title = null, $value = '', $form = null)
    {
        parent::__construct($name, $title, $value, $form);

        Requirements::css('/_resources/app/client/cms/rrule/RRuleField.css');
        Requirements::javascript('/_resources/app/client/cms/rrule/moment.min.js');
        Requirements::javascript('/_resources/app/client/cms/rrule/RRuleField.js');
    }
}
