<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\ProductInfoDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class UserProductAction extends AbstractController
{
        public function __invoke(#[MapRequestPayload] ProductInfoDto $infoDto)
        {
            print_r($infoDto);
            exit();
        }
}