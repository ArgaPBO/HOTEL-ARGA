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
    var navlink = document.querySelector("a[href='admin-fasilitaskamar.php']");
    navlink.removeAttribute("href");
</script>
<div class="content">
    <table>
        <thead>
        <tr class="tabletop">
            <td class="pointer" onclick="sortTable(this,'string')" data-descending="0">Tipe Kamar<div class="sort">▼▲<div></td>
            <td class="pointer" onclick="sortTable(this,'string')" data-descending="0">Nama Fasilitas<div class="sort">▼▲<div></td><!-- sort button remember to draw icon -->
            <td class="pointer" onclick="hideTable()">Aksi<div class="hide">▼<div></td><!-- hide button remember to draw icon -->
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="admin") {
        $result=$conn->query("SELECT * FROM fasilitaskamar");
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr class='tablecontent'><td>".$row["kamar_tipekamar"]."</td><td>".$row["namafasilitas"]."</td><td><a class='pointer' onclick='editData(\"".$row["kamar_tipekamar"]."\",\"".$row["namafasilitas"]."\",".$row["id_fasilitas"].")'>Ubah</a> | <a class='pointer' onclick='openLihat(\"".$row["kamar_tipekamar"]."\")'>Lihat</a></td></tr>";
        }
        }
        ?>
        </tbody>
    </table>
    
    <div class="inputdiv">
    <form class="formedit" method="post" hidden>
        <select id="inputtipekamar" name="tipekamar">
            <option id="inputtipekamarplaceholder" disabled selected>Tipe Kamar</option>
            <?php
            $result=$conn->query("SELECT tipekamar FROM kamar");
            while ($row = $result->fetch_assoc()) {
                echo "<option id='inputtipekamarselect".$row["tipekamar"]."' value='".$row["tipekamar"]."'>".$row["tipekamar"]."</option>";
            }
            ?>
        </select>
        <input id="inputnamafasilitas" type="text" name="namafasilitas" placeholder="Jumlah Kamar">
        <input id="inputid_fasilitas" type="hidden" name="id_fasilitas">
        <input id="inputsubmit" type="submit" name="aksi" value="Add">
        <input id="inputsubmitdelete" type="submit" name="aksi" value="Delete">
    </form>
    <?php
    if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="admin") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["aksi"] == "Add" || $_POST["aksi"] == "Edit") {
                
            $valid=true;
            $tipekamar;
            $namafasilitas;
            if (isset($_POST["tipekamar"]) && !empty($_POST["tipekamar"])) {
                $tipekamar = $_POST["tipekamar"];
            } else {
                $valid=false;
                echo "Tipe Kamar tidak boleh kosong<br>";
            }
            if (isset($_POST["namafasilitas"]) && !empty($_POST["namafasilitas"])) {
                $namafasilitas = $_POST["namafasilitas"];
            } else {
                $valid=false;
                echo "Nama Fasilitas tidak boleh kosong<br>";
            }
            
            if ($valid == true && !empty($tipekamar) && !empty($namafasilitas)) {
                if ($_POST["aksi"] == "Add") {
                $insert = "INSERT IGNORE INTO fasilitaskamar (kamar_tipekamar,namafasilitas) VALUES ('$tipekamar','$namafasilitas')";
                $inserted = $conn->query($insert);
                if ($inserted === false) {
                    echo "Data gagal dibuat";
                }
                if ($conn->affected_rows == 0) {
                    echo "Data invalid";
                } else {
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                
                } elseif ($_POST["aksi"] == "Edit") {
                    if (isset($_POST["id_fasilitas"]) && !empty($_POST["id_fasilitas"])) {
                        $previd = $_POST["id_fasilitas"];
                        $insert = "UPDATE IGNORE fasilitaskamar SET kamar_tipekamar='$tipekamar',namafasilitas='$namafasilitas' WHERE id_fasilitas='$previd'";
                        $inserted = $conn->query($insert);
                        if ($inserted === false) {
                        echo "Data gagal diedit";
                        }
                        if ($conn->affected_rows == 0) {
                        echo "Data sama atau invalid";
                        } else {
                        echo "<meta http-equiv='refresh' content='0'>";
                        }
                        
                    }
                    
                }
                
            }
        
            } else if ($_POST["aksi"] == "Delete") {
                if (isset($_POST["id_fasilitas"]) && !empty($_POST["id_fasilitas"])) {
                    $previd = $_POST["id_fasilitas"];
                    $insert = "DELETE FROM fasilitaskamar WHERE id_fasilitas='$previd'";
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
        var inputtipekamarplaceholder = document.getElementById("inputtipekamarplaceholder");
        var inputnamafasilitas = document.getElementById("inputnamafasilitas");
        var inputid_fasilitas = document.getElementById("inputid_fasilitas");
        var inputsubmit = document.getElementById("inputsubmit");
        var inputsubmitdelete = document.getElementById("inputsubmitdelete");

        if (inputsubmit.value=="Add" && form.hidden==false) {
            form.hidden=true;
        } else {
            form.hidden=false;
            inputtipekamarplaceholder.selected=true;
            inputnamafasilitas.placeholder="Nama Fasilitas";
            inputtipekamarplaceholder.innerHTML="Tipe Kamar";
            inputnamafasilitas.value="";
            inputid_fasilitas.value="";
            inputsubmit.value="Add";
            inputsubmitdelete.hidden=true;
        }
    }

    function editData(tipekamar, namafasilitas, id_fasilitas) {
        var form = document.querySelector(".formedit");
        var inputtipekamarplaceholder = document.getElementById("inputtipekamarplaceholder");
        var inputtipekamarselect = document.getElementById("inputtipekamarselect"+tipekamar);
        var inputnamafasilitas = document.getElementById("inputnamafasilitas");
        var inputid_fasilitas = document.getElementById("inputid_fasilitas");
        var inputsubmit = document.getElementById("inputsubmit");
        var inputsubmitdelete = document.getElementById("inputsubmitdelete");
        if (inputsubmit.value=="Edit" && inputid_fasilitas.value==id_fasilitas && form.hidden==false) {
            form.hidden=true;
        } else {
            form.hidden=false;
            inputtipekamarplaceholder.innerHTML=tipekamar;
            inputnamafasilitas.placeholder=namafasilitas;
            inputtipekamarselect.selected=true;
            inputnamafasilitas.value=namafasilitas;
            inputid_fasilitas.value=id_fasilitas;
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