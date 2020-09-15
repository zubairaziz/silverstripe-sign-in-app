<?php

namespace App\Extension;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class SiteConfig extends DataExtension
{
    private static $db = [
        'ContactAddress' => 'Varchar',
        'ContactCity' => 'Varchar',
        'ContactState' => 'Varchar',
        'ContactZip' => 'Varchar',
        'ContactPhoneNumber' => 'Varchar',
        'ContactEmail' => 'Varchar',
        'FacebookURL' => 'Varchar',
        'InstagramURL' => 'Varchar',
        'TwitterURL' => 'Varchar',
        'LinkedInURL' => 'Varchar',
        'YouTubeURL' => 'Varchar',
        'CanonicalDomain' => 'Varchar(255)'
    ];

    private static $has_one = [
        'SocialSharePhoto' => Image::class,
        'SlideOutMenuButtonLink' => SiteTree::class
    ];

    private static $owns = [
        'SocialSharePhoto'
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

        $fields->addFieldsToTab('Root.Social Media', [
            TextField::create('FacebookURL'),
            TextField::create('InstagramURL'),
            TextField::create('TwitterURL'),
            TextField::create('LinkedInURL', 'LinkedIn URL'),
            TextField::create('YouTubeURL', 'YouTube URL'),
            UploadField::create('SocialSharePhoto')->setAllowedFileCategories('image')
        ]);

        $fields->addFieldsToTab(
            'Root.Canonical',
            LiteralField::create(
                'Info',
                '<p>The canonical domain will be added to the HTML head of your pages. It should be specified with the full protocol and with no trailing slash, eg.  https://www.example.com</p>'
            ),
            TextField::create('CanonicalDomain')
                ->setDescription('eg. https://www.example.com')
        );
    }

    public function getDirectionsLink()
    {
        $address = [
            $this->owner->ContactAddress,
            $this->owner->ContactCity,
            $this->owner->ContactState,
            $this->owner->ContactZip
        ];

        $link = sprintf('https://www.google.com/maps/place/%s', join('+', $address));

        return str_replace(' ', '+', $link);
    }

    public function getSocialMediaList()
    {
        $items = [
            [
                'Name' => 'Facebook',
                'Icon' => 'facebook',
                'URL' => $this->owner->FacebookURL
            ],
            [
                'Name' => 'Instagram',
                'Icon' => 'instagram',
                'URL' => $this->owner->InstagramURL
            ],
            [
                'Name' => 'Twitter',
                'Icon' => 'twitter',
                'URL' => $this->owner->TwitterURL
            ],
            [
                'Name' => 'LinkedIn',
                'Icon' => 'linkedin',
                'URL' => $this->owner->LinkedInURL
            ],
            [
                'Name' => 'YouTube',
                'Icon' => 'youtube',
                'URL' => $this->owner->YouTubeURL
            ]
        ];

        $list = ArrayList::create();

        foreach ($items as $item) {
            if ($item['URL']) {
                $list->push(ArrayData::create($item));
            }
        }

        return $list;
    }

    public function getSiteStructuredData()
    {
        $socialMedia = [
            $this->owner->FacebookURL,
            $this->owner->InstagramURL,
            $this->owner->TwitterURL,
            $this->owner->LinkedInURL,
            $this->owner->YouTubeURL
        ];

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
}
