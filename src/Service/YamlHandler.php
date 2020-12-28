<?php


namespace App\Service;


use Symfony\Component\Yaml\Yaml;


class YamlHandler
{
    private $projectDir;

    public function __construct($project_dir)
    {
        $this->projectDir = $project_dir;
    }

    public function readYaml($filename)
    {
        $file_path = $this->projectDir . $filename;

        return Yaml::parseFile($file_path);
    }

    public function writeYaml($filename, $data)
    {
        $file_path = $this->projectDir . $filename;

        $yaml = Yaml::dump($data);

        file_put_contents($file_path, $yaml);
    }

}