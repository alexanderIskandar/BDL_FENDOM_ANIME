<!DOCTYPE html>
<html>
<head>
	<title>Admin Tempest</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	
	<script src="../js/jquery-3.6.1.min.js"></script>
    
    <link rel="stylesheet" href="../css/menubar.css">

    <style>
        .container {
            margin-left: 160px;
        }

        .left .logo {
            margin-top: 10%;
            text-align: center;
        }
    </style>
</head>
<body>
	<!-- isi -->
    <div class="left">
    	<div class="logo">
            <img src="../img/logo.png" width="140">
        </div>
        <div class="atas">
            <ul>
                <li><a href="dashboard.php">History Tensura</a></li>
                <li><a href="add_tempest.php">Tempest Character</a></li>
                <li><a href="add_demon.php">Demon Character</a></li>
                <li><a href="add_angel.php">Angel Character</a></li>
            </ul>
        </div>
        <div class="bawah">
            <ul>
                <li><a href="logout.php">Log out <i class="fa fa-sign-out"></i></i></a></li>
            </ul>
        </div>
	</div>

	<div class="container">
        <center><h1>Tempest Character</h1></center>
        <hr>
		<div class="text-center">
			<?php 
				require_once "../vendor/autoload.php";
				$client 	= new MongoDB\Client;
				$dataBase 	= $client->selectDatabase('BDLcrud');
				$collection = $dataBase->selectCollection('anime');
				if(isset($_POST['create'])) {
					$data 		= [
						'nama' 		=> $_POST['nama'],
						'title' 	=> $_POST['title'],
						'desk' 		=> $_POST['desk'],
						'ktg' 		=> $_POST['ktg']
					];

					if($_FILES['file']) {
						if(move_uploaded_file($_FILES['file']['tmp_name'], '../upload/'.$_FILES['file']['name'])) {
							$data['fileName'] = $_FILES['file']['name'];
						} else {
							echo "Failed to upload file.";
						}
					}

					$result = $collection->insertOne($data);
					if($result->getInsertedCount()>0) {
						echo "Article is created..";
						header("location: add_tempest.php");
					} else {
						echo "Failed to create Article";
					}
				}

				if(isset($_POST['update'])) {
					
					$filter		= ['_id' => new MongoDB\BSON\ObjectId($_POST['aid'])];

					$data 		= [
						'nama' 		=> $_POST['nama'],
						'title' 	=> $_POST['title'],
						'desk' 		=> $_POST['desk'],
						'ktg' 		=> $_POST['ktg']
					];

					$result = $collection->updateOne($filter, ['$set' => $data]);

					if($result->getModifiedCount()>0) {
						echo "Character is updated..";
						header("location: add_tempest.php");
					} else {
						echo "Failed to update Character";
					}
				}

				if(isset($_GET['action']) && $_GET['action'] == 'delete') {
					
					$filter		= ['_id' => new MongoDB\BSON\ObjectId($_GET['aid'])];

					$article = $collection->findOne($filter);
					if(!$article) {
						echo "Character not found.";
					}

					$fileName = '../upload/'.$article['fileName'];
					if(file_exists($fileName)) {
						if(!unlink($fileName)) {
							echo "Failed to delete file."; exit;
						}
					}

					$result = $collection->deleteOne($filter);

					if($result->getDeletedCount()>0) {
						echo "Character is deleted..";
						header("location: add_tempest.php");
					} else {
						echo "Failed to delete Character";
					}

					
				}

			?>
		</div>
		<div class="row">
		    <div class="col-md-4">
			    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
					<fieldset>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-12" for="nama">Nama</label>  
						  <div class="col-md-12">
						  <input id="nama" name="nama" type="text" placeholder="" class="form-control input-md">
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-12" for="title">Title</label>  
						  <div class="col-md-12">
						  <input id="title" name="title" type="text" placeholder="" class="form-control input-md">
						  </div>
						</div>

						<!-- Text Area-->
						<div class="form-group">
						  <label class="col-md-12" for="desk">Deskripsi</label>  
						  <div class="col-md-12">
						  <textarea id="desk" name="desk" placeholder="" class="form-control" rows="6"></textarea>
						  </div>
						</div>

						<div class="form-group">
							<label class="col-md-12" for="desk">Kategoti Karakter</label>
							<div class="col-md-12">
								<select name="ktg" class="form-control" id="ktg">
									<option>-- Kategori --</option>
									<option value="tempest">Tempest</option>
									<option value="demon">Demon</option>
			                        <option value="angel">Angel</option>
		                        </select>
	                        </div>
                    	</div>

						<!-- File input-->
						<div class="form-group" id="fileInput">
						  <label class="col-md-12" for="file">Select Image</label>  
						  <div class="col-md-12">
						  <input id="file" name="file" type="file" placeholder="" class="form-control input-md">
						  </div>
						</div>

						<!-- Hidden article id -->
						<input type="hidden" name="aid" id="aid">

						<button id="create" name="create" class="btn btn-primary">Add Character</button>
						<button id="update" style="display: none;" name="update" class="btn btn-primary">Update Character</button>

					</fieldset>
				</form>
		    </div>
		    <div class="col-md-8">
		    	<!-- Show -->
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Picture</th>
							<th scope="col">Name</th>
							<th scope="col">Title</th>
							<th scope="col">Deskripsi</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<?php 
						$tabel = 'ktg';
						$keyword = 'tempest';
						$filter = array($tabel=> new MongoDB\BSON\Regex($keyword));

						$articles = $collection->find($filter);
						foreach ($articles as $key => $article) {
							$data = json_encode( [
								'id' 			=> (string) $article['_id'],
								'nama' 		=> $article['nama'],
								'title' 	=> $article['title'],
								'desk' 		=> $article['desk']
							], true);

							echo "<tr>";
							echo "<th scope='row'><img src='../upload/".$article['fileName']."' width='100' height='100'></th>";
							echo "<td>".$article['nama']."</td>";
							echo "<td>".$article['title']."</td>";
							echo "<td>".$article['desk']."</td>";
							echo "<td>";
							echo "<a href = 'javascript:updateArticle($data)' class='btn btn-primary fa fa-gear'></a>";
							echo "<a href = 'add_tempest.php?action=delete&aid=".$article['_id']."'class='btn btn-danger fa fa-trash'></a>";
							echo "</td>";
							echo "</tr>";		
						}
					?>
				</table>
		    </div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	function updateArticle(article) {
		console.log(article);
		$('#aid').val(article.id);
		$('#nama').val(article.nama);
		$('#title').val(article.title);
		$('#desk').val(article.desk);
		$('#ktg').val(article.ktg);

		$('#create').hide();
		$('#fileInput').hide();
		$('#update').show();
	}
</script>