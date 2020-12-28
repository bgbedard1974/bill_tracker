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

    public function __construct($month, YamlHandler $yaml)
    {
        $this->yaml = $yaml;
        $filename = '/data/' .$month . '.yml';
        if (!$yaml->fileExists($filename)) {
            $this->inputFile = $this->yaml->getTemplateFile();
            $this->outputFile = $filename;
        } else {
            $this->inputFile = $filename;
            $this->outputFile = $filename;

        }

        $yaml_data = $this->yaml->readYaml($this->inputFile);
        $this->data = $yaml_data['bills'];
        $this->month = $month;
    }

    public function markBill($bill_id, $mark)
    {
        $index = 0;

        foreach ($this->data as $key => $bill) {
            if ($bill['bill_id'] === $bill_id) {
                $index = $key;
                break;
            }
        }

        $this->data[$index]['value'] = $mark;
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

    public function getMonth()
    {
        return $this->month;
    }

}