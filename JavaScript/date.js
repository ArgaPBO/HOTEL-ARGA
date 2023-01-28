
var d= new Date();
var date= document.querySelector('.date');
var day= d.getDay();
// var hari= '';
var tanggal= d.getDate();
var month= d.getMonth();
// var bulan= '';
var tahun= d.getFullYear();
// switch(day) {
//     case 1:
//         hari = 'Senin';
//         break;
//     case 2:
//         hari = 'Selasa';
//         break;
//     case 3:
//         hari = 'Rabu';
//         break;
//     case 4:
//         hari = 'Kamis';
//         break;
//     case 5:
//         hari = 'Jumat';
//         break;
//     case 6:
//         hari = 'Sabtu';
//         break;
//     case 0:
//         hari = 'Minggu';
//         break;
// }

// switch(month) {
//     case 0:
//         bulan = 'Januari';
//         break;
//     case 1:
//         bulan = 'Februari';
//         break;
//     case 2:
//         bulan = 'Maret';
//         break;
//     case 3:
//         bulan = 'April';
//         break;
//     case 4:
//         bulan = 'Mei';
//         break;
//     case 5:
//         bulan = 'Juni';
//         break;
//     case 6:
//         bulan = 'Juli';
//         break;
//     case 7:
//         bulan = 'Agustus';
//         break;
//     case 8:
//         bulan = 'September';
//         break;
//     case 9:
//         bulan = 'Oktober';
//         break;
//     case 10:
//         bulan = 'November';
//         break;
//     case 11:
//         bulan = 'Desember';
//         break;
// }
var arrayhari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
var arraybulan= ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
// date.innerHTML=hari+', '+tanggal+' '+bulan+' '+year;
date.innerHTML=arrayhari[day]+', '+tanggal+' '+arraybulan[month]+' '+tahun;