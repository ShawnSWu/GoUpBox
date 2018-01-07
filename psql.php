<?php
/****** 連接資料庫 ***************/
function db_connect($constr)
{
	return(pg_connect($constr));
}
/****** 設定資料庫編碼 ***************/
function db_set_encoding($conn,$encstr)
{
     return(pg_set_client_encoding($conn,$encstr));
}
/******* 執行Query *******************/
function db_exec($conn,$query)
{
  return(pg_query($conn,$query));
}
function db_num_rows($conn)
{
  return(pg_num_rows($conn));
}
/******* 取一筆資料 *****************/
function db_fetch_row($conn)
{
  return(pg_fetch_row($conn));
}
/**********清除查詢結果 ************/
function db_freeresult($result)
{
   return(pg_Free_Result($result));
}
/********* 計算查詢結果筆數 ************/
function db_NumRows($result)
{
   return(pg_Num_Rows($result));
}
/*******計算每一筆查詢結果的欄位數 ********/
function db_NumFields($result)
{
   return(pg_Num_Fields($result));
}
/*******關閉一個資料庫連結 ********/
function db_close($conn)
{
   return(pg_close($conn));
}
/*******檢查到底PKEY這個欄位是第幾個欄位 ********/
function db_FieldNum($result,$PKEY)
{
     return(pg_Field_Num($result,$PKEY));
}
/*******檢查資料庫錯誤信息 ********/
function db_errormessage()
{
     return(pg_errormessage());
}
/*******檢查資料庫回傳欄位名 ********/
function db_field_name($result,$fpt)
{
     return(pg_field_name($result,$fpt));
}
?>
