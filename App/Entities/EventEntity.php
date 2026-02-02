<?php

namespace App\Entities;

class EventEntity
{
    // ========================================
    // PROPRIÉTÉS
    // ========================================
    
    private ?int $id = null;
    private ?string $title = null;
    private ?string $slug = null;
    private ?string $type = null;
    private ?string $description = null;
    private ?string $shortDescription = null;
    private ?string $dateStart = null;
    private ?string $dateEnd = null;
    private ?int $duration = null;
    private ?string $location = null;
    private ?string $locationCity = null;
    private ?string $locationPostalCode = null;
    private bool $isOnline = false;
    private ?string $onlineLink = null;
    private int $capacity = 20;
    private int $availableSpots = 20;
    private int $minParticipants = 1;
    private float $price = 0.00;
    private string $currency = 'EUR';
    private ?string $image = null;
    private ?int $categoryId = null;
    private ?int $organizerId = null;
    private string $status = 'draft';
    private bool $isFeatured = false;
    private int $viewsCount = 0;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    // Relations (données jointes)
    private ?string $categoryName = null;
    private ?string $categoryColor = null;
    private ?string $categoryIcon = null;

    // ========================================
    // GETTERS
    // ========================================
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function getDateStart(): ?string
    {
        return $this->dateStart;
    }

