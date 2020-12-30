<?php


namespace App\Service;


class MonthHandler
{
    public function getMonthText($month) :string
    {
        $date = self::createDate($month);
        return $date->format('F Y');
    }

    public function getPrevNextMonths($month) :array
    {
        $date = self::createDate($month);
        $date->modify('-1 month');
        $prev_month = $date->format('m_Y');
        $date->modify('+2 month');
        $next_month = $date->format('m_Y');
        return [
            'prev_month' => $prev_month,
            'next_month' => $next_month
        ];
    }

    private static function createDate($month_string) : \DateTime
    {
        $parts = explode('_', $month_string);
        $day = 1;
        $month = $parts[0] * 1;
        $year = $parts[1];

        $date_string = implode('-', [$year, $month , $day]);

        return new \DateTime($date_string);
    }

}