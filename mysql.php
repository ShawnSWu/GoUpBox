<?php
/****** 連接資料庫 ***************/
function db_connect($constr)
{
   global $PHP_AUTH_USER,$PHP_AUTH_PW;
   $pt=stristr($constr,"dbname");
   if ($pt===false) $user=$PHP_AUTH_USER;
   else
   {
	$pt=trim(substr($pt,6));
        $pt=stristr($pt,"=");
   	if ($pt===false) $user=$PHP_AUTH_USER;
   	else
	{
		$pt=trim(substr($pt,1));
        	$dbname=strtok($pt," \n\t");
	}
   }
   $pt=stristr($constr,"user");
   if ($pt===false) $user=$PHP_AUTH_USER;
   else
   {
	$pt=trim(substr($pt,4));
        $pt=stristr($pt,"=");
   	if ($pt===false) $user=$PHP_AUTH_USER;
   	else
	{
		$pt=trim(substr($pt,1));
        	$user=strtok($pt," \n\t");
	}
   }
	$pt=stristr($constr,"password");
   if ($pt===false) $pwd=$PHP_AUTH_USER;
   else
   {
        $pt=trim(substr($pt,8));
        $pt=stristr($pt,"=");
        if ($pt===false) $pwd=$PHP_AUTH_PW;
        else
        {
                $pt=trim(substr($pt,1));
                $pwd=strtok($pt," \n\t");
        }
   }
   $pt=stristr($constr,"host");
   if ($pt===false) $host='localhost';
   else
   {
        $pt=trim(substr($pt,4));
        $pt=stristr($pt,"=");
        if ($pt===false) $host='localhost';
        else
        {
                $pt=trim(substr($pt,1));
                $host=strtok($pt," \n\t");
        }
   }
   $conn=@mysql_connect($host,$user,$pwd);
   if (!mysql_select_db($dbname,$conn)) 
	echo "connect $dbname err!";
   return($conn);
}
/****** 設定資料庫編碼 ***************/
function db_set_encoding($conn,$encstr)
{
     //return(pg_set_client_encoding($conn,$encstr));
      $encstr=str_replace('utf-8','utf8',$encstr);
      db_exec($conn,'set names '.$encstr);
     return(true);
}
/******* 執行Query *******************/
function db_exec($conn,$query)
{
  return(mysql_query($query,$conn));
}
/******* 取一筆資料 *****************/
function db_fetch_row($conn,$num)
{
  //return(mysql_result($conn,$num));
  mysql_data_seek($conn,$num);
  return(mysql_fetch_row($conn));
}
function db_num_rows($conn)
{
  return(mysql_num_rows($conn));
}
/**********清除查詢結果 ************/
function db_freeresult($result)
{
   return(mysql_free_Result($result));
}
/********* 計算查詢結果筆數 ************/
function db_NumRows($result)
{
   return(mysql_num_rows($result));
}
/*******計算每一筆查詢結果的欄位數 ********/
function db_NumFields($result)
{
   return(mysql_Num_Fields($result));
}
/*******關閉一個資料庫連結 ********/
function db_close($conn)
{
   return(mysql_close($conn));
}
/*******檢查到底PKEY這個欄位是第幾個欄位 ********/
function db_FieldNum($result,$PKEY)
{
     return(false);
     //return(pg_Field_Num($result,$PKEY));
}
/*******檢查資料庫錯誤信息 ********/
function db_errormessage()
{
     return(mysql_error());
}
/*******檢查資料庫回傳欄位名 ********/
function db_field_name($result,$fpt)
{
     return(mysql_field_name($result,$fpt));
}
?>
