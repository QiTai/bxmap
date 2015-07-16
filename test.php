
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/15
 * Time: 9:22
 */

    header("Content-type: text/html; charset=utf-8");

//    $prov = array("北京", "上海");
//
//    $prov["辽宁"] = array( 12, 13);
//
//    echo "<p>";
//    print_r($prov["辽宁"][0]);
//    echo "<br />";
//    print_r($prov["辽宁"][1]);
//    echo "</p>";
//var_dump($prov);
//    //
//    //echo "<br />" ;
//
//    function ip2int($ip){
//        list($ip1, $ip2, $ip3, $ip4) = explode(".", $ip);
//        return $ip1*pow(256,3)+$ip2*pow(256,2)+$ip3*256+$ip4;
//    }
//
//    include_once "conn.php";
//
//    //$sql = "select * from lib2 where Country = 'GOOGLE' ";        //OK
////    $sql = "select * from lib1 where Country = '中国' ";      //not OK; Chinese has que;
////    $sql = "select * from lib2 where ipStart_int = 2749300736";
////    $sql = "select * from lib1 where ipStart_int = 16777472";
////
////    echo "$sql<br><br>";
////
////    $result = mysql_query($sql);
////
////    if($result === FALSE)
////    {
////        echo "Nothing found in database <br>";
////        die(mysql_error());
////    }
////
////
////    $row = mysql_fetch_array($result);
////
////    if(is_array($row) || is_object($row))
////    {
////        foreach($row as $value)
////        {
////            echo "$value <br>";
////        }
////
////        if($row['Country'] === '美国')
////        {
////            echo "美国<br>";
////        }
////        else
////        {
////            echo "<br>";
////            echo $row['Country'];
////            echo "test";
////        }
////    }
////    else
////    {
////        echo "mysql_fetch_array doesn't generate an array result !!! <br>";
////    }
//
//    $test = array();
//    $test[0] = "hello";
//    $test[2] = "hi";
//    var_dump($test);
//    echo "<br>";
//
//    $filename = array();
//    for($i = 1; $i <= 240; $i++)
//    {
//        $filename[] = "traffic_web" . "$i" .".csv";
//    }

$json = json_encode(
    array(
        "code" => 0,
        "msg"  => "Nothing special",
        "data" => array(          //--------------------->$flow
            array(                //--------------------->$flow[$hour]
                "time" => 0,
                "data" => array(  //------------------->$proves_flow
                    array(       //------------------>$prov_flow
                        "name"  => "北京",
                        "value" => 0
                                    ),
                    array(
                        "name"  => "上海",
                        "value" => 1
                    ),
                    array(
                        "name"  => "天津",
                        "value" => 2
                    )
                )
            ),
            array(
                "time" => 1,
                "data" => array(
                    array(
                        "name"  => "北京",
                        "value" => 0
                    ),
                    array(
                        "name"  => "上海",
                        "value" => 1
                    ),
                    array(
                        "name"  => "天津",
                        "value" => 2
                    )
                )
            )
        )
    )
);

// Define the errors.
$constants = get_defined_constants(true);
$json_errors = array();
foreach ($constants["json"] as $name => $value) {
    if (!strncmp($name, "JSON_ERROR_", 11)) {
        $json_errors[$value] = $name;
    }
}

// Show the errors for different depths.
foreach (range(4, 3, -1) as $depth) {
    var_dump(json_decode($json, true, $depth));
    echo 'Last error: ', $json_errors[json_last_error()], PHP_EOL, PHP_EOL;
}