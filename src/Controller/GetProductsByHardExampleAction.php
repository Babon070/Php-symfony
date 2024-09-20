<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetProductsByHardExampleAction extends AbstractController
{
    public function __invoke(ProductRepository $productRepository): array
    {
        return $productRepository->findByExampleField('6');
    }
}