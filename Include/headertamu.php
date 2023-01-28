<?php
echo"
</head>
<body>
<form id='logout' method='post' action='index.php'>
<input type='hidden' name='logout' value='logout'>
</form>
<div class='box'>
    <div class='navbar'>
        <ul>
            <li class='left'><h2 class='pointer' onclick='document.getElementById(\"logout\").submit()'>HOTEL ARGA</h2></li>
            <li class='right'><a href='fasilitas.php'>Fasilitas</a></li>
            <li class='right' style='border-right: 1px solid #000;'><a href='kamar.php'>Kamar</a></li>
            <li class='right' style='border-right: 1px solid #000;'><a href='home.php'>Home</a></li>
            <li class='right'><p class='date'></p></li>
        </ul>
    </div>
    <script src='JavaScript/date.js'></script>";
?>