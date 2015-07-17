
<?php

header("Content-type: text/html; charset=utf-8");

include "conn.php";

//function ip2int($ip){
//    list($ip1, $ip2, $ip3, $ip4) = explode(".", $ip);
//    return $ip1*pow(256,3)+$ip2*pow(256,2)+$ip3*256+$ip4;
//}

//initialize the Net Flow
$prov = array("北京", "天津", "上海", "重庆", "河北", "河南", "云南", "辽宁", "黑龙江", "湖南", "安徽",
               "山东", "新疆", "江苏", "浙江", "江西", "湖北", "广西", "甘肃", "山西", "内蒙古", "陕西",
               "吉林", "福建", "贵州", "广东", "青海", "西藏", "四川", "宁夏", "海南", "台湾", "香港", "澳门");
$flow = array();


$row = 1;
if (($handle = fopen("traffic_web.csv", "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
        if($row === 1)
            continue;
        $ip   = ip2long($data[2]);
        $time = strtotime($data[1]);
        $hour = (int)(date('H',$time));            //$hour format: string

        $lib = array("lib1", "lib2", "lib3", "lib4");
        $index = 0;
        do{
            $sql = "select * from $lib[$index] where ipEnd_int >= '$ip'  limit 1";
            $result = mysql_query($sql);
            $result_row = mysql_fetch_array($result);
            $index ++;
        }while(is_array($result_row)===FALSE);

        if(is_array($result_row) || is_object($result_row))
        {
            foreach($prov as $prov_name)
            {
                if($result_row['Prov'] === $prov_name)
                {
                    $flow[$hour][$prov_name] ++;
//                    echo "<br>";
//                    var_dump($flow);
//                    echo "<br>";
                }
            }
        }
        else
        {
            echo "mysql_fetch_array doesn't generate an array result !!! <br>";
        }
        $row++;
    }
    fclose($handle);
    //关闭ip_lib数据库
    mysql_close($conn);

    echo "-----------------------------------================================------------------------------<br>";
    var_dump($flow);

    //store the web_traffic into database web_traffic;
    $conn2 = @mysql_connect("localhost:3306","root", "") or die('my_connect error:' .mysql_error());
    mysql_select_db("web_traffic",$conn2) or die('mysql_select_db error:'.mysql_error());
    mysql_query("SET Prov 'utf-8'");

    foreach($flow as $hour => $value)
    {
        foreach($prov as $prov_name)
        {
//            echo $hour . "<br>";
//            echo $prov_name . "<br>";

            $flow_tmp = $flow[$hour][$prov_name];
            if(isset($flow_tmp))
            {
//                $total += $flow_tmp;
//                echo $flow[$hour][$prov_name] . "<br>";
                //first you see whether it's in the database;
                $query_sql = "select * from traffic where hour_time = '$hour' and Prov = '$prov_name'";
                $result    = mysql_query($query_sql);
                $result_row = mysql_fetch_array($result);
                if(is_array($result_row) || is_object($result_row))
                {
                    $flow_tmp += $result_row[2];
                    //update database
                    $update_sql = "update traffic set hour_time = '$hour', Prov = '$prov_time', flow = '$flow_tmp' where hour_time = '$hour' and Prov = '$prov_name'";
                    mysql_query($update_sql);
                }
                else
                {
                    //never exist in the database before; just insert is ok!
                    $insert_sql = "insert into traffic(hour_time,Prov,flow) value('$hour','$prov_name','$flow_tmp')";
                    mysql_query($insert_sql);
                }
            }
        }
    }

//    echo "==================" . $total . "=====================<br>";
    mysql_close($conn2);
}



