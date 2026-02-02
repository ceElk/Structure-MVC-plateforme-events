<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\EventEntity;

class Event extends DbConnect
{
    private function toEntity($data): EventEntity
    {
        $entity = new EventEntity();
        return $entity->hydrate($data);
    }

    private function toEntities(array $data): array
    {
        $entities = [];
        foreach ($data as $row) {
            $entities[] = $this->toEntity($row);
        }
        return $entities;
    }

    public function countPublishedEvents(): int
    {
        $sql = "
            SELECT COUNT(*) as total 
            FROM events 
            WHERE status = 'published' 
            AND date_start >= NOW()
        ";

        $result = $this->fetch($sql);
        return $result ? (int)$result->total : 0;
    }

    public function getFeaturedEvents(int $limit = 3): array
    {
        $sql = "
            SELECT 
                e.*,
                c.name AS category_name,
                c.color AS category_color,
                c.icon AS category_icon,
                (e.capacity - e.available_spots) AS reserved_spots
            FROM events e
            LEFT JOIN categories c ON e.category_id = c.id
            WHERE e.status = 'published'
            AND e.date_start >= NOW()
            ORDER BY e.is_featured DESC, e.created_at DESC
            LIMIT :limit
        ";

        $this->request = $this->connection->prepare($sql);
        $this->request->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $this->request->execute();

        $data = $this->request->fetchAll();
        return $this->toEntities($data);
    }

    public function getFilteredEvents(?string $type = null, ?int $categoryId = null, ?string $filter = null): array
    {
        $sql = "
            SELECT 
                e.*,
                c.name AS category_name,
                c.color AS category_color,
                c.icon AS category_icon,
                (e.capacity - e.available_spots) AS reserved_spots
            FROM events e
            LEFT JOIN categories c ON e.category_id = c.id
            WHERE e.status = 'published'
            AND e.date_start >= NOW()
        ";

        $bindings = [];

        if ($type && in_array($type, ['atelier', 'evenement'], true)) {
            $sql .= " AND e.type = :type";
            $bindings[':type'] = $type;
        }

        if ($categoryId) {
            $sql .= " AND e.category_id = :category_id";
            $bindings[':category_id'] = (int)$categoryId;
        }

        if ($filter === 'upcoming') {
            $sql .= " AND e.date_start >= NOW()";
        }

        $sql .= " ORDER BY e.date_start ASC";

        $data = $this->fetchAll($sql, $bindings);
        return $this->toEntities($data);
    }

    public function findById(int $id): ?EventEntity
    {
        $sql = "
            SELECT 
                e.*,
                c.name AS category_name,
                c.color AS category_color,
                c.icon AS category_icon
            FROM events e
            LEFT JOIN categories c ON e.category_id = c.id
            WHERE e.id = :id
        ";

        $data = $this->fetch($sql, [':id' => $id]);
        return $data ? $this->toEntity($data) : null;
    }

    public function incrementViews(int $eventId): bool
    {
        $sql = "UPDATE events SET views_count = views_count + 1 WHERE id = :id";
        return $this->executeTryCatch($sql, [':id' => $eventId]);
    }

    public function createFromEntity(EventEntity $event)
    {
        $sql = "
            INSERT INTO events (
                title, slug, type, description, short_description,
                date_start, date_end, duration, location, location_city,
                location_postal_code, is_online, online_link, capacity,
                available_spots, min_participants, price, currency,
                image, category_id, organizer_id, status, is_featured
            ) VALUES (
                :title, :slug, :type, :description, :short_description,
                :date_start, :date_end, :duration, :location, :location_city,
                :location_postal_code, :is_online, :online_link, :capacity,
                :available_spots, :min_participants, :price, :currency,
                :image, :category_id, :organizer_id, :status, :is_featured
            )
        ";

        if ($this->executeTryCatch($sql, $event->toArray())) {
            return $this->lastInsertId();
        }

        return false;
    }

    public function updateFromEntity(EventEntity $event): bool
    {
        $sql = "
            UPDATE events SET
                title = :title,
                slug = :slug,
                type = :type,
                description = :description,
                short_description = :short_description,
                date_start = :date_start,
                date_end = :date_end,
                duration = :duration,
                location = :location,
                location_city = :location_city,
                location_postal_code = :location_postal_code,
                is_online = :is_online,
                online_link = :online_link,
                capacity = :capacity,
                available_spots = :available_spots,
                min_participants = :min_participants,
                price = :price,
                currency = :currency,
                image = :image,
                category_id = :category_id,
                organizer_id = :organizer_id,
                status = :status,
                is_featured = :is_featured
            WHERE id = :id
        ";

        $data = $event->toArray();
        $data[':id'] = $event->getId();

        return $this->executeTryCatch($sql, $data);
    }

    // ============================================================
    // Alias controller-friendly
    // ============================================================
    public function getAllByType(string $type): array
    {
        return $this->getFilteredEvents($type, null, null);
    }

    public function getById(int $id): ?EventEntity
    {
        return $this->findById($id);
    }

    public function insert(EventEntity $event)
    {
        return $this->createFromEntity($event);
    }

    public function update(EventEntity $event): bool
    {
        return $this->updateFromEntity($event);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM events WHERE id = :id";
        return $this->executeTryCatch($sql, [':id' => $id]);
    }

    public function getAll(): array
    {
        $sql = "
            SELECT 
                e.*,
                c.name AS category_name,
                c.color AS category_color,
                c.icon AS category_icon
            FROM events e
            LEFT JOIN categories c ON e.category_id = c.id
            ORDER BY e.created_at DESC
        ";

        $data = $this->fetchAll($sql);
        return $this->toEntities($data);
    }
}
