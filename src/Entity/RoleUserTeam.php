<?php

namespace App\Entity;

use App\Repository\RoleUserTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleUserTeamRepository::class)
 */
class RoleUserTeam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=UserTeam::class, mappedBy="roleUserTeam")
     */
    private $userTeams;

    public function __construct()
    {
        $this->userTeams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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
            $userTeam->setRoleUserTeam($this);
        }

        return $this;
    }

    public function removeUserTeam(UserTeam $userTeam): self
    {
        if ($this->userTeams->removeElement($userTeam)) {
            // set the owning side to null (unless already changed)
            if ($userTeam->getRoleUserTeam() === $this) {
                $userTeam->setRoleUserTeam(null);
            }
        }

        return $this;
    }

    public function __toString()//permet de définir une sortie en chaine de caractère si la classe est appelé directement, notamment pour les listes déroulante des formulaires
    {
        return $this->getRole();
    }
}
