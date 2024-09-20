<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Exception\NameGenerationException;

class GetProductsByCategoryAction extends AbstractController
{
    public function __invoke(Request $request, ProductRepository $productRepository): array
    {
       $categoryId = $request->query->get('categoryId');

      if(!$categoryId){
          throw new NameGenerationException('Enter category id');
      }

      return $productRepository->findBy(['category' => (int)$categoryId]);
    }
}