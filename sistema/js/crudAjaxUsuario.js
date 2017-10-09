// EMPRESA

function insereEmpresaUsuario(){


	var oPagina = new XMLHttpRequest();
	with(oPagina){


		var empresa = document.getElementsByName("txtNomeEmpresa")[0].value;
		var cnpj = document.getElementsByName("txtCnpj")[0].value;

		open('GET', 'http://localhost/beardsbucket/sistema/src/CrudUsuario.php?funcao=insereEmpresa&empresa='+empresa+'&cnpj='+cnpj);

		send();
		onload = function(){




			if(responseText != "Erro ao Inserir"){

				var oDados = JSON.parse(responseText);

				var Contador = parseInt(oDados.length);

				Contador = Contador -1;

				var tableEmpresa = document.getElementById("tableEmpresa");



				tableEmpresa.insertAdjacentHTML('beforeend',
					"<tr><td>" + oDados[Contador]['EMP_COD'] + "</td>"+
					"<td>" + oDados[Contador]['EMP_NOME_EMPRESA'] + "</td> "+
					"<td>" + oDados[Contador]['EMP_CNPJ'] + "</td> "+
					"<td><button class = 'btn' id = '"+oDados[Contador]['EMP_COD']+
					"' onclick = 'alert(this.id)'>Alterar</button></tr> "
					);

			}

			else{
				document.getElementById("retornoFormEmpresa").style.display = "block";
				document.getElementById("retornoFormEmpresa").innerHTML = "Não foi possível inserir a empresa";
				setTimeout(function(){ document.getElementById("retornoFormEmpresa").style.display = "none"; }, 3000);

			}

		}


	}

}
function selecionaEmpresa(codEmpresa){

	var oPagina = new XMLHttpRequest();

	with(oPagina){


		open('GET', 'http://localhost/beardsbucket/sistema/src/CrudUsuario.php?funcao=selecionaEmpresa&codEmpresa='+codEmpresa);

		send();

		onload = function(){

			var oDados = JSON.parse(responseText);

			document.getElementsByName("codEmpresa")[0].value = oDados[0]['EMP_COD'];
			document.getElementsByName("txtNomeEmpresa")[0].value = oDados[0]['EMP_NOME_EMPRESA'];
			document.getElementsByName("txtCnpj")[0].value = oDados[0]['EMP_CNPJ'];

			document.getElementById("buttonEmpresa").innerHTML = "Alterar";

		}



	}


}


function alteraEmpresa(codEmpresa){

	var oPagina = new XMLHttpRequest();

	with(oPagina){


		open('GET', 'http://localhost/beardsbucket/sistema/src/CrudUsuario.php?funcao=selecionaEmpresa&codEmpresa='+codEmpresa);

		send();

		onload = function(){

			var oDados = JSON.parse(responseText);

			document.getElementsByName("codEmpresa")[0].value = oDados[0]['EMP_COD'];
			document.getElementsByName("txtNomeEmpresa")[0].value = oDados[0]['EMP_NOME_EMPRESA'];
			document.getElementsByName("txtCnpj")[0].value = oDados[0]['EMP_CNPJ'];

			document.getElementById("buttonEmpresa").innerHTML = "Alterar";

		}



	}


}


function atualizaComboEmpresa(){
	var oPagina = new XMLHttpRequest();

	with(oPagina){

		open('GET', 'http://localhost/beardsbucket/sistema/src/CrudUsuario.php?funcao=comboConta');

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



