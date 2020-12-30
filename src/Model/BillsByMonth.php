<?php


namespace App\Model;


use App\Service\YamlHandler;


class BillsByMonth
{
    private $data;
    private $month;
    private $yaml;
    private $inputFile;
    private $outputFile;
    private $fileExists;

    public function __construct(string $month, YamlHandler $yaml)
    {
        $this->yaml = $yaml;
        $filename = '/data/' .$month . '.yml';
        if (!$yaml->fileExists($filename)) {
            $this->fileExists = false;
            $this->inputFile = $this->yaml->getTemplateFile();
            $this->outputFile = $filename;
        } else {
            $this->fileExists = true;
            $this->inputFile = $filename;
            $this->outputFile = $filename;

        }

        $yaml_data = $this->yaml->readYaml($this->inputFile);
        $this->data = $yaml_data['bills'];
        $this->month = $month;
    }

    public function markBill($bill_id, $mark)
    {
        $this->data[$bill_id] = $mark;
    }

    public function save()
    {
        $yaml_data = [];
        $yaml_data['bills'] = $this->data;
        $this->yaml->writeYaml($this->outputFile, $yaml_data);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function fileDoesExist(): bool
    {
        return $this->fileExists;
    }

    public function getViewData(Bills $bills): array
    {
        $block_a_bills = $bills->getBillsByBlock('a');

        $block_a = [];
        foreach ($block_a_bills as $bill) {
            $bill['value'] = $this->data[$bill['id']];
            $block_a[] = $bill;
        }

        $block_b_bills = $bills->getBillsByBlock('b');
        $block_b = [];
        foreach ($block_b_bills as $bill) {
            $bill['value'] = $this->data[$bill['id']];
            $block_b[] = $bill;
        }

        return [
            'block_a' => $block_a,
            'block_b' => $block_b
        ];
    }

}