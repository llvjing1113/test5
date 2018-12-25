<?php
header("content-type:text/html;charset=utf-8");
define("IN_PHP",34);
include_once 'class/mysql.class.php';
include_once 'class/Upload.class.php';
$dbObj=new db_mysql('localhost','root','','liuyan');
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
if(!empty($_POST))
{
	//处理文件上传
	if($_FILES['picture']['name']!="")
	{
		//文件上传
		$tArr=array(
										'filepath'=>date('Y-m'),
										'allowsize'=>1024*1024*2,
										'allowmime'=>array('image/gif','image/png','image/jpg','image/jpeg'),
										'israndname'=>1
									);
	$upObj=new fileup($tArr);
	$files=$upObj->up('picture');
	if($files)
	{
		//上传成功
		$_POST['picture']=date('Y-m').'/'.$files;
	}
	else
	{
		//上传失败
		//echo $upObj->geterror();
		//exit();
		die($upObj->geterror());
	}
	}
	$_POST['timeline']=time();
	$rtn=$dbObj->insert('liuyan',$_POST);
	if($rtn)
	{
		echo "<script>";
		echo "alert('添加成功');";
		echo "location.href='index.php';";
		echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "alert('添加失败');";
		echo "location.href='index.php';";
		echo "</script>";
	}
	exit();
}

?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/global.css">
</head>
<body>
<div>
    <h2>欢迎您：Tom</h2>
	<hr style=" height:1px;border:none;border-top:1px dashed #0066CC;">
	<form enctype= "multipart/form-data" action="content.php" method="post">
    <div class="index_new_box_3">
        <ul>
            <li>
                <div class="index_new_box_3_main"><span>留言心情：</span></div>
                <div class="index_new_box_3_main"><input type="file" name="picture">   </div>				
            </li>		
            <li>
                <div class="index_new_box_3_main"><span>留言内容：</span></div>
                <div class="index_new_box_3_main"><textarea   STYLE="border:1px dotted   #6CABE7;" cols="90" rows="4" name='content'></textarea>   </div>				
            </li>
           	
            <li>
                <div class="index_new_box_3_main">&nbsp;<input class="button" type="submit" value="提交" /></div>
            </li>				
        </ul>
	</div>
	</form>
</div>
</body>
</html>