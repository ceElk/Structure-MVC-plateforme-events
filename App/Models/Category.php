<?php

namespace App\Models;

use App\Core\DbConnect;

class Category extends DbConnect
{
    /**
     * Récupère toutes les catégories avec le nombre d'événements
     * 
     * @return array
     */
    public function getCategoriesWithCount(): array
    {
        $sql = "
            SELECT 
                c.id,
                c.name,
                c.slug,
                c.description,
                c.color,
                c.icon,
                COUNT(e.id) AS event_count
            FROM categories c
            LEFT JOIN events e ON c.id = e.category_id 
                AND e.status = 'published'
                AND e.date_start >= NOW()
            WHERE c.is_active = 1
            GROUP BY c.id
            ORDER BY c.name ASC
        ";
        
        return $this->fetchAll($sql);
    }

    /**
     * Récupère une catégorie par son ID
     * 
     * @param int $id
     * @return object|null
     */
    public function findById(int $id): ?object
    {
        $sql = "SELECT * FROM categories WHERE id = :id AND is_active = 1";
        return $this->fetch($sql, [':id' => $id]);
    }

    /**
     * Récupère toutes les catégories actives
     * 
     * @return array
     */
    public function getAllActive(): array
    {
        $sql = "SELECT * FROM categories WHERE is_active = 1 ORDER BY name ASC";
        return $this->fetchAll($sql);
    }
}