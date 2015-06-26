<?php
$db = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.58.128)(PORT=1521)))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=ukm1)))";
//$db = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.58.128)(PORT=1521))(CONNECT_DATA=(SID=ukm)))"
//$db=OCILogon("agus","salim",'//192.168.58.128:1521/ukm');\
if(!empty($db)){
	//var_dump($db);
	echo "Connected";
}else{
	echo "Fail";
}
?>
