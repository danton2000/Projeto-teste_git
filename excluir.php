<?php
	require_once("model/crud.class.php");
	$id_produto = "";
	$nome = "";

	$id_produto_get = $_GET['id_produto'];//PEGO NA URL DA PAGINA
	if(isset($id_produto_get)){
		$produto = new Crud("produtos");
		$filtro = array(
			"id_produto" => $id_produto_get
		);
		$resposta = $produto->selectCrud("*", true, $filtro);
		$nome = $resposta[0]->nome;
		// echo "<pre>";
		// print_r($resposta);
		// echo "</pre>";
		$nome = $resposta[0]->nome;
		$id_produto = $resposta[0]->id_produto;
		if (isset($_GET['confirmar'])){
			$resposta = $produto->excluiCrud($filtro);
			if ($resposta) header("Location: index.php");
		}
	}

?>

<!DOCTYPE php>
<html lang="pt-br">
<head>
  <title>Excluir produto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">	
		<div class="row pt-4">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<h2>Excluir o produto " <?php echo htmlspecialchars($nome);?>" ?</h2>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 mt-4">
				<a class="btn btn-danger" href="excluir.php?id_produto=<?php echo $id_produto; ?>&confirmar">Confirmar</a>
				<a class="btn btn-secondary" href="index.php">Cancelar</a>
			</div>
		</div>
	</div>
</body>
</html>
