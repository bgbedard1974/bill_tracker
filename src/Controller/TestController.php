<?php

namespace App\Controller;

use App\Model\Bills;
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
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig');
    }

    /**
     * @Route("/mark/{id}/{type}", name="mark")
     * @param string $id
     * @param string $type
     * @param YamlHandler $handler
     * @return Response
     */
    public function mark(string $id, string $type, YamlHandler $handler): Response
    {
        $data = $handler->readYaml('/data/12_2020.yml');

        //$id = 'int';
        $marks = [
            'paid' => 'X',
            'skipped' => '--'
        ];
        $mark = $marks[$type];

        $bills = new Bills('12_20', $data['bills']);
        $bills->markBill($id, $mark);

        $data = [];
        $data['bills'] = $bills->getData();

        dump($data);

        $handler->writeYaml('/data/12_2020.yml', $data);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/create/{month}", name="create")
     * @param string $month
     * @param YamlHandler $handler
     * @return Response
     */
    public function create(string $month, YamlHandler $handler): Response
    {
        $data = $handler->readYaml('/data/template.yml');

        $filename = '/data/' . $month . '.yml';

        $handler->writeYaml($filename, $data);

        return new Response("<h1>Month Created</h1>");
    }

}
