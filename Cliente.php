<?php
require_once 'Usuario.php';

class Cliente extends Usuario{
    private string $tipo = 'Cliente';
    private bool $permicaoEspecial = false;

    public function getTipo(): string {
        return $this->tipo;
    }
    public function getPermicaoEspecial(): bool {
        return $this->permicaoEspecial;
    }
}