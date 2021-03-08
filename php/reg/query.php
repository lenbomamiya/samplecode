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

<!-- Start to set MySQL query method and setting. -->
<?php
	header ( "Content-Type: text/html; charset=utf-8" );
	session_start();
	include ( "../config.php" );
	
	// To set how much rows of queried data can print in one page.
	$PageRows = 20;
	// To set default page#.
	$PageNum = 1;
	
	//
	// To set session variables' states.
	//
	// In query mode.
	if ( isset($_POST["QueDate"]) ) {
		unset($_SESSION["QueQuery"]);
		$_SESSION["QueDate"] = $_POST["QueDate"];
		$_SESSION["QueToday"] = $_POST["QueToday"];
		$_SESSION["QueHall"] = $_POST["QueHall"];
		$_SESSION["QueNum"] = $_POST["QueNum"];
		$_SESSION["QueKey"] = $_POST["QueKey"];
		$_SESSION["QueOrg"] = $_POST["QueOrg"];
	// In paging mode.
	} else if ( isset($_GET["Pages"]) ) {
		$PageNum = $_GET["Pages"];               // Ready to print PageNum.
	// To initial variables' states.
	} else {
		$_SESSION["QueDate"] = date ( "Y-m-d" ); // Default using today's date.
		unset($_SESSION["QueToday"]);
		unset($_SESSION["QueHall"]);
		unset($_SESSION["QueNum"]);
		unset($_SESSION["QueKey"]);
		unset($_SESSION["QueOrg"]);
	}
	
	// To save numbers of row of queried data to print in this page
	$PageRowsCur = ( $PageNum -1 ) * $PageRows;
	
	//
	// Not in paging mode, get a new query statement to rerun.
	//
	if ( empty($_GET["Pages"]) ) {
		//
		// To query all booking info today.
		//
		if ( $_SESSION["QueToday"] == "true" ) {
			// User had selected RoomHall and RoomNum.
			if ( !empty($_SESSION["QueNum"]) ) {
				if ( !empty($_SESSION["QueOrg"]) ) {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') = 0 ";
					$_SESSION["SqlQuery"] .=               "AND `RoomKey` = '{$_SESSION["QueKey"]}' ";
					$_SESSION["SqlQuery"] .=               "AND `UserOrg` LIKE '%{$_SESSION["QueOrg"]}%' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `StartTime`+0";
				} else {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') = 0 ";
					$_SESSION["SqlQuery"] .=               "AND `RoomKey` = '{$_SESSION["QueKey"]}' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `StartTime`+0";
				}
			// User had selected RoomHall only.
			} else if ( !empty($_SESSION["QueHall"]) ) {
				if ( !empty($_SESSION["QueOrg"]) ) {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') = 0 ";
					$_SESSION["SqlQuery"] .=               "AND `RoomHall` = '{$_SESSION["QueHall"]}' ";
					$_SESSION["SqlQuery"] .=               "AND `UserOrg` LIKE '%{$_SESSION["QueOrg"]}%' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomNum`, `StartTime`+0";
				} else {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') = 0 ";
					$_SESSION["SqlQuery"] .=               "AND `RoomHall` = '{$_SESSION["QueHall"]}' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomNum`, `StartTime`+0";
				}
			// User didn't select RoomHall and RoomNum.
			} else {
				if ( !empty($_SESSION["QueOrg"]) ) {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') = 0 ";
					$_SESSION["SqlQuery"] .=               "AND `UserOrg` LIKE '%{$_SESSION["QueOrg"]}%' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomKey`, `StartTime`+0";
				} else {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') = 0 ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomKey`, `StartTime`+0";
				}
			} // endif
		//
		// To query all booking info after today's date ( include today ).
		//
		} else {
			// User had selected RoomHall and RoomNum.
			if ( !empty($_SESSION["QueNum"]) ) {
				if ( !empty($_SESSION["QueOrg"]) ) {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') >= 0 ";
					$_SESSION["SqlQuery"] .=               "AND `RoomKey` = '{$_SESSION["QueKey"]}' ";
					$_SESSION["SqlQuery"] .=               "AND `UserOrg` LIKE '%{$_SESSION["QueOrg"]}%' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `DateReg`, `StartTime`+0";
				} else {
					$_SESSION["SqlQuery"] = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=        "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') >= 0 ";
					$_SESSION["SqlQuery"] .=              "AND `RoomKey` = '{$_SESSION["QueKey"]}' ";
					$_SESSION["SqlQuery"] .=     "ORDER BY `DateReg`, `StartTime`+0";
				}
			// User had selected RoomHall only.
			} else if ( !empty($_SESSION["QueHall"]) ) {
				if ( !empty($_SESSION["QueOrg"]) ) {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') >= 0 ";
					$_SESSION["SqlQuery"] .=               "AND `RoomHall` = '{$_SESSION["QueHall"]}' ";
					$_SESSION["SqlQuery"] .=               "AND `UserOrg` LIKE '%{$_SESSION["QueOrg"]}%' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomNum`, `DateReg`, `StartTime`+0";
				} else {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') >= 0 ";
					$_SESSION["SqlQuery"] .=               "AND `RoomHall` = '{$_SESSION["QueHall"]}' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomNum`, `DateReg`, `StartTime`+0";
				}
			// User didn't select RoomHall and RoomNum.
			} else {
				if ( !empty($_SESSION["QueOrg"]) ) {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') >= 0 ";
					$_SESSION["SqlQuery"] .=               "AND `UserOrg` LIKE '%{$_SESSION["QueOrg"]}%' ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomKey`, `DateReg`, `StartTime`+0";
				} else {
					$_SESSION["SqlQuery"]  = "SELECT * FROM `booking` ";
					$_SESSION["SqlQuery"] .=         "WHERE DATEDIFF(`DateReg`, '{$_SESSION["QueDate"]}') >= 0 ";
					$_SESSION["SqlQuery"] .=      "ORDER BY `RoomKey`, `DateReg`, `StartTime`+0";
				}
			} // endif
		
		} // End of if ( $_SESSION["QueToday"] == "true" )
		
	} // End of if ( empty($_GET["Pages"]) )
	
	$SqlQueryLimit = $_SESSION["SqlQuery"]." LIMIT ".$PageRowsCur.", ".$PageRows; // SQL query statement with LIMIT 由本頁開始記錄筆數開始，每頁顯示預設筆數
	$SqlResult = mysql_query ( $SqlQueryLimit );                                  // 以加上限制顯示筆數的SQL敘述句查詢資料到 $SqlResult 中
	$SqlResultAll = mysql_query ( $_SESSION["SqlQuery"] );                        // 以未加上限制顯示筆數的SQL敘述句查詢資料到 $SqlResultAll 中
	$RecordsTotal = mysql_num_rows ( $SqlResultAll );                             // 計算總筆數
	$PagesTotal = ceil ( $RecordsTotal / $PageRows );                             // 計算總頁數 = 無條件進位 ( 總筆數 / 每頁筆數 )
