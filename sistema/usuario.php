<?php include_once('superior.php');
require 'src/conecta.php';


$cod =  $_SESSION['user']['id'];


if($_SESSION['user']['permission'] == 0)
    $permissao = "Usuário";
else if ($_SESSION['user']['permission'] == 1)
    $permissao = "Gerente";
else
    $permissao = "Administrador";


$cSql = "SELECT * FROM USUARIO WHERE USR_COD = ".$cod;


$dataSet = mysqli_query($conecta, $cSql);

if($oDados = mysqli_fetch_assoc($dataSet)){
    $SENHA =  $oDados['USR_SENHA'];
    $EMAIL =  $oDados['USR_EMAIL'];
    $STATUS = $oDados['USR_STATUS'];
}


if($STATUS == 1)
    $STATUS = "Ativo";
else
    $STATUS = "Inativo";
mysqli_free_result($dataSet);
mysqli_close($conecta);

if ($permissao != 'Administrador'){
    echo '
    <script src="js/jquery-3.2.1.js" type="text/javascript">   </script>
<script>
    
    $(document).ready(function
        () {
            $("#rowEmpresa").remove();
            $("#rowAdminstrador").remove();
            $("#rowConta").remove();
        });
    </script>

';
}

?>





<div class="content">

    <div class="container-fluid" >

        <div class="row">
           <div class="col-lg-4 col-md-5">
            <div class="card card-user" style=" height:295px">
                <div class="image">
                    <img src="assets/img/background.jpg" alt="..."/>
                </div>
                <div class="content">
                    <div class="author">
                      <img class="avatar border-white" src="assets/img/faces/beards.png" alt="..."/>
                      <h4 class="title"><?php echo $_SESSION['user']['name']?></h4>
                  </div>
                  <p class="description text-center"><?php echo $permissao;?></p>
              </div>

          </div>
      </div>
      <!-- Fim Perfil Esquerda -->

      <!-- Perfil Cadastro -->
      <div class="col-lg-8 col-md-7">
        <div class="card">
            <div class="header">
                <h4 class="title">Editar Perfil</h4>
            </div>

            <div class="content">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control border-input" value = "<?php echo $_SESSION['user']['name']?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Login</label>
                                <input type="text" class="form-control border-input"  value = "<?php echo $_SESSION['user']['username']?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Senha</label>
                                <input type="password" class="form-control border-input" value = "<?php echo $SENHA?>" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control border-input"  value = "<?php echo $EMAIL?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Permissão</label>
                                <input type="text" class="form-control border-input" value = "<?php echo $permissao?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control border-input" value="<?php echo $STATUS?>" >
                            </div>
                        </div>
                    </div>
                </form>




                <div class="text-center">
                    <button type="submit" class="btn btn-info btn-fill btn-wd">Atualizar</button>
                    <br>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>  

    </div> <!-- Fim Form Perfil -->

</div> <!-- Fim ROW Conjunto perfil -->



<div class="row" id="rowEmpresa"> <!-- ROW EMPRESA -->

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Empresa / Perfil</h4>
            </div>
            <div class="content">
                <form>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control border-input"  placeholder="Pessoal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CNPJ</label>
                                <input type="text" class="form-control border-input" placeholder="04.666.666/00001-6">
                            </div>
                        </div>

                    </div>
                    
                    <table class="table table-bordered table-striped text-center " width="100%" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th>Ações</th>

                            </tr>
                        </thead>

                        <tbody>

                            <?php

                            require 'src/conecta.php';

                            
                            $cSql = "SELECT EMP_COD, EMP_NOME_EMPRESA, EMP_CNPJ FROM USUARIO INNER JOIN USR_EMPR ON USUARIO.USR_COD = USR_EMPR.COD_USR INNER JOIN EMPRESA ON 
                            EMPRESA.EMP_COD = USR_EMPR.COD_EMPR WHERE COD_USR = ".$cod;


                            $dataSet = mysqli_query($conecta, $cSql);

                            while($oDados = mysqli_fetch_assoc($dataSet)){
                                echo "

                                <tr>
                                <td>".$oDados['EMP_COD']."</td>
                                <td>".$oDados['EMP_NOME_EMPRESA']."</td>
                                <td>".$oDados['EMP_CNPJ']."</td>
                                <td><button class = 'btn' id = '".$oDados['EMP_COD']."' onclick = 'alert(this.id)'>Alterar</button></td>
                                </tr>
                                ";

                            }

                            mysqli_free_result($dataSet);
                            mysqli_close($conecta);  


                            ?>

                        </tbody>
                    </table>

                </form>

                <div class="text-center">
                    <button type="submit" class="btn btn-info btn-fill btn-wd">Atualizar</button>
                </div>

            </div>


        </div>

    </div> 

</div> <!-- Fim ROW Empresa -->


