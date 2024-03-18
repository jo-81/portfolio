<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

use function Symfony\Component\Clock\now;

class TimeAgoExtensionRuntime implements RuntimeExtensionInterface
{
    public function doTimeAgo(\DateTimeInterface $value): string
    {
        return $this->getDifferenceDatetime($value->diff(now()));
    }

    private function getDifferenceDatetime(\DateInterval $interval): string
    {
        if ($interval->y) {
            return $interval->y > 1 ? "$interval->y ans" : "$interval->y an";
        }

        if ($interval->m) {
            return $interval->m.' mois';
        }

        if ($interval->d) {
            return $interval->d.' j';
        }

        if ($interval->h) {
            return $interval->h.' h';
        }

        if ($interval->i) {
            return $interval->i.' m';
        }

        return 'à l\'instant';
    }
}
