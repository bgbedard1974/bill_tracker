<?php


namespace App\Service;


use Symfony\Component\Yaml\Yaml;


class YamlHandler
{
    private $projectDir;
    private $templateFile;

    public function __construct($project_dir, $template_file)
    {
        $this->projectDir = $project_dir;
        $this->templateFile = $template_file;
    }

    public function readYaml($filename)
    {
        $file_path = $this->getFilePath($filename);

        return Yaml::parseFile($file_path);
    }

    public function writeYaml($filename, $data)
    {
        $file_path = $this->getFilePath($filename);

        $yaml = Yaml::dump($data);

        file_put_contents($file_path, $yaml);
    }

    private function getFilePath($filename): string
    {
        return $this->projectDir . $filename;
    }

    public function fileExists($filename): bool
    {
        $file_path = $this->getFilePath($filename);
        return file_exists($file_path);
    }

    public function getTemplateFile() : string
    {
        return $this->templateFile;
    }

}