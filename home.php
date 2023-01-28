<?php include 'Include/headserver.php'; include 'Include/header.php'; ?>
<title>Document</title>
<style>
    .fatas {
        margin-top: 1pc;
        overflow: hidden;
        text-align: center;
    }
    .fatas > div {
        display: inline-block;
        margin-left: 4pc;
        margin-right: 4pc;
        text-align: left;
    }
    .fatas > div > input[type="number"] {
        width: 60px;
    }
    .hoteltentang {
        margin-top: 3pc;
        text-align: center;
    }
    .hoteltentang p {
        margin-top: 1pc;
        text-align: justify;
    }
    .fbawah {
        margin-top: 1pc;
        margin-left: auto;
        margin-right: auto;
        width: 70%;
    }
    .fbawah table {
        width: 60%;
        margin: 0.5pc 1pc;
        /* border-spacing: 1pc; */
    }
    .fbawah table tr td {
        width: 50%;
    }
    .fbawah table tr td > * {
        margin-top: 0.5pc;
        margin-bottom: 0.5pc;
    }
    .fbawah *[type="submit"] {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<?php include 'Include/headertamu.php'; ?>
<script>
    var navlink = document.querySelector("a[href='home.php']");
    navlink.removeAttribute("href");
</script>
<div class="content">
    <div class="hotelthumbnail"></div>
    <?php
$samename=0;
$invaliddate=0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["hak"]=="tamu") {
        
  $valid=true;
  $namapemesanan;
  $email;
  $nohandphone;
  $namatamu;
  $tipekamar;
  $tanggalcekin;
  $tanggalcekout;
  $jumlahkamar;
  if (isset($_POST["tanggalcekin"]) && !empty($_POST["tanggalcekin"])) {
    $tanggalcekin = $_POST["tanggalcekin"];
  } else {
    $valid=false;
    echo "Tanggal Cek In tidak boleh kosong<br>";
  }
  if (isset($_POST["tanggalcekout"]) && !empty($_POST["tanggalcekout"])) {
    $tanggalcekout = $_POST["tanggalcekout"];
  } else {
    $valid=false;
    echo "Tanggal Cek Out tidak boleh kosong<br>";
  }
  if (isset($_POST["jumlahkamar"]) && !empty($_POST["jumlahkamar"])) {
    $jumlahkamar = $_POST["jumlahkamar"];
  } else {
    $valid=false;
    echo "Jumlah Kamar tidak boleh kosong<br>";
  }
  if (isset($_POST["namapemesanan"]) && !empty($_POST["namapemesanan"])) {
    $namapemesanan = $_POST["namapemesanan"];
  } else {
    $valid=false;
    echo "Nama Pemesanan tidak boleh kosong<br>";
  }
  if (isset($_POST["email"]) && !empty($_POST["email"])) {
      $email = $_POST["email"];
  } else {
  $valid=false;
  echo "Email tidak boleh kosong<br>";
  }
  if (isset($_POST["nohandphone"]) && !empty($_POST["nohandphone"])) {
    $nohandphone = $_POST["nohandphone"];
  } else {
    $valid=false;
    echo "No Handphone tidak boleh kosong<br>";
  }
  if (isset($_POST["namatamu"]) && !empty($_POST["namatamu"])) {
    $namatamu = $_POST["namatamu"];
  } else {
    $valid=false;
    echo "Nama Tamu tidak boleh kosong<br>";
  }
  if (isset($_POST["tipekamar"]) && !empty($_POST["tipekamar"])) {
    $tipekamar = $_POST["tipekamar"];
  } else {
    $valid=false;
    echo "Tipe Kamar tidak boleh kosong<br>";
  }
  if ($tanggalcekin >= $tanggalcekout) {
    $valid=false;
    $invaliddate=1;
  }
  if ($valid == true && !empty($namapemesanan) && !empty($email) && !empty($nohandphone) && !empty($namatamu) && !empty($tipekamar) && !empty($tanggalcekin) && !empty($tanggalcekout) && !empty($jumlahkamar)) {
    
      $insert = "INSERT IGNORE INTO pemesanan VALUES ('$namapemesanan','$email','$nohandphone','$namatamu','$tipekamar','$tanggalcekin','$tanggalcekout','$jumlahkamar')";
      $inserted = $conn->query($insert);
      if ($inserted === false) {
        echo "Data gagal dibuat";
      }
      if ($conn->affected_rows == 0) {
        $samename=1;
      } else {
        echo "<script type='text/javascript'>alert('Pemesanan $namapemesanan berhasil');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
      }
    
    
  }
}

function samename() {
  global $samename;
  if ($samename) {
    echo "<br><span style='color:#F00;'>Nama Pemesanan tidak boleh sama</span>";
  }
}

function invaliddate() {
  global $invaliddate;
  if ($invaliddate) {
    echo " <span style='color:#F00;'>Tanggal tidak valid</span>";
  }
}

?>
    <form class="formpesan" method="post">
        <div class="fatas">
            <div>
                <p>Tanggal Cek In</p>
                <input name="tanggalcekin" type="date" required>
            </div>
            <div>
                <p>Tanggal Cek Out</p>
                <input name="tanggalcekout" type="date" required><?php invaliddate(); ?>
            </div>
            <div>
                <p>Jumlah Kamar</p>
                <input name="jumlahkamar" type="number" min="1" required>
            </div>
            <div>
                <button type="button" onclick="toggleHidden(document.getElementsByClassName('fbawah')[0],document.getElementsByClassName('hoteltentang')[0])">Pesan</button>
            </div>
        </div>
        

        <div class="fbawah" hidden>
            <h1>Form Pemesanan</h1>
            <table>
                <tr>
                    <td><p>Nama Pesanan</p></td>
                    <td><input name="namapemesanan" type="text" required><?php samename(); ?></td>
                </tr>
                <tr>
                    <td><p>Email</p></td>
                    <td><input name="email" type="email" required></td>
                </tr>
                <tr>
                    <td><p>No Handphone</p></td>
                    <td><input name="nohandphone" type="tel" required></td>
                </tr>
                <tr>
                    <td><p>Nama Tamu</p></td>
                    <td><input name="namatamu" type="text" required></td>
                </tr>
                <tr>
                    <td><p>Tipe Kamar</p></td>
                    <td><select name="tipekamar" required>
                        <option disabled selected></option>
                        <?php
                        $result = $conn->query("SELECT tipekamar FROM kamar");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["tipekamar"]."'>".$row["tipekamar"]."</option>";
                        }
                        ?>
                    </select></td>
                </tr>
            </table>
            <button type="submit">Konfirmasi Pesanan</button>
        </div>
        
    </form>
    <script>
        function toggleHidden(a,b) {
            a.hidden=!a.hidden;
            b.hidden=!b.hidden;
        }
    </script>
    <div class="hoteltentang">
        <h1>Tentang Kami</h1>
        <p>Hotel Arga merupakan hotel satu-satunya di Tangsel yang menawarkan kamar paling berkualitas untuk para tamu. Dengan kolam renang sebesar 250m x 500m dan restoran mewah, Hotel arga memiliki fasilitas yang paling bagus dan mendapat piagam dari PBB dan Kementerian Pariwisata dan Ekonomi Kreatif Indonesia. Kami juga menawarkan harga yang terjangkau dengan kualitas yang tetap bagus.</p>
    </div>
</div>
<div class="footer">
</div>
<?php include 'Include/footer.php'; mysqli_close($conn);?>