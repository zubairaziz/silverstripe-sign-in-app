<?php

namespace App\Extension;

use App\Util\AssetUtil;
use SilverStripe\Control\Director;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;

class UserDefinedFormController extends DataExtension
{
    public function updateEmail($email, $recipient, $emailData)
    {
        $emailData['SiteConfig'] = SiteConfig::current_site_config();
        $emailData['SiteLogo'] = Director::absoluteURL(AssetUtil::getResourcePath('images/logo-email.png'));
        $emailData['Subject'] = $email->getSubject();
        $emailData['IsUserformEmail'] = true;

        $email->setHTMLTemplate('App/Email/StyledEmail');
        $email->setData($emailData);
    }
}
