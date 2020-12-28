<?php


namespace App\Model;


use App\Service\YamlHandler;

class Config
{
    const CONFIG_FILE = '/data/config.yml';
    private $bills;
    private $activeMonth;
    private $validMarks;
    private $yaml;

    public function __construct(YamlHandler $yaml)
    {
        $this->yaml = $yaml;
        $filename = $this->yaml->getTemplateFile() . self::CONFIG_FILE;
        $yaml_data = $this->yaml->readYaml($filename);
        $this->bills = $yaml_data['config']['bills'];
        $this->activeMonth = $yaml_data['config']['active_month'];
        $this->validMarks = $yaml_data['config']['valid_marks'];
    }

    public function save()
    {
        $yaml_data = [];
        $yaml_data['config'] =
            [
                'bills' => $this->bills,
                'active_month' => $this->activeMonth

            ];
        $filename = $this->yaml->getTemplateFile() . self::CONFIG_FILE;
        $this->yaml->writeYaml($filename, $yaml_data);
    }

    public function getBills()
    {
        return $this->bills;
    }

    public function getActiveMonth()
    {
        return $this->activeMonth;
    }

    public function setActiveMonth($month)
    {
        $this->activeMonth = $month;
    }

    public function getValidMarks()
    {
        return $this->validMarks;
    }

}