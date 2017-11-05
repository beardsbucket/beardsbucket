 <?php
 require "conecta.php";
 session_start();
 $cod =  $_SESSION['user']['id'];


 if($_GET['funcao'] == 'atualizaDash'){
        $primeiroDia = date('Y-m-01');
        $UltimoDia = date('Y-m-31');



        $codEmpresa = $_GET['cmbEmpresaSelecao'];
// TODOS
        if($codEmpresa==0){
                $cSql = "SELECT 
                (SELECT SUM(LCT_VLRTITULO) from LANCAMENTO INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR
                WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) AND LCT_TIPO = 'Receita' AND LCT_STATUSLANC = 'A Pagar - Receber' 
                AND  DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDia') AS RECEITA, 
                (SELECT SUM(LCT_VLRTITULO) from LANCAMENTO  INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR
                WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) AND LCT_TIPO = 'Despesa' AND LCT_STATUSLANC = 'A Pagar - Receber'
                AND DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDia') AS DESPESA, 
                ((((SELECT SUM(CNT_SALDOINICIAL) FROM CONTA WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = $cod))+
                (SELECT IFNULL((SELECT SUM(LCT_VLRPAGO) from LANCAMENTO INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD 
                INNER JOIN EMPRESA ON EMP_COD = COD_EMPR  WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = $cod) AND LCT_STATUSLANC = 'Pago - Recebido' AND LCT_TIPO = 
                'Receita'),0))-(SELECT IFNULL((SELECT SUM(LCT_VLRPAGO) from LANCAMENTO  INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA 
                ON EMP_COD = COD_EMPR  WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = $cod) AND LCT_STATUSLANC = 
                'Pago - Recebido' AND LCT_TIPO = 'Despesa'),0))))) AS CAIXA";

        }
        else{

// POR EMPRESA

                $cSql = " SELECT 
                (SELECT SUM(LCT_VLRTITULO) from LANCAMENTO INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR
                WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) AND COD_EMPR = $codEmpresa AND LCT_TIPO = 'Receita' AND LCT_STATUSLANC = 'A Pagar - Receber' 
                AND  DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDia') AS RECEITA, 
                (SELECT SUM(LCT_VLRTITULO) from LANCAMENTO  INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR
                WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) AND COD_EMPR = $codEmpresa AND LCT_TIPO = 'Despesa' AND LCT_STATUSLANC = 'A Pagar - Receber'
                AND DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDia') AS DESPESA, 
                ((((SELECT SUM(CNT_SALDOINICIAL) FROM CONTA WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = $cod) AND COD_EMPR = $codEmpresa)+
                (SELECT IFNULL((SELECT SUM(LCT_VLRPAGO) from LANCAMENTO INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD 
                INNER JOIN EMPRESA ON EMP_COD = COD_EMPR  WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = $cod) AND COD_EMPR = $codEmpresa AND LCT_STATUSLANC = 'Pago - Recebido' AND LCT_TIPO = 
                'Receita'),0))-(SELECT IFNULL((SELECT SUM(LCT_VLRPAGO) from LANCAMENTO  INNER JOIN CONTA ON LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA 
                ON EMP_COD = COD_EMPR  WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = $cod) AND COD_EMPR = $codEmpresa AND LCT_STATUSLANC = 
                'Pago - Recebido' AND LCT_TIPO = 'Despesa'),0))))) AS CAIXA";

                

        }

        $result = mysqli_query($conecta,$cSql);



        $json_array = array();

        while($row = mysqli_fetch_assoc($result)){

                $json_array[] = $row;

        }

        echo json_encode($json_array, JSON_UNESCAPED_UNICODE);

}


