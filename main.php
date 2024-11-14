<?php
require_once 'Conta.php';

function listarPlanos($planos) {
    foreach ($planos as $index => $plano) {
        $index++;
        echo $index. "- Plano Tipo: " . $plano->getTipo() . PHP_EOL;
        echo $plano->listarCartoes() . PHP_EOL;
        echo "---------------------". PHP_EOL;
    }
}

function listarClientes($contas){
    foreach($contas as $conta){
        if ($conta->getTipo() === 'cliente'){
            echo (PHP_EOL. 'Id- '. $conta->getId(). PHP_EOL. 'Usuario- '. $conta->getNomeUsuario(). PHP_EOL. 'Plano- '. $conta->descricaoPlano().PHP_EOL);
        }
    }
}

function listarCartoes($cartoes){
    foreach ($cartoes as $index => $cartao) {
        $index++;
        echo $index. "- Cartão Tipo: " . $cartao->getTipo() . PHP_EOL;
        echo "---------------------". PHP_EOL;
    }
}

function retornarCartoes($valores, $cartoes) {
    $listaDeIndex = explode(' ', $valores);
    $listaDeCartoes = [];

    foreach ($cartoes as $indexCartao => $cartao) {
        foreach ($listaDeIndex as $index) {
            if ((int)$index == $indexCartao + 1) { 
                $listaDeCartoes[] = $cartao; 
            }
        }
    }

    return $listaDeCartoes;
}


function gerarId($contas){
    $id = 1;
    foreach($contas as $conta){
        $id++;
    }
    return $id;
}

function transferir($idContaQueTransfere, $idContaQueRecebe, $valor, $contas){
    foreach($contas as $conta){
        if ($conta->getId() == $idContaQueTransfere){
            $resultadoSaque = $conta->sacar($valor);
            if(!$resultadoSaque){
                return false;
            }
        }
    }
    foreach($contas as $conta){
        if ($conta->getId() == $idContaQueRecebe){
            $resultadoDeposito = $conta->depositar($valor);
            if($resultadoDeposito){
                return true;
            } else {
                return false;
            }
        }
    }
    return false;
}

function printarMenuInicial(){
    echo ('Menu: '. PHP_EOL. '1: Criar conta'. PHP_EOL. '2: Entar na conta'. PHP_EOL. '3: Sair'. PHP_EOL);
}

function criarConta($planos, $contas){
    echo (PHP_EOL. 'Criar conta: '. PHP_EOL. '1: Cliente'. PHP_EOL. '2: Gerente'. PHP_EOL);
    $resposta = readline('>');

    switch ($resposta){
        case 1: echo (PHP_EOL. 'Digite o nome do cliente:'.PHP_EOL);
                $nome = readline('>');
                echo (PHP_EOL. 'Digite o contato do cliente:'.PHP_EOL);
                $contato = readline('>');
                echo (PHP_EOL. 'Digite o CPF do cliente:'.PHP_EOL);
                $cpf = readline('>');
                echo (PHP_EOL. 'Digite o login do cliente:'.PHP_EOL);
                $login = readline('>');
                echo (PHP_EOL. 'Digite a senha do cliente:'.PHP_EOL);
                $senha = readline('>');
                echo (PHP_EOL. 'Digite o número do plano que deseja:'.PHP_EOL);
                listarPlanos($planos);
                $planoIndex = readline('>');
                $planoIndex--;
                $planoEscolhido = $planos[$planoIndex];
                $usuario = new Cliente($nome, $contato, $cpf);
                $id = gerarId($contas);
                $conta = new Conta($id, $usuario, $planoEscolhido, $login, $senha);
                return $conta;
                break;

        case 2: echo (PHP_EOL. 'Digite a senha de super usuario para criar um gerente:'.PHP_EOL);
                $superSenha = readline('>');
                if ($superSenha != 'abc123'){
                    break;
                }
                echo (PHP_EOL. 'Digite o nome do gerente:'.PHP_EOL);
                $nome = readline('>');
                echo (PHP_EOL. 'Digite o contato do gerente:'.PHP_EOL);
                $contato = readline('>');
                echo (PHP_EOL. 'Digite o CPF do gerente:'.PHP_EOL);
                $cpf = readline('>');
                echo (PHP_EOL. 'Digite o login do gerente:'.PHP_EOL);
                $login = readline('>');
                echo (PHP_EOL. 'Digite a senha do gerente:'.PHP_EOL);
                $senha = readline('>');
                $usuario = new Gerente($nome, $contato, $cpf);
                $id = gerarId($contas);
                $conta = new Conta($id, $usuario, null, $login, $senha);
                return $conta;
                break;

        default: echo 'Opção invalida';
                 break;
    }
}

