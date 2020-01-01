<?php
		
	/*guarda un objeto en un fichero recibe el objeto
	y el path del fichero donde guardarlo devuelve true si lo
	ha conseguido y false sin no lo ha conseguido*/
	function guardarObjeEnFichero($objeto,$path){
		$objeto=serialize($objeto);
		if (is_writable($path)) {
		$fp = fopen($path, "w"); 
		fwrite($fp, $objeto); 
		fclose($fp);
		return true;
		}else
			return false;
		}
		
	/*lee un objeto de un fichero recibe el path del fichero
	devuelve el objeto si lo a conseguido y false si no*/
	function leerObjeEnFichero($path){
		if (file_exists($path)){
			$objeto = file_get_contents($path);
			$objeto=unserialize($objeto);           
			if (!empty($objeto)){
				return $objeto;
			}else
				return $objeto;
		}
	}
	function damePalabrasYDef(){
		$archivo=scandir("ArchivosPalabras");
		unset($archivo[array_search("..",$archivo)]);
		unset($archivo[array_search(".",$archivo)]);
		shuffle($archivo);
		$archivo=$archivo[0];
		$archivo=fopen("ArchivosPalabras/".$archivo,"r");
		$arrayPalabrasYDef=[];
		while (($buffer = fgets($archivo))!== false) {
			array_push($arrayPalabrasYDef,$buffer);
		}
		return $arrayPalabrasYDef;
	}
	function insertarEnArrai(&$letrasIntro,$letrasPal,$letra){
		if(array_search($letra,$letrasIntro)===false && array_search($letra,$letrasPal)!==false){
			$coincidencias=array_keys($letrasPal,$letra);
			foreach($coincidencias as $coincidencia){
				$letrasIntro[$coincidencia]=$letra;
			}
			return 0;
		}else if(array_search($letra,$letrasIntro)!==false){
			return 1;
		}else if(array_search($letra,$letrasPal)===false){
			return 2;
		}
	}
?>