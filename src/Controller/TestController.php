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
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig');
    }

    /**
     * @Route("/mark/{id}/{mark}", name="mark")
     * @param string $id
     * @param string $mark
     * @param YamlHandler $yaml
     * @return Response
     */
    public function mark(string $id, string $mark, YamlHandler $yaml): Response
    {
        $config = new Config();
        $month = $config->getActiveMonth();

        $bills = new BillsByMonth($month, $yaml);
        if (in_array($mark, $config->getValidMarks())) {
            $bills->markBill($id, $mark);
            $bills->save();
        }

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/create/{month}", name="create")
     * @param string $month
     * @param YamlHandler $yaml
     * @return Response
     */
    public function create(string $month, YamlHandler $yaml): Response
    {
        $bills = new BillsByMonth($month, $yaml);
        $bills->save();

        return new Response("<h1>Month Created</h1>");
    }

}
