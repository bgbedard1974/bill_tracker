<?php

namespace App\Controller;

use App\Model\BillsByMonth;
use App\Model\Config;
use App\Service\YamlHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/test", name="test.")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param YamlHandler $yaml
     * @return Response
     */
    public function index(YamlHandler $yaml): Response
    {
        $data = $yaml->readYaml('/data/template_b.yml');

        $id = 'asf';
        $mark = 'skipped';

        $data['bills'][$id] = $mark;

        dump($data);

        $yaml->writeYaml('/data/11_2020.yml', $data);

        return $this->render('test/index.html.twig');
    }





}
