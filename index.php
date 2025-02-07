<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>basdat_db_f1</title>
</head>
<body>
    <h1>Tugas Basdat 20 Oktober 2022</h1>
    <?php
    $servername = "localhost:1224";
    $database = "basdat_db_f1";
    $username = "root";
    $password = "";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    // if (!$conn) {
    //     die("Connection failed: " . mysqli_connect_error());
    // }
    // echo "Connected successfully";


    // persen kerja
    // jumlah kerja
    $kerja = mysqli_query($conn, "SELECT nama_perusahaan FROM `kerja` WHERE nama_perusahaan IS NOT NULL");
    $jumlah_kerja1 = $kerja->num_rows;

    // jumlah slrh
    $semua_kerja = mysqli_query($conn, "SELECT * FROM `kerja`");
    $jumlah_kerja2 = $semua_kerja->num_rows;

    // persentase kerja
    $persen_kerja = $jumlah_kerja1/$jumlah_kerja2*100;

    echo "persen kerja : ".round($persen_kerja,2)."%<br><br>";




    // top 5 kerja
    $top_kerja = mysqli_query($conn, "SELECT COUNT(id_kerja) as id_kerja, nama_perusahaan FROM kerja WHERE nama_perusahaan IS NOT NULL GROUP BY nama_perusahaan ORDER BY COUNT(id_kerja) DESC LIMIT 5;");

    echo "top 5 perusahaan";
    echo "<table>";
    echo "<tr>
    <td>banyak siswa</td>
    <td>nama perusahaan</td>
    </tr>";
    foreach ($top_kerja as $tk) {
        echo "<tr >
            <td>".$tk['id_kerja']."</td>
            <td>".$tk['nama_perusahaan']."</td>
        </tr>";
    }
    echo "</table><br>";

    // foreach ($top_kerja as $tk) {
    //     $jumlahKerja[] = $tk['id_kerja'];
    //     $namaPerusahaan[] = $tk['nama_perusahaan'];
    // }



    // persen kuliah
    // jumlah kuliah
    $kuliah = mysqli_query($conn, "SELECT nama_univ FROM `kuliah` WHERE nama_univ IS NOT NULL");
    $jumlah_kuliah1 = $kuliah->num_rows;

    $semua_kuliah = mysqli_query($conn, "SELECT * FROM `kuliah`");
    $jumlah_kuliah2 = $semua_kuliah->num_rows;

    // persentase kuliah
    $persen_kuliah = $jumlah_kuliah1/$jumlah_kuliah2*100;

    echo "persen kuliah : ". round($persen_kuliah,2)."%<br><br>";




    // top 5 kuliah
    $top_kuliah = mysqli_query($conn, "SELECT COUNT(id_kuliah) as id_kuliah, nama_univ FROM kuliah WHERE nama_univ IS NOT NULL GROUP BY nama_univ ORDER BY COUNT(id_kuliah) DESC LIMIT 5;");

    echo "top 5 kuliah";
    echo "<table>";
    echo "<tr>
    <td>banyak siswa</td>
    <td>nama perusahaan</td>
    </tr>";
    foreach ($top_kuliah as $tk2) {
        echo "<tr >
            <td>".$tk2['id_kuliah']."</td>
            <td>".$tk2['nama_univ']."</td>
        </tr>";
    }
    echo "</table><br>";

    


    // persen nganggur

    // persentase nganggur
    $persen_nganggur = 100-($persen_kerja+$persen_kuliah);

    echo "persen nganggur : ". round($persen_nganggur,2)."%";
    

    ?>
    <div style="width: 650px; margin: 0 auto;">
		<canvas style="margin: 0px;" id="alumni"></canvas>
		<canvas id="univ"></canvas>
		<canvas id="kerja"></canvas>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.1.slim.js" integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
$( document ).ready(function() {
    // alert('hallo')
});
var alumniID = document.getElementById('alumni').getContext('2d');
var kerjaID = document.getElementById('kerja').getContext('2d');
var univID = document.getElementById('univ').getContext('2d');
new Chart(alumniID, {
    type: 'doughnut',
    data: {
        labels: [
            'kerja',
            'kuliah',
            'nganggur'
            ],
        datasets: [{
            label: 'persentase alumni selesai lulus',
            data: [
                <?= round($persen_kerja,2); ?>,
                <?= round($persen_kuliah,2); ?>,
                <?= round($persen_nganggur,2); ?>
            ],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    }
});

new Chart(univID, {
  type: "bar",
  data: {
    labels: [ <?php  foreach($top_kuliah as $b){
         echo "'".$b['nama_univ']."',";
            } ?> ],
    datasets: [{
        label: 'data alumni kuliah',
        backgroundColor:  ["red", "green","blue","orange","brown"],
        data: [ <?php  foreach($top_kuliah as $p){
            echo "'".$p['id_kuliah']."',"; 
                } ?> ] 
        }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "World Wine Production 2018"
    }
  }
});

new Chart(kerjaID, {
  type: "bar",
  data: {
    labels: [ <?php  foreach($top_kerja as $b){
         echo "'".$b['nama_perusahaan']."',";
            } ?> ],
    datasets: [{
        label: 'data alumni kerja',
        backgroundColor:  ["red", "green","blue","orange","brown"],
        data: [ <?php  foreach($top_kerja as $p){
            echo "'".$p['id_kerja']."',"; 
                } ?> ] 
        }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});


</script>
</html>