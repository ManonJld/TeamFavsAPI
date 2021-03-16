<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookmarkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookmarkRepository::class)
 * @ORM\HasLifecycleCallbacks()// permet de gérer le created at à la date du jour
 * @ApiResource(
 *     attributes={
 *          "order":{"name":"asc"}
 *     },
 *     subresourceOperations={
 *          "api_categories_bookmarks_get_subresource"={
 *              "normalization_context"={"groups"={"bookmarks_subresource"}}
 *               }
 *     }
 * )
 */
class Bookmark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"bookmarks_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"bookmarks_subresource"})
     * @Assert\NotBlank(
     *     message="Veuillez entrer un nom pour le favoris"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"bookmarks_subresource"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"bookmarks_subresource"})
     * @Assert\NotBlank(
     *     message="Veuillez entrer une URL"
     * )
     * @Assert\Url(
     *     message="Veuillez entrer une URL valide"
     * )
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"bookmarks_subresource"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"bookmarks_subresource"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="bookmarks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *     message="Veuillez renseigner une catégorie"
     * )
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookmarks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"bookmarks_subresource"})
     * @Assert\NotBlank(
     *     message="Veuillez renseigner un utilisateur"
     * )
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
//    permet de créer automatiquement la date
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function __toString()//permet de définir une sortie en chaine de caractère si la classe est appelé directement, notamment pour les listes déroulante des formulaires
    {
        return $this->getName();
    }
}
