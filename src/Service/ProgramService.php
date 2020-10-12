<?php

namespace App\Service;

use App\Cache\Keys;
use App\Cache\MemcachedClient;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramPayment;
use App\Entity\Program\ProgramReview;
use Psr\Cache\CacheItemInterface;
use Throwable;

class ProgramService
{
    public function isDiscount(Program $program): bool
    {
        /** @var ProgramPayment $payment */
        foreach ($program->getPayments() as $payment) {
            if ((int)$payment->getDiscount() > 0) {
                return true;
            }
        }

        return false;
    }

    public function getDuration(Program $program): string
    {
        switch ($program->getDurationType()) {
            case Program::DURATION_DAYS:
                return sprintf('%s дней', $program->getDurationValue());
            case Program::DURATION_HOURS:
                return sprintf('%s ак.ч.', $program->getDurationValue());
            case Program::OTHER:
                return $program->getDurationValue();
        }

        return '';
    }

    public function getPrice(Program $program): ?int
    {
        /** @var ProgramPayment $payment */
        foreach ($program->getPayments() as $payment) {
            if ($payment->getType() === ProgramPayment::INDIVIDUAL_TYPE && (int)$payment->getPrice() > 0) {
                return $payment->getPrice();
            }
        }

        foreach ($program->getPayments() as $payment) {
            if ($payment->getType() === ProgramPayment::LEGAL_ENTITY_TYPE && (int)$payment->getPrice() > 0) {
                return $payment->getPrice();
            }
        }

        return null;
    }

    public function getOldPrice(Program $program): ?int
    {
        /** @var ProgramPayment $payment */
        foreach ($program->getPayments() as $payment) {
            if ($payment->getType() === ProgramPayment::INDIVIDUAL_TYPE && (int)$payment->getOldPrice() > 0) {
                return $payment->getOldPrice();
            }
        }

        foreach ($program->getPayments() as $payment) {
            if ($payment->getType() === ProgramPayment::LEGAL_ENTITY_TYPE && (int)$payment->getOldPrice() > 0) {
                return $payment->getOldPrice();
            }
        }

        return null;
    }

    public function getAverageRating(Program $program): float
    {
        $result = static function (Program $program) {
            $result = 0;

            /** @var ProgramReview $programReview */
            foreach ($program->getReviews() as $programReview) {
                $result += $programReview->getAverageRating();
            }

            return $result;
        };

        try {
            $cache = MemcachedClient::getCache();

            /** @var CacheItemInterface $item */
            $item = $cache->getItem(sprintf('%s_%s', Keys::PROGRAM_AVERAGE_REVIEW, $program->getId()));

            if (!$item->isHit()) {
                $item->set($result($program));
                $item->expiresAfter(360000);
                $cache->save($item);
            }

            return $item->get();
        } catch (Throwable $e) {
            return 0;
        }
    }
}
