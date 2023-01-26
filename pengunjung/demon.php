<?php 
	require_once "../vendor/autoload.php";
	$client 	= new MongoDB\Client;
	$dataBase 	= $client->selectDatabase('BDLcrud');
	$collection = $dataBase->selectCollection('anime');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Character Demon</title>	
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
   <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../css/pengunjung.css">
	<link rel="stylesheet" href="../css/footer.css">
	<link rel="icon" type="image/x-icon" href="../img/icon.png">

	<style>
	    .footer-distributed{
	        width: 88.1%;
	    }
   </style
</head>
<body class="bg" style="background-image: url(../img/history.jpg)">
	<div class="left">
    	<div class="logo">
            <a href="../index.php"><img src="../img/logo.png" width="140"></a>
        </div>
        <div class="atas">
            <ul>
                <li><a href="dashboard.php">History Tensura</a></li>
                <li><a href="tempest.php">Tempest Character</a></li>
                <li><a href="demon.php">Demon Character</a></li>
                <li><a href="angel.php">Angel Character</a></li>
            </ul>
        </div>
	</div>

	<div class="container">
		<div class="isi">
			<center><b>DEMON</b></center> <br>
			<div class="paragraf">
				Demon (悪魔族デ ー モ ン setan , menyala. "Suku Iblis" ? ) adalah ras utama Bentuk Kehidupan Spiritual dan merupakan makhluk magis yang berasal dari unsur. Mereka memiliki keunggulan melawan Malaikat tetapi pada gilirannya dirugikan melawan Elemental .</b> <br> <br>
				<b>Latar Belakang</b>
			</div>
			<div class="paragraf">
				Daemon secara spontan muncul di dunia spiritual, di mana mereka saling bertarung tanpa henti. Kadang-kadang mereka mungkin dipanggil ke Dunia Material, di mana mereka membutuhkan Tubuh Material untuk tetap secara permanen atau mereka akan dikeluarkan kembali ke Dunia Daemon oleh kekuatan penolakan Dunia Material. <br> <br>

				Daemon memiliki daya tahan sihir yang kuat, dan meski tanpa tubuh fisik, gunakan media sementara yang terbuat dari magicules yang dikenal sebagai "Magic Body" untuk berinteraksi dengan bidang material. Tubuh ajaib ini membuat serangan fisik tidak berguna melawan mereka karena, meskipun rusak, mereka dapat dengan mudah mengembalikannya ke bentuk aslinya. Begitu Daemon menjelma menjadi bejana fisik, energi mereka menyublim di dalamnya dan mulai berubah menjadi sesuatu yang benar-benar milik mereka. Namun tubuh mereka, tidak mempertahankan manfaat yang sama seperti korpus magis murni dan serangan fisik dapat membahayakan mereka. Secara khusus, efek yang murni alami, seperti yang dihasilkan oleh elemental, sangat efektif melawan mereka karena perlawanan mereka terhadap sihir menjadi tidak berarti. <br> <br>
				<b></b>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="tabel">
			<table class="table table-striped table-bordered data">
				<thead>
					<tr>			
						<th>Gambar Charcater</th>
						<th>Nama Charcater</th>
						<th>Title Charcater</th>
						<th>Deskripsi Charcater</th>
					</tr>
				</thead>

				<tbody>
					<?php 
						$tabel = 'ktg';
						$keyword = 'demon';
						$filter = array($tabel=> new MongoDB\BSON\Regex($keyword));

						$ttl = $collection->count($filter);
						echo "<b>Banyak Character $ttl</b> <br> <br>";

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
							echo "</tr>";		
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<footer class="footer-distributed">
        <div class="footer-left">
            <h3>Tensura<span>pedia</span></h3>
            <p class="footer-company-name"></p>
        </div>

        <div class="footer-center">
        <div>
            <i class="fa fa-whatsapp"></i>
            <p><a href="https://api.whatsapp.com/send/?phone=08993959351">+628993959351</a></p>
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="#">TugasBDL@bdl.com</a></p>
        </div>
            </div>
            <div class="footer-right">
                <p class="footer-company-about">
                <span>Tentang kami</span>
                Kelompok kami terdiri dari 3 orang, yaitu Jonathan, Surya, dan Lutfi</p>
                <div class="footer-icons">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
    </footer>

</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('.data').DataTable();
	});
</script>
</html>