function entrarNaConta($contas) {
    echo (PHP_EOL . 'Digite seu login:' . PHP_EOL);
    $login = readline('>');
    
    echo (PHP_EOL . 'Digite sua senha:' . PHP_EOL);
    $senha = readline('>');

    foreach ($contas as $conta) {
        if ($conta->getLogin() === $login && $conta->getSenha() === $senha) {
            echo (PHP_EOL . 'Login bem-sucedido!' . PHP_EOL);
            return $conta;
        }
    }

    echo (PHP_EOL . 'Login ou senha inválidos!' . PHP_EOL);
    return null;
}

function contaAcessada($conta, &$contas, &$planos, &$cartoes){
    if($conta->getTipo() === 'cliente'){
        echo (PHP_EOL. 'Selecione a opção desejada: '. PHP_EOL. '1: Ver saldo'. PHP_EOL. '2: Sacar'. PHP_EOL. '3: Depositar'. PHP_EOL. '4: Trasferir'. PHP_EOL. '5: Ver meus dados'. PHP_EOL. '6: Alterar plano'. PHP_EOL. '7: Encerrar seção'. PHP_EOL);
        $resposta = readline('>');

        switch ($resposta){
            case 1: echo (PHP_EOL. 'O seu saldo é de: R$'. $conta->getSaldo() .PHP_EOL);
            return true;
                    break;

            case 2: echo (PHP_EOL. 'Digite o valor que deseja sacar:' .PHP_EOL);
                    $valor = readline('>');
                    $resultadoDaOperacao = $conta->sacar($valor);
                    if($resultadoDaOperacao){
                        echo (PHP_EOL.'Saque realizado!'. PHP_EOL);
                    } else {
                        echo (PHP_EOL.'Ocorreu um erro ao sacar, tente novamente!'. PHP_EOL);
                    }
                    return true;
                    break;

            case 3: echo (PHP_EOL. 'Digite o valor que deseja depositar:' .PHP_EOL);
                    $valor = readline('>');
                    $resultadoDaOperacao = $conta->depositar($valor);
                    if($resultadoDaOperacao){
                        echo (PHP_EOL.'Deposito realizado!'. PHP_EOL);
                    } else {
                        echo (PHP_EOL.'Ocorreu um erro ao depositar, tente novamente!'. PHP_EOL);
                    }
                    return true;
                    break;

            case 4: echo (PHP_EOL. 'Digite o id da conta que deseja tranferir:' .PHP_EOL);
                    $id = readline('>');
                    echo (PHP_EOL. 'Digite o valor que deseja trasferir:' .PHP_EOL);
                    $valor = readline('>');
                    $resultadoDaOperacao = transferir($conta->getId(), $id, $valor, $contas);
                    if($resultadoDaOperacao){
                        echo (PHP_EOL.'Transferencia realizada!'. PHP_EOL);
                    } else {
                        echo (PHP_EOL.'Ocorreu um erro ao tranferir, tente novamente!'. PHP_EOL);
                    }
                    return true;
                    break;

            case 5: echo (PHP_EOL. 'Id- '. $conta->getId(). PHP_EOL. 'Usuario- '. $conta->getNomeUsuario(). PHP_EOL. 'Plano- '. $conta->descricaoPlano().PHP_EOL. 'Tipo de conta- '. $conta->getTipo(). PHP_EOL);
            return true;
                    break;
            
                    
            case 6: echo (PHP_EOL. 'Seu plano atual é: '. $conta->descricaoPlano(). PHP_EOL. PHP_EOL. 'Digite o número do seu novo plano:'.PHP_EOL);
                    listarPlanos($planos);
                    $planoIndex = readline('>');
                    $planoIndex--;
                    $planoEscolhido = $planos[$planoIndex];
                    $conta->setPlano($planoEscolhido);
                    echo (PHP_EOL. 'Seu novo plano é: '. $conta->descricaoPlano(). PHP_EOL);
                    return true;
                    break;

            case 7: return false;
                    break;
            
            default: echo (PHP_EOL.'Opção inavlida'.PHP_EOL);
                     return true;
                     break;
        }
    } else if($conta->getTipo() === 'gerente'){
        echo (PHP_EOL. 'Selecione a opção desejada: '. PHP_EOL. '1: Ver clientes'. PHP_EOL. '2: Adicionar plano'. PHP_EOL. '3: Adicionar cartão'. PHP_EOL. '4: Ver planos'. PHP_EOL. '5: Ver cartões'. PHP_EOL. '6: Encerrar seção'. PHP_EOL);
        $resposta = readline('>');

        switch ($resposta){
            case 1: listarClientes($contas);
                    return true;
                    break;

            case 2: echo (PHP_EOL. 'Digite o nome do plano: '. PHP_EOL);
                    $nomePlano = readline('>');
                    echo(PHP_EOL. 'Digite o número do cartão que deseja adicionar no plano, se for mais de um cartão separe os numeros por espaço:'. PHP_EOL);
                    listarCartoes($cartoes);
                    $numerosCartao = readline('>');
                    $cartoesDoPlano = retornarCartoes($numerosCartao, $cartoes);
                    $plano = new Plano($nomePlano, $cartoesDoPlano);
                    $planos[] = $plano;
                    return true;
                    break;

            case 3: echo (PHP_EOL. 'Digite o tipo de cartão: '. PHP_EOL);
                    $tipoCartao = readline('>');
                    $cartao = new Cartao($tipoCartao);
                    $cartoes[] = $cartao;
                    return true;
                    break;

            case 4: echo PHP_EOL;
                    listarPlanos($planos);
                    return true;
                    break;

            case 5: echo PHP_EOL;
                    listarCartoes($cartoes);
                    return true;
                    break;

            case 6: return false;

            default: echo (PHP_EOL. 'Opção invalida'. PHP_EOL);
                    return true;
        }
    }
}


