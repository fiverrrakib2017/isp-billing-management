<?php

require('../routeros_api.class.php');

$API = new RouterosAPI();

//$API->debug = true;
//$port = 8727;
if ($API->connect('103.146.16.16', 'rdsusermoloy', 'rdsusermoloy@121', 8722)) {

   //$API->write('/interface/getall');
$API->write('/system/resource/print');
//$ARRAY = $API->write("/ppp/active/print", array("count-only"=> "",));
   
           // print_r($ARRAY);
   $READ = $API->read(true);

   
   $ARRAY = $API->parseResponse($READ);

   print_r($READ);

   //echo"<br>";
   //echo"<br>";

echo "Uptime: ".$READ['0']['uptime']."<br>";
//echo "Platform: ".$READ['0']['platform']."<br>";
echo "Version: ".$READ['0']['version']."<br>";
//echo "Architecture: ".$READ['0']['architecture-name']."<br>";
echo "Hardware: ".$READ['0']['board-name']."<br>";
echo "CPU: ".$READ['0']['cpu'].", ";
echo "Core: ".$READ['0']['cpu-count']." Core, ";
echo "Speed: ".$READ['0']['cpu-frequency']/(1000)." GHz";
   //echo $API->read('cpu');

$API->disconnect();

}

?>
