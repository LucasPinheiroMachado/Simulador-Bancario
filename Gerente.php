<?php
require_once 'Usuario.php';

class Gerente extends Usuario{
    private string $tipo = 'gerente';
    private bool $permicaoEspecial = true;

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getPermicaoEspecial(): bool {
        return $this->permicaoEspecial;
    }
}