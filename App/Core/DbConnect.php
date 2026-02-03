<?php

namespace App\Core;

use PDO;
use PDOException;

abstract class DbConnect
{
    protected $connection;
    protected $request;

    const SERVER = 'localhost';
    const USER = 'root';
    const PASSWORD = 'root';
    const BASE = 'plateforme-events';

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                'mysql:host=' . self::SERVER . ';dbname=' . self::BASE . ';charset=utf8',
                self::USER,
                self::PASSWORD
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            die('Erreur DB : ' . $e->getMessage());
        }
    }

    /**
     * Exécute une requête avec gestion d'erreur
     * PRIVÉE car usage interne uniquement
     */
    protected function executeTryCatch(string $sql, array $bindings = []): bool
    {
        try {
            $this->request = $this->connection->prepare($sql);
            
            foreach ($bindings as $key => $value) {
                $this->request->bindValue($key, $value);
            }
            
            return $this->request->execute();
            
        } catch (PDOException $e) {
            // Log l'erreur au lieu de crasher
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère tous les résultats
     */
    protected function fetchAll(string $sql, array $bindings = []): array
    {
        if ($this->executeTryCatch($sql, $bindings)) {
            return $this->request->fetchAll();
        }
        return [];
    }

    /**
     * Récupère un seul résultat
     */
    protected function fetch(string $sql, array $bindings = [])
    {
        if ($this->executeTryCatch($sql, $bindings)) {
            return $this->request->fetch();
        }
        return null;
    }

    /**
     * Alias pour fetch() - pour compatibilité
     */
    protected function fetchOne(string $sql, array $bindings = [])
    {
        return $this->fetch($sql, $bindings);
    }

    /**
     * Exécute une requête sans récupérer de résultats (INSERT/UPDATE/DELETE)
     */
    protected function execute(string $sql, array $bindings = []): bool
    {
        return $this->executeTryCatch($sql, $bindings);
    }

    /**
     * Exécute un INSERT et retourne l'ID inséré
     */
    protected function executeInsert(string $sql, array $bindings = []): ?int
    {
        if ($this->executeTryCatch($sql, $bindings)) {
            return (int)$this->lastInsertId();
        }
        return null;
    }

    /**
     * Récupère l'ID du dernier insert
     */
    protected function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Compte le nombre de lignes affectées
     */
    protected function rowCount(): int
    {
        return $this->request ? $this->request->rowCount() : 0;
    }
}