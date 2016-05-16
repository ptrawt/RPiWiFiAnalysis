<?php
    $n = 10;
    if (isset($_GET["n"]))
        $n = intval($_GET["n"]);

    $data = 'rssi';
    if (isset($_GET["data"]))
        $data = $_GET["data"];


    header("content-type: application/json");
    include 'config.php';

   $conn = mysql_connect($dbhost, $dbuser, $dbpass);

   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   mysql_select_db($dbname);

    $res = array();
    $res["categories"] = array();
    $res["series"] = array();

    if(isset($_GET['time1']) && isset($_GET['time2']))
    {
        $ti1 = $_GET['time1'];
        $ti2 = $_GET['time2'];
        $query = "SELECT time,bssid,ssid,$data FROM data where time between '$ti1' and '$ti2' order by time desc;";
    }else{
        $query = "SELECT time,bssid,ssid,$data FROM data where time order by time desc;";
    }

    $result = mysql_query($query);
    if (! $result){
       throw die(mysql_error());
    }

    $ltime = "";
    $c = 0;
    $v = 0;

    while($row = mysql_fetch_assoc($result)){
        $name = strtoupper($row["bssid"])." | ".$row["ssid"];
        if ($ltime!=$row["time"]) {
            if ($c==$n) break;
            array_unshift($res["categories"], $row["time"]);
            $ltime = $row["time"];
            $c++;
        }

        $h = false;

        foreach($res["series"] as &$serie) {
            if ($serie["name"]==$name) {
                while(count($serie["data"])<$c-1) {
                    array_unshift($serie["data"], null);
                }

                if (count($serie["data"])<$c)
                    array_unshift($serie["data"], floatval($row[$data]));

                $h = true;
                break;
            }
        }


        if (!$h) {
            $tmp = array();
            $tmp["name"] = $name;
            $tmp["data"] = array();
            if($v < 4){
                $tmp["visible"] = true;
                $v++;
            }
            else{
                $tmp["visible"] = false;
            }
            while(count($tmp["data"])<$c-1) {
                array_unshift($tmp["data"], null);
            }
            array_unshift($tmp["data"], floatval($row[$data]));
            array_push($res["series"], $tmp);
        }
    }
    foreach($res["series"] as &$serie) {
        while(count($serie["data"])<$c) {
            array_unshift($serie["data"], null);
        }
        $tmp = 0;
        $count = 0;
        foreach($serie["data"] as $i){
            if($i != null){
                $tmp += $i;
                $count++;
            }
        }
    }
    echo json_encode($res);
?>
