<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Component\User\ProductInfoDto;
use App\Controller\GetProductsByCategoryAction;
use App\Controller\GetProductsByHardExampleAction;
use App\Controller\UserProductAction;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new GetCollection(
            uriTemplate: 'product/by-category',
            controller: GetProductsByCategoryAction::class,
            openapiContext: [
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'categoryId',
                        'schema' => [
                            'type' => 'integer',
                        ]
                    ]
                ]
            ],
            name: 'GetProducts',
        ),
        new GetCollection(
            uriTemplate: 'product/hard-example',
            controller: GetProductsByHardExampleAction::class,
            name: 'GetProductsHardExample',
        ),
        new Post(),
        new Post(
            uriTemplate: 'product/price',
            controller: UserProductAction::class,
            input: ProductInfoDto::class,
            name: 'Product'
        ),
        new Get(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:read', 'product:write'])]
    private ?Category $category = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:read', 'product:write'])]
    private ?MediaObject $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(MediaObject $image): static
    {
        $this->image = $image;

        return $this;
    }
}
