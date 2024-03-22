<?php
namespace App\Repository;

use App\Database\Database;
use App\Model\Cliente;
use PDO;

class ClienteRepository {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function insert(Cliente $c) {
        $query = $this->conn->prepare("INSERT INTO clientes (nome, email, cidade, estado) VALUES (:nome, :email, :cidade, :estado)");
        $query->bindParam(":nome", $c->getNome());
        $query->bindParam(":email", $c->getEmail());
        $query->bindParam(":cidade", $c->getCidade());
        $query->bindParam(":estado", $c->getEstado());
        $query->execute();
        $c->setId($this->conn->lastInsertId());
        return $c;
    }

    public function find() {
        $query = $this->conn->prepare("SELECT * FROM clientes");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id) {
        $query = $this->conn->prepare("SELECT * FROM clientes WHERE cliente_id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function update(Cliente $c) {
        $query = $this->conn->prepare("UPDATE clientes SET nome = :nome, email = :email, cidade = :cidade, estado = :estado WHERE cliente_id = :id");
        $query->bindParam(":nome", $c->getNome());
        $query->bindParam(":email", $c->getEmail());
        $query->bindParam(":cidade", $c->getCidade());
        $query->bindParam(":estado", $c->getEstado());
        $query->bindParam(":id", $c->getId());
        $query->execute();
    }

    public function delete(int $id) {
        $query = $this->conn->prepare("DELETE FROM clientes WHERE cliente_id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
    }
}