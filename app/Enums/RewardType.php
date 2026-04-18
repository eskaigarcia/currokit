<?php

namespace App\Enums;

enum RewardType: string
{
    case Badge = 'badge';
    case FreeTrial = 'free_trial';
    case PointsBoost = 'points_boost';
    case PremiumDays = 'premium_days';
}
