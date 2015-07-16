<?php 

$lib_file = 'ip_lib.csv';
$libreader = new CsvReader($lib_file);
$ip_line_number = $libreader->get_lines();
$iplist = $libreader->get_data($ip_line_number);
//echo $ip_line_number, chr(10);
//echo "<br>";

function BinarySearch($search_ip){
	global $ip_line_number;
	global $iplist;
	$low=0;
	$high=$ip_line_number-1;
	while($low<$high){
		$current=intval(($low+$high)/2);
		
		if($search_ip >= $iplist[$current][0] && $search_ip <= $iplist[$current][1])
			return $iplist[$current][5];
		if($search_ip > $iplist[$current][1]) $low=$current;
		else $high=$current;
	}
	echo $search_ip."<br>";
	return 0;
	


}

?>