<?php
require_once 'Gerente.php';
require_once 'Cliente.php';
require_once 'Plano.php';

class Conta {
    private int $id;
    private Gerente|Cliente $usuario;
    private Plano $plano;
    private string $login;
    private string $senha;
    private float $saldo = 0.0;

    public function __construct(int $id, Gerente|Cliente $usuario, Plano $plano = null, string $login, string $senha) {
        $this->id = $id;
        $this->usuario = $usuario;
        if ($plano != null) {
            $this->plano = $plano;
        }
        $this->login = $login;
        $this->senha = $senha;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsuario(): Gerente|Cliente {
        return $this->usuario;
    }

    public function setUsuario(Gerente|Cliente $usuario): void {
        $this->usuario = $usuario;
    }

    public function getPlano(): Plano {
        return $this->plano;
    }

    public function setPlano(Plano $plano): void {
        $this->plano = $plano;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function setLogin(string $login): void {
        $this->login = $login;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public function setSenha(string $senha): void {
        $this->senha = $senha;
    }

    public function getTipo() {
        return $this->usuario->getTipo();
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): void {
        $this->saldo = $saldo;
    }

    public function sacar(float $valor): bool {
        if (!is_numeric($valor)) {
            return false;
        }
        if($this->saldo >= $valor){
            $this->saldo -= $valor;
            return true;
        } else {
            return false;
        }
    }

    public function depositar(float $valor): bool {
        if (!is_numeric($valor)) {
            return false;
        }
            $this->saldo += $valor;
            return true;
    }

    public function descricaoPlano(): string {
        if (!$this->plano) {
            return "Nenhum plano associado.";
        }
        
        $descricao = $this->plano->getTipo() . PHP_EOL;
        $descricao .= "Cartões do Plano- ";
    
        foreach ($this->plano->getCartoes() as $cartao) {
            $descricao .= ' | '. $cartao->getTipo() . ' | ';
        }
    
        return $descricao;
    }
    public function getNomeUsuario(): string {
        return $this->usuario->getNome();
    }
}