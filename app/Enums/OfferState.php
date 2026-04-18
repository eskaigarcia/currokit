<?php

namespace App\Enums;

enum OfferState: string
{
    case Saved = 'saved';
    case Applied = 'applied';
    case Interviewing = 'interviewing';
    case OfferReceived = 'offer_received';
    case Rejected = 'rejected';
    case Discarded = 'discarded';
}
