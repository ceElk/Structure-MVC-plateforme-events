<?php

namespace App\Entities;

class UserEntity
{
    private ?int $id = null;
    private ?string $username = null;
    private ?string $email = null;
    private ?string $password = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $phone = null;
    private ?int $roleId = 2; // Par défaut : user
    private ?bool $isActive = true;
    private ?bool $emailVerified = false;
    private ?string $lastLogin = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;
    
    // Relation
    private ?string $roleName = null; // Depuis la table roles

    // ========== GETTERS ==========
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function getEmailVerified(): ?bool
    {
        return $this->emailVerified;
    }

    public function getLastLogin(): ?string
    {
        return $this->lastLogin;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    // ========== SETTERS ==========
    
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setRoleId(?int $roleId): self
    {
        $this->roleId = $roleId;
        return $this;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function setEmailVerified(?bool $emailVerified): self
    {
        $this->emailVerified = $emailVerified;
        return $this;
    }

    public function setLastLogin(?string $lastLogin): self
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setRoleName(?string $roleName): self
    {
        $this->roleName = $roleName;
        return $this;
    }

    // ========== MÉTHODES UTILES ==========
    
    public function isAdmin(): bool
    {
        return $this->roleName === 'admin' || $this->roleId === 1;
    }

    public function getFullName(): string
    {
        $parts = array_filter([$this->firstName, $this->lastName]);
        return !empty($parts) ? implode(' ', $parts) : $this->username ?? 'Utilisateur';
    }

    public function getFormattedCreatedAt(string $format = 'd/m/Y'): ?string
    {
        if (!$this->createdAt) {
            return null;
        }
        
        try {
            $date = new \DateTime($this->createdAt);
            return $date->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getFormattedLastLogin(string $format = 'd/m/Y H:i'): ?string
    {
        if (!$this->lastLogin) {
            return null;
        }
        
        try {
            $date = new \DateTime($this->lastLogin);
            return $date->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}