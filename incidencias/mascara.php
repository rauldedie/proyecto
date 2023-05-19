<?php


$rol1="jefe";
$rol2="oficial";
$rol3="peon";

$id1=1;
$id2=2;
$id3=3;
$id4=4;
$id5=5;
$id6=6;

$pass1 = "J0n5lu222n2z";
$pass2 = "P1m1k0tr2";
$pass3 = "Js2c1rc1";
$pass4 = "R0g1d1lv2z";
$pass5 = "Ant2mp10s1";
$pass6 = "P1qch0t2r0";

$passhjl = md5(md5($id1).$pass1);
$roljl = md5(md5($id2).$rol1);

$passhpk = md5(md5($id2).$pass2);
$rolpk = md5(md5($id2).$rol1);

$passhjc = md5(md5($id3).$pass3);
$roljc = md5(md5($id3).$rol1);

$passhr = md5(md5($id4).$pass4);
$rolr = md5(md5($id4).$rol2);

$passha = md5(md5($id5).$pass5);
$rola = md5(md5($id5).$rol3);

$passhchoc = md5(md5($id6).$pass6);
$rolchoc = md5(md5($id6).$rol3);
//sldk368.piensasolutions.com

echo "Contraseña Jose Luis: ".$passhjl."<br>";
echo $roljl."<br>";
echo "Contraseña Pako: ".$passhpk."<br>";
echo $rolpk."<br>";
echo "Contraseña Jose Carlos: ".$passhjc."<br>";
echo $roljc."<br>";
echo "Contraseña Rocio: ".$passhr."<br>";
echo $rolr."<br>";
echo "Contraseña Antonio: ".$passha."<br>";
echo $rola."<br>";
echo "Contraseña Chocolatero: ".$passhchoc."<br>";
echo $rolchoc."<br>";

?>
