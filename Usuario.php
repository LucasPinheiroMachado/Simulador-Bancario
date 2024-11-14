<?php

class Usuario{
    private string $nome;
    private int $contato;
    private string $cpf;

    public function __construct(string $nome, int $contato, string $cpf) {
        $this->nome = $nome;
        $this->contato = $contato;
        $this->cpf = $cpf;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getContato(): int {
        return $this->contato;
    }

    public function setContato(int $contato): void {
        $this->contato = $contato;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void {
        $this->cpf = $cpf;
    }
}