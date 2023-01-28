<?php include 'Include/headserver.php'; include 'Include/cekresepsionis.php'; include 'Include/header.php'; ?>
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
    .searchbar {
        overflow: hidden;
        margin-bottom: 1pc;
    }
    .dateform {
        float: left;
        width: 25%;
    }
    .textform {
        float: right;
        width: 25%;
        text-align: right;
    }
</style>
<?php include 'Include/headerresepsionis.php' ?>
<div class="content">
    <div class="searchbar">
        <form class="dateform" method="post">
            Tanggal <input type="date" name="searchdate"<?php
            if (isset($_POST["searchdate"])) {
                echo " value='".$_POST["searchdate"]."'";
            }
            ?>> <button type="submit">Search</button>
        </form>
        <form class="textform" method="post">
            <input type="text" name="searchtext" placeholder="&#x1F50D Nama Tamu"<?php
            if (isset($_POST["searchtext"])) {
                echo " value='".$_POST["searchtext"]."'";
            }
            ?>> <button type="submit">Search</button>
        </form>
    </div>
    <table>
        <thead>
        <tr class="tabletop">
            <td class="pointer" onclick="sortTable(this,'string')" data-descending="0">Nama Tamu<div class="sort">▼▲<div></td>
            <td class="pointer" onclick="sortTable(this,'date')" data-descending="0">Tanggal Cek In<div class="sort">▼▲<div></td><!-- sort button remember to draw icon -->
            <td class="pointer" onclick="sortTable(this,'date')" data-descending="0">Tanggal Cek Out<div class="sort">▼▲<div></td><!-- sort button remember to draw icon -->
            <td class="pointer" onclick="hideTable()">Aksi<div class="hide">▼<div></td><!-- hide button remember to draw icon -->
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="resepsionis") {
        $result;
        if (isset($_POST["searchdate"]) && !empty($_POST["searchdate"])) {
            $result=$conn->query("SELECT namapemesanan,namatamu,tanggalcekin,tanggalcekout FROM pemesanan WHERE tanggalcekin <= '".$_POST["searchdate"]."' AND tanggalcekout >= '".$_POST["searchdate"]."'");
        } elseif (isset($_POST["searchtext"]) && !empty($_POST["searchtext"])) {
            $result=$conn->query("SELECT namapemesanan,namatamu,tanggalcekin,tanggalcekout FROM pemesanan WHERE namatamu LIKE '%".$_POST["searchtext"]."%'");
        } else {
            $result=$conn->query("SELECT namapemesanan,namatamu,tanggalcekin,tanggalcekout FROM pemesanan");
        }
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='tablecontent'><td>".$row["namatamu"]."</td><td>".$row["tanggalcekin"]."</td><td>".$row["tanggalcekout"]."</td><td><a class='pointer' onclick='alert(\"Pemesanan ".$row["namapemesanan"]." milik ".$row["namatamu"]." telah di Cek In\")'>Cek In</a> | <form id='delete".$row["namapemesanan"]."' method='post'><input type='hidden' name='aksi' value='Cek Out'><input type='hidden' name='namapemesanan' value='".$row["namapemesanan"]."'></form><a class='pointer' onclick='document.getElementById(\"delete".$row["namapemesanan"]."\").submit()'>Cek Out</a></td></tr>";
        }
        }
        ?>
        </tbody>
        <?php
    if (isset($_SESSION["hak"]) && $_SESSION["hak"]=="resepsionis") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
             if (isset($_POST["aksi"]) && $_POST["aksi"] == "Cek Out") {
                if (isset($_POST["namapemesanan"]) && !empty($_POST["namapemesanan"])) {
                    $previd = $_POST["namapemesanan"];
                    $insert = "DELETE FROM pemesanan WHERE namapemesanan='$previd'";
                    $inserted = $conn->query($insert);
                    if ($inserted === false) {
                        echo "Data gagal dihapus";
                    }
                    if ($conn->affected_rows == 0) {
                        echo "Data tidak ditemukan";
                    } else {
                        echo "<script>alert(\"Pemesanan ".$previd." telah di Cek Out\");</script>";
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                    
                }
            }
        }
    }
    ?>
    </table>
    
</div>
<div class="footer">
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
            } else if (type=="date") {
                compare = function(row1,row2) {
                    return (new Date(row2.cells[col.cellIndex].innerHTML) - new Date(row1.cells[col.cellIndex].innerHTML));
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
            } else if (type=="date") {
                compare = function(row1,row2) {
                    return (new Date(row1.cells[col.cellIndex].innerHTML) - new Date(row2.cells[col.cellIndex].innerHTML));
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
        var form = document.querySelector("form");
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
        var form = document.querySelector("form");
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
</script>
<?php include 'Include/footer.php'; ?>