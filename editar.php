<?php
require_once("model/crud.class.php");
	$id_produto = "";
	$nome = "";
	$preco ="";
	$id_produto_get = $_GET['id_produto'];

	if (isset($id_produto_get)){
		$produto = new Crud("produtos");
		$filtro = array(
			"id_produto" => $id_produto_get
		);
		$resposta = $produto->selectCrud("*", true, $filtro);
		$nome = $resposta[0]->nome;
		$id_produto = $resposta[0]->id_produto;
		$preco = $resposta[0]->preco;
	}

	if (isset($_POST['editar'])){
		$produto = new Crud("produtos");
		$array_dados = array(
			"nome" => $_POST['nome'],
			"preco" => $_POST['preco']
		);
		$array_id =array(
			"id_produto" => $_POST['id_produto']
		);
		$resposta = $produto->atualizaCrud($array_dados, $array_id);
		if ($resposta) header("Location: index.php?editar=sucesso");
		else
			header("Location: index.php?editar=erro");
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Editar produto</title>
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
				<h2>Editar de produto</h2>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12">
			<form action="editar.php" method="POST" class="was-validated">
					<input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
					<div class="form-group">
					  <label for="nome">Nome:</label>
					  <input type="text" class="form-control" id="nome" placeholder="Nome do produto" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>				  
					</div>	
					<div class="form-group">
					  <label for="preco">Preço (R$):</label>
					   <input type="number" min="1" step="any" class="form-control" id="preco" placeholder="00,00" value="<?php echo htmlspecialchars($preco); ?>" name="preco" required>				  
					</div>
					<button type="submit" name="editar" class="btn btn-primary">Salvar alterações</button>
				</form>  
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 text-center mt-4">
				<a class="btn btn-danger" href="index.php">Voltar</a>
			</div>
		</div>
	</div>
</body>
</html>
