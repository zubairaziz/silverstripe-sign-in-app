<?php

namespace App\Extension;

use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SiteConfig extends DataExtension
{
    private static $db = [
        'ContactAddress' => 'Varchar',
        'ContactCity' => 'Varchar',
        'ContactState' => 'Varchar',
        'ContactZip' => 'Varchar',
        'ContactPhoneNumber' => 'Varchar',
        'ContactEmail' => 'Varchar',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('Tagline');

        $fields->addFieldsToTab('Root.Contact Info', [
            TextField::create('ContactAddress', 'Address'),
            TextField::create('ContactCity', 'City'),
            TextField::create('ContactState', 'State'),
            TextField::create('ContactZip', 'Zip'),
            TextField::create('ContactPhoneNumber', 'Phone Number'),
            EmailField::create('ContactEmail', 'Email Address')
        ]);
    }

    public function getSiteStructuredData()
    {
        $data = [
            '@context' => 'http://schema.org',
            '@type' => 'Organization',
            'identifier' => 'https://www.signinapp.com/',
            'name' => $this->owner->Title,
            'url' => 'https://www.signinapp.com/',
            'email' => $this->owner->ContactEmail,
            'telephone' => $this->owner->ContactPhoneNumber,
            'logo' => $this->owner->SocialSharePhoto()->AbsoluteURL,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->owner->ContactAddress,
                'addressLocality' => $this->owner->ContactCity,
                'addressRegion' => $this->owner->ContactState,
                'postalCode' => $this->owner->ContactZip
            ],
            'sameAs' => array_filter($socialMedia)
        ];

        return $data;
    }

    public function canView($member = null, $context = [])
    {
        return true;
    }
}
