<?php


namespace App\Model;


class Bills
{
    private $data;

    public function __construct(Config $config)
    {
        $this->data = $config->getBills();
    }

    public function getBillById(string $id)
    {
        $index = 0;
        foreach ($this->data as $key => $bill) {
            if ($bill['id'] === $key) {
                $index = $key;
                break;
            }
        }
        return $this->data[$index];
    }

    public function getBillsByBlock(string $block): array
    {
        $bills = [];

        foreach ($this->data as $bill) {
            if ($bill['block'] === $block) {
                $bills[] = $bill;
            }
        }

        return $bills;

    }
}