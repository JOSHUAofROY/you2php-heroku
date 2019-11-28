<?
function extraeDato($datoSalida,$cortaIni,$cortaFin){
	$largoTotal = strlen($datoSalida);
	$largoCorta_ini= strpos($datoSalida,$cortaIni);
	$largoCorta_ini = $largoCorta_ini + strlen($cortaIni);
	$cortado = substr($datoSalida, $largoCorta_ini, $largoTotal);
	$largoCorta_fin = strpos($cortado,$cortaFin);
	$cortado = substr($cortado, 0, $largoCorta_fin);
	return $cortado;
}
function escribeErrorTxt($error){
	$lineaTxt = "";
	$lineaTxt='Error:'.$error;
	$fp=fopen("Error.txt","a");
	fwrite($fp,$lineaTxt);
	fwrite($fp,chr(13).chr(10));
	fclose($fp);
}
function guardaResultTxt($proxy,$visitas){
	$lineaTxt = "";
	if($visitas == null){
		$visitas = "error";
		$archivo = "resultError.txt";
	}else{
		$archivo = "resultOK.txt";
	$lineaTxt=$proxy.";".$visitas.";".date("d-m-Y H:i:s");
	}
	$fp=fopen($archivo,"a");
	fwrite($fp,$lineaTxt);
	fwrite($fp,chr(13).chr(10));
	fclose($fp);
}
function traeProxy(){
	$num = count(file("proxys.txt")) - 1; 

	$rand = rand(0,$num);
	$proxy = trim(Proxy("proxys.txt", $rand));

	if($proxy == "stop"){
		$retorno = array(  
			'estado' => 'Termino',  
			'texto' => 'Se terminaron los proxys.'
		  );

		return $retorno;
	}
	else{
		if(LineaExisteEnOtroArchivo($proxy, "proxysOcupados.txt") == 1)
		{	        
			$retorno = array(  
				'estado' => 'Ocupado',  
				'texto' => 'Proxy ocupado.'
			  );

			return $retorno;
		}
		else
		{
			$retorno = array(  
				'estado' => 'Exito',  
				'proxy' => $proxy
			  );

			return $retorno;
		}
	}
}
function RecargarPagina($tiempo,$url)
	{
		return "<META HTTP-EQUIV='REFRESH' CONTENT='$tiempo;URL=$url'>";
	}
function Proxy($file, $numero)
{
	$archivo = file($file);

	$numerodeproxys = count($archivo);

	if($numero < $numerodeproxys)
	{
		return $archivo[$numero];
	}
	else
	{
		return "stop";
	}
}
function LineaExisteEnOtroArchivo($linea, $Archivo)
	{
		$fp = fopen($Archivo, "r");
	   
	    while (!feof($fp)) 
	    {
  		  $current_line = fgets($fp);
  		  
	      if (strcmp(trim($linea), trim($current_line)) == 0)
	      {
     		  fclose($fp);
			  
			  return 1;
	      }
        }
        
        fclose($fp);
        
        return 0;
	}
?>