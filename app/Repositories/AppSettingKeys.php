<?php

namespace App\Repositories;

enum TicketNotificationSetting: string
{
    case DEPARTMENT_MEMBERS = "department_members_notification.enabled";
    case DEPARTMENT_MEMBERS_CHANNELS = "department_members_notification.channels";
    case CC_CONTACT = "cc_contact_notification.enabled";
    case CC_CONTACT_CHANNELS = "cc_contact_notification.channels";
    case BCC_CONTACT = "bcc_contact_notification.enabled";
    case BCC_CONTACT_CHANNELS = "bcc_contact_notification.channels";
    case CHANGE_STATUS = "change_status_notification.enabled";
    case CHANGE_STATUS_CHANNELS = "change_status_notification.channels";
}

enum TicketEvents: string
{
    case UPDATED = "updated";
    case CREATED = "created";
}