if($_GET['funcao'] == 'atualizaDespesa'){
 $UltimoDiaM = date('Y-m-31');
 if($_GET['codEmpresa'] == 0){

         $cSql = "SELECT 
         LCT_COD, EMP_NOME_EMPRESA, LCT_DESCRICAO, CAT_NOME,CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')) AS LCT_VLRTITULO,
         DATE_FORMAT(LCT_DTVENC, '%d/%m/%Y') AS LCT_DTVENCFOR, (LCT_JUROSDIA/100) AS LCT_JUROSDIA, IF( DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') 
         <  DATE_FORMAT(NOW(), '%Y-%m-%d') AND LCT_JUROSDIA > 0, CONCAT('R$ ',format(LCT_VLRTITULO+
         ((LCT_VLRTITULO*((LCT_JUROSDIA/100)*DATEDIFF(CURRENT_DATE, DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d'))))),2,'de_DE')),
         (CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')))) AS LCT_VALORACRESCIMO
         FROM LANCAMENTO INNER JOIN CONTA ON 
         LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR INNER JOIN CATEGORIA ON
         LANCAMENTO.CAT_COD = CATEGORIA.CAT_COD WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) 
         AND DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDiaM' AND LCT_STATUSLANC = 'A Pagar - Receber' AND LCT_TIPO = 'Despesa'";
 }
 else{
        $cSql = "SELECT 
        LCT_COD, EMP_NOME_EMPRESA, LCT_DESCRICAO, CAT_NOME,CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')) AS LCT_VLRTITULO,
        DATE_FORMAT(LCT_DTVENC, '%d/%m/%Y') AS LCT_DTVENCFOR, (LCT_JUROSDIA/100) AS LCT_JUROSDIA, IF( DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') 
        <  DATE_FORMAT(NOW(), '%Y-%m-%d') AND LCT_JUROSDIA > 0, CONCAT('R$ ',format(LCT_VLRTITULO+
        ((LCT_VLRTITULO*((LCT_JUROSDIA/100)*DATEDIFF(CURRENT_DATE, DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d'))))),2,'de_DE')),
        (CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')))) AS LCT_VALORACRESCIMO
        FROM LANCAMENTO INNER JOIN CONTA ON 
        LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR INNER JOIN CATEGORIA ON
        LANCAMENTO.CAT_COD = CATEGORIA.CAT_COD WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) 
        AND DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDiaM' AND LCT_STATUSLANC = 'A Pagar - Receber' AND LCT_TIPO = 'Despesa' AND COD_EMPR = $_GET[codEmpresa]";
}

$result = mysqli_query($conecta,$cSql);
if(mysqli_num_rows($result) >= 1){


 $json_array = array();

 while($row = mysqli_fetch_assoc($result)){

        $json_array[] = $row;

}

echo json_encode($json_array, JSON_UNESCAPED_UNICODE);
}
else
        echo "sem registros";

}


if($_GET['funcao'] == 'AtualizaReceita'){
 $UltimoDiaM = date('Y-m-31');

 if($_GET['codEmpresa'] == 0){
         $cSql = "SELECT 
         LCT_COD, EMP_NOME_EMPRESA, LCT_DESCRICAO, CAT_NOME,CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')) AS LCT_VLRTITULO,
         DATE_FORMAT(LCT_DTVENC, '%d/%m/%Y') AS LCT_DTVENCFOR, (LCT_JUROSDIA/100) AS LCT_JUROSDIA, IF( DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') 
         <  DATE_FORMAT(NOW(), '%Y-%m-%d') AND LCT_JUROSDIA > 0, CONCAT('R$ ',format(LCT_VLRTITULO+
         ((LCT_VLRTITULO*((LCT_JUROSDIA/100)*DATEDIFF(CURRENT_DATE, DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d'))))),2,'de_DE')),
         (CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')))) AS LCT_VALORACRESCIMO
         FROM LANCAMENTO INNER JOIN CONTA ON 
         LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR INNER JOIN CATEGORIA ON
         LANCAMENTO.CAT_COD = CATEGORIA.CAT_COD WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) 
         AND DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDiaM' AND LCT_STATUSLANC = 'A Pagar - Receber' AND LCT_TIPO = 'Receita'";
 }

 else{
         $cSql = "SELECT 
         LCT_COD, EMP_NOME_EMPRESA, LCT_DESCRICAO,  CAT_NOME,CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')) AS LCT_VLRTITULO,
         DATE_FORMAT(LCT_DTVENC, '%d/%m/%Y') AS LCT_DTVENCFOR, (LCT_JUROSDIA/100) AS LCT_JUROSDIA, IF( DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') 
         <  DATE_FORMAT(NOW(), '%Y-%m-%d') AND LCT_JUROSDIA > 0, CONCAT('R$ ',format(LCT_VLRTITULO+
         ((LCT_VLRTITULO*((LCT_JUROSDIA/100)*DATEDIFF(CURRENT_DATE, DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d'))))),2,'de_DE')),
         (CONCAT('R$ ',format(LCT_VLRTITULO,2,'de_DE')))) AS LCT_VALORACRESCIMO
         FROM LANCAMENTO INNER JOIN CONTA ON 
         LANCAMENTO.CNT_COD = CONTA.CNT_COD INNER JOIN EMPRESA ON EMP_COD = COD_EMPR INNER JOIN CATEGORIA ON
         LANCAMENTO.CAT_COD = CATEGORIA.CAT_COD WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod) 
         AND DATE_FORMAT(LCT_DTVENC, '%Y-%m-%d') <= '$UltimoDiaM' AND LCT_STATUSLANC = 'A Pagar - Receber' AND LCT_TIPO = 'Receita' AND COD_EMPR = $_GET[codEmpresa]";
 }

 $result = mysqli_query($conecta,$cSql);
 if(mysqli_num_rows($result) >= 1){


         $json_array = array();

         while($row = mysqli_fetch_assoc($result)){

                $json_array[] = $row;

        }

        echo json_encode($json_array, JSON_UNESCAPED_UNICODE);
}
else
        echo "sem registros";

}

if($_GET['funcao'] == 'efetuaPagamento'){

        $cSql = "UPDATE LANCAMENTO SET LCT_VLRPAGO = $_GET[VALORPAGO], LCT_STATUSLANC = 'Pago - Recebido', LCT_DTPAG = NOW() WHERE LCT_COD = $_GET[CODLANCAMENTO]";
        if(mysqli_query($conecta,$cSql)){
                echo "Lancou";

                $cSql = "UPDATE USUARIO SET USR_PONTUACAO = USR_PONTUACAO + 10 WHERE USR_COD = $cod";

                mysqli_query($conecta,$cSql);
        }

        else{
                echo mysqli_connect_errno($conecta);
        }



}



?>