<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserTeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserTeamRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"userTeam_read"}},
 * )
 */

class UserTeam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="userTeams", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"users_read", "userTeam_read"})
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userTeams")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"teams_read", "userTeam_read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=RoleUserTeam::class, inversedBy="userTeams")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"teams_read", "users_read", "userTeam_read"})
     */
    private $roleUserTeam;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRoleUserTeam(): ?RoleUserTeam
    {
        return $this->roleUserTeam;
    }

    public function setRoleUserTeam(?RoleUserTeam $roleUserTeam): self
    {
        $this->roleUserTeam = $roleUserTeam;

        return $this;
    }
}
