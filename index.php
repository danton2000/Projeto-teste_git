<?php
	require_once("model/crud.class.php");
	if(isset($_POST['cadastrar'])){
		$nome = $_POST['nome'];
		$preco = $_POST['preco'];

		$produtos = new Crud("produtos");
		$array_dados = array(
			"nome" => $nome,
			"preco" => $preco
		);	
		$resposta = $produtos->insereCrud($array_dados);//precisa criar um array com os dados
		if($resposta){
			header("location: index.php?cadastrar=sucesso");
		}else{
			header("location: index.php?cadastrar=erro");
		}
	}
?>

<!DOCTYPE php>
<html lang="pt-br">
<head>
  <title>Cadastro de produtos</title>
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
		   <div class="col-sm-12 col-md-6 col-lg-6">
				<h2>Lista de produtos</h2>			
		   </div>
		   <div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">Cadastro de produtos</button>
				<!-- The Modal -->
				<div class="modal fade" id="myModal">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <!-- Modal Header -->
					  <div class="modal-header">
						<h4 class="modal-title">Cadastro de produtos</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					  </div>
					  <!-- Modal body -->
					  <div class="modal-body">
							<form action="index.php" method="POST" class="was-validated">
								<div class="form-group">
								  <label for="nome">Nome:</label>
								  <input type="text" class="form-control" id="nome" placeholder="Nome do produto" name="nome" required>				  
								</div>	
								<div class="form-group">
								  <label for="preco">Preço (R$):</label>
								   <input type="number" min="1" step="any" class="form-control" id="preco" placeholder="00,00" name="preco" required>				  
								</div>
								<button name="cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
							</form>   
						</div>
					  <!-- Modal footer -->
					  <div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
					  </div>
					</div>
				  </div>
				</div>
		   </div>
		</div>
		
		<table class="table table-striped">
		<thead>
		  <tr>
			<th>Id</th>
			<th>Nome</th>
			<th>Preço</th>
			<th class="text-center">Ações</th>
		  </tr>
		</thead>
		<tbody>
			<?php
				$produtos = new Crud("produtos");
				$resposta = $produtos->selectCrud("*");//$resposta está em formato de array

				foreach($resposta as $indice => $valor){
					echo '<tr>';
						echo '<td>' . $valor->id_produto . '</td>';
						echo '<td> ' . $valor->nome . ' </td>';
						echo '<td>R$' . $valor->preco . ' </td>';
						echo '<td class="text-center">';
						echo '<a href="editar.php?id_produto='. $valor->id_produto .'"name="editar" title="Editar"><i class="fa fa-pencil"></i></a> ';
						echo '<a href="excluir.php?id_produto='. $valor->id_produto .'"name="excluir" title="Excluir"><i class="fa fa-trash-o text-danger"></i></a>';
						echo '</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		</table>
	</div>
</body>
</html>
