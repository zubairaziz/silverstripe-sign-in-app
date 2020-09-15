<?php

namespace App\Extension;

use App\Page\HallOfFamerPage;
use App\Page\HomePage;
use App\Page\ScholarshipPage;
use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Model\VirtualPage;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\HTML;

class SiteTree extends DataExtension
{
    public function IsExternalRedirector()
    {
        if ($this->owner->ClassName == RedirectorPage::class) {
            return $this->owner->RedirectionType == 'External';
        }
    }

    public function IsHomePage()
    {
        return $this->owner->ClassName == HomePage::class;
    }

    public function IsHallOfFamerPage()
    {
        return $this->owner->ClassName == HallOfFamerPage::class;
    }

    public function IsScholarshipPage()
    {
        return $this->owner->ClassName == ScholarshipPage::class;
    }

    public function getBodyClasses()
    {
        $classes = [];

        $classes[] = sprintf('page-%s', strtolower($this->owner->URLSegment));
        $classes[] = sprintf('pagetype-%s', strtolower((new \ReflectionClass($this->owner))->getShortName()));

        return join(' ', $classes);
    }

    public function getPageHeaderClasses()
    {
        $classes = ['page-header'];

        if ($this->owner->HeaderStyle == 'Hero') {
            $classes[] = 'page-header--hero';
        }

        return join(' ', $classes);
    }

    public function getNicePageHeaderTitle()
    {
        $headerTitle = $this->owner->getField('HeaderTitle');

        if ($headerTitle) {
            return $headerTitle;
        }

        return $this->owner->Title;
    }

    public function MetaTags(&$tags)
    {
        $siteConfig = SiteConfig::current_site_config();

        if ($siteConfig->CanonicalDomain != '' && $this->owner->ClassName != VirtualPage::class) {
            $canonicalBase = trim($siteConfig->CanonicalDomain, '/');

            if (method_exists($this->owner, 'CanonicalLink')) {
                $link = $this->owner->CanonicalLink();
            } else {
                $link = $this->owner->Link();
            }

            $canonLink = $canonicalBase . $link;

            $atts = [
                'rel' => 'canonical',
                'href' => $canonLink
            ];

            $canonTag = HTML::createTag('link', $atts);

            $tagsArray = explode(PHP_EOL, $tags);
            $tagPattern = 'rel="canonical"';
            $tagSearch = function ($val) use ($tagPattern) {
                return (stripos($val, $tagPattern) !== false ? true : false);
            };

            $currentTags = array_filter($tagsArray, $tagSearch);
            $cleanedTags = array_diff($tagsArray, $currentTags);
            $cleanedTags[ ] = $canonTag;

            $tags = implode(PHP_EOL, $cleanedTags);
        }
    }
}
