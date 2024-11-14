<?php

class Cartao {
    private string $tipo;

    public function __construct(string $tipo) {
        $this->tipo = $tipo;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function setTipo(string $tipo): void {
        $this->tipo = $tipo;
    }
}