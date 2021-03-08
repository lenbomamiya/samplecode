<!--
//*********************************************************************
// PHP5 Document
//
// Description: 
// Programmer : lenbo
// History    : 20121101 - Release.
//              20130725 - To add comments and change function name.
//**********************************************************************
-->

<script language="javascript" type="text/javascript" src="../datepicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="../room.js"></script>

<?php
	header("Content-Type: text/html; charset=utf-8");
	include("../config.php");
	
	// delete a old record
	if(isset($_POST["Action"])&&($_POST["Action"]=="delete")){
		$SqlQuery = "DELETE FROM `booking` WHERE `PriKey` = '{$_POST["PriKey"]}'";
		mysql_query($SqlQuery);
		
		echo "<script>alert(\"登記資料已刪除！\");</script>";
		echo "<meta http-equiv=\"refresh\" content=\"0; URL=query.php?Pages=".$_POST["Pages"]."\"/>";
	// SQL query statement.
	}else{
		$SqlQuery = "SELECT * FROM `booking` WHERE `PriKey` = '{$_GET["PriKey"]}'";
		$SqlResult = mysql_query($SqlQuery);
		$RowResult = mysql_fetch_assoc($SqlResult);
	}
?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>教室借用登記查詢系統 - 刪除登記</title>
</head>

<body>
	<!-- top message start -->
	<table border="0" width="1000" align="center">
		<tr>
        	<td align="right" width="57%" nowrap><img src="../logo.png" height="40"></td>
            <td align="left" width="43%" nowrap><font size="6">教室借用登記系統</font><br></td>
        </tr>
    	<tr>
        	<td align="center" colspan="2">
			<h1>刪除登記</h1>
			<hr width="100%">
		</td></tr>
    </table>
	<!-- top message end -->
	
    <!-- info message start -->
   	<table border="0" width="1006" align="center"><tr><td align="center">
			<font size="5" color="red"><b>注意！即將刪除下列教室借用登記資料</b></font>
	</td></tr></table>
   	<!-- info message end -->
    
    <br><br><br><br>
    
	<!-- Table list of records start -->
    <table border="0" cellspacing="2" width="1006" align="center">
    	<!-- classified catalogue of table -->
		<tr bgcolor="cadetblue">
 			<th width="65" nowrap>教室</th>
  			<th width="105" nowrap>借用日期</th>
  			<th width="40" nowrap>星期</th>
  			<th width="45" nowrap>節次</th>
  			<th width="100" nowrap>單位</th>
  			<th width="80" nowrap>申請人</th>
  			<th width="100" nowrap>聯絡電話</th>
  			<th width="200" nowrap>活動內容</th>
  			<th width="40" nowrap>人數</th>
  			<th width="100" nowrap>備註</th>
  			<th width="105" nowrap>申請日期</th>
  		</tr>
        
        <!-- content of table -->
        <tr>
        	<td align="center"><?php echo $RowResult["RoomHall"].$RowResult["RoomNum"] ?></td>
			<td align="center"><?php echo $RowResult["DateReg"] ?></td>
			<td align="center"><?php 
									$ArrayWeek = array("一", "二", "三", "四", "五", "六", "日");
								 	echo $ArrayWeek[date(N, strtotime($RowResult["DateReg"]))-1];
								 ?>
			</td>
			<td align="center">
			    <?php 
				if ( $RowResult["StartTime"] == $RowResult["EndTime"] ) {
					echo $RowResult["StartTime"];
				} else {
					echo $RowResult["StartTime"]."-".$RowResult["EndTime"];
				}
			    ?>
			</td>
			<td align="center"><?php echo $RowResult["UserOrg"] ?></td>
			<td align="center"><?php echo $RowResult["UserName"] ?></td>
			<td><?php echo $RowResult["UserPhone"] ?></td>
			<td><?php echo $RowResult["Active"] ?></td>
			<td align="center"><?php echo $RowResult["Persons"] ?></td>
			<td><?php echo $RowResult["Remarks"] ?></td>
			<td align="center"><?php echo $RowResult["DateApply"] ?></td>
		</tr>
	</table>
	<!-- Table list of records end -->
	
	<br><br><br><br>
	
	<table border="0" width="1000" align="center"><tr><td align="center">
    <form method="post" action="delete.php">
      	<input type="hidden" name="Action" value="delete">
	    <input type="hidden" name="Pages" value="<?php echo $_GET["Pages"];?>">
        <input type="hidden" name="PriKey" value="<?php echo $RowResult["PriKey"];?>">
        <input type="submit" value="確定"/>
        &nbsp;<input type="button" value="取消" onClick="location.href='query.php?Pages=<?php echo $_GET["Pages"]?>'"/>
    </form>
    </td></tr></table>

	<!-- bottom message start -->
	<table border="0" width="1000" align="center">
		<tr><td colspan="2"><hr width="100%"></td></tr>
		<tr><td width="180" nowrap></td><td>
			本組僅負責「校本部(含圖書館校區)」「開學期間」第「1-10」節課程之教室借用登記。<br>
			其餘時段及場地，請冾總務處事務組(02-7734-1925)。<br>
		</td></tr>
		<tr><td width="180" nowrap></td><td>
			借用教室前請先閱讀：<a href="../rule.php" target="_blank">教室借用規則</a>
			&nbsp;網頁程式設計：<a href="mailto:lenbo.mamiya@gmail.com">lenbo</a>
		</td></tr>
	</table>
    <!-- bottom message end -->

</body>
</html>