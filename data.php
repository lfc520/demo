<?php
	123123132132
	//忽略notice警告
	error_reporting(E_ALL^E_NOTICE);
	//创建PDO对象
	$pdo = new PDO("mysql:host=localhost;dbname=demo","root","");
	//每页显示的数据条数
	$pagenum = 2;
	//
	//$pdo -> query("select * from member") -> rowCount()  总条数
	//下面计算总页数
	$pagetotal = ceil($pdo -> query("select * from member") -> rowCount()/$pagenum);
	/*$_GET 变量
	预定义的 $_GET 变量用于收集来自 method="get" 的表单中的值。
	从带有 GET 方法的表单发送的信息，对任何人都是可见的（会显示在浏览器的地址栏），并且对发送信息的量也有限制。*/
	//当前页,最小写1
	if ($_GET['page']) {
		$page = $_GET['page'];
	}else{
		$page = 1;
	}
	//当前页不能大于总页数
	if ($page>=$pagetotal) {
		$page = $pagetotal;
	}
	//当前页不能小于1
	if ($page<=1) {
		$page = 1;
	}
	//在php中.(小数点)是连接符,和JS中+(加号)一样
	$sql = "select * from member limit ".($page-1)*$pagenum.",".$pagenum;
	//执行查询语句，返回对象结果集
	$result = $pdo -> query($sql);
	//从结果集中一次性获取所有数据
	$data = $result -> fetchAll(PDO::FETCH_OBJ);
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	echo "<hr>";
	//上下翻页及页数
	echo "<a href='?page=".($page-1)."'>上一页</a>&nbsp;&nbsp;<a href='?page=".($page+1)."'>下一页</a>&nbsp;&nbsp;".$page."/".$pagetotal;
	echo "<hr>";
	echo "<input type='number' class='numChange' value=".$page." style='width:60px'>";
	echo "<hr>";
	echo "<input type='text' class='textChange' value=".$page.">";
	echo "<input type='submit' class='submitChange'>";
?>
<script>
	var numChange = document.querySelector(".numChange");
	//input的change事件影响了地址栏page的值
	//地址栏page的值又影响了php的分页
    numChange.addEventListener("change",function(){
    	location.href = "?page=" + this.value;
    });
    //点击提交按钮实现跳转
    var textChange = document.querySelector(".textChange");
    var submitChange = document.querySelector(".submitChange");
    submitChange.addEventListener("click",function(){
    	location.href = "?page=" + textChange.value;
    });
</script>
