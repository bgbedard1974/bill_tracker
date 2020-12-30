<?php

namespace App\Controller;

use App\Model\Bills;
use App\Model\BillsByMonth;
use App\Model\Config;
use App\Service\MonthHandler;
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
     * @Route("/show/{month}", name="show")
     * @param string $month
     * @param Config $config
     * @param YamlHandler $yaml
     * @param MonthHandler $mh
     * @return Response
     */
    public function show(string $month, Config $config, YamlHandler $yaml, MonthHandler $mh): Response
    {
        $bills_this_month = new BillsByMonth($month, $yaml);
        $bills = new Bills($config);
        $data = $bills_this_month->getViewData($bills);
        $data['month'] = $month;
        $data['month_text'] = $mh->getMonthText($month);
        $is_active_month = false;
        if ($month === $config->getActiveMonth()) {
            $is_active_month = true;
        }

        $data['is_active_month'] = $is_active_month;

        if (!$bills_this_month->fileDoesExist()) {
            $data['no_data'] = true;
        } else {
            $data['no_data'] = false;
        }

        $data = array_merge($data, $mh->getPrevNextMonths($month));

        return $this->render('bills/show.html.twig', $data);
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
        $message_type = 'warning';
        $message = 'Bill not found.';
        $config = new Config($yaml);
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
        return $this->redirect($this->generateUrl('bills.show', ['month' => $month]));
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
        return $this->redirect($this->generateUrl('bills.show', ['month' => $month]));
    }

    /**
     * @Route("/activate/{month}", name="activate")
     * @param string $month
     * @param Config $config
     * @return Response
     */
    public function activate(string $month, Config $config): Response
    {
        $config->setActiveMonth($month);
        $config->save();

        $this->addFlash('success', 'Month Activated.');
        return $this->redirect($this->generateUrl('bills.show', ['month' => $month]));
    }
}
