<?php
    require("config.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda de contatos</title>
    </head>
    <body>
        <form action="?act=save" method="POST" name="form1" >
          <h1>Agenda de contatos</h1>
          <hr>
          <input type="hidden" name="id" <?php 
            // preenche o id no campo id com um valor "value"
            if (isset($id) && $id != null || $id != "") {
                echo "value=\"{$id}\"";
            }
          ?>/>
          Nome:
          <input type="text" name="nome" <?php 
            // preenche o nome no campo nome com um valor "value"
            if (isset($nome) && $nome != null || $nome != "") {
                echo "value=\"{$nome}\"";
            }
          ?>/> 
          E-mail:
          <input type="text" name="email" <?php 
            //preenche o email no campo email com um valor "value"
            if (isset($email) && $email != null || $email != "") {
                echo "value=\"{$email}\"";
            }
          ?>/>
            
          Celular:
         <input type="text" name="celular" <?php 
            // preenche o celular no campo celular com um valor "value"
            if (isset($celular) && $celular != null || $celular != "") {
                echo "value=\"{$celular}\"";
            }
         ?>/>
         <input type="submit" value="salvar" />
         <input type="reset" value="Novo" />
         <hr>
       </form>
        <table border="1" width="100%">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Celular</th>
                <th>Ações</th>
            </tr>
            <?php
                try {
                    $stmt = $conexao->prepare("SELECT * FROM contatos");

                    if($stmt->execute()) {
                        while($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo 
                                "<td>" . $rs->nome . "</td>
                                <td>" . $rs->email . "</td> 
                                <td>" . $rs->celular . "</td>
                                <td><center><a href=\"?act=upd&id=" . $rs->id . "\">[Alterar]</a>"
                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                . "<a href=\" ?act=del&id=" . $rs->id . "\">[Excluir]</a></center></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Erro: Não foi possível recuperar os dados do banco de dados";
                    }
                } catch (PDOException $erro){
                    echo "Erro: " . $erro->getMessage();
                }
            ?>
        </table>
    </body>
</html>