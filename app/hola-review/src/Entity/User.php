<?php

namespace App\Entity;

use App\Entity\Role;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * @ApiResource(
 *     collectionOperations  = {"get","post"},
 *     itemOperations={
 *      "get",
 *      "delete",
 *      "put",
 *     },
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 * )
 * @UniqueEntity(fields={"username"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     maxMessage="Set your name in 50 chars or less"
     * )
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     */

    private $name;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     maxMessage="Set your username in 50 chars or less"
     * )
     * @Assert\NotBlank()
     * @Groups({"user:read", "user:write", "get_by_username:getbyusername"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"user:write"})
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     maxMessage="Set your password in 20 chars or less"
     * )
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank()
     */
    private $role;

    /**
     * User constructor.
     * @param $name
     * @param $username
     * @param $password
     * @param $role
     */
    public function __construct($name, $username, $password, $role)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->role = new Role($role);
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
