<?php
header("Content-type: text/html; charset=utf-8");
include('CsvReader.php');
include ('conn.php');
include ('BinarySearch.php');

$prov = array("北京", "天津", "上海", "重庆", "河北", "河南", "云南", "辽宁", "黑龙江", "湖南", "安徽",
               "山东", "新疆", "江苏", "浙江", "江西", "湖北", "广西", "甘肃", "山西", "内蒙古", "陕西",
               "吉林", "福建", "贵州", "广东", "青海", "西藏", "四川", "宁夏", "海南", "台湾", "香港", "澳门");
$flow = array();
// $sql = "select * from bxmap.lib";
// $result = mysql_query($sql);


$weblog_file = 'traffic_web.csv';
$weblogreader = new CsvReader($weblog_file);
$line_number = $weblogreader->get_lines();
echo "Number of all records is ".$line_number."<br>";	 

$data = $weblogreader->get_data(1000000,13000000);

$index=0;
foreach ($data as $each) {

	$ip   = ip2long($each[2]);
    $time = strtotime($each[1]);
    $hour = (int)(date('H',$time)); 

    // foreach ($iplist as $eachip) {
    // 	if($eachip[1]>=$ip) {
    // 		$ip_prov=$eachip[5];
    // 		break;
    // 	}
    // }
    // $sql = "select * from bxmap.lib where ipEnd_int >= '$ip'  limit 1";
    // $result = mysql_query($sql);
    // $result_row = mysql_fetch_array($result);

    $ip_prov=BinarySearch($ip);

    if($ip_prov){
        foreach($prov as $prov_name){
            if($ip_prov === $prov_name){
                $flow[$hour][$prov_name]++;
                break;
    		}

        }
    }
    $index++;
    if($index%100000==0) echo $index."<br>";
}

echo "Number of handled records is ".$index."<br>";

$sum=0;
foreach ($flow as $each) {
	$sum+=array_sum($each);
	# code...
}
echo "Valid is ".$sum."<br>";


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
                $query_sql = "select * from bxmap.traffic where hour_time = '$hour' and Prov = '$prov_name'";
                $result    = mysql_query($query_sql);
                $result_row = mysql_fetch_array($result);
                if(is_array($result_row) || is_object($result_row))
                {
                    $flow_tmp += $result_row[2];
                    //update database
                    $update_sql = "update bxmap.traffic set hour_time = '$hour', Prov = '$prov_name', flow = '$flow_tmp' where hour_time = '$hour' and Prov = '$prov_name'";
                    mysql_query($update_sql);
                }
                else
                {
                    //never exist in the database before; just insert is ok!
                    $insert_sql = "insert into bxmap.traffic(hour_time,Prov,flow) values('$hour','$prov_name','$flow_tmp')";
                    mysql_query($insert_sql);
                }
            }
        }
    }





mysql_close($conn);

echo "Finish!";
 


 

?>