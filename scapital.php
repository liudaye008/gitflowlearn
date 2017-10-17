<?php 

error_reporting(E_ALL || ~E_NOTICE);
/* 
*处理Excel导出 
*@param $datas array 设置表格数据 
*@param $titlename string 设置head 
*@param $title string 设置表头 
*/ 
function excelData($datas,$titlename,$title,$filename){ 
    $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>"; 
    $str .="<table border=1><head>".$titlename."</head>"; 
    $str .= $title; 
    foreach ($datas  as $key=> $rt ) 
    { 
        $str .= "<tr>"; 
        foreach ( $rt as $k => $v ) 
        { 
            $str .= "<td>{$v}</td>"; 
        } 
        $str .= "</tr>\n"; 
    } 
    $str .= "</table></body></html>"; 
    header( "Content-Type: application/vnd.ms-excel; name='excel'" ); 
    header( "Content-type: application/octet-stream" ); 
    header( "Content-Disposition: attachment; filename=".$filename); 
    header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" ); 
    header( "Pragma: no-cache" ); 
    header( "Expires: 0" ); 
} 

	$stime=microtime(true);
	$pdo = NULL;
    try{
      $dsn = "mysql:host=mysql.dev.infra.scapital.com;dbname=scapital_local";
      $pdo = new PDO($dsn,'root','scapitol',array(PDO::ATTR_PERSISTENT=>TRUE));
      $pdo->query("SET NAMES UTF8");

    }catch(Exception $e){
      die("Connect Error". mysql_error());
    }
    
	$sql="SELECT * FROM `mp_bank` limit 5";

    $result = $pdo->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

$headTitle = "XX保险公司 优惠券赠送记录"; 
$title = "优惠券记录"; 
$filename = $title.".xls";
$headtitle= "<tr style='height:50px;border-style:none;><th border=\"0\" style='height:60px;width:270px;font-size:22px;' colspan='11' >{$headTitle}</th></tr>"; 
excelData($rows,$titlename,$headtitle,$filename);

    $etime=microtime(true);//获取程序执行结束的时间
	$total=$etime-$stime;   //计算差值
	echo "<br />[sql查询时间：{$total} ]秒";

    $keys = array_keys($rows[0]);
    echo"<link href='https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css' rel='stylesheet'>";
	echo"<table class='table table-striped' border=1>";
	echo"<tr>";
	echo"<td>序号</td>";
	for ($i=0; $i < count($keys); $i++) { 
		echo"<td>".$keys[$i]."</td>";
	}
	echo"</tr>";

	for ($i=0; $i < count($rows); $i++) { 
		echo"<tr>";
		echo"<td>".($i+1)."</td>";
		for ($j=0; $j < count($keys); $j++) { 
			echo"<td>".$rows[$i][$keys[$j]]."</td>";
		}
		echo"</tr>";
	}

 ?>
 </table>

