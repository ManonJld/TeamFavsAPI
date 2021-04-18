<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()// permet de gérer le created at à la date du jour
 * @ApiResource(
 *     attributes={
 *          "order":{"name":"asc"}
 *     },
 *     normalizationContext={"groups"={"category_read"}},
 *     subresourceOperations={
 *          "api_teams_categories_get_subresource"={
 *              "normalization_context"={"groups"={"categories_subresource"}}
 *               }
 *     }
 * )
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categories_subresource", "bookmark_read", "bookmarks_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category_read", "categories_subresource", "bookmark_read", "bookmarks_subresource"})
     * @Assert\Length(
     *      min = 3,
     *      max = 40,
     *      minMessage = "Le nom de votre team doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de votre team ne peut pas faire plus de {{ limit }} caractères"
     * )
     * @Assert\NotBlank(
     *     message="Veuillez entrer un nom pour la catégorie"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"category_read", "categories_subresource"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"category_read", "categories_subresource"})
     * @Assert\Length(
     *      min = 3,
     *      max = 500,
     *      minMessage = "La description de la catégorie doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "La description de la catégorie est limitée à {{ limit }} caractères"
     * )
     * @Assert\Regex("/^\w+/")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="categories", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *     message="Veuillez renseigner une team"
     * )
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"categories_subresource"})
     * @Assert\NotBlank(
     *     message="Veuillez renseigner un utilisteur"
     * )
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Bookmark::class, mappedBy="category", cascade={"remove"})
     * @ApiSubresource(maxDepth=1)
     * @Groups("teams_read")
     */
    private $bookmarks;

    public function __construct()
    {
        $this->bookmarks = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

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

    /**
     * @return Collection|Bookmark[]
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): self
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks[] = $bookmark;
            $bookmark->setCategory($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): self
    {
        if ($this->bookmarks->removeElement($bookmark)) {
            // set the owning side to null (unless already changed)
            if ($bookmark->getCategory() === $this) {
                $bookmark->setCategory(null);
            }
        }

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
