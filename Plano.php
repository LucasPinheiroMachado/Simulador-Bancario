<?php
require_once 'Cartao.php';

class Plano {
    private string $tipo;
    private array $cartoes = []; 

    public function __construct(string $tipo, array $cartoes) {
        $this->tipo = $tipo;
        $this->cartoes = $cartoes;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function setTipo(string $tipo): void {
        $this->tipo = $tipo;
    }

    public function adicionarCartao(Cartao $cartao): void {
        $this->cartoes[] = $cartao;
    }

    public function getCartoes(): array {
        return $this->cartoes;
    }

    public function listarCartoes(): void {
        foreach ($this->cartoes as $cartao) {
            echo "Cartão Tipo: " . $cartao->getTipo() . PHP_EOL;
        }
    }
}