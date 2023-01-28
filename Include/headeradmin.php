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
            <li class='right'><a href='admin-fasilitashotel.php'>Fasilitas Hotel</a></li>
            <li class='right' style='border-right: 1px solid #000;'><a href='admin-fasilitaskamar.php'>Fasilitas Kamar</a></li>
            <li class='right' style='border-right: 1px solid #000;'><a href='admin-kamar.php'>Kamar</a></li>
            <li class='right usertypetext'><h3>Admin</h3></li>
            <li class='right'><p class='date'></p></li>
        </ul>
    </div>
    <script src='JavaScript/date.js'></script>"
    ;
?>