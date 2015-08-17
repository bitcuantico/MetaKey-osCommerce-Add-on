<?php

	/////////////////////////////////////////////////////////////
	// Addon: MetaKey v1.0
	// Descripción: Genera automáticamente los Meta KeyWords y Description de los productos en OsCommerce
	// Autor: Jonathan Ramírez
	// Twitter: @bitcuantico
	// Sitio Web: http://www.bitcuantico.com
	/////////////////////////////////////////////////////////////

	/////////////////////////INSTALACIÓN/////////////////////////
	//Modifica la variable "$bitcuantico" si tu proyecto no se encuentra en raíz sino en una carpeta
	//Ejemplo: /tienda/ o /shop/
	////////////////////////////////////////////////////////////
	
	$bitcuantico="/";

	////////////////////////////////////////////////////////////////
	////Descripción y Keywords para Página Principal - index.php////
	////////////////////////////////////////////////////////////////
	$url=$_SERVER['REQUEST_URI'];
	$raizi = $bitcuantico."index.php";
	if($url==$bitcuantico || $url==$raizi){

		//Zona de Edición
		$metaDescription = "Ejemplo de descripción en el Addon creado por Jonathan Ramírez de BitCuántico.";
		$metaKeywords ="bitcuantico, jonathan, ramirez, tknologyk";

		echo '<meta name="description" content="' . utf8_decode($metaDescription) . '" />' . "\n";
		echo '<meta name="keywords" content="' . utf8_decode($metaKeywords) . '" />' . "\n";
	}

	/////////////////////////////////////////////////////////////////
	////Descripción y Keywords para Productos - products_info.php////
	/////////////////////////////////////////////////////////////////
	
	if(!empty($HTTP_GET_VARS['products_id'])){

		$producto_id = $HTTP_GET_VARS['products_id'];

		////////////////////////////
		////Inicio - Descripción////
		////////////////////////////
		$metaQuery = "SELECT products_description, products_name FROM products_description WHERE products_id='".$producto_id."'";
		$metaQueryResult = tep_db_query ( $metaQuery );

		while($metaQueryData = tep_db_fetch_array ($metaQueryResult)){

			$metaName = $metaQueryData['products_name'];
			$meta_Name = explode(" ", $metaName);
			$i_maxn = count($meta_Name);

			$metaDescription = $metaQueryData['products_description'];
			while (strstr($metaDescription, '"')) $metaDescription = str_replace('"', '', $metaDescription);
			$metaDescription = strip_tags($metaDescription);
			$patron="[\n|\r|\t|\n\r|\n\r\t]";
			$metaDescription = preg_replace($patron, " ", $metaDescription);
			$meta_key = explode(" ", $metaDescription);
			$i_max = count($meta_key);

			$length = 250;
			$metaDescription = substr($metaDescription, 0, strrpos(substr($metaDescription, 0, $length), ' '));
			$metaDescription .= "...";

			function reem($texto1) {
				$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ', '\"', '€', 'ü');
				$repl = array('&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;', '&ntilde;', '&quot;', '&euro;', '&uuml;');
				$texto1 = str_replace ($repl, $find, $texto1);
				$find = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü', 'ç', 'Ç');
				$repl = array('&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;', '&Ntilde;', '&Uuml;', '&ccedil;', '&Ccedil;');
				$texto1 = str_replace ($repl, $find, $texto1);
				return $texto1;
			}

			$metaDescription = utf8_decode(reem($metaDescription));

			////////////////////////////
			/////Inicio - Keywords//////
			////////////////////////////
		}

		for ($bc=0; $bc < $i_maxn; $bc++) { 
			$hola3 = strlen($meta_Name[$bc]);
			if($hola3>=6){
				if($metaKeywords==""){
					$metaKeywords = $meta_Name[$bc];
				}else{
					$metaKeywords .= ", ".$meta_Name[$bc]."";
				}
			}
		}

		$id_categoria = $current_category_id;
		$metaQuerys = "SELECT categories_name FROM categories_description WHERE categories_id='".$id_categoria."'";
		$metaQueryResults = tep_db_query ( $metaQuerys );

		while($metaQueryDatas = tep_db_fetch_array ($metaQueryResults)){
			$metaCategorid = $metaQueryDatas['categories_name'];
		}
		$metaCategorid = strtolower($metaCategorid);
		$metaKeywords .= ", ".$metaCategorid."";

		for ($xyz=0; $xyz < $i_max; $xyz++){
			$hola2 = strlen($meta_key[$xyz]);

			$coma  = ',';
			$punto = ".";
			$dpunto = ":";
			$guion = "-";
			$cpunto = ";";
			$pos1 = strpos($meta_key[$xyz], $coma);
			$pos2 = strpos($meta_key[$xyz], $punto);
			$pos3 = strpos($meta_key[$xyz], $dpunto);
			$pos4 = strpos($meta_key[$xyz], $guion);
			$pos5 = strpos($meta_key[$xyz], $cpunto);
			$pos1++;
			$pos2++;
			$pos3++;
			$pos4++;
			$pos5++;

			if($hola2==$pos1 || $hola2==$pos2 || $hola2==$pos3 || $hola2==$pos4 || $hola2==$pos5){
				$meta_key[$xyz] = substr($meta_key[$xyz], 0, -1);
			}

			$meta_key[$xyz] = strtolower($meta_key[$xyz]);
			$meta_key = array_unique($meta_key);

			$meta_key[$xyz] = utf8_decode(reem($meta_key[$xyz]));

			$var4 = "&";

			$pos = strpos($meta_key[$xyz], $var4);

			if ($pos === false) {
				$hola3 = strlen($meta_key[$xyz]);
				if($hola3>=6){
					$metaKeywords .= ", ".$meta_key[$xyz]."";
				}
			}
		}

		$metaKeywords = substr($metaKeywords, 0, 999);

		echo '<meta name="description" content="' . $metaDescription . '" />' . "\n";
		echo '<meta name="keywords" content="' . $metaKeywords . '" />' . "\n";
	
	}
?>