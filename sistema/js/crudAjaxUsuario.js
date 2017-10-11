//  --------------------------------------------USUÁRIO ------------------------------------------------



//  --------------------------------------------FIM USUÁRIO ------------------------------------------------




//  -------------------------------------------- EMPRESA ------------------------------------------------

function selecionaAcao(param){

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// ///////////////////////////////////////////////INSERE EMPRESA/////////////////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

if(param == 1){

	if(document.getElementsByName("txtNomeEmpresa")[0].value.trim().length<=0){
		alert("Preencha o nome da Empresa");
		document.getElementsByName("txtNomeEmpresa")[0].focus()	;

	}

	else{


		var oPagina = new XMLHttpRequest();
		with(oPagina){


			var empresa = document.getElementsByName("txtNomeEmpresa")[0].value;
			var cnpj = document.getElementsByName("txtCnpj")[0].value;

			open('GET', './src/CrudUsuario.php?funcao=insereEmpresa&empresa='+empresa+'&cnpj='+cnpj);

			send();
			onload = function(){



				if(responseText != "Erro ao Inserir"){

					var oDados = JSON.parse(responseText);

					var Contador = parseInt(oDados.length);

					Contador = Contador -1;

					var tableEmpresa = document.getElementById("tableEmpresa");

					document.getElementById("retornoFormEmpresa").style.display = "block";
					document.getElementById("retornoFormEmpresa").setAttribute("class", "retSuccess");

					document.getElementById("retornoFormEmpresa").innerHTML = "Dados inseridos com sucesso";

					setTimeout(function(){ document.getElementById("retornoFormEmpresa").style.display = "none"; }, 3000);


					tableEmpresa.insertAdjacentHTML('beforeend',
						"<tr><td name = 'emp"+oDados[Contador]['EMP_COD']+"'>" + oDados[Contador]['EMP_COD'] + "</td>"+
						"<td name = 'emp"+oDados[Contador]['EMP_COD']+"'>" + oDados[Contador]['EMP_NOME_EMPRESA'] + "</td> "+
						"<td name = 'emp"+oDados[Contador]['EMP_COD']+"'>" + oDados[Contador]['EMP_CNPJ'] + "</td> "+
						"<td name = 'emp"+oDados[Contador]['EMP_COD']+"'>" + oDados[Contador]['EMP_STATUS'] + "</td> "+

						"<td><button class = 'btn' id = '"+oDados[Contador]['EMP_COD']+
						"' onclick = 'selecionaEmpresa(this.id)'>Alterar</button></tr> "
						);

					atualizaComboEmpresa();





				}

				else{

					document.getElementById("retornoFormEmpresa").style.display = "block";
					document.getElementById("retornoFormEmpresa").setAttribute("class", "retDanger");
					document.getElementById("retornoFormEmpresa").innerHTML = "Não foi possível inserir a empresa";
					setTimeout(function(){ document.getElementById("retornoFormEmpresa").style.display = "none"; }, 3000);

				}

			}


		}

	}
}
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// ///////////////////////////////////////////////ALTERA EMPRESA/////////////////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

if(param == 2){


	if(document.getElementsByName("txtNomeEmpresa")[0].value.trim().length<=0){
		alert("Preencha o nome da Empresa");
		document.getElementsByName("txtNomeEmpresa")[0].focus()	;

	}

	else{


		var codEmpresa = document.getElementsByName("codEmpresa")[0].value, 
		nomeEmpresa = document.getElementsByName("txtNomeEmpresa")[0].value,
		cnpjEmpresa = document.getElementsByName("txtCnpj")[0].value;



		var oPagina = new XMLHttpRequest();

		with(oPagina){

			open('GET', './src/CrudUsuario.php?funcao=atualizaEmpresa&empresa='+nomeEmpresa+'&cnpj='+cnpjEmpresa+'&status='+document.getElementById("cmbStatusEmpresa").value+'&codEmpresa='+codEmpresa);

			send();



			onload = function(){

				if(responseText != "Erro ao Atualizar"){


					var oDados = JSON.parse(responseText);

					var codEmpresa = 'emp'+oDados[0]['EMP_COD'];

					document.getElementsByName(codEmpresa)[1].innerText = oDados[0]['EMP_NOME_EMPRESA'];
					document.getElementsByName(codEmpresa)[2].innerText = oDados[0]['EMP_CNPJ'];
					document.getElementsByName(codEmpresa)[3].innerText = oDados[0]['EMP_STATUS'];

					document.getElementById("buttonEmpresa").innerHTML = "Inserir";
					document.getElementById("buttonCancelarEmpresa").style.display = 'none';
					document.getElementById("buttonEmpresa").value = 1;

					document.getElementById("retornoFormEmpresa").style.display = "block";

					document.getElementById("retornoFormEmpresa").setAttribute("class", "retSuccess");

					document.getElementById("retornoFormEmpresa").innerHTML = "Dados atualizados com sucesso";

					setTimeout(function(){ document.getElementById("retornoFormEmpresa").style.display = "none"; }, 3000);

					document.all.txtCnpj.value = "";
					document.all.txtNomeEmpresa.value="";

					atualizaComboEmpresa();


				}

				else{

					document.getElementById("retornoFormEmpresa").style.display = "block";
					document.getElementById("retornoFormEmpresa").setAttribute("class", "retDanger");
					document.getElementById("retornoFormEmpresa").innerHTML = "Não foi possível atualizar a empresa";
					setTimeout(function(){ document.getElementById("retornoFormEmpresa").style.display = "none"; }, 3000);
				}

			}





		}
	}



}


// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// ///////////////////////////////////////////////CANCELA A ALTERAÇÂO EMPRESA////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //


else if(param == 3){
	document.getElementById("buttonEmpresa").innerHTML = "Inserir";
	document.getElementById("buttonCancelarEmpresa").style.display = 'none';
	document.getElementById("buttonEmpresa").value = 1;

	document.all.txtCnpj.value = "";
	document.all.txtNomeEmpresa.value="";

	document.getElementById("cmbStatusEmpresa").selectedIndex = "0";

	// document.getElementById("cmbStatusEmpresa").disabled = true;



}

}


// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// //////////////////////////////////////SELECIONA A EMPRESA DO FORM CONTA///////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //
function selecionaEmpresa(codEmpresa){

	codEmpresa = 'emp'+codEmpresa;

	document.getElementById("cmbStatusEmpresa").disabled = false;


	document.getElementById("codEmpresa").value = document.getElementsByName(codEmpresa)[0].innerText;
	document.getElementById("txtNomeEmpresa").value = document.getElementsByName(codEmpresa)[1].innerText;
	document.getElementById("txtCnpj").value = document.getElementsByName(codEmpresa)[2].innerText;
	document.getElementById("cmbStatusEmpresa").value = document.getElementsByName(codEmpresa)[3].innerText;

	document.getElementById("buttonEmpresa").innerHTML = "Alterar";
	document.getElementById("buttonEmpresa").value = 2;
	document.getElementById("buttonCancelarEmpresa").style.display = 'inline';

}



//  --------------------------------------------FIM EMPRESA ------------------------------------------------




//  --------------------------------------------CONTA ------------------------------------------------

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// ///////////////////////////////////////////////INSERE CONTA///////////////////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //


function selecionaAcaoConta(param){

	if(param == 1){
		

		var oPagina = new XMLHttpRequest();
		with(oPagina){

			var statusEmpresa = document.getElementById("cmbStatusConta").value;	
			var nomeConta = document.getElementsByName("nomeConta")[0].value;
			var nomeBanco = document.getElementsByName("nomeBanco")[0].value;
			var empresa = document.getElementsByName("cmbEmpresa")[0].value;
			var agenciaConta = document.getElementsByName("agenciaConta")[0].value;
			var conta = document.getElementsByName("numeroConta")[0].value;
			var tipo = document.getElementsByName("tipoConta")[0].value;
			var saldo = document.getElementsByName("saldoInicial")[0].value;



			open('GET', './src/CrudUsuario.php?funcao=insereConta&nomeConta='+nomeConta+'&nomeBanco='+nomeBanco+'&agenciaConta='+agenciaConta+'&numeroConta='+conta+'&tipoConta='+tipo+'&cmbStatusConta='+statusEmpresa+'&saldoInicial='+saldo+'&cmbEmpresa='+empresa);

			send();
			onload = function(){


				if(responseText != "Erro ao Inserir!"){

					var oDados = JSON.parse(responseText);

					var Contador = parseInt(oDados.length) -1;


					var tableConta = document.getElementById("tableConta");



					tableConta.insertAdjacentHTML('beforeend',
						"<tr><td name = 'conta"+oDados[Contador]['CNT_COD']+"'>" + oDados[Contador]['CNT_COD'] + "</td>"+
						"<td name = 'conta"+oDados[Contador]['CNT_COD']+"'>" + oDados[Contador]['CNT_NOME'] + "</td> "+
						"<td name = 'conta"+oDados[Contador]['CNT_COD']+"'>" + oDados[Contador]['CNT_BANCO'] + "</td> "+
						"<td name = 'conta"+oDados[Contador]['CNT_COD']+"'>" + oDados[Contador]['EMP_NOME_EMPRESA'] + "</td> "+
						"<td name = 'conta"+oDados[Contador]['CNT_COD']+"'>" + "R$"+oDados[Contador]['CNT_SALDOINICIAL'].replace(/[.]/g, ",").replace(/\d(?=(?:\d{3})+(?:\D|$))/g, "$&.") + "</td> "+
						"<td name = 'conta"+oDados[Contador]['CNT_COD']+"'>" + oDados[Contador]['CNT_STATUS'] + "</td> "+


						"<td><button class = 'btn' id = '"+oDados[Contador]['CNT_COD']+
						"' onclick = 'selecionaConta(this.id)'>Alterar</button></tr> "
						);

					document.getElementById("retornoFormConta").style.display = "block";
					document.getElementById("retornoFormConta").innerHTML = "Dados inseridos com sucesso!";
					document.getElementById("retornoFormConta").setAttribute("class", "retSuccess");
					
					setTimeout(function(){ document.getElementById("retornoFormConta").style.display = "none"; }, 3000);


				}

				else{
					document.getElementById("retornoFormConta").style.display = "block";
					document.getElementById("retornoFormConta").innerHTML = "Não foi possível inserir a Conta";
					document.getElementById("retornoFormConta").setAttribute("class", "retDanger");

					setTimeout(function(){ document.getElementById("retornoFormConta").style.display = "none"; }, 3000);

				}


			}

		}
	}
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// ///////////////////////////////////////////////ATUALIZA CONTA/////////////////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //
if(param == 2){


	var oPagina = new XMLHttpRequest();
	with(oPagina){

		var nomeConta = document.getElementById("nomeConta").value;
		var nomeBanco = document.getElementById("nomeBanco").value;
		var agencia = document.getElementById("agenciaConta").value;
		var conta = document.getElementById("numeroConta").value;
		var tipoConta = document.getElementById("tipoConta").value;
		var statusEmpresa = document.getElementById("cmbStatusConta").value;
		var saldoInicial = document.getElementById("saldoInicial").value;
		var codEmpresa = document.getElementById("cmbEmpresa").value;
		var codConta = document.getElementById("codConta").value;

		open('GET', './src/CrudUsuario.php?funcao=atualizaConta&nomeConta='+nomeConta+'&nomeBanco='+nomeBanco+'&agencia='+agencia+'&conta='+conta+'&tipoConta='+tipoConta+'&statusEmpresa='+statusEmpresa+'&saldoInicial='+saldoInicial+'&codEmpresa='+codEmpresa+'&codConta='+codConta);

		send();
		onload = function(){

			if(responseText != "Erro ao atualizar"){


				var oDados = JSON.parse(responseText);

				var Contador = parseInt(oDados.length) -1;

				var tableConta = document.getElementById("tableConta");

				var codConta = 'conta'+oDados[0]['CNT_COD'];

				document.getElementsByName(codConta)[0].innerText = oDados[0]['CNT_COD'];
				document.getElementsByName(codConta)[1].innerText = oDados[0]['CNT_NOME'];
				document.getElementsByName(codConta)[2].innerText = oDados[0]['CNT_BANCO'];
				document.getElementsByName(codConta)[3].innerText = oDados[0]['EMP_NOME_EMPRESA'];
				document.getElementsByName(codConta)[4].innerText = oDados[0]['CNT_SALDOINICIAL'];
				document.getElementsByName(codConta)[5].innerText = oDados[0]['CNT_STATUS'];
				document.getElementById("buttonEmpresa").innerHTML = "Inserir";
				
				
				document.getElementById("retornoFormConta").style.display = "block";
				document.getElementById("retornoFormConta").innerHTML = "Dados Alterados com sucesso!";
				document.getElementById("retornoFormConta").setAttribute("class", "retSuccess");

				setTimeout(function(){ document.getElementById("retornoFormConta").style.display = "none"; }, 3000);


			}

			else {
				document.getElementById("retornoFormConta").style.display = "block";
				document.getElementById("retornoFormConta").innerHTML = "Não foi possível alterar a Conta";
				document.getElementById("retornoFormConta").setAttribute("class", "retDanger");

				setTimeout(function(){ document.getElementById("retornoFormConta").style.display = "none"; }, 3000);
			}
		}
	}
}
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// ///////////////////////////////////////////////CANCELA A ALTERAÇÂO CONTA//////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

else if(param == 3){
	document.getElementById("buttonConta").innerHTML = "Inserir";
	document.getElementById("buttonCancelarConta").style.display = 'none';
	document.getElementById("buttonConta").value = 1;

	document.all.nomeConta.value = "";
	document.all.nomeBanco.value="";
	document.all.cmbEmpresa.value="";
	document.all.agenciaConta.value="";
	document.all.numeroConta.value="";
	document.all.tipoConta.value="";
	document.all.saldoInicial.value="";
	
	document.getElementById("cmbStatusConta").selectedIndex = "0";

	document.getElementById("cmbStatusConta").disabled = true;
}


}







