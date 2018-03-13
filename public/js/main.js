var frase = $(".frase").text();
var numPalavras = frase.split(" ").length;

var tamanhoFrase = $("#tamanho-frase");
tamanhoFrase.text(numPalavras);

var campo = $(".campo-digitacao"); 
campo.on("input", function()  {     
    var conteudo = campo.val();     
	
	// aqui o conteudo sofre um split considerando os elementos
	// que NÃO são espaços em branco, ou seja, as palavras.
	// como o split conta sempre uma palavra a mais 
	// é necessário subtrair 1 para ficar certo.
	// 
	
	var qtdPalavras = conteudo.split(/\S+/).length - 1;     
	// console.log(qtdPalavras); 
	
	$("#contador-palavras").text(qtdPalavras); 
	
	var qtdCaracteres = conteudo.length;     
	$("#contador-caracteres").text(qtdCaracteres); 
}); 

