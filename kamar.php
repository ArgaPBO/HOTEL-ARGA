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
        text-align: left;
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
    .listkamar {
      margin-top: 2pc;
      margin-left: auto;
      margin-right: auto;
      width: 80%;
    }
    .infokamar {
      margin-bottom: 2pc;
    }
    .infokamar img {
      border: 1px solid #000;
      width: 100%;
      height: 20pc;
      object-fit: cover;
    }
    .infokamar p {
      margin-left: 6.5px;
    }

</style>
<?php include 'Include/headertamu.php'; ?>
<script>
    var navlink = document.querySelector("a[href='kamar.php']");
    navlink.removeAttribute("href");
</script>
<div class="content">
    <div class="hotelthumbnail"></div>
    <div class="listkamar">
<?php
$result = $conn->query("SELECT * FROM kamar");
while ($row = $result->fetch_assoc()) {
    echo "<div class='infokamar' id='info-".$row["tipekamar"]."'>
    <img class='pointer' onclick='startPreview(\"".$row["gambar"]."\")' src='Media/".$row["gambar"]."'>
    <h1>Tipe ".$row["tipekamar"]."</h1>
    <p class='pre'>Fasilitas:\n";
    $result2 = $conn->query("SELECT namafasilitas FROM fasilitaskamar WHERE kamar_tipekamar='".$row["tipekamar"]."'");
    $totalrows = $result2->num_rows;
    $currentrow = 0;
    while ($row2 = $result2->fetch_assoc()) {
      $currentrow+=1;
      echo $row2["namafasilitas"];
      if ($currentrow < $totalrows) {
        echo "\n";
      }
    }
    echo "</p></div>";
}
?>
    </div>
</div>
<div class="footer">
</div>
<div onclick="endPreview()" class="preview" hidden>
    <img>
</div>
<script>
    function startPreview(image) {
        var preview = document.querySelector(".preview");
        var img = document.querySelector(".preview img");
        preview.hidden = false;
        img.src = "Media/"+image;
    }
    function endPreview() {
        var preview = document.querySelector(".preview");
        preview.hidden = true;
    }
</script>
<?php include 'Include/footer.php'; mysqli_close($conn);?>