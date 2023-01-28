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
    .fasilitas {
      margin-top: 2pc;
    }
    .gallery {
      overflow: hidden;
      text-align: justify;
      margin-top: 1pc;
    }
    .fimage {
      display: inline-block;
      width: 33%;
      aspect-ratio: 3/2;
      border: 1px solid #000;
      object-fit: cover;
    }
    /* .gallery:after {
      content: "";
      width: 100%;
      display: inline-block;
    } */
</style>
<?php include 'Include/headertamu.php'; ?>
<script>
    var navlink = document.querySelector("a[href='fasilitas.php']");
    navlink.removeAttribute("href");
</script>
<div class="content">
    <div class="hotelthumbnail"></div>
    <div class="fasilitas">
    <h1>Fasilitas</h1>
    <div class="gallery">
    
<?php
$result = $conn->query("SELECT namafasilitas,gambar FROM fasilitashotel");
while ($row = $result->fetch_assoc()) {
  echo "<img class='fimage pointer' id='image-".$row["namafasilitas"]."' src='Media/".$row["gambar"]."' onclick='startPreview(\"".$row["gambar"]."\")'>\n";
}
?>

    </div>
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