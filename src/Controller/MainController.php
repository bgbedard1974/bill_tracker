<?php

namespace App\Controller;

use App\Model\BillsByMonth;
use App\Model\Config;
use App\Model\Bills;
use App\Service\MonthHandler;
use App\Service\YamlHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Config $config
     * @param YamlHandler $yaml
     * @param MonthHandler $mh
     * @return Response
     */
    public function index(Config $config, YamlHandler $yaml, MonthHandler $mh): Response
    {
        $month = $config->getActiveMonth();

        return $this->redirect($this->generateUrl('bills.show', ['month' => $month]));
    }

}
