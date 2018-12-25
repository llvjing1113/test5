<?php
session_start();
header("content-type:text/html;charset=utf-8");
error_reporting(0);

define("IN_PHP",34);
include_once 'class/mysql.class.php';
$dbObj=new db_mysql('localhost','root','','liuyan');
$actions=isset($_GET['action'])?$_GET['action']:$_POST['act'];
if($actions=='logout')
{
	//删除session
	unset($_SESSION['USR']);
}
elseif($actions=='checkuser')//验证账号是否正确
{
	$name=isset($_POST['name'])?$_POST['name']:"";
	$sql=" select count(*) as n from user where name='{$name}' ";
	$uArr=$dbObj->getone($sql);
	//echo '<pre>';
	//print_r($uArr);
	//echo '</pre>';
	if($uArr['n']==1)//输入的账号正确
	{
		$msgArr=array('msg'=>'账号正确');
	}
	else//输入的账号错误
	{
		$msgArr=array('msg'=>'账号错误');
	}
	echo json_encode($msgArr);
	exit();
}
elseif($actions=='checkcode')//判断验证码是否正确
{
	$codes=isset($_POST['codes'])?$_POST['codes']:"";
	$codeArr=explode('|',$_SESSION['code']);
	if(strtoupper($codes)==strtoupper($codeArr[0]))
	{
		echo "验证码正确";
	}
	else
	{
		echo "验证码错误";
	}
	exit();
}
if(!empty($_POST))
	{
		$usr=isset($_POST['username'])?$_POST['username']:"";
		$pwds=isset($_POST['pwd'])?$_POST['pwd']:"";
		$code=isset($_POST['auths'])?$_POST['auths']:"";
		$reg=isset($_POST['reg'])?$_POST['reg']:"";
		if($usr==""||$pwds==""||$code=="")
		{
			echo "<script>";
			echo "alert('账号，密码及验证码不能为空');";
			echo "location.href='login.php';";
			echo "</script>";
		}
		//获取生成的验证码
		$codeArr=explode('|',$_SESSION['code']);
		//判断验证码是否超时
		if((time()-$codeArr[1])>30)
		{
			echo "<script>";
			echo "alert('验证码超时');";
			echo "location.href='login.php';";
			echo "</script>";
			exit();
		}
		//echo '<pre>';
		//print_r($codeArr);
		//echo '</pre>';
		//判断验证码
		if(strtoupper($code)!=strtoupper($codeArr[0]))
		{
			echo "<script>";
			echo "alert('验证码不正确');";
			echo "location.href='index.php';";
			echo "</script>";
		}
		//判断账号
		$sql="select * from user where name='{$usr}'";
		$uarr=$dbObj->getone($sql);
		if(empty($uarr))
		{
			//账号不正确
			echo "<script>";
			echo "alert('账号不正确');";
			echo "location.href='login.php';";
			echo "</script>";
		}
		else
		{
			//账号正确，判断密码
			if(md5($pwds)==$uarr['pwd'])
			{
				if($reg==1)//处理记住账号
				{
					setcookie('REGUSR',$usr,time()+60*60*24*7,'/');
				}
				//将已登录成功的用户写入session
				$_SESSION['USR']=$usr;
				echo "<script>";
				echo "alert('登录成功');";
				echo "location.href='content.php';";
				echo "</script>";
			}
			else
			{
				echo "<script>";
				echo "alert('密码错误！');";
				echo "location.href='login.php';";
				echo "</script>";
			}
		}
		//echo '<pre>';
		//print_r($uarr);
		//echo '</pre>';
		exit();
	}
	//获取记住账号的值
	$regusr=isset($_COOKIE['REGUSR'])?$_COOKIE['REGUSR']:"";

?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/global.css">
</head>
	<script src='jquery-1.7.js'></script>
	<script>
	$(function()
	{
		$("#usr").blur(function()
		{
			$.post("login.php",{'name':$("#usr").val(),'act':'checkuser'},function(a)
			{
				//alert(a.msg);
				$("#hg").html(a.msg);
				if(a.msg=='账号正确')
				{
					$("#hg").css('color','green');
				}
				else
				{
					$("#hg").css('color','red');
				}
			},'json');
		});
		$("#yz").keyup(function()
		{
			//alert(11);
			$.post("login.php",{'codes':$("#yz").val(),'act':'checkcode'},function(a)
			{
				alert(a);
			})
		})
	})
	function change()
	{
		$("#yzm").attr("src","code.php?"+Math.random());
	}
	</script>
<body>
<div>
    <h2>用户登录</h2>
	<hr style=" height:1px;border:none;border-top:1px dashed #0066CC;">
	<form action="login.php" method="post">
    <div class="index_new_box_3">
        <ul>
            <li>
                <div class="index_new_box_3_main"><span>用户：</span> <input id='usr' type="text" name="username" /></div><span id='hg'></span>
            </li>
            <li>
                <div class="index_new_box_3_main"><span>密码：</span> <input type="password" name="pwd" /></div>
            </li>	
            <li>
                <div class="index_new_box_3_main"><span>验证码：</span> <input id='yz' type="text" name="auths" />
				<img src='code.php' width='100' height='30' id='yzm'><br>
				&nbsp;&nbsp;<a href='javascript:;' onclick='change();'>换一张</a><br></div>
            </li>	
			<li>
				<input type='checkbox' name='reg' value='1'>记住账号<br>
			</li>
            <li>
                <div class="index_new_box_3_main">&nbsp;<input class="button" type="submit" value="登录" /></div>
            </li>				
        </ul>
	</div>
	</form>
</div>
</body>
</html>