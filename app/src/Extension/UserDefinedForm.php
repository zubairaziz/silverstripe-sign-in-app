<?php

namespace App\Extension;

use App\Util\Util;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class UserDefinedForm extends DataExtension
{
    private static $db = [
        'AutoresponderEnabled' => 'Boolean',
        'AutoresponderSubject' => 'Varchar',
        'AutoresponderContent' => 'HTMLText',
        'EmailFrom' => 'Varchar'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Autoresponder', [
            Util::cmsInfoMessage('Sends an email to the user after submission.'),
            FieldGroup::create(
                'Enabled',
                CheckboxField::create('AutoresponderEnabled', 'Enable Autoresponder')
            ),
            EmailField::create('EmailFrom', 'Email From'),
            TextField::create('AutoresponderSubject', 'Email Subject'),
            HTMLEditorField::create('AutoresponderContent', 'Email Content')
        ]);
    }
}
