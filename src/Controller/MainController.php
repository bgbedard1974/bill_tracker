<?php

namespace App\Controller;

use App\Model\BillsByMonth;
use App\Model\Config;
use App\Service\YamlHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $block_a = [
            ['name' => 'Mortgage', 'id' => 'mrt', 'value' => ''],
            ['name' => 'Association Fee', 'id' => 'asf', 'value' => 'paid'],
            ['name' => 'Natural Gas', 'id' => 'gas', 'value' => 'skipped'],
        ];
        $block_b = [
            ['name' => 'Target Card', 'id' => 'tgc', 'value' => ''],
            ['name' => 'Car', 'id' => 'car', 'value' => ''],
        ];
        $data = [
            'month' => 'December 2020',
            'is_active_month' => true,
            'block_a' => $block_a,
            'block_b' => $block_b
        ];
        return $this->render('main/month.html.twig', $data);
    }


}
