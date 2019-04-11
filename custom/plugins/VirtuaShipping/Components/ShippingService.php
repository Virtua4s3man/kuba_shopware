<?php

namespace VirtuaShipping\Components;

class ShippingService
{
    public $config;

    private $DateTimeFormat = 'Y-m-d?G:i:s';

    private $today;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->today = new \DateTime('now');
    }

    public function readyToShip(\DateTime $now)
    {
        return
            !$this->toLateToShipToday($now)
            and !$this->todayInNoShippingTimeRange($now)
            and !$this->isNoShippingDayOfWeek($now);
    }

    public function getNearestShippingDate()
    {
        $now = new \DateTime('now');

        if ($this->toLateToShipToday($now)) {
            $now->modify('+1 day');
            $now->setTime(0, 0, 0);
        }

        if ($this->todayInNoShippingTimeRange($now)) {
            $now = $this->convertToConfigToDateTime($this->config['no_shipping_end_date']);
            $now->modify('+1 day');
        }

        while (!$this->readyToShip($now)) {
            if ('00:00:00' !== $now->format('H:i:s')) {
                    $now->setTime(0, 0, 0);
            }
            $now->modify('+1 day');
        }

        return $now;
    }

    /**
     * @param \DateTime $now
     *
     * @return bool
     */
    public function todayInNoShippingTimeRange(\DateTime $now)
    {
        $start = $this->convertToConfigToDateTime($this->config['no_shipping_start_date']);
        $end = $this->convertToConfigToDateTime($this->config['no_shipping_end_date']);

        if ($start and $end and $start < $end) {
            return $start < $now and $now < $end;
        }

        return false;
    }

    /**
     * @param \DateTime $now
     * @return bool
     */
    public function toLateToShipToday(\DateTime $now)
    {
        if ($this->config['last_shipping_hour']) {
            return $now > \DateTime::createFromFormat(
                'G:i:s',
                array_pop(
                    explode('T', $this->config['last_shipping_hour'])
                )
            );
        }

        return false;
    }

    /**
     * @param \DateTime $now
     * @return bool
     */
    public function isNoShippingDayOfWeek(\DateTime $now)
    {
        if ($this->config['no_shipping_week_days']) {
            return in_array($now->format('N'), $this->config['no_shipping_week_days']);
        }

        return false;
    }

    /**
     * @param $dateTimeString
     * @return bool|\DateTime
     */
    private function convertToConfigToDateTime($dateTimeString)
    {
        return \DateTime::createFromFormat('Y-m-d?G:i:s', $dateTimeString);
    }
}