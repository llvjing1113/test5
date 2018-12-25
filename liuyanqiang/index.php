<?php
define('IN_PHP',44);
include_once 'class/mysql.class.php';
$dbObj=new db_mysql('localhost','root','','liuyan');
$sql="select * from liuyan";
$liuArr=$dbObj->getall($sql);
//echo '<pre>';
//print_r($liuArr);
//echo '</pre>';
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/global.css">
    <title>留言滚动墙</title>
    <script type="text/javascript" src="./js/jquery-1.3.2.min.js" /></script>
    <script src="./js/jquery.kxbdmarquee.js" type="text/javascript"></script>
    <style>
        #element_id{overflow:hidden;}
		img
		{
			width:50px;
			height:50px;
		}
    </style>

</head>

<body>
<div>
    <h2>留言墙</h2>

	<div class="index_new_box_1_main">
		<span><a href="login.php">我要留言</a></span>
	</div>
    <div class="index_new_box_3">
        <ul>
            <li>
                <div class="index_new_box_3_main"><span>留言心情</span></div>
                <div class="index_new_box_3_main"><span>留言内容</span></div>
                <div class="index_new_box_3_main"><span>留言日期</span></div>
            </li>
        </ul>
        <div id="element_id" style="height: 150px;">
            <ul>
			<?php
			foreach($liuArr as $v)
			{
			?>
                <li>
                    <div class="index_new_box_1_main"><img src="<?php echo $v['picture']?>">（Tom）</div>
                    <div class="index_new_box_1_main"><?php echo $v['content']?></div>
                    <div class="index_new_box_1_main"><?php echo $v['timeline']?></div>
                </li>
			<?php
			}
			?>
                <!--<li>
                    <div class="index_new_box_1_main"><img src="img/biaohan-2.png" height="62px">(<a href="javascript:alert('单击这里删除该记录')">Tom</a>)</div>
                    <div class="index_new_box_1_main"><a href="javascript:alert('单击这里修改该记录')">春江水暖鸭先知...</a></div>
                    <div class="index_new_box_1_main">2017-02-20</div>
                </li>
                <li>
                    <div class="index_new_box_1_main"><img src="img/05s.jpg" height="62px">(jack)</div>
                    <div class="index_new_box_1_main">早起的鸟儿有虫吃！</div>
                    <div class="index_new_box_1_main">2017-02-15</div>
                </li>   -->            
            </ul>
        </div>
    </div>
</div>
    <script type="text/javascript">
        $(function(){
            $('#element_id').kxbdMarquee({direction:'up',isEqual:true,loop:0,scrollAmount:1,scrollDelay:20});
			//getnewcontent();
        });
		
		function getnewcontent()
		{
			$.get('newcontent.php',function(data){
				$("#wall").html(data);
			});
			getnewcontent("getLine()",3000);
		}		
    </script>
</body>
</html>