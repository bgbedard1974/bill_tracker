<?php


namespace App\Model;


class Bills
{
    private $data;
    private $month;

    public function __construct($month, $data)
    {
        $this->data = $data;
        $this->month = $month;
    }

    public function markBill($bill_id, $mark)
    {
        $index = 0;
        //dump($this->data);

        foreach ($this->data as $key => $bill) {
            if ($bill['bill_id'] === $bill_id) {
                $index = $key;
                break;
            }
        }

        $this->data[$index]['value'] = $mark;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMonth()
    {
        return $this->month;
    }

}