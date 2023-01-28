<?php include 'Include/headserver.php'; include 'Include/cekadmin.php'; include 'Include/header.php'; ?>
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
        width: 30%;
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
    var navlink = document.querySelector("a[href='admin-kamar.php']");
    navlink.removeAttribute("href");
</script>
<div class="content">
    <table>
        <thead>
        <tr class="tabletop">
            <td class="pointer" onclick="sortTable(this,'string')" data-descending="0">Tipe Kamar<div class="sort">▼▲<div></td>
            <td class="pointer" onclick="sortTable(this,'number')" data-descending="0">Jumlah Kamar<div class="sort">▼▲<div></td><!-- sort button remember to draw icon -->
            <td>Image</td>
            <td class="pointer" onclick="hideTable()">Aksi<div class="hide">▼<div></td><!-- hide button remember to draw icon -->
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="admin") {
        $result=$conn->query("SELECT * FROM kamar");
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='tablecontent'><td>".$row["tipekamar"]."</td><td>".$row["jumlahkamar"]."</td><td><img class='imgprev pointer' src='Media/".$row["gambar"]."' onclick='startPreview(\"".$row["gambar"]."\")'></td><td><a class='pointer' onclick='editData(\"".$row["tipekamar"]."\",".$row["jumlahkamar"].",\"".$row["gambar"]."\")'>Ubah</a> | <a class='pointer' onclick='openLihat(\"".$row["tipekamar"]."\")'>Lihat</a></td></tr>";
        }
        }
        ?>
        </tbody>
    </table>
    
    <div class="inputdiv">
    <form class="formedit" method="post" hidden>
        <input id="inputtipekamaredit" type="hidden" name="tipekamaredit">
        <input id="inputtipekamar" type="text" name="tipekamar" placeholder="Tipe Kamar">
        <input id="inputjumlahkamar" type="number" min="1" name="jumlahkamar" placeholder="Jumlah Kamar">
        <input id="inputgambar" type="text" name="gambar" placeholder="Gambar">
        <input id="inputsubmit" type="submit" name="aksi" value="Add">
        <input id="inputsubmitdelete" type="submit" name="aksi" value="Delete">
    </form>
    <?php
    if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="admin") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["aksi"] == "Add" || $_POST["aksi"] == "Edit") {
                
            $valid=true;
            $tipekamar;
            $jumlahkamar;
            $gambar;
            if (isset($_POST["tipekamar"]) && !empty($_POST["tipekamar"])) {
                $tipekamar = $_POST["tipekamar"];
            } else {
                $valid=false;
                echo "Tipe Kamar tidak boleh kosong<br>";
            }
            if (isset($_POST["jumlahkamar"]) && !empty($_POST["jumlahkamar"])) {
                $jumlahkamar = $_POST["jumlahkamar"];
            } else {
                $valid=false;
                echo "Jumlah Kamar tidak boleh kosong<br>";
            }
            if (isset($_POST["gambar"])) {
                $gambar = $_POST["gambar"];
            } else {
                $valid=false;
                echo "Gambar tidak terbaca<br>";
            }
            
            if ($valid == true && !empty($tipekamar) && !empty($jumlahkamar)) {
                if ($_POST["aksi"] == "Add") {
                $insert = "INSERT IGNORE INTO kamar VALUES ('$tipekamar','$jumlahkamar','$gambar')";
                $inserted = $conn->query($insert);
                if ($inserted === false) {
                    echo "Data gagal dibuat";
                }
                if ($conn->affected_rows == 0) {
                    echo "Tipe Kamar tidak boleh sama";
                } else {
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                
                } elseif ($_POST["aksi"] == "Edit") {
                    if (isset($_POST["tipekamaredit"]) && !empty($_POST["tipekamaredit"])) {
                        $previd = $_POST["tipekamaredit"];
                        $insert = "UPDATE IGNORE kamar SET tipekamar='$tipekamar',jumlahkamar='$jumlahkamar',gambar='$gambar' WHERE tipekamar='$previd'";
                        $inserted = $conn->query($insert);
                        if ($inserted === false) {
                        echo "Data gagal diedit";
                        }
                        if ($conn->affected_rows == 0) {
                        echo "Tipe Kamar atau data tidak boleh sama atau invalid";
                        } else {
                        echo "<meta http-equiv='refresh' content='0'>";
                        }
                        
                    }
                    
                }
                
            }
        
            } else if ($_POST["aksi"] == "Delete") {
                if (isset($_POST["tipekamaredit"]) && !empty($_POST["tipekamaredit"])) {
                    $previd = $_POST["tipekamaredit"];
                    $insert = "DELETE FROM kamar WHERE tipekamar='$previd'";
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
        var inputtipekamaredit = document.getElementById("inputtipekamaredit");
        var inputtipekamar = document.getElementById("inputtipekamar");
        var inputjumlahkamar = document.getElementById("inputjumlahkamar");
        var inputgambar = document.getElementById("inputgambar");
        var inputsubmit = document.getElementById("inputsubmit");
        var inputsubmitdelete = document.getElementById("inputsubmitdelete");

        if (inputsubmit.value=="Add" && form.hidden==false) {
            form.hidden=true;
        } else {
            form.hidden=false;
            inputtipekamar.placeholder="Tipe Kamar";
            inputjumlahkamar.placeholder="Jumlah Kamar";
            inputgambar.placeholder="Gambar";
            inputtipekamar.value="";
            inputjumlahkamar.value="";
            inputgambar.value="";
            inputsubmit.value="Add";
            inputsubmitdelete.hidden=true;
        }
    }

    function editData(tipekamar, jumlahkamar, gambar) {
        var form = document.querySelector(".formedit");
        var inputtipekamaredit = document.getElementById("inputtipekamaredit");
        var inputtipekamar = document.getElementById("inputtipekamar");
        var inputjumlahkamar = document.getElementById("inputjumlahkamar");
        var inputgambar = document.getElementById("inputgambar");
        var inputsubmit = document.getElementById("inputsubmit");
        var inputsubmitdelete = document.getElementById("inputsubmitdelete");
        if (inputsubmit.value=="Edit" && inputtipekamaredit.value==tipekamar && form.hidden==false) {
            form.hidden=true;
        } else {
            form.hidden=false;
            inputtipekamaredit.value=tipekamar;
            inputtipekamar.placeholder=tipekamar;
            inputjumlahkamar.placeholder=jumlahkamar;
            inputgambar.placeholder=gambar;
            inputtipekamar.value=tipekamar;
            inputjumlahkamar.value=jumlahkamar;
            inputgambar.value=gambar;
            inputsubmit.value="Edit";
            inputsubmitdelete.hidden=false;
        }
    }

    function openLihat(a) {
        location.href="kamar.php#info-"+a;
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