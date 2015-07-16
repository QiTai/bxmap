<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/15
 * Time: 9:41
 */


$conn = @mysql_connect("127.0.0.1:3306", "root","baixing") or die('my_connect error:'.mysql_error());

//mysql_select_db("ip_lib", $conn) or die('mysql_select_db error:'.mysql_error());
mysql_select_db("bxmap", $conn) or die('mysql_select_db error:'.mysql_error());

mysql_query("set names 'utf8'");		//防止中文变成问号



