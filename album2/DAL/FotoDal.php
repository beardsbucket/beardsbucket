<?php
class FotoDAL{
    
    public static function recuperarTodasAsFotos(){
        $foto = new Foto();
        
        $foto->setExtensao("jpg");
        $foto->setCoordenadas("1313313.556465464");
        $foto->setCaminho("./img/foto01.jpg");
        
            $arrFotos = array($foto);
        
            return $arrFotos;
        
    }
    
}