<!DOCTYPE HTML>
<html lang="es">
<head>
	<title>AHORCADO</title>
	<meta charset="UTF-8">
	<meta name="description" content="AHORCADO">
	<meta name="autor" content="BIENVENIDO">
	<link rel="shortcut icon" href="imagenes/completo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="ahorcado.css">
	<?php require_once("funcionesAhorcado.php");?>
</head>

<body>

<?php if(isset($_POST["btnJugar"])&& !isset($_POST["salir"])){?>
	
<header class="hJuego">
	<h1>Juego del Ahorcado</h1>
	<?php 
	$meme="";
		$imgsHorca=scandir("imagenes");
		unset($imgsHorca[array_search("..",$imgsHorca)]);
		unset($imgsHorca[array_search(".",$imgsHorca)]);
		sort($imgsHorca, SORT_NATURAL | SORT_FLAG_CASE);
		$hasGanado=false;
	?>
<?php if(!isset($_POST["letra"])){?>
	<?php 
		

		$arrayPalabrasYDef=damePalabrasYDef();
		$datosVarios["categoria"]=$arrayPalabrasYDef[0];
		$palabraYDef=$arrayPalabrasYDef[array_rand($arrayPalabrasYDef)];
		$palabraYDef=explode("—",$palabraYDef);
		$palabra=$palabraYDef[0];
		$datosVarios["defPalabra"]=$palabraYDef[1];
		$datosVarios["intentos"]=10;
		$letrasPalabra=str_split($palabra);
		unset($letrasPalabra[array_search(" ",$letrasPalabra)]);
		$letrasIntro=[];
		?>
		<h2>Jugamos con: <?php echo $datosVarios["categoria"];?></h2>
		<h2>Te quedan: <?php echo $datosVarios["intentos"];?> intentos</h2>
		<div class="tabla">
			<table>
				<tr>
				<?php 
					for($i=0;$i<count($letrasPalabra);$i++){	
				?>
				<td></td>
				<?php } ?>
				</tr>
			</table>
		</div>
	<?php
		guardarObjeEnFichero($letrasPalabra,"objetosGuardados/ArrayDePalabras.txt");
		guardarObjeEnFichero($datosVarios,"objetosGuardados/datosVarios.txt");
		guardarObjeEnFichero($letrasIntro,"objetosGuardados/arrayPalabrasIntro.txt");
	?>
<?php }else if(isset($_POST["letra"])){?>
	<?php 
		$letrasPalabra=leerObjeEnFichero("objetosGuardados/ArrayDePalabras.txt");
		$datosVarios=leerObjeEnFichero("objetosGuardados/datosVarios.txt");
		$letrasIntro=leerObjeEnFichero("objetosGuardados/arrayPalabrasIntro.txt");
		if($datosVarios["intentos"]<=0)
			$datosVarios["intentos"]=1;
		
		if( insertarEnArrai($letrasIntro,$letrasPalabra,strtolower($_POST["letra"]))==2){
			$datosVarios["intentos"]-=1;
		};
			if(count(array_diff($letrasPalabra,$letrasIntro))==0){
				$hasGanado=true;
				$meme="fondos/ganado.gif";
			}
		$imagen=$imgsHorca[$datosVarios["intentos"]];
		
	?>
	<h2>Jugamos con: <?php echo $datosVarios["categoria"];?></h2>
	<h2>Te quedan: <?php echo $datosVarios["intentos"];?> intentos</h2>
	<div class="imgHorca"><img src="imagenes/<?php echo $imagen;?>" alt="imagen de horca"/></div>
	<div class="tabla">
		<table>
			<tr>
				<?php 
					for($i=0;$i<count($letrasPalabra);$i++){	
				?>
				<td><?php 
				if(isset($letrasIntro[$i]))
					echo $letrasIntro[$i];
				else
					echo "";?> 
				</td>
				<?php } ?>
			</tr>
		</table>
	</div>
	<?php
		guardarObjeEnFichero($letrasPalabra,"objetosGuardados/ArrayDePalabras.txt");
		guardarObjeEnFichero($datosVarios,"objetosGuardados/datosVarios.txt");
		guardarObjeEnFichero($letrasIntro,"objetosGuardados/arrayPalabrasIntro.txt");
	?>
<?php } ?>
	<?php		
		if($datosVarios["intentos"]==0 && !$hasGanado){
			$meme="fondos/perdido.gif";
		}
		$datosVarios=leerObjeEnFichero("objetosGuardados/datosVarios.txt");
		if($datosVarios["intentos"]!==0 && !$hasGanado){
	?>
</header>
		<div class="formJugando"><!-- para insertar una letra si aun no ha ganado tambien se puede abandonar-->
			<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<label for="id_letra">Letra</label>
				<input type="text" name="letra" id="id_letra" autofocus="autofocus"/>
				<input type="hidden" name="btnJugar" />
				<input type="hidden" name="entrado" />
				<input type="submit" value="Insertar" name="insertar"/>
				<input type="submit" value="Salir" name="salir"/>
			</form>	
		</div>
		<?php } else{
			unset($_POST);
			?>
			<h3><?php echo implode($letrasPalabra);?></h3>
			<p><?php echo $datosVarios["defPalabra"]?></p>
		<div class="formTerminado"><!-- se muestra si has ganado o has perdido te permite ir a la siguiente o abandonar -->
			<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<input type="hidden" name="btnJugar" />
				<input type="submit" value="Siguiente" name="Siguiente"/>
				<input type="submit" value="Salir" name="salir"/>
					
			</form>
		</div>
		<?php }
		if($meme){
		?>
<div class="meme"><img src="<?php echo $meme;?>" alt="meme"/></div>
<?php } } else{?>
<!-- Lo que se muestra al principio -->
	<header class="hPrincipal">
		<div><img src="completo.png" alt="imagen del juego"/></div>
		<h1>AHORCADO</h1>
	</header>
	<div class="formPrincipal">
		<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
			<input type="submit" value="JUGAR" name="btnJugar" /><br/>
			<input type="submit" name="btnSalir" value="SALIR"/>
		</form>
	</div>
<?php } ?>
</body>

</html>