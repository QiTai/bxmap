<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/15
 * Time: 9:41
 */


$conn = @mysql_connect("localhost:3306", "root","") or die('my_connect error:'.mysql_error());

//mysql_select_db("ip_lib", $conn) or die('mysql_select_db error:'.mysql_error());
mysql_select_db("utf8_ip_lib", $conn) or die('mysql_select_db error:'.mysql_error());

mysql_query("SET Country 'utf-8'");

mysql_query("SET Prov 'utf-8'");



