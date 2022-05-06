<?php

namespace Modules\Setting\Enums;

enum TicketSetting: string
{
    case TICKET = "ticket";

    case TICKET_NOTIFICATION = "ticket.notification";

    case NOTIFICATION_BROADCAST_ALLOWED = "ticket.notification.broadcast.allow";

    case NOTIFICATION_BROADCAST_MESSAGE = "ticket.notification.broadcast.message";

    case MAX_RESPONSE_TO_TICKET_TIMEOUT = "ticket.max_response_to_ticket_timeout";

    case NOTIFICATION_BROADCAST_CHANNEL = "ticket.notification.channel";

    case MAX_ATTACHMENT_SIZE = "ticket.max_attachment_size";

    case ATTACHMENT_TYPES_ALLOWED = "ticket.attachment_types_allowed";
}
