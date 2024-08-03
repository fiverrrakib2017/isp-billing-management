<?php
if(isset($_GET["ping"]))
{
    $host = $_GET["ping"];
    exec("ping -c 1 " . $host, $output, $result);

        if ($result == 0)
        {
        echo "Ping okay!";
        }
        else
        {
        echo "Ping failed!";
        }



}
        
                          
  ?>