<?php include 'Include/headserver.php'; include 'Include/header.php'; ?>
<title>Document</title>
<style>
    table {
        border-spacing: 0;
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        border-left: 1px solid #000;
        width: 100%;
        table-layout: fixed;
    }
    td {
        border-right: 1px solid #000;
        display: table-cell;
    }
    .tabletop {
        background-color: rgb(204,204,204);
    }
    .tablecontent {
        background-color: rgb(238,238,238);
    }
    .tablecontent:nth-child(even) {
        background-color: #fff;
    }
    .inputdiv {
        overflow: hidden;
    }
    .inputdiv > * {
        margin-top: 1pc;
    }
    form {
        float: left;
        width: 80%;
    }
    .addbutton {
        float: right;
        height: 60px;
        width: 60px;
        text-align: center;
        border: 5px solid #000;
        border-radius: 50%;
        background-color: rgb(204,204,204);
    }
    input[type="text"] {
        width: 29%;
    }
    input[type="submit"] {
        width: 5%;
    }
    .sort {
        float: right;
    }
    .hide {
        float: right;
    }
</style>
<?php include 'Include/headeradmin.php' ?>
<script>
    var navlink = document.querySelector("a[href='admin-fasilitashotel.php']");
    navlink.removeAttribute("href");
</script>
<div class="content">
    <table>
        <thead>
        <tr class="tabletop">
            <td class="pointer" onclick="sortTable(this,'string')" data-descending="0">Nama Fasilitas<div class="sort">▼▲<div></td><!-- sort button remember to draw icon -->
            <td class="pointer" onclick="sortTable(this,'string')" data-descending="0">Keterangan<div class="sort">▼▲<div></td>
            <td>Image</td>
            <td class="pointer" onclick="hideTable()">Aksi<div class="hide">▼<div></td><!-- hide button remember to draw icon -->
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="admin") {
        $result=$conn->query("SELECT * FROM fasilitashotel");
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='tablecontent'><td>".$row["namafasilitas"]."</td><td>".$row["keterangan"]."</td><td><img class='imgprev pointer' src='Media/".$row["gambar"]."' onclick='startPreview(\"".$row["gambar"]."\")'></td><td><a class='pointer' onclick='editData(\"".$row["namafasilitas"]."\",\"".$row["keterangan"]."\",\"".$row["gambar"]."\")'>Ubah</a> | <a class='pointer' onclick='openLihat(\"".$row["namafasilitas"]."\")'>Lihat</a></td></tr>";
        }
        }
        ?>
        </tbody>
    </table>
    
    <div class="inputdiv">
    <form class="formedit" method="post" hidden>
        <input id="inputnamafasilitasedit" type="hidden" name="namafasilitasedit">
        <input id="inputnamafasilitas" type="text" name="namafasilitas" placeholder="Nama Fasilitas">
        <input id="inputketerangan" type="text" name="keterangan" placeholder="Keterangan">
        <input id="inputgambar" type="text" name="gambar" placeholder="Image">
        <input id="inputsubmit" type="submit" name="aksi" value="Add">
        <input id="inputsubmitdelete" type="submit" name="aksi" value="Delete">
    </form>
    <?php
    if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="admin") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["aksi"] == "Add" || $_POST["aksi"] == "Edit") {
                
            $valid=true;
            $namafasilitas;
            $keterangan;
            $gambar;
            if (isset($_POST["namafasilitas"]) && !empty($_POST["namafasilitas"])) {
                $namafasilitas = $_POST["namafasilitas"];
            } else {
                $valid=false;
                echo "Nama Fasilitas tidak boleh kosong<br>";
            }
            if (isset($_POST["keterangan"])) {
                $keterangan = $_POST["keterangan"];
            } else {
                $valid=false;
                echo "Keterangan tidak terbaca<br>";
            }
            if (isset($_POST["gambar"])) {
                $gambar = $_POST["gambar"];
            } else {
                $valid=false;
                echo "Image tidak terbaca<br>";
            }
            
            if ($valid == true && !empty($namafasilitas)) {
                if ($_POST["aksi"] == "Add") {
                $insert = "INSERT IGNORE INTO fasilitashotel VALUES ('$namafasilitas','$keterangan','$gambar')";
                $inserted = $conn->query($insert);
                if ($inserted === false) {
                    echo "Data gagal dibuat";
                }
                if ($conn->affected_rows == 0) {
                    echo "Nama Fasilitas tidak boleh sama";
                } else {
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                
                } elseif ($_POST["aksi"] == "Edit") {
                    if (isset($_POST["namafasilitasedit"]) && !empty($_POST["namafasilitasedit"])) {
                        $previd = $_POST["namafasilitasedit"];
                        $insert = "UPDATE IGNORE fasilitashotel SET namafasilitas='$namafasilitas',keterangan='$keterangan',gambar='$gambar' WHERE namafasilitas='$previd'";
                        $inserted = $conn->query($insert);
                        if ($inserted === false) {
                        echo "Data gagal diedit";
                        }
                        if ($conn->affected_rows == 0) {
                        echo "Nama Fasilitas atau data tidak boleh sama atau invalid";
                        } else {
                        echo "<meta http-equiv='refresh' content='0'>";
                        }
                        
                    }
                    
                }
                
            }
        
            } else if ($_POST["aksi"] == "Delete") {
                if (isset($_POST["namafasilitasedit"]) && !empty($_POST["namafasilitasedit"])) {
                    $previd = $_POST["namafasilitasedit"];
                    $insert = "DELETE FROM fasilitashotel WHERE namafasilitas='$previd'";
                    $inserted = $conn->query($insert);
                    if ($inserted === false) {
                        echo "Data gagal dihapus";
                    }
                    if ($conn->affected_rows == 0) {
                        echo "Data tidak ditemukan";
                    } else {
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                    
                }
            }
        }
    }
    ?>
    <h1 class="addbutton pointer" onclick="addData()">+</h1>
    </div>
    
