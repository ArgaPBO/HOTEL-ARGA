<?php include 'Include/headserver.php'; include 'Include/header.php'; ?>
<?php
$uset=1;
$pset=1;
$usame=0;

if (isset($_POST["logout"]) && $_POST["logout"]="logout") {
    session_unset();
    session_destroy();
    echo "<meta http-equiv='refresh' content='0'>";
}

if ($_POST) {
    if (isset($_POST["aksi"])) {
        if ($_POST["aksi"]=="Log In") {    
            $username="";
            $password="";    
            if (!empty($_POST["username"])) {
                $username=$_POST["username"];
            } else {
                $uset=0;
            }
            if (!empty($_POST["password"])) {
                // $password=md5($_POST["password"], true);
                $password=$_POST["password"];
            } else {
                $pset=0;
            }

            if ($uset==1 && $pset==1) {
                $result = $conn->query("SELECT * FROM akun WHERE id_akun='".$username."' LIMIT 1");
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // if ($password==$row["password"]) {
                    if (md5($password, true) == $row["password"]) {
                        $_SESSION["akun"]=$row["id_akun"];
                        if ($row["tipeakun"] == "tamu") {
                            $_SESSION["hak"]="tamu";
                            header("Location: home.php");
                        } elseif ($row["tipeakun"] == "admin") {
                            $_SESSION["hak"]="admin";
                            header("Location: admin-kamar.php");
                        } elseif ($row["tipeakun"] == "resepsionis") {
                            $_SESSION["hak"]="resepsionis";
                            header("Location: resepsionis.php");
                        }
                    } else {
                        $pset=2;
                    }
                } else {
                    $uset=2;
                }
            }
        } elseif ($_POST["aksi"]=="Register") {
            $username="";
            $password="";
            $tipeakun="";
            $valid=true;
            if (isset($_POST["username"]) && !empty($_POST["username"])) {
                $username=$_POST["username"];
            } else {
                $valid=false;
                echo "Username kosong<br>";
            }
            if (isset($_POST["password"]) && !empty($_POST["password"])) {
                $password=$_POST["password"];
            } else {
                $valid=false;
                echo "Password kosong<br>";
            }
            if (isset($_POST["tipeakun"]) && !empty($_POST["tipeakun"])) {
                $tipeakun=$_POST["tipeakun"];
            } else {
                $valid=false;
                echo "Tipe Akun kosong<br>";
            }
            if ($valid==true && !empty($username) && !empty($password) && !empty($tipeakun)) {
                $insert = "INSERT IGNORE INTO akun VALUES ('$username',0x".md5($password).",'$tipeakun')";
                $inserted = $conn->query($insert);
                if ($inserted === false) {
                    echo "Data gagal dibuat";
                }
                if ($conn->affected_rows == 0) {
                    $usame=1;
                } else {
                    echo "<script type='text/javascript'>alert('Register berhasil');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
                }
            }
        }
    }

}





function req($a) {
    if ($a=="u") {
        global $uset;
        if ($uset==0) {
            echo "<span style='color:#F00;'>*</span>";
        }
    } elseif ($a=="p") {
        global $pset;
        if ($pset==0) {
            echo "<span style='color:#F00;'>*</span>";
        }
    }
}

function res($a) {
    if ($a=="u") {
        global $uset;
        if ($uset=="2") {
            echo "<span style='color:#F00;'>Username not found</span>";
        }
    } elseif ($a=="p") {
        global $pset;
        if ($pset=="2") {
            echo "<span style='color:#F00;'>Wrong password</span>";
        }
    }
}

function same() {
    global $usame;
    if ($usame==1) {
        echo "<span style='color:#F00;'>Username must be unique</span>";
    }
}

?>
<title>Document</title>
<style>
    .login {
        position: absolute;
        width: 30pc;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        border: 1px solid #000;
    }
    .login h1 {
        margin-left: 0.5pc;
    }
    .login p {
        padding-top:1.5pc;
        text-align: center;
    }
    .login form {
    }
    .login form table {
        margin-left: auto;
        margin-right: auto;
        padding-top:1pc;
        padding-bottom:1pc;
        border-spacing:0.5pc;
    }
    .userpass {
        text-align: right;
    }
    .login form *[type="submit"] {
        display: block;
        margin-bottom: 1.5pc;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<?php include 'Include/header0.php'; ?>
<div class="login">
    <h1 id="h1text">Login</h1>
    <div style="text-align: center;"><p style="display: inline-block;" id="ptext">Don't have an existing account? Create one here </p><button style="display: inline-block; margin-left:5px;" data-aksi="login" onclick="toggleForm(this)">Create Account</button></div>
    <form id="formlogin" method="post">
    <table>
        <tr>
            <td class="userpass"><h3>Username<?php req("u"); ?></h3></td>
            <td><input type="text" name="username"><?php res("u")?></td>
        </tr>
        <tr>
            <td class="userpass"><h3>Password<?php req("p"); ?></h3></td>
            <td><input type="password" name="password"><?php res("p")?></td>
        </tr>
    </table>
    <input type="submit" name="aksi" value="Log In">
    </form>
    <form id="formregister" method="post" hidden>
        <table>
        <tr>
            <td class="userpass"><h3>Username</h3></td>
            <td><input type="text" name="username" required><?php same()?></td>
        </tr>
        <tr>
            <td class="userpass"><h3>Password</h3></td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td class="userpass"><h3>Tipe Akun</h3></td>
            <td>
                <select name="tipeakun" required>
                    <option disabled selected></option>
                    <option value="tamu">Tamu</option>
                    <option value="resepsionis">Resepsionis</option>
                    <option value="admin">Admin</option>
                </select>
            </td>
        </tr>
        </table>
        <input type="submit" name="aksi" value="Register">
    </form>
    <script>
        function toggleForm(a) {
            if (a.dataset.aksi=="login") {
                document.getElementById("h1text").innerHTML="Register";
                document.getElementById("ptext").innerHTML="Already have an existing account? Login here ";
                a.innerHTML="Login";
                document.getElementById("formlogin").hidden=true;
                document.getElementById("formregister").hidden=false;
                a.dataset.aksi = "register";
            } else {
                document.getElementById("h1text").innerHTML="Login";
                document.getElementById("ptext").innerHTML="Don't have an existing account? Create one here ";
                a.innerHTML="Create Account";
                document.getElementById("formlogin").hidden=false;
                document.getElementById("formregister").hidden=true;
                a.dataset.aksi = "login";
            }
        }
    </script>
</div>
<?php include 'Include/footer0.php'; ?>