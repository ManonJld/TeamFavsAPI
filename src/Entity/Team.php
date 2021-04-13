<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 * @ORM\HasLifecycleCallbacks()// permet de gérer le created at à la date du jour
 * @ApiResource(
 *     normalizationContext={"groups"={"teams_read"}},
 *     collectionOperations={
 *          "GET"={
 *              "method"="get",
 *              "openapi_context"={
 *                  "summary"="Récupère la liste des teams, leurs utilisateurs et leur role",
 *                  "description"="Récupère la liste des teams, leurs utilisateurs et leur role"
 *          }},
 *          "POST"={
 *              "method"="post"
 *     }
 *     }
 * )
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users_read", "teams_read", "userTeam_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read", "teams_read", "userTeam_read"})
     * @Assert\Length(
     *      min = 3,
     *      max = 40,
     *      minMessage = "Le nom de votre team doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de votre team ne peut pas faire plus de {{ limit }} caractères"
     * )
     * @Assert\NotBlank(
     *     message = "Veuillez donner un nom à votre Team"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"teams_read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="teamsCreated")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"teams_read"})
     * @Assert\NotBlank(
     *     message="Veuillez renseigner un utilisateur"
     * )
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=UserTeam::class, mappedBy="team", orphanRemoval=true)
     * @Groups({"teams_read"})
     */
    private $userTeams;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="team", orphanRemoval=true)
     * @ApiSubresource(maxDepth=2)
     * @Groups("teams_read")
     */
    private $categories;

    //la ligne this->id est ajoutée pour gérer le cascade persist
    public function __construct()
    {
        $this->id = Team::class;
        $this->userTeams = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    //Cette fonction permet de pouvoir créer une entité UserTeam, à la création d'une entité Team. Il faut en plus cascade persist dans l'entité UserTeam
    public function userTeam()
    {
        $newUserTeam = new UserTeam();
        $newUserTeam->setTeam($this);
        $this->userTeams->add($newUserTeam);
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
     * @return Collection|UserTeam[]
     */
    public function getUserTeams(): Collection
    {
        return $this->userTeams;
    }

    public function addUserTeam(UserTeam $userTeam): self
    {
        if (!$this->userTeams->contains($userTeam)) {
            $this->userTeams[] = $userTeam;
            $userTeam->setTeam($this);
        }

        return $this;
    }

    public function removeUserTeam(UserTeam $userTeam): self
    {
        if ($this->userTeams->removeElement($userTeam)) {
            // set the owning side to null (unless already changed)
            if ($userTeam->getTeam() === $this) {
                $userTeam->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setTeam($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getTeam() === $this) {
                $category->setTeam(null);
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
