<?php

namespace App\View;

use App\Form\FormController;
use App\Model\MessageSettings;
use App\Util\AssetUtil;
use App\Util\TextUtil;
use App\Util\Util;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\TemplateGlobalProvider;

class SiteTemplateGlobalProvider implements TemplateGlobalProvider
{
    public static function get_template_global_variables()
    {
        return [
            'PhoneLink' => 'PhoneLink',
            'PhoneLinker' => [
                'method' => 'PhoneLinker',
                'casting' => 'HTMLFragment'
            ],
            'GetPageByType' => 'GetPageByType',
            'ContactForm' => 'ContactForm',
            'SignInForm' => 'SignInForm',
            'SignOutForm' => 'SignOutForm',
            'LogOutForm' => 'LogOutForm',
            'LunchOutForm' => 'LunchOutForm',
            'AppointmentOutForm' => 'AppointmentOutForm',
            'LunchInForm' => 'LunchInForm',
            'AppointmentInForm' => 'AppointmentInForm',
            'IsLive' => 'IsLive',
            'SiteCSS' => 'SiteCSS',
            'SiteLiveCSS' => 'SiteLiveCSS',
            'SiteJS' => 'SiteJS',
            'Asset' => 'Asset',
            'AssetInline' => [
                'method' => 'AssetInline',
                'casting' => 'HTMLFragment'
            ],
            'TextEmphasize' => [
                'method' => 'TextEmphasize',
                'casting' => 'HTMLFragment'
            ],
            'TextDeemphasize' => [
                'method' => 'TextDeemphasize',
                'casting' => 'HTMLFragment'
            ],
            'TextEmphasizeFromStart' => [
                'method' => 'TextEmphasizeFromStart',
                'casting' => 'HTMLFragment'
            ],
            'TextEmphasizeFromEnd' => [
                'method' => 'TextEmphasizeFromEnd',
                'casting' => 'HTMLFragment'
            ],
            'WelcomeMessage' => 'WelcomeMessage',
            'BirthdayMessage' => 'BirthdayMessage',
        ];
    }

    public static function ContactForm()
    {
        $controller = FormController::create();

        return $controller->ContactForm();
    }

    public static function SignInForm()
    {
        $controller = FormController::create();

        return $controller->SignInForm();
    }

    public static function SignOutForm($disabled = false)
    {
        $controller = FormController::create();

        return $controller->SignOutForm($disabled);
    }

    public static function LogOutForm($isNavigation = false)
    {
        $controller = FormController::create();

        return $controller->LogOutForm($isNavigation);
    }

    public static function LunchOutForm($disabled = false)
    {
        $controller = FormController::create();

        return $controller->LunchOutForm($disabled);
    }

    public static function AppointmentOutForm($disabled = false)
    {
        $controller = FormController::create();

        return $controller->AppointmentOutForm($disabled);
    }

    public static function LunchInForm($disabled = false)
    {
        $controller = FormController::create();

        return $controller->LunchInForm($disabled);
    }

    public static function AppointmentInForm($disabled = false)
    {
        $controller = FormController::create();

        return $controller->AppointmentInForm($disabled);
    }

    public static function PhoneLink($number)
    {
        return sprintf('+1%s', Util::cleanPhoneNumber($number));
    }

    public static function PhoneLinker($number, $classes = '', $text = null)
    {
        $text = is_null($text) ? $number : $text;
        $cleanedNumber = sprintf('+1%s', Util::cleanPhoneNumber($number));
        $phoneLink = sprintf('<a href="tel:%s" class="phone-link %s">%s</a>', $cleanedNumber, $classes, $text);

        return $phoneLink;
    }

    public static function GetPageByType($pageType)
    {
        return DataObject::get_one('App\\Page\\' . $pageType);
    }

    public static function IsLive()
    {
        return Director::isLive();
    }

    public static function SiteCSS()
    {
        AssetUtil::requireSiteCSS();
    }

    public static function SiteLiveCSS()
    {
        $css = '';
        $vendor = Director::baseFolder() . '/public/_resources/app/client/dist/vendor.css';
        $main = Director::baseFolder() . '/public/_resources/app/client/dist/app.css';
        $vendorCss = '';
        $mainCss = '';
        if (file_exists($vendor)) {
            $vendorCss = file_get_contents($vendor);
        }
        if (file_exists($main)) {
            $mainCss = file_get_contents($main);
        }
        $css = $vendorCss . $mainCss;
        return $css;
    }

    public static function SiteJS()
    {
        AssetUtil::requireSiteJS();
    }

    public static function Asset($path)
    {
        return AssetUtil::getAsset($path);
    }

    public static function AssetInline($path)
    {
        return AssetUtil::getAssetInline($path);
    }

    public static function TextEmphasize($text)
    {
        return TextUtil::emphasize($text);
    }

    public static function TextDeemphasize($text)
    {
        return TextUtil::deemphasize($text);
    }

    public static function TextEmphasizeFromStart($text, $numWords = 1)
    {
        return TextUtil::emphasizeFromStart($text, $numWords);
    }

    public static function TextEmphasizeFromEnd($text, $numWords = 1)
    {
        return TextUtil::emphasizeFromEnd($text, $numWords);
    }

    public static function WelcomeMessage()
    {
        $settings = MessageSettings::current_settings();
        return $settings->WelcomeMessage;
    }
}
