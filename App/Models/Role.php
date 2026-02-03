<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\RoleEntity;

class Role extends DbConnect
{
    /**
     * Récupère tous les rôles
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM roles ORDER BY id ASC";
        $data = $this->fetchAll($sql);
        return $this->toEntities($data);
    }

    /**
     * Récupère un rôle par ID
     */
    public function getById(int $id): ?RoleEntity
    {
        $sql = "SELECT * FROM roles WHERE id = :id";
        $data = $this->fetchOne($sql, [':id' => $id]);
        
        if (!$data) {
            return null;
        }
        
        return $this->toEntity($data);
    }

    /**
     * Récupère un rôle par nom
     */
    public function getByName(string $name): ?RoleEntity
    {
        $sql = "SELECT * FROM roles WHERE name = :name";
        $data = $this->fetchOne($sql, [':name' => $name]);
        
        if (!$data) {
            return null;
        }
        
        return $this->toEntity($data);
    }

    /**
     * Convertit un tableau en RoleEntity
     */
    protected function toEntity(array $data): RoleEntity
    {
        $role = new RoleEntity();
        
        if (isset($data['id'])) $role->setId((int)$data['id']);
        if (isset($data['name'])) $role->setName($data['name']);
        if (isset($data['description'])) $role->setDescription($data['description']);
        if (isset($data['created_at'])) $role->setCreatedAt($data['created_at']);
        
        return $role;
    }

    /**
     * Convertit un tableau d'arrays en tableau de RoleEntity
     */
    protected function toEntities(array $dataList): array
    {
        $roles = [];
        foreach ($dataList as $data) {
            $roles[] = $this->toEntity($data);
        }
        return $roles;
    }
}