$planos = [];
$cartoes = [];

$cartao1 = new Cartao("Crédito");
$cartao2 = new Cartao("Débito");
$cartao3 = new Cartao("Fidelidade");

$cartoes[] = $cartao1;
$cartoes[] = $cartao2;
$cartoes[] = $cartao3;

$plano1 = new Plano("Premium", [$cartao2, $cartao1, $cartao3]);
$plano2 = new Plano("Intermediário", [$cartao2, $cartao1]);
$plano3 = new Plano("Básico", [$cartao2]);


$planos[] = $plano3;
$planos[] = $plano2;
$planos[] = $plano1;

$contas = [];

$gerente = new Gerente("João", 123456789, "123.456.789-00");
$cliente1 = new Cliente("Maria", 987654321, "987.654.321-00");
$cliente2 = new Cliente("José", 112233445, "112.233.445-00");

$conta1 = new Conta(1, $gerente, null, 'loginGerente', 'senhaGerente');
$conta2 = new Conta(2, $cliente1, $plano2, 'loginMaria', 'senhaMaria');
$conta3 = new Conta(3, $cliente2, $plano3, 'loginJose', 'senhaJose');

$contas[] = $conta1;
$contas[] = $conta2;
$contas[] = $conta3;

$ativo = true;

while($ativo){
    printarMenuInicial();
    $resposta = readline('>');

    switch ($resposta){
        case 1: $contas[] = criarConta($planos, $contas);
                break;

        case 2: $contaAtiva = entrarNaConta($contas);
                $contaEmAcesso = true;
                while($ativo && $contaAtiva != null && $contaEmAcesso){
                $contaEmAcesso = contaAcessada($contaAtiva, $contas, $planos, $cartoes);
                }
                break;

        case 3: $ativo = false;
                break;

        default: echo 'Opção invalida';
                 break;
    }
}