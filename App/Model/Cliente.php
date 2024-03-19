<?php
namespace App\Model;
class Cliente {
    private int id;
    private string nome;
    private string email;
    private string cidade;
    private string estado;

    // Getters e setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCidade(): string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    // Métodos
    public function __construct(int $id, string $nome, string $email, string $cidade, string $estado)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->cidade = $cidade;
        $this->estado = $estado;
    }
}