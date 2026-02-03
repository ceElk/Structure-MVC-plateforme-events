<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\UserEntity;

class User extends DbConnect
{
    /**
     * Récupère tous les utilisateurs avec leur rôle
     */
    public function getAll(): array
    {
        $sql = "SELECT u.*, r.name as role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                ORDER BY u.created_at DESC";
        
        $data = $this->fetchAll($sql);
        return $this->toEntities($data);
    }

    /**
     * Récupère un utilisateur par ID
     */
    public function getById(int $id): ?UserEntity
    {
        $sql = "SELECT u.*, r.name as role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.id = :id";
        
        $data = $this->fetchOne($sql, [':id' => $id]);
        
        if (!$data) {
            return null;
        }
        
        return $this->toEntity($data);
    }

    /**
     * Récupère un utilisateur par email
     */
    public function getByEmail(string $email): ?UserEntity
    {
        $sql = "SELECT u.*, r.name as role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.email = :email";
        
        $data = $this->fetchOne($sql, [':email' => $email]);
        
        if (!$data) {
            return null;
        }
        
        return $this->toEntity($data);
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function insert(UserEntity $user): ?int
    {
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, phone, role_id, is_active, email_verified) 
                VALUES (:username, :email, :password, :first_name, :last_name, :phone, :role_id, :is_active, :email_verified)";
        
        $bindings = [
            ':username' => $user->getUsername(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':phone' => $user->getPhone(),
            ':role_id' => $user->getRoleId() ?? 2,
            ':is_active' => (int)($user->getIsActive() ?? true),
            ':email_verified' => (int)($user->getEmailVerified() ?? false)
        ];
        
        return $this->executeInsert($sql, $bindings);
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(UserEntity $user): bool
    {
        $sql = "UPDATE users 
                SET username = :username,
                    email = :email,
                    first_name = :first_name,
                    last_name = :last_name,
                    phone = :phone,
                    role_id = :role_id,
                    is_active = :is_active,
                    updated_at = NOW()
                WHERE id = :id";
        
        $bindings = [
            ':id' => $user->getId(),
            ':username' => $user->getUsername(),
            ':email' => $user->getEmail(),
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':phone' => $user->getPhone(),
            ':role_id' => $user->getRoleId(),
            ':is_active' => (int)$user->getIsActive()
        ];
        
        return $this->execute($sql, $bindings);
    }

    /**
     * Met à jour le mot de passe d'un utilisateur
     */
    public function updatePassword(int $userId, string $hashedPassword): bool
    {
        $sql = "UPDATE users 
                SET password = :password,
                    updated_at = NOW()
                WHERE id = :id";
        
        $bindings = [
            ':id' => $userId,
            ':password' => $hashedPassword
        ];
        
        return $this->execute($sql, $bindings);
    }

    /**
     * Met à jour la dernière connexion
     */
    public function updateLastLogin(int $userId): bool
    {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = :id";
        return $this->execute($sql, [':id' => $userId]);
    }

    /**
     * Supprime un utilisateur
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        return $this->execute($sql, [':id' => $id]);
    }

    /**
     * Compte le nombre total d'utilisateurs
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) as total FROM users";
        $result = $this->fetchOne($sql);
        return (int)($result->total ?? 0); // ✅ CORRIGÉ : -> au lieu de []
    }

    /**
     * Compte les utilisateurs par rôle
     */
    public function countByRole(int $roleId): int
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role_id = :role_id";
        $result = $this->fetchOne($sql, [':role_id' => $roleId]);
        return (int)($result->total ?? 0); // ✅ CORRIGÉ : -> au lieu de []
    }

    /**
     * Convertit un tableau OU objet en UserEntity
     */
    protected function toEntity($data): UserEntity
    {
        // ✅ Convertir l'objet en tableau si nécessaire
        if (is_object($data)) {
            $data = (array)$data;
        }

        $user = new UserEntity();
        
        if (isset($data['id'])) $user->setId((int)$data['id']);
        if (isset($data['username'])) $user->setUsername($data['username']);
        if (isset($data['email'])) $user->setEmail($data['email']);
        if (isset($data['password'])) $user->setPassword($data['password']);
        if (isset($data['first_name'])) $user->setFirstName($data['first_name']);
        if (isset($data['last_name'])) $user->setLastName($data['last_name']);
        if (isset($data['phone'])) $user->setPhone($data['phone']);
        if (isset($data['role_id'])) $user->setRoleId((int)$data['role_id']);
        if (isset($data['is_active'])) $user->setIsActive((bool)$data['is_active']);
        if (isset($data['email_verified'])) $user->setEmailVerified((bool)$data['email_verified']);
        if (isset($data['last_login'])) $user->setLastLogin($data['last_login']);
        if (isset($data['created_at'])) $user->setCreatedAt($data['created_at']);
        if (isset($data['updated_at'])) $user->setUpdatedAt($data['updated_at']);
        if (isset($data['role_name'])) $user->setRoleName($data['role_name']);
        
        return $user;
    }

    /**
     * Convertir un tableau d'arrays/objets en tableau de UserEntity
     */
    protected function toEntities(array $dataList): array
    {
        $users = [];
        foreach ($dataList as $data) {
            $users[] = $this->toEntity($data);
        }
        return $users;
    }
}