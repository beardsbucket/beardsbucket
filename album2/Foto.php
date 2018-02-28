<?php 


class Foto{

	private $extensao;

	private $coordenadas;

	private $caminho;

	public function setCoordenadas($coordenadas){

		$this->coordenadas = $coordenadas;
	}

	public function setCaminho($caminho){

		$this->caminho = $caminho;
	}

	public function setExtensao($extensao){

		$this->extensao = $extensao;

	}

	public function getExtensao(){

		return $this->extensao;
	}

	public function getCoordenadas(){

		return $this->coordenadas;
	}

	public function getCaminho(){

		return $this->caminho;
	}
	

}

?>