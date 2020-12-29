<?php

namespace App\Controller;

use App\Model\Bills;
use App\Model\BillsByMonth;
use App\Model\Config;
use App\Service\YamlHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bills", name="bills.")
 */
class BillsController extends AbstractController
{
    /**
     * @Route("/mark/{id}/{mark}", name="mark")
     * @param string $id
     * @param string $mark
     * @param YamlHandler $yaml
     * @return Response
     */
    public function mark(string $id, string $mark, YamlHandler $yaml): Response
    {
        $message_type = 'warning';
        $message = 'Bill not found.';
        $config = new Config();
        $month = $config->getActiveMonth();

        $bills = new Bills($config);
        $bills_this_month = new BillsByMonth($month, $yaml);
        if (in_array($mark, $config->getValidMarks())) {
            $bills_this_month->markBill($id, $mark);
            $bills_this_month->save();
            $message_type = 'success';
            $bill = $bills->getBillById($id);
            $message = $bill['name'] . ' has been marked ' . strtoupper($mark);
        } else {
            $message = 'Invalid mark.';
        }

        $this->addFlash($message_type, $message);
        return $this->redirect($this->generateUrl('home'));
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

        $this->addFlash('success', 'Month Created.');
        return $this->redirect($this->generateUrl('home'));
    }
}