?>
<!-- End to set MySQL query method and setting. -->

<html>
<head>
   	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
   	<title>教室借用登記系統</title>
</head>

<body>
	<!-- top message start -->
	<table border="0" width="1000" align="center">
		<tr>
        	<td align="right" width="57%" nowrap><img src="../logo.png" height="40"></td>
            <td align="left" width="43%" nowrap><font size="6"><a href="query.php" target="_self">教室借用登記系統</a></font><br></td>
        </tr>
    	<tr>
        	<td align="center" colspan="2">
    			<form method="post" action="query.php">
  					<b>借用日期</b>
       	 			<input type="text" name="QueDate" size="13" maxlength="10" maxlength="10"
    			   	   	   value="<?php echo $_SESSION["QueDate"];?>" class="Wdate" onFocus="WdatePicker({lang:'zh-tw'})"/>
    				<select id="QueToday" name="QueToday">
  						<option value="false" <?php if($_SESSION["QueToday"]!="true") echo "selected"?>>以後</option>
    					<option value="true" <?php if($_SESSION["QueToday"]=="true") echo "selected"?>>當日</option>
    				</select>
  					&nbsp;<b>借用場地</b>
    				<select id="QueHall" name="QueHall"></select>大樓
        			<select id="QueNum" name="QueNum" style="width:60px"></select>教室
        			<input type="hidden" id="QueKey" name="QueKey" size="5" maxlength="5"/>
        				<script language="javascript">
							// initial RoomHall and RoomNum of 2 order selection
							room(true);
							// if QueHall is selected, then set it.
							var HallValue = "<?php echo $_SESSION["QueHall"]?>"; change_choice("QueHall", HallValue);
							// if QueNum is selected, then set it.
							var NumValue = "<?php echo $_SESSION["QueNum"]?>"; change_choice("QueNum", NumValue);
            			</script>
        			&nbsp;<b>申請單位</b>
       	 			<input type="text" name="QueOrg" size="18" maxlength="9"
        				   value="<?php echo $_SESSION["QueOrg"];?>"/>
					&nbsp;<input type="submit" value="送出查詢"/>
					<!-- &nbsp;<input type="button" value="預設查詢" echo onClick="location.href='query.php'"/> -->
            		&nbsp;<input type="button" value="新增登記" onClick="location.href='reg.php?Pages=<?php echo $PageNum;?>'"/>
    			</form>
    			<hr width="100%">
    		</td>
        </tr>
    </table>
	<!-- top message end -->
	
	<!-- info message start -->
	<!-- Can`t find any reocrd to fit query. -->
    <?php if(!$RecordsTotal){ ?>
		<table border="0" width="1088" align="center"><tr><td align="center">
			<font size="5"><b>查無教室借用登記資料！</b></font><br><br><br><br><br><br><br><br><br>
		</td></tr></table>
	
	<!-- Find records to fit query. -->
	<?php }else{ ?>
		<table border="0" width="1088" align="center"><tr><td align="center">
			<font size="5"><b>找到<?php echo $RecordsTotal ?>筆教室借用登記資料！</b></font><br><br>
		</td></tr></table>
		
		<!-- Table list of records -->
		<table border="0" cellspacing="2" width="1088" align="center">
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
  				<th width="80" nowrap colspan="2">功能</th>
  			</tr>
		
        <!-- content of table -->
    	<?php
    		$ArrayWeek = array ( "一", "二", "三", "四", "五", "六", "日" );
    		$CountRow = 1;
    		while($RowResult = mysql_fetch_assoc($SqlResult)){
				echo "<tr ";
				if($CountRow%2 == 0) echo "bgcolor=\"lavender\"";
				echo ">";
				echo "<td align=\"center\">".$RowResult["RoomHall"].$RowResult["RoomNum"]."</td>";
				echo "<td align=\"center\">".$RowResult["DateReg"]."</td>";
				echo "<td align=\"center\">".$ArrayWeek[date(N, strtotime($RowResult["DateReg"]))-1]."</td>";
				
				if ( $RowResult["StartTime"] == $RowResult["EndTime"] ) {
					echo "<td align=\"center\">".$RowResult["StartTime"]."</td>";
				} else {
					echo "<td align=\"center\">".$RowResult["StartTime"]."-".$RowResult["EndTime"]."</td>";
				}
				
				echo "<td align=\"center\">".$RowResult["UserOrg"]."</td>";
				echo "<td align=\"center\">".$RowResult["UserName"]."</td>";
				echo "<td>".$RowResult["UserPhone"]."</td>";
				echo "<td>".$RowResult["Active"]."</td>";
				echo "<td align=\"center\">";
					if($RowResult["Persons"] == 0) echo "";
					else echo $RowResult["Persons"];
				echo "</td>";
				echo "<td>".$RowResult["Remarks"]."</td>";
				echo "<td align=\"center\">".$RowResult["DateApply"]."</td>";
				echo "<td align=\"center\"><a href='update.php?Pages=".$PageNum."&PriKey=".$RowResult["PriKey"]."'><font color=\"green\">修改</font></a></td>";
				echo "<td align=\"center\"><a href='delete.php?Pages=".$PageNum."&PriKey=".$RowResult["PriKey"]."'><font color=\"red\">刪除</font></a></td>";
				echo "</tr>";
				$CountRow++;
			}
		?>
		</table>
		<!-- info message end -->
		
        <!-- display hyperlink of pages start -->
        <table border="0" cellspacing="2" width="1088" align="center"><tr>
  			<td align="right" width="60" nowrap>頁數：</td>
  			<td align="left" width="638" nowrap>
				<!-- pages function start -->
  				<?php
  					for($i=1;$i<=$PagesTotal;$i++){
  	  					if($i==$PageNum){
  	  						echo $i." ";
  	  					}else{
  	  						echo "<a href=\"query.php?Pages=$i\">$i</a> ";
  						}
  					}
  				?>
  			   	<!-- pages function end -->
  			</td>
    		
    		<td align="right" width="300" nowrap>
    			<!-- volti function start -->
    			<?php if ($PageNum > 1) { // If it not first page, then print the message below. ?>
    				<a href="query.php?Pages=1">第一頁</a>&nbsp;
    				<a href="query.php?Pages=<?php echo $PageNum-1;?>">上一頁</a>&nbsp;
    			<?php } ?>
    			<?php if ($PageNum < $PagesTotal) { // If it not last page, then print the message below. ?>
    				<a href="query.php?Pages=<?php echo $PageNum+1;?>">下一頁</a>&nbsp;
    				<a href="query.php?Pages=<?php echo $PagesTotal;?>">最後頁</a>&nbsp;
    			<?php } ?>
    			<!-- volti function end -->
  			</td>
  			<td width="80" nowrap></td>
  		</tr></table>
		<!-- display hyperlink of pages end -->
	<?php } ?>
	<!-- info message end -->
	
	<!-- bottom message start -->
	<table border="0" width="1000" align="center">
		<tr><td colspan="2"><hr width="100%"></td></tr>
		<tr><td width="190" nowrap></td><td>
			本組僅負責「校本部(含圖書館校區)」「開學期間」第「1-10」節課程之教室借用登記。<br>
			其餘時段及場地，請冾總務處事務組(02-7734-1925)。<br>
		</td></tr>
		<tr><td width="190" nowrap></td><td>
			借用教室前請先閱讀：<a href="../rule.php" target="_blank">教室借用規則</a>
			&nbsp;網頁程式設計：<a href="mailto:lenbo.mamiya@gmail.com">lenbo</a>
		</td></tr>
	</table>
    <!-- bottom message end -->
	
</body>
</html>