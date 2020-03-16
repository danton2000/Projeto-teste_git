<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/Aula02.03/crud-1/model/conexao.class.php");

class Crud extends Conexao {
    private $tabela; 

    public function __construct($tabela){        
        $this->conexao();	
        $this->tabela = $tabela;
    }

    public function insereCrud($array_dados) {        
        foreach($array_dados as $indice => $valor){
            $colunas[] = $indice;
            $marcacao[] = ":" . $indice;
        }
        $sql = "INSERT INTO {$this->tabela} (" . join(",", $colunas) . ") VALUES (" . join(",", $marcacao) . ")";
        $query = $this->conn->prepare($sql);     
        $query->execute($array_dados);
        if($query->rowCount() > 0){
            $id = $this->conn->lastInsertId();
            return $id;
        }else{
            return false;
        }
        $this->conn->close();
    }   

    public function selectCrud($colunas, $where = false, $array_dados = null, $operador = "=") {        
        if ($where) {            
            foreach($array_dados as $indice => $valor){
                $filtro[] = $indice . " " . $operador . " :" . $indice;
            }
            $sql = "SELECT {$colunas} FROM {$this->tabela} WHERE " . join(" AND ", $filtro);
            #echo "<p>$sql</p>";
            $query = $this->conn->prepare($sql);
            $query->execute($array_dados); 
        } else {
            $sql = "SELECT {$colunas} FROM {$this->tabela}";
            $query = $this->conn->prepare($sql);
            $query->execute();
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
            
        $this->conn->close();  
    }   

    public function atualizaCrud($array_dados, $array_id) {
        foreach($array_dados as $indice => $valor){
            $dados[] = $indice . " = :" . $indice;
        }
        foreach($array_id as $indice => $valor){
            $id[] = $indice . " = :" . $indice;
        }
        $sql = "UPDATE {$this->tabela} SET " . join(",", $dados) . " WHERE " . join(" = ", $id);
        $query = $this->conn->prepare($sql);     
        $query->execute(array_merge($array_dados, $array_id));
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        $this->conn->close();
    }

    public function excluiCrud($array_id) {
        foreach($array_id as $indice => $valor){
            $id[] = $indice . " = :" . $indice;
        }
        $sql = "DELETE FROM {$this->tabela} WHERE " . join(" = ", $id);      
        $query = $this->conn->prepare($sql);     
        $query->execute($array_id);
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        $this->conn->close();
    }

    
}

/*
# INSERT
$array_usuario = array(
    "nome" => "Fulano",
    "sobrenome" => "Silva",
    "email" => "beltrano@gmail.com",
    "senha" => Crud::criptoSenha("senacrs"),
    "data_nasc" => "2000/06/12"
);

$usuario = new Crud("usuario");
$resposta = $usuario->insereCrud($array_usuario);
if ($resposta) {
    echo "Usuário cadastrado com sucesso! <br>";

    $array_endereco = array(
        "logradouro" => "Rua Venâncio Aires 414",
        "estado" => "RS",
        "cep" => "91571230",
        "pais" => "Brasil",
        "complemento" => "",
        "tel_residencial" => "",
        "tel_celular" => "999999999999",
        "id_usuario" => $resposta
    );
    $endereco = new Crud("endereco");
    $resposta = $endereco->insereCrud($array_endereco);

    if ($resposta) {
        echo "Endereço cadastrado com sucesso! <br>";        
    } else {
        echo "Erro ao cadastrar endereco!";
    }

} else {
    echo "Erro ao inserir usuário!";
}


#####################################################
echo "<h1>SELECT GENÉRICO</h1>";
$usuario = new Crud("usuario");
$resposta = $usuario->selectCrud("*");
echo "<pre>";
print_r($resposta);
echo "</pre>";

echo "<h1>SELECT COM WHERE</h1>";
$usuario = new Crud("usuario");
$array_where = array(
    "email" => "fulano@gmail.com"
);
$resposta = $usuario->selectCrud("*", true, $array_where);
echo "<pre>";
print_r($resposta);
echo "</pre>";

echo "<h1>SELECT COM WHERE E LIKE</h1>";
$usuario = new Crud("usuario");
$array_where = array(
    "email" => "%gmail.com%"
);
$resposta = $usuario->selectCrud("*", true, $array_where, "like");
echo "<pre>";
print_r($resposta);
echo "</pre>";

echo "<h1>SELECT COM WHERE > </h1>";
$usuario = new Crud("usuario");
$array_where = array(
    "data_nasc" => "2000/06/11"
);
$resposta = $usuario->selectCrud("*", true, $array_where, ">");
echo "<pre>";
print_r($resposta);
echo "</pre>";

# EXEMPLO DE LOGIN
echo "<h1>EXEMPLO DE LOGIN</h1>";
$usuario = new Crud("usuario");
$array_where = array(
    "email" => "beltrano@gmail.com",
    "senha" => Crud::criptoSenha("senacrs2")
);
$resposta = $usuario->selectCrud("*", true, $array_where);
if ($resposta) {
    echo "Logado <br>";
} else {
    echo "Login ou senha incorretos <br>";
}

#####################################################
# UPDATES
$usuario = new Crud("usuario");
$array_dados = array(
    "data_nasc" => "1996/02/04"
);
$array_id = array(
    "id_usuario" => 8
);
$resposta = $usuario->atualizaCrud($array_dados, $array_id);
if ($resposta) {
    echo "Usuario atualizado com sucesso! <br>";        
} else {
    echo "O usuário não sofreu alterações! <br>";
}

$endereco = new Crud("endereco");
$array_dados = array(
    "pais" => "Portugal"
);
$array_id = array(
    "id_usuario" => 7
);
$resposta = $endereco->atualizaCrud($array_dados, $array_id);
if ($resposta) {
    echo "Endereco atualizado com sucesso! <br>";        
} else {
    echo "O Endereco não sofreu alterações! <br>";
}

#####################################################
# DELETE

$endereco = new Crud("endereco");
$array_id = array(
    "id_usuario" => 7
);
$resposta = $endereco->excluiCrud($array_id);
if ($resposta) {
    echo "Endereco excluído com sucesso! <br>";        
} else {
    echo "O Endereco não pode ser excluído! <br>";
}

$usuario = new Crud("usuario");
$array_id = array(
    "id_usuario" => 7
);
$resposta = $usuario->excluiCrud($array_id);
if ($resposta) {
    echo "Usuario excluído com sucesso! <br>";        
} else {
    echo "O Usuario não pode ser excluído! <br>";
}


##########################################
*/