</div>
<div class="footer">
</div>
<div onclick="endPreview()" class="preview" hidden>
    <img>
</div>
<script>
    function sortTable(col, type) {
        var tbody = document.querySelector("tbody");
        var rows = Array.from(tbody.rows);
        var compare;
        if (col.dataset.descending==0) {
            col.dataset.descending=1;
            if (type=="number") {
                compare = function(row1,row2) {
                    return (row2.cells[col.cellIndex].innerHTML - row1.cells[col.cellIndex].innerHTML);
                }
            } else if (type=="string") {
                compare = function(row1,row2) {
                    return (row2.cells[col.cellIndex].innerHTML > row1.cells[col.cellIndex].innerHTML ? 1 : -1);
                }
            }
        } else if (col.dataset.descending==1) {
            col.dataset.descending=0;
            if (type=="number") {
                compare = function(row1,row2) {
                return (row1.cells[col.cellIndex].innerHTML - row2.cells[col.cellIndex].innerHTML);
            }
            } else if (type=="string") {
                compare = function(row1,row2) {
                    return (row1.cells[col.cellIndex].innerHTML > row2.cells[col.cellIndex].innerHTML ? 1 : -1);
                }
            }
        }
        rows.sort(compare);
        tbody.append(...rows);
    }

    function hideTable() {
        document.querySelector("tbody").hidden = !document.querySelector("tbody").hidden;
    }

    function addData() {
        var form = document.querySelector(".formedit");
        var inputnamafasilitasedit = document.getElementById("inputnamafasilitasedit");
        var inputnamafasilitas = document.getElementById("inputnamafasilitas");
        var inputketerangan = document.getElementById("inputketerangan");
        var inputgambar = document.getElementById("inputgambar");
        var inputsubmit = document.getElementById("inputsubmit");
        var inputsubmitdelete = document.getElementById("inputsubmitdelete");

        if (inputsubmit.value=="Add" && form.hidden==false) {
            form.hidden=true;
        } else {
            form.hidden=false;
            inputnamafasilitas.placeholder="Nama Fasilitas";
            inputketerangan.placeholder="Keterangan";
            inputgambar.placeholder="Image";
            inputnamafasilitas.value="";
            inputketerangan.value="";
            inputgambar.value="";
            inputsubmit.value="Add";
            inputsubmitdelete.hidden=true;
        }
    }

    function editData(namafasilitas, keterangan, gambar) {
        var form = document.querySelector(".formedit");
        var inputnamafasilitasedit = document.getElementById("inputnamafasilitasedit");
        var inputnamafasilitas = document.getElementById("inputnamafasilitas");
        var inputketerangan = document.getElementById("inputketerangan");
        var inputgambar = document.getElementById("inputgambar");
        var inputsubmit = document.getElementById("inputsubmit");
        var inputsubmitdelete = document.getElementById("inputsubmitdelete");
        if (inputsubmit.value=="Edit" && inputnamafasilitasedit.value==namafasilitas && form.hidden==false) {
            form.hidden=true;
        } else {
            form.hidden=false;
            inputnamafasilitasedit.value=namafasilitas;
            inputnamafasilitas.placeholder=namafasilitas;
            inputketerangan.placeholder=keterangan;
            inputgambar.placeholder=gambar;
            inputnamafasilitas.value=namafasilitas;
            inputketerangan.value=keterangan;
            inputgambar.value=gambar;
            inputsubmit.value="Edit";
            inputsubmitdelete.hidden=false;
        }
    }

    function openLihat(a) {
        location.href="fasilitas.php#image-"+a;
    }

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