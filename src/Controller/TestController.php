<?php

namespace App\Controller;

use App\Model\BillsByMonth;
use App\Model\Config;
use App\Service\YamlHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * __Route("/test", name="test.")
 */
class TestController extends AbstractController
{
    /**
     * __Route("/", name="index")
     * @param YamlHandler $yaml
     * @return Response
     */
    public function index(YamlHandler $yaml): Response
    {
        $data = $yaml->readYaml('/data/template.yml');

        $id = 'asf';
        $mark = 'skipped';

        $data['bills'][$id] = $mark;

        dump($data);

        $yaml->writeYaml('/data/11_2020.yml', $data);

        return $this->render('test/index.html.twig');
    }

    /**
     * __Route("/source", name="source")
     */
    public function source(): Response
    {
        $month = '01_2021';
        return $this->redirect($this->generateUrl('test.destination', ['month' => $month]));
    }

    /**
     * __Route("/destination/{month}", name="destination")
     * @param string $month
     * @return Response
     */
    public function destination(string $month): Response
    {
        //dump($month);
        return $this->render('test/index.html.twig');
    }

    /**
     * __Route("/dates", name="dates")
     */
    public function dates()
    {
        $month = '12_2020';
        $parts = explode('_', $month);
        $day = 1;
        $month = $parts[0] * 1;
        $year = $parts[1];

        $date_string = implode('-', [$year, $month , $day]);

        $date = new \DateTime($date_string);
        $date->modify('+2 month');
        dump($date->format('F Y'));

        return $this->render('test/index.html.twig');
    }

}