<div class="row" id="rowConta">  <!-- Conta -->

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Conta</h4>
            </div>
            <div class="content">

                <form>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control border-input"  placeholder="Itaú">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Banco</label>
                                <input type="text" class="form-control border-input" placeholder="Itaú">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                               <label for="">Empresa / Pefil</label>
                               <select placeholder="" class="form-control border-input">
                                <option name="" id="">Selecione...</option>
                                <option name="" id="">Pessoal</option>
                                <option name="" id="">Albroz</option>
                                <option name="" id="">Unas</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Agência</label>
                            <input type="email" class="form-control border-input" placeholder="5607">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Conta Corrente</label>
                            <input type="text" class="form-control border-input" placeholder="00657-3">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo</label>
                            <input type="text" class="form-control border-input"  placeholder="Conta Corrente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Saldo Incial</label>
                            <input type="text" class="form-control border-input" placeholder="R$ 80.000,00">
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-striped text-center " width="100%" id="dataTable" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Banco</th>
                            <th>Empresa</th>
                            <th>Saldo Inicial</th>
                            <th>Ações</th>





                        </tr>
                    </thead>

                    <tbody>

                        <?php

                        require 'src/conecta.php';


                        $cSql = "SELECT CNT_COD, CNT_NOME, CNT_BANCO, CNT_AGNC, CNT_NMCONTA, CNT_TIPO, CNT_TIPO, CNT_SALDOINICIAL, EMP_NOME_EMPRESA  FROM CONTA INNER JOIN
                        EMPRESA ON EMPRESA.EMP_COD = CONTA.COD_EMPR INNER JOIN USR_EMPR ON USR_EMPR.COD_EMPR = EMPRESA.EMP_COD WHERE COD_USR = ".$cod;


                        $dataSet = mysqli_query($conecta, $cSql);

                        while($oDados = mysqli_fetch_assoc($dataSet)){
                            echo "

                            <tr>
                            <td>".$oDados['CNT_COD']."</td>
                            <td>".$oDados['CNT_NOME']."</td>
                            <td>".$oDados['CNT_BANCO']."</td>
                            <td>".$oDados['EMP_NOME_EMPRESA']."</td>
                            <td>".$oDados['CNT_SALDOINICIAL']."</td>

                            <td><button class = 'btn' id = '".$oDados['CNT_COD']."' onclick = 'alert(this.id)'>Alterar</button></td>
                            </tr>
                            ";

                        }

                        mysqli_free_result($dataSet);
                        mysqli_close($conecta);  



                        ?>

                    </tbody>
                </table>

            </form>

            <div class="text-center">
                <button type="submit" class="btn btn-info btn-fill btn-wd">Atualizar</button>
            </div>

        </div> 
    </div>
</div> <!-- Fim Conta -->
</div> <!-- Fim ROW Conta -->




<!-- Administrador -->
<div class="row" id="rowAdminstrador">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Administrador</h4>
            </div>
            <div class="content">
               <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control border-input" placeholder="Nome">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Login</label>
                            <input type="text" class="form-control border-input"  placeholder="beardsmaster">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Senha</label>
                            <input type="email" class="form-control border-input" placeholder="****">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control border-input" placeholder="alex@beardsweb.com.br">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Permissão</label>
                            <input type="text" class="form-control border-input" placeholder="Administrador">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control border-input" placeholder="Ativo">
                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-striped text-center " width="100%" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>Permissão</th>

                        <th>Ações</th>



                    </tr>
                </thead>

                <tbody>

                 <?php

                 require 'src/conecta.php';


                 $cSql = "SELECT DISTINCT USR_COD, USR_NOME, USR_LOGIN, USR_PERMISSAO FROM USR_EMPR INNER JOIN USUARIO ON USUARIO.USR_COD = USR_EMPR.COD_USR WHERE
                 COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = $cod)";


                 $dataSet = mysqli_query($conecta, $cSql);

                 while($oDados = mysqli_fetch_assoc($dataSet)){
                    echo "

                    <tr>
                    <td>".$oDados['USR_COD']."</td>
                    <td>".$oDados['USR_NOME']."</td>
                    <td>".$oDados['USR_LOGIN']."</td>

                    
                    ";

                    if($oDados['USR_PERMISSAO'] == 0)
                        $permissao = "Usuário";
                    else if ($oDados['USR_PERMISSAO'] == 1)
                        $permissao = "Gerente";
                    else
                        $permissao = "Administrador";

                    echo"
                    <td>".$permissao."</td>";


                    if($permissao != "Administrador"){
                        echo "<td><button class = 'btn' id = '".$oDados['USR_COD']."' onclick = 'alert(this.id)'>Alterar</button></td>
                    </tr>
                    ";
                    }
                    else{
                        echo "<td><button class = 'btn' id = '".$oDados['USR_COD']."' onclick = 'alert(this.id)' disabled>Alterar</button></td>
                    </tr>
                    ";
                    }


                }

                mysqli_free_result($dataSet);
                mysqli_close($conecta);  



                ?>

                </tbody>
                </table>



                <div class="text-center">
                <button type="submit" class="btn btn-info btn-fill btn-wd">Atualizar</button>
                </div>
                </div>
                </div> <!-- Card Administrador-->
                </div>

                </div> <!--FINAL ROW Administrador-->










                </div> <!-- Container Fluid -->
                </div> <!-- Container-->




                <?php include_once('inferior.php');?>


