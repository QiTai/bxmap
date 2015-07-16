<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/15
 * Time: 19:29
 */

header("Content-type: text/html; charset=utf-8");

//store the web_traffic into database web_traffic;
$conn2 = @mysql_connect("localhost:3306","root", "") or die('my_connect error:' .mysql_error());
mysql_select_db("web_traffic",$conn2) or die('mysql_select_db error:'.mysql_error());
mysql_query("SET Prov 'utf-8'");


$prov = array("北京", "天津", "上海", "重庆", "河北", "河南", "云南", "辽宁", "黑龙江", "湖南", "安徽",
    "山东", "新疆", "江苏", "浙江", "江西", "湖北", "广西", "甘肃", "山西", "内蒙古", "陕西",
    "吉林", "福建", "贵州", "广东", "青海", "西藏", "四川", "宁夏", "海南", "台湾", "香港", "澳门");


$flow = array();
$proves_flow = array();
//for($hour = 0; $hour < 24; $hour++)
for($hour = 21 ; $hour < 24; $hour++)
{
    $proves_flow[$hour] = array();
//    $flow[$hour] = array("time" => 0 , "data" => $proves_flow);
//    $flow[$hour] = array("time" => 0 );
    foreach($prov as $prov_name)
    {
        $query_sql = "select * from traffic where hour_time = '$hour' and Prov = '$prov_name'";
        $result = mysql_query($query_sql);

        echo "<br>===============$result==============<br>";
        $result_row = mysql_fetch_array($result);
        if(is_array($result_row) || is_object($result_row))
        {
            $prov_flow = array("name"  => $prov_name,
                "value" => $result_row[2] );
            $proves_flow[$hour][] = $prov_flow;
            echo "prov_flow: \t";
            var_dump($prov_flow);
            echo "<br>";
            echo "proves_flow[hour]: \t";
            var_dump($proves_flow[$hour]);
            echo "<br>";
        }
        else
        {
            echo "Nothing match in database<br>";
        }
    }
    echo "proves_flow[hours]: \t";
    var_dump($proves_flow[$hour]);
    echo "<br>";
    $flow[$hour] = array("time" => $hour , "data" => $proves_flow[$hour]);
    echo "flow[hours]: \t";
    var_dump($flow[$hour]);
    echo "<br>";
    echo "flow: \t";
    var_dump($flow);
    echo "<br>";

}
$Json_array = array( "code" => 0,
    "msg"  => "Nothing special",
    "data" => $flow);
$Json = json_encode($Json_array);

echo "Json_array: \t";
var_dump($Json_array);
echo "===========================<br>";
echo "Json: \t";
var_dump($Json);



//send the Json to frontend
//refer to website