<?php 
    //设置时区
    date_default_timezone_set("PRC");
    //配置项
	$DC_NAME="haproxy";
    $DCMP_NAME="haproxy_haproxy_1";
	$DH_IP="192.168.254.116";
	$DH_IP2="192.168.254.126";
	$DIR="/etc/haproxy/";
	$CONF=$DIR."haproxy.cfg";
	$DEFAULT_FILE="haproxy.cfg";
	$LOGFILE="/usr/share/nginx/html/adm/haprconf/haprconf.log";
	$LOGROWS=100;
	$CMD_STATUS="sudo -u root ssh ".$DH_IP." docker ps -a --format \"{{.Names}}\;{{.Status}}\;{{.Ports}}\"|grep ".$DC_NAME;
	$CMD_TEST="sudo -u root ssh ".$DH_IP." docker exec ".$DCMP_NAME." haproxy -c -f /etc/haproxy/haproxy.cfg 2>&1";
	#$CMD_RESTART="sudo -u root ssh ".$DH_IP." docker restart ".$DC_NAME." 2>&1";
	$CMD_RESTART="sudo -u root ssh ".$DH_IP." docker restart ".$DCMP_NAME." 2>&1";
	$CMD_RESTART2="sudo -u root ssh ".$DH_IP2." docker restart ".$DCMP_NAME." 2>&1";
	$REDWORDS=array("error","fail","timeout","disconnect","err","lost","stop","deny","denied","exit");
	$GREENWORDS=array("ok","success","start"," connect","up",$DC_NAME);
	
function GET_STATUS(){
	global $CMD_STATUS;
	global $LOGFILE;
	global $STATUS;
	global $DC_NAME;
	exec($CMD_STATUS,$tmp,$tmpout);
	foreach ($tmp as $a){
        $test_res.=" ".$a."\n";
    }
	$arr=explode(";",$test_res);
	$STATUS=$arr[1];
	if( stripos($STATUS,"Exit")===false ){
		echo "<li><label style='color:green'>".$STATUS."</label></li>";	
	}else{
		echo "<li><label style='color:red'>".$STATUS."</label></li>";	
	}
    echo "<script>document.title='".$DC_NAME."';</script>"; 
	exec("sudo -u root  echo \"".$test_res."\" >>".$LOGFILE,$tmp2,$tmpout); 	
}
?>
