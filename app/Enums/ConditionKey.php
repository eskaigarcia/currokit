<?php

namespace App\Enums;

enum ConditionKey: string
{
    case CompaniesCreated = 'companies_created';
    case ContributionsMade = 'contributions_made';
    case TimesVoted = 'times_voted';
    case InstancesCreated = 'instances_created';
    case OffersTracked = 'offers_tracked';
    case ContentLiked = 'content_liked';
    case ContentShared = 'content_shared';
    case LikesToContributions = 'likes_to_contributions';
}
