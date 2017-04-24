<?php
function callAPI($method, $url, $data = false)
{
    $curl = curl_init();
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

if(isset($_POST['enviar']) and isset($_POST['cantidad']))
{
	if($_POST['moneda_base'] != $_POST['moneda_convertir'])
	{
		//Se realizar la llamada a la API
		$result = json_decode(callAPI('GET','http://api.fixer.io/latest?base='.$_POST['moneda_base']));
		//Resultado del tipo de cambio de la moneda
		$cambio = (float)$_POST['cantidad']*(float)$result->{'rates'}->{$_POST['moneda_convertir']};
		//Mensaje final de la conversion
		echo $_POST['cantidad']." ".$_POST['moneda_base']." son ".$cambio." ".$_POST['monedas'].$_POST['moneda_convertir'];	
	}
	else
	{
		echo "Elija distintas monedas para el cambio";
	}
	
}
else
{
	echo "Debe ingresar una cantidad para la conversion";
}
?>