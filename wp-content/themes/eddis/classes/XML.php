<?php
/*
* Clase simple para cargar el contenido de un archivo en un objeto XML
*/
 class xml {
 	function parseXML($filename) {
 		if (file_exists($filename)) {
 			$xml=simplexml_load_file($filename);
 			// esta orden muestra el resultado de xml
 			//var_dump($xml);
			return $xml; 			
 		} else {
 			echo $filename;
 			exit("Error al abrir el archivo XML");
 		}
 	}
 }