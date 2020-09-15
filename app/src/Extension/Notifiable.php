<?php

namespace App\Extension;

use App\Subscription\Subscriber;
use App\Subscription\SubscriptionNotification;
use App\Util\Util;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;

class Notifiable extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        $notification = SubscriptionNotification::get()->filter([
            'ResourceClass' => $this->owner->ClassName,
            'ResourceID' => $this->owner->ID
        ])->first();

        if ($notification && ($notification->NotifyAt > '2019-09-17')) {
            $message = 'Notification Status: ';
            $n_date = date('F j, Y g:i a', strtotime($notification->NotifyAt));
            $n_link = "/admin/subscription-notifications/App-Subscription-SubscriptionNotification/EditForm/field/App-Subscription-SubscriptionNotification/item/{$notification->ID}/edit";

            if ($notification->Sent) {
                $message .= 'Sent on ' . $n_date;
            } else {
                $message .= 'Pending, to be sent on ' . $n_date . " - <a href='{$n_link}'>Manage Notification</a>";
            }

            $messageField = Util::cmsInfoMessage($message);

            $fields->insertBefore('PreviewLink', $messageField);
        }

        if ($this->owner->exists() && SubscriptionNotification::canNotify($this->owner)) {
            $subscriberCount = Subscriber::forSubscription($this->owner->ClassName)->count();

            $fields->addFieldsToTab('Root.Main', [
                FieldGroup::create(
                    'Subscribers',
                    CheckboxField::create(
                        '_Notify',
                        sprintf('Send email notification to %s subscribers on save', $subscriberCount)
                    )
                )
            ], 'Metadata');
        }
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();

        $shouldNotify = Controller::curr()->getRequest()->requestVar('_Notify');

        if ($shouldNotify) {
            if ($this->owner->exists() && SubscriptionNotification::canNotify($this->owner)) {
                SubscriptionNotification::notify($this->owner);
            }
        }
    }
}
