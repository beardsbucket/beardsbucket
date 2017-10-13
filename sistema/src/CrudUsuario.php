<?php

require 'conecta.php';
session_start();
$cod =  $_SESSION['user']['id'];


// ATUALIZA USUARIO


if ($_GET['funcao'] == 'alteraUsuario'){

	$cSql = "UPDATE USUARIO SET USR_SENHA = '$_GET[txtSenha]', USR_LOGIN = '$_GET[txtLogin]', USR_NOME = '$_GET[txtNome]', USR_EMAIL = '$_GET[txtEmail]' WHERE USR_COD = $cod";
	

	$cSql = str_replace("''","NULL", $cSql);

	
	if (mysqli_query($conecta, $cSql)){


		$cSql = "SELECT USR_COD, USR_SENHA, USR_LOGIN, USR_NOME, USR_EMAIL, IF(USR_STATUS = 1, REPLACE(1, USR_STATUS, 'Ativo'), REPLACE(0, USR_STATUS, 'INATIVO')) AS  USR_STATUS,
		IF(USR_PERMISSAO = 0, REPLACE(USR_PERMISSAO, 0, 'Usuário'), REPLACE(USR_PERMISSAO, 1, 'Administrador')) as USR_PERMISSAO FROM USUARIO where USR_COD =
		".$cod;


		$_SESSION['user']['name'] = $_GET['txtNome'];

		$result = mysqli_query($conecta, $cSql); 

		$json_array = array(); 

		if($row = mysqli_fetch_assoc($result))  
		{  
			$json_array[] = $row;  
		}  


		echo json_encode($json_array, JSON_UNESCAPED_UNICODE);                          

	}


	else{
		echo "Erro ao alterar";
	}	
}

// NSERT INTO CONTA VALUES (0,'teste','Itaubis','1234','123','CC',12000,'1',1)

// 1 Inserir Empresa

if ($_GET['funcao'] == 'insereEmpresa'){



	$cSql = "INSERT INTO EMPRESA  VALUES (0, '$_GET[empresa]', '$_GET[cnpj]',1)";
	
	$cSql = str_replace("''","NULL", $cSql);

	
	if (mysqli_query($conecta, $cSql)){


		$codEmpresa = mysqli_insert_id($conecta);


		$cSql = "INSERT INTO USR_EMPR  values (0, $cod, $codEmpresa)";



		mysqli_query($conecta, $cSql);


		$cSql = "SELECT EMP_COD, EMP_NOME_EMPRESA, EMP_CNPJ, IF(EMP_STATUS = 1,REPLACE( EMP_STATUS,1,'Ativo'),REPLACE( EMP_STATUS,0,'Inativo')) as EMP_STATUS FROM USUARIO INNER JOIN USR_EMPR ON USUARIO.USR_COD = USR_EMPR.COD_USR INNER JOIN EMPRESA ON EMPRESA.EMP_COD = USR_EMPR.COD_EMPR WHERE COD_USR = ".$cod;


		$result = mysqli_query($conecta, $cSql); 

		$json_array = array();  
		while($row = mysqli_fetch_assoc($result))  
		{  
			$json_array[] = $row;  
		}  


		echo json_encode($json_array, JSON_UNESCAPED_UNICODE);                          

	}

	else{
		echo "Erro ao Inserir";
	}	
}
// ATUALIZA EMPRESA

else if($_GET['funcao'] == 'atualizaEmpresa'){

	$status = $_GET['status'];

	if($status == "Ativo")
		$status = 1;
	else
		$status = 0;



	$cSql = "UPDATE EMPRESA SET EMP_NOME_EMPRESA = '$_GET[empresa]', EMP_CNPJ = '$_GET[cnpj]', EMP_STATUS = $status WHERE EMP_COD = $_GET[codEmpresa]";



	if($result = mysqli_query($conecta, $cSql)){

		$cSql = "SELECT EMP_COD, EMP_NOME_EMPRESA, EMP_CNPJ,
		IF(EMP_STATUS = 1,REPLACE( EMP_STATUS,1,'Ativo'),REPLACE( EMP_STATUS,0,'Inativo')) as EMP_STATUS 
		FROM USUARIO JOIN USR_EMPR ON USR_COD = COD_USR INNER JOIN EMPRESA ON EMP_COD = COD_EMPR WHERE EMP_COD = $_GET[codEmpresa]";

		$result = mysqli_query($conecta, $cSql);

		if($row = mysqli_fetch_assoc($result))
		{  
			$json_array[] = $row;  
		}  


		echo json_encode($json_array, JSON_UNESCAPED_UNICODE);              

	}

	else
		echo "Erro ao Atualizar";
	

}