function selecionaConta(codConta){

	var oPagina = new XMLHttpRequest();
	with(oPagina){

		open('GET', './src/CrudUsuario.php?funcao=selecionaConta&codConta='+codConta);

		send();
		onload = function(){

			var oDados = JSON.parse(responseText);

			document.getElementById("codConta").value = oDados[0]['CNT_COD'];
			document.getElementById("nomeConta").value = oDados[0]['CNT_NOME'];
			document.getElementById("nomeBanco").value = oDados[0]['CNT_BANCO'];
			document.getElementById("cmbEmpresa").value = oDados[0]['EMP_COD'];
			document.getElementById("agenciaConta").value = oDados[0]['CNT_AGNC'];
			document.getElementById("numeroConta").value = oDados[0]['CNT_NMCONTA'];
			document.getElementById("tipoConta").value = oDados[0]['CNT_TIPO'];
			document.getElementById("saldoInicial").value = oDados[0]['CNT_SALDOINICIAL'];
			document.getElementById("cmbStatusConta").value = oDados[0]['CNT_STATUS'];


			document.getElementById("buttonConta").innerHTML = "Alterar";
			document.getElementById("buttonConta").value = 2;
			document.getElementById("buttonCancelarConta").style.display = 'inline';
		}
	}
}

//  --------------------------------------------FIM CONTA ------------------------------------------------





//  --------------------------------------------ADMINISTRADOR USUÁRIO ------------------------------------------------
function selecionaAcaoAdministrador(param){

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //

// ///////////////////////////////////////////////INSERE ADMINISTRADOR///////////////////////////////////////////////////// // 

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //
	if(param == 1){


	}

}

//  --------------------------------------------FIM ADMINISTRADOR ------------------------------------------------





//  --------------------------------------------ATUALIZAÇÃO DA PÁGINA ------------------------------------------------
// ATUALIZA COMBO EMPRESA DA CONTA

function atualizaComboEmpresa(){
	var oPagina = new XMLHttpRequest();

	with(oPagina){

		open('GET', './src/CrudUsuario.php?funcao=comboConta');

		send();

		onload = function(){

			var oDados = JSON.parse(responseText);

			for(var i = 0; i<oDados.length; i++){
				var x = document.getElementById("cmbEmpresa");
				var option = document.createElement("option");
				option.text = oDados[i]['EMP_NOME_EMPRESA'];
				option.value = oDados[i]['EMP_COD'];
				x.add(option);
			}
		}
	}
}



(function(){

	atualizaComboEmpresa();


}())

//  --------------------------------------------FIM ATUALIZAÇÃO ------------------------------------------------