    public function getDateEnd(): ?string
    {
        return $this->dateEnd;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getLocationCity(): ?string
    {
        return $this->locationCity;
    }

    public function getLocationPostalCode(): ?string
    {
        return $this->locationPostalCode;
    }

    public function isOnline(): bool
    {
        return $this->isOnline;
    }

    public function getOnlineLink(): ?string
    {
        return $this->onlineLink;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getAvailableSpots(): int
    {
        return $this->availableSpots;
    }

    public function getMinParticipants(): int
    {
        return $this->minParticipants;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getOrganizerId(): ?int
    {
        return $this->organizerId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isFeatured(): bool
    {
        return $this->isFeatured;
    }

    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    // Relations
    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function getCategoryColor(): ?string
    {
        return $this->categoryColor;
    }

    public function getCategoryIcon(): ?string
    {
        return $this->categoryIcon;
    }

    // ========================================
    // SETTERS
    // ========================================
    
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function setType(?string $type): self
    {
        if ($type && !in_array($type, ['atelier', 'evenement'])) {
            throw new \InvalidArgumentException("Type invalide. Valeurs acceptées : 'atelier', 'evenement'");
        }
        $this->type = $type;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function setDateStart(?string $dateStart): self
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function setDateEnd(?string $dateEnd): self
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function setLocationCity(?string $locationCity): self
    {
        $this->locationCity = $locationCity;
        return $this;
    }

    public function setLocationPostalCode(?string $locationPostalCode): self
    {
        $this->locationPostalCode = $locationPostalCode;
        return $this;
    }

    public function setIsOnline(bool $isOnline): self
    {
        $this->isOnline = $isOnline;
        return $this;
    }

    public function setOnlineLink(?string $onlineLink): self
    {
        $this->onlineLink = $onlineLink;
        return $this;
    }

    public function setCapacity(int $capacity): self
    {
        if ($capacity < 1) {
            throw new \InvalidArgumentException("La capacité doit être au moins 1");
        }
        $this->capacity = $capacity;
        return $this;
    }

    public function setAvailableSpots(int $availableSpots): self
    {
        if ($availableSpots < 0) {
            throw new \InvalidArgumentException("Les places disponibles ne peuvent pas être négatives");
        }
        $this->availableSpots = $availableSpots;
        return $this;
    }

    public function setMinParticipants(int $minParticipants): self
    {
        if ($minParticipants < 1) {
            throw new \InvalidArgumentException("Le minimum de participants doit être au moins 1");
        }
        $this->minParticipants = $minParticipants;
        return $this;
    }

    public function setPrice(float $price): self
    {
        if ($price < 0) {
            throw new \InvalidArgumentException("Le prix ne peut pas être négatif");
        }
        $this->price = $price;
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function setCategoryId(?int $categoryId): self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function setOrganizerId(?int $organizerId): self
    {
        $this->organizerId = $organizerId;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $validStatuses = ['draft', 'published', 'cancelled', 'completed'];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException("Statut invalide. Valeurs acceptées : " . implode(', ', $validStatuses));
        }
        $this->status = $status;
        return $this;
    }

    public function setIsFeatured(bool $isFeatured): self
    {
        $this->isFeatured = $isFeatured;
        return $this;
    }

    public function setViewsCount(int $viewsCount): self
    {
        $this->viewsCount = $viewsCount;
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

    // Relations setters
    public function setCategoryName(?string $categoryName): self
    {
        $this->categoryName = $categoryName;
        return $this;
    }

    public function setCategoryColor(?string $categoryColor): self
    {
        $this->categoryColor = $categoryColor;
        return $this;
    }

    public function setCategoryIcon(?string $categoryIcon): self
    {
        $this->categoryIcon = $categoryIcon;
        return $this;
    }

    // ========================================
    // MÉTHODES UTILITAIRES
    // ========================================
    
    /**
     * Hydrate l'entité depuis un objet ou tableau
     */
    public function hydrate($data): self
    {
        if (is_array($data)) {
            $data = (object) $data;
        }

        $this->id = $data->id ?? null;
        $this->title = $data->title ?? null;
        $this->slug = $data->slug ?? null;
        $this->type = $data->type ?? null;
        $this->description = $data->description ?? null;
        $this->shortDescription = $data->short_description ?? null;
        $this->dateStart = $data->date_start ?? null;
        $this->dateEnd = $data->date_end ?? null;
        $this->duration = $data->duration ?? null;
        $this->location = $data->location ?? null;
        $this->locationCity = $data->location_city ?? null;
        $this->locationPostalCode = $data->location_postal_code ?? null;
        $this->isOnline = (bool)($data->is_online ?? false);
        $this->onlineLink = $data->online_link ?? null;
        $this->capacity = (int)($data->capacity ?? 20);
        $this->availableSpots = (int)($data->available_spots ?? 20);
        $this->minParticipants = (int)($data->min_participants ?? 1);
        $this->price = (float)($data->price ?? 0.00);
        $this->currency = $data->currency ?? 'EUR';
        $this->image = $data->image ?? null;
        $this->categoryId = $data->category_id ?? null;
        $this->organizerId = $data->organizer_id ?? null;
        $this->status = $data->status ?? 'draft';
        $this->isFeatured = (bool)($data->is_featured ?? false);
        $this->viewsCount = (int)($data->views_count ?? 0);
        $this->createdAt = $data->created_at ?? null;
        $this->updatedAt = $data->updated_at ?? null;

        // Relations
        $this->categoryName = $data->category_name ?? null;
        $this->categoryColor = $data->category_color ?? null;
        $this->categoryIcon = $data->category_icon ?? null;

        return $this;
    }

    /**
     * Convertit l'entité en tableau pour l'insertion/update en BDD
     */
    public function toArray(): array
    {
        return [
            ':title' => $this->title,
            ':slug' => $this->slug,
            ':type' => $this->type,
            ':description' => $this->description,
            ':short_description' => $this->shortDescription,
            ':date_start' => $this->dateStart,
            ':date_end' => $this->dateEnd,
            ':duration' => $this->duration,
            ':location' => $this->location,
            ':location_city' => $this->locationCity,
            ':location_postal_code' => $this->locationPostalCode,
            ':is_online' => (int)$this->isOnline,
            ':online_link' => $this->onlineLink,
            ':capacity' => $this->capacity,
            ':available_spots' => $this->availableSpots,
            ':min_participants' => $this->minParticipants,
            ':price' => $this->price,
            ':currency' => $this->currency,
            ':image' => $this->image,
            ':category_id' => $this->categoryId,
            ':organizer_id' => $this->organizerId,
            ':status' => $this->status,
            ':is_featured' => (int)$this->isFeatured,
        ];
    }

    /**
     * Vérifie si l'événement a des places disponibles
     */
    public function hasAvailableSpots(): bool
    {
        return $this->availableSpots > 0;
    }

    /**
     * Calcule le taux de remplissage
     */
    public function getFillRate(): float
    {
        if ($this->capacity === 0) {
            return 0;
        }
        return (($this->capacity - $this->availableSpots) / $this->capacity) * 100;
    }

    /**
     * Formate la date de début
     */
    public function getFormattedDateStart(string $format = 'd/m/Y'): ?string
    {
        if (!$this->dateStart) {
            return null;
        }
        return date($format, strtotime($this->dateStart));
    }

    /**
     * Formate l'heure de début
     */
    public function getFormattedTimeStart(string $format = 'H:i'): ?string
    {
        if (!$this->dateStart) {
            return null;
        }
        return date($format, strtotime($this->dateStart));
    }

    /**
     * Vérifie si l'événement est gratuit
     */
    public function isFree(): bool
    {
        return $this->price == 0;
    }

    /**
     * Retourne le prix formaté
     */
    public function getFormattedPrice(): string
    {
        if ($this->isFree()) {
            return 'Gratuit';
        }
        return number_format($this->price, 2) . ' ' . $this->currency;
    }
}