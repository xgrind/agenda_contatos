<?php

// Verificar se foi enviando dados via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
        $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
        $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
        $celular = (isset($_POST["celular"]) && $_POST["celular"] != null) ? $_POST["celular"] : NULL;
    } else if (!isset($id)) {
        // Se não se não foi setado nenhum valor para variável $id
        $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
        $nome = NULL;
        $email = NULL;
        $celular = NULL;
    }

    try {
        $conexao = new PDO("mysql:host=localhost; dbname=crudsimples", "root", "");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexao->exec("set names utf8");
    } catch (PODException $erro) {
        echo "Erro na conexão: " . $erro->getMessage();
    }

    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
        try {
            if ($id != "") {
                $stmt = $conexao->prepare("UPDATE contatos SET nome=?, email=?, celular=? WHERE id = ?");
                $stmt->bindParam(4, $id);                
            } else {
                $stmt = $conexao->prepare("INSERT INTO contatos (nome, email, celular) VALUES (?, ?, ?)");
            }
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $celular);
             
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    echo "Dados cadastrados com sucesso!";
                    $id = null;
                    $nome = null;
                    $email = null;
                    $celular = null;
                } else {
                    echo "Erro ao tentar efetivar cadastro";
                }
            } else {
                   throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }

    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
        try {
            $stmt = $conexao->prepare("SELECT * FROM contatos WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $rs = $stmt->fetch(PDO::FETCH_OBJ);
                $id = $rs->id;
                $nome = $rs->nome;
                $email = $rs->email;
                $celular = $rs->celular;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
        try {
            $stmt = $conexao->prepare("DELETE FROM contatos WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "Registo foi excluído com êxito";
                $id = null;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }
    

?>