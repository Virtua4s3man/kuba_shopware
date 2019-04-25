<?php

namespace VirtuaShipping\Components;

class ShippingService
{
    private $config;

    public $configDateFormat = 'Y-m-d?G:i:s';

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function resolveEstimatedDeliveryTime($articleShippingIn)
    {
        $now = new \DateTime('now');
        $shipmentDate = $this->getNearestShippingDate($now);
        $daysToDeliver = intval($articleShippingIn);

        return $this->countWorkingDays($daysToDeliver, $shipmentDate);
    }

    /**
     * @param \DateTime $now
     * @return bool|\DateTime
     */
    private function getNearestShippingDate(\DateTime $now)
    {
        if ($this->afterShippingHours($now)) {
            $now->modify('+1 day');
            $now->setTime(0, 0, 0);
        }

        if ($this->inNoShippingTimeRange($now)) {
            $now = $this->convertToDateTime($this->config['no_shipping_end_date']);
            $now->modify('+1 day');
        }

        while (!$this->readyToShip($now)) {
            $now->modify('+1 day');
        }

        return $now;
    }

    /**
     * @param \DateTime $now
     *
     * @return bool
     */
    private function inNoShippingTimeRange(\DateTime $now)
    {
        $start = $this->convertToDateTime($this->config['no_shipping_start_date']);
        $end = $this->convertToDateTime($this->config['no_shipping_end_date']);

        if ($start && $end && $start < $end) {
            return $start <= $now && $now <= $end;
        }

        return false;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    private function afterShippingHours(\DateTime $date)
    {
        if ($this->config['last_shipping_hour']) {
            $lastShippingHour = clone $date;
            $lastShippingHour->setTime(...$this->lastShippingTimeToArray());

            return $date > $lastShippingHour;
        }

        return false;
    }

    /**
     * @param \DateTime $now
     * @return bool
     */
    private function isNoShippingDayOfWeek(\DateTime $now)
    {
        if ($this->config['no_shipping_week_days']) {
            return in_array($now->format('N'), $this->config['no_shipping_week_days']);
        }

        return false;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    private function readyToShip(\DateTime $date)
    {
        return
            !$this->inNoShippingTimeRange($date)
            && !$this->isNoShippingDayOfWeek($date);
    }

    /**
     * @return array
     */
    private function lastShippingTimeToArray()
    {
        return explode(
            ':',
            array_pop(
                explode('T', $this->config['last_shipping_hour'])
            )
        );
    }

    /**
     * @param $dateTimeString
     * @return bool|\DateTime
     */
    private function convertToDateTime($dateTimeString)
    {
        return \DateTime::createFromFormat($this->configDateFormat, $dateTimeString);
    }

    /**
     * @param int $daysToDeliver
     * @param \DateTime $shipmentDate
     * @return \DateTime
     */
    private function countWorkingDays($daysToDeliver, \DateTime $shipmentDate)
    {
        while ($daysToDeliver !== 0) {
            $isFreeDay = $this->isNoShippingDayOfWeek(
                $shipmentDate->modify('+1 day')
            ) ? true : false;

            if (!$isFreeDay) {
                $daysToDeliver--;
            }
        }

        return $shipmentDate;
    }
}