// CONTA ---------------------------------------------------------------------------------------

// Atualiza empresas Combo Conta

else if($_GET['funcao'] == 'comboConta'){


	$cSql = "SELECT DISTINCT EMP_COD, EMP_NOME_EMPRESA, EMP_CNPJ FROM USUARIO INNER JOIN USR_EMPR ON USUARIO.USR_COD = USR_EMPR.COD_USR INNER JOIN
	EMPRESA ON EMPRESA.EMP_COD = USR_EMPR.COD_EMPR WHERE COD_USR = $cod order by (EMP_NOME_EMPRESA) asc;";

	
	$result = mysqli_query($conecta, $cSql);

	while($row = mysqli_fetch_assoc($result))
	{  
		$json_array[] = $row;  
	}  


	echo json_encode($json_array, JSON_UNESCAPED_UNICODE);              


}

// Insere Conta
else if($_GET['funcao'] == 'insereConta'){


	$cSql = "INSERT INTO CONTA VALUES(0, '$_GET[nomeConta]', '$_GET[nomeBanco]', '$_GET[agenciaConta]', '$_GET[numeroConta]','$_GET[tipoConta]',$_GET[cmbStatusConta],$_GET[saldoInicial],$_GET[cmbEmpresa])";


	$cSql = str_replace("''","NULL", $cSql);

	
	if (mysqli_query($conecta, $cSql)){

		$cSql = "SELECT CNT_COD, CNT_NOME, CNT_BANCO, CNT_AGNC, CNT_NMCONTA, CNT_TIPO, CNT_TIPO, CONCAT('R$ ',format(CNT_SALDOINICIAL,2,'de_DE')) AS CNT_SALDOINICIAL, EMP_NOME_EMPRESA, IF(CNT_STATUS = 1,REPLACE( CNT_STATUS,1,'Ativo'),REPLACE( CNT_STATUS,0,'Inativo')) as CNT_STATUS  FROM CONTA INNER JOIN
		EMPRESA ON EMPRESA.EMP_COD = CONTA.COD_EMPR INNER JOIN USR_EMPR ON USR_EMPR.COD_EMPR = EMPRESA.EMP_COD WHERE COD_USR = ".$cod." order by CNT_COD";

		$result = mysqli_query($conecta, $cSql); 

		$json_array = array();  
		while($row = mysqli_fetch_assoc($result))  
		{  
			$json_array[] = $row;  
		}  


		echo json_encode($json_array, JSON_UNESCAPED_UNICODE);                          

	}

	else
		echo "Erro ao Inserir!";      

}

else if($_GET['funcao'] == 'selecionaConta'){


	$cSql = "SELECT DISTINCT CNT_COD, CNT_NOME, CNT_BANCO, CNT_AGNC, CNT_NMCONTA, CNT_TIPO, CNT_TIPO, CONCAT('R$ ',format(CNT_SALDOINICIAL,2,'de_DE')) AS CNT_SALDOINICIAL, EMP_COD, CNT_STATUS FROM CONTA INNER JOIN
	EMPRESA ON EMPRESA.EMP_COD = CONTA.COD_EMPR INNER JOIN USR_EMPR ON USR_EMPR.COD_EMPR = EMPRESA.EMP_COD WHERE CNT_COD =  $_GET[codConta]";

	// echo $cSql;
	

	$result = mysqli_query($conecta, $cSql); 

	$json_array = array();  
	if($row = mysqli_fetch_assoc($result))  
	{  
		$json_array[] = $row;  
		echo json_encode($json_array, JSON_UNESCAPED_UNICODE);                          

	}  

	else
		echo "Erro ao consultar";  


}


// Atualiza Conta

else if($_GET['funcao'] == 'atualizaConta'){


	$cSql = "UPDATE CONTA SET CNT_NOME = '$_GET[nomeConta]', CNT_BANCO = '$_GET[nomeBanco]', CNT_AGNC = '$_GET[agencia]', CNT_NMCONTA = '$_GET[conta]', CNT_TIPO = '$_GET[tipoConta]', CNT_STATUS = $_GET[statusEmpresa], CNT_SALDOINICIAL = $_GET[saldoInicial], COD_EMPR = $_GET[codEmpresa] WHERE CNT_COD = $_GET[codConta]";

	$cSql = str_replace("''","NULL", $cSql);

	
	if (mysqli_query($conecta, $cSql)){

		$cSql = "SELECT DISTINCT CNT_COD, CNT_NOME, CNT_BANCO, CNT_AGNC, CNT_NMCONTA, CNT_TIPO, CNT_TIPO, CONCAT('R$ ',format(CNT_SALDOINICIAL,2,'de_DE')) AS CNT_SALDOINICIAL, EMP_NOME_EMPRESA, EMP_COD, IF(CNT_STATUS = 1,REPLACE( CNT_STATUS,1,'Ativo'),REPLACE( CNT_STATUS,0,'Inativo')) as CNT_STATUS FROM CONTA INNER JOIN
		EMPRESA ON EMPRESA.EMP_COD = CONTA.COD_EMPR INNER JOIN USR_EMPR ON USR_EMPR.COD_EMPR = EMPRESA.EMP_COD WHERE CNT_COD =  $_GET[codConta]";


		$result = mysqli_query($conecta, $cSql); 

		$json_array = array();  
		if($row = mysqli_fetch_assoc($result))  
		{  
			$json_array[] = $row;  
			echo json_encode($json_array, JSON_UNESCAPED_UNICODE);                          
		}  


	}

	else
		echo "Erro ao atualizar";  




}
else if($_GET['funcao'] == 'insereAdministrador'){
	$cSql = "INSERT INTO USUARIO VALUES (0,'$_GET[administradorSenha]','$_GET[administradorLogin]','$_GET[administradorNome]','$_GET[administradorEmail]',$_GET[administradorPermissao],$_GET[administradorStatus])";
	
	$cSql = str_replace("''","NULL", $cSql);

	if (mysqli_query($conecta,$cSql)) {


		$cod_Usuario = mysqli_insert_id($conecta);
		$cod_EmpresaUsuario = $_GET['cmbEmpresaAdm'];


		$cSql = "INSERT INTO USR_EMPR VALUES (0,$cod_Usuario, $cod_EmpresaUsuario)";

		mysqli_query($conecta,$cSql);

		$cSql = "SELECT DISTINCT USR_COD,COD_EMPR,EMP_NOME_EMPRESA, USR_NOME, USR_LOGIN, USR_PERMISSAO, USR_EMAIL, USR_SENHA, IF(USR_STATUS = 1,REPLACE( USR_STATUS,1,'Ativo'),REPLACE( USR_STATUS,0,'Inativo')) as USR_STATUS, 
		IF(USR_PERMISSAO = 0, REPLACE(0, USR_PERMISSAO, 'Usuário'), REPLACE(USR_PERMISSAO, 1, 'Administrador')) as USR_PERMISSAO FROM USR_EMPR INNER JOIN USUARIO ON 
		USUARIO.USR_COD = USR_EMPR.COD_USR join EMPRESA on COD_EMPR = EMP_COD WHERE COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR =$cod)";

		$result = mysqli_query($conecta,$cSql);

		$json_array = array();
		while($row = mysqli_fetch_assoc($result))  
		{  
			$json_array[] = $row;  

		}  	
		echo json_encode($json_array, JSON_UNESCAPED_UNICODE);                          

	}
	else
		echo "Erro ao inserir";  

}













