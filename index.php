<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">	
		<title>Conversor de Moneda</title>
		<link rel="shortcut icon" href="https://lh3.googleusercontent.com/T_LqkvbadUMXOCJxa6GIuX7QdJjWAOlxwZ7btCeeQEdAn1TErCsFHgA-cjgemfotlUw=w300">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</head>
	<body>
		<h1 style="text-align:center;">Conversor de moneda</h1>
		<form name="form_moneda" action="index.php" method="post" accept-charset="utf-8" class="form-horizontal" >
			<div class="input-group container" >		
				<label for="valor">Ingrese cantidad a convertir:</label>
				<span class="glyphicon glyphicon-usd"></span>
				<input type="number" value="0" min="0" class="form-control" name="cantidad">
			</div>
			<?php
			    $siglas = array("AUD" => "Dolar Australiano","BGN" => "Lev Bulgaria","BRL" => "Real Brasilenio","CAD" => "Dolar Canadiense","CHF" => "Franco Suizo","CNY" => "Yuan Chino","CZK" => "Corona Checa","DKK" => "Corona Danesa","GBP" => "Libra Esterlina Britanica","HKD" => "Dolar de Hong Kong","HRK" => "Kuna Croata","HUF" => "Florin Hungaro","IDR" => "Rupia Indonesia","ILS" => "Shekel Israeli","INR" => "Rupia Hindu","JPY" => "Yen Japones","KRW" => "Won Surcoreano","MXN" => "Peso Mexicano","MYR" => "Ringgit Malasio","NZD" => "Dolar Neozelandes","PHP" => "Peso Filipino","PLN" => "Zloty Polaco","RON" => "Reu Rumano","RUB" => "Rublo Ruso","SEK" => "Corona Sueca","SGD" => "Dolar Singapurense","THB" => "Baht Thailandes","TRY" => "Lira Turca","USD" => "Dolar Estadounidense","ZAR" => "Rand Sudafricano");			    
			?>
			<div class="input-group container">
				<label class="control-label" for="label_moneda_base">Seleccione moneda base</label>			
				<select name="moneda_base" class="form-control">
					<?php
					    foreach($siglas as $moneda => $desc){
					        echo "<option value=$moneda>$desc</option>";
					    }
					?>
				</select>
			</div>
			<div class="input-group container">
				<label class="control-label" for="label_moneda_covertir">Seleccione moneda a convertir</label>			
				<select name="moneda_convertir" class="form-control">
				<?php
					    foreach($siglas as $moneda => $desc){
					        echo "<option value=$moneda>$desc</option>";
					    }
					?>
				</select>
			</div>
			<button type="submit" class="btn btn-primary center-block" name="enviar">Enviar</button>
			
		</form>
	</body>
</html>

<?php
include 'request_api.php';

if(isset($_POST['enviar']) and isset($_POST['cantidad']))
{
    if($_POST['moneda_base'] != $_POST['moneda_convertir'])
    {
	    //Se realizar la llamada a la API
	    $result = json_decode(callAPI('GET','http://api.fixer.io/latest?base='.$_POST['moneda_base']));
	    //Resultado del tipo de cambio de la moneda
	    $cambio = $_POST['cantidad']*$result->{'rates'}->{$_POST['moneda_convertir']};
	    //print_r($cambio);
	    //Mensaje final de la conversion
	    $moneda_base = $siglas[$_POST['moneda_base']];
	    $moneda_convertir = $siglas[$_POST['moneda_convertir']];
	    $conversion = $_POST['cantidad']." ".$moneda_base." son ".$cambio." ".$moneda_convertir;
	    
	    echo "<div class=\"container\">$conversion</div";	
    }
    else
    {
	    echo "<div class=\"container\">Elija distintas monedas para el cambio</div>";
    }

}
else
{
    echo "<div class=\"container\">Debe ingresar una cantidad para la conversion</div>";
}
?>



