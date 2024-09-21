<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Component\User\FullNameDto;
use App\Controller\AboutMeAction;
use App\Controller\UserCreateAction;
use App\Controller\UserFullNameAction;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message: 'Email {{ value }} is already registered }}')]
//#[ApiFilter(SearchFilter::class, properties: [
////    'id' => 'exact',
////    'email' => 'partial'
//])]
#[ApiResource(
        operations: [
        new GetCollection(),
        new Post(
            uriTemplate: 'users/my',
            controller: UserCreateAction::class,
            name: 'users',
        ),
        new Post(
            uriTemplate: 'users/full-name',
            controller: UserFullNameAction::class,
            input: FullNameDto::class,
            name: 'fullName',
        ),
        new Post(
            uriTemplate: 'users/auth',
            name: 'auth'
        ),
        new GetCollection(
            uriTemplate: 'users/about_me',
            controller: AboutMeAction::class,
            name: 'aboutMe',
        ),
        new Get(),
        new Delete(),
    ],


    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    paginationItemsPerPage: 5
)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message: 'Vote email n\'est pas valid' )]
    #[Assert\NotBlank(message: 'Email not empty')]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:write'])]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
        // TODO: Implement getRoles() method.
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
        // TODO: Implement getUserIdentifier() method.
    }
}
