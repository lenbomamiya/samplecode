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
<script language="javascript" type="text/javascript" src="../time.js"></script>

<?php
	header("Content-Type: text/html; charset=utf-8");
	include("../config.php");
	
	if(isset($_POST["Action"])&&($_POST["Action"]=="reg")){
		// check the data is completed or not.
		if(isset($_POST["DateReg"]) && empty($_POST["DateReg"])){
			echo "<script>alert(\"未選填「借用日期」！\");</script>";
		}else if(isset($_POST["DateReg"]) && empty($_POST["RoomHall"])){
			echo "<script>alert(\"未選借用場地「大樓」！\");</script>";
		}else if(isset($_POST["DateReg"]) && empty($_POST["RoomNum"])){
			echo "<script>alert(\"未選借用場地「教室」！\");</script>";
		}else if(isset($_POST["DateReg"]) && empty($_POST["UserOrg"])){
			echo "<script>alert(\"未填「申請單位」名稱！\");</script>";
		}else if(isset($_POST["DateReg"]) && empty($_POST["UserName"])){
			echo "<script>alert(\"未填「申請人」姓名！\");</script>";
		}else if(isset($_POST["DateReg"]) && empty($_POST["UserPhone"])){
			echo "<script>alert(\"未填「聯絡電話」！\");</script>";
		}else if(isset($_POST["DateReg"]) && empty($_POST["Active"])){
			echo "<script>alert(\"未填「活動內容」！\");</script>";
		// check the RoomTime is conflict or not.
		}else{
			// query registed data to find RoomTime is conflict or not?
			$SqlQuery = "SELECT * FROM `booking` WHERE DATEDIFF(`DateReg`, '{$_POST["DateReg"]}') = 0 AND `RoomKey` = '{$_POST["RoomKey"]}'
									          ORDER BY `StartTime`";
			$SqlResult = mysql_query($SqlQuery);
			while ( $RowResult = mysql_fetch_assoc ( $SqlResult ) ) {
				for ( $i = intval($RowResult["StartTime"]); $i <= intval($RowResult["EndTime"]); $i++ ) {
					if ( $i == $_POST["StartTime"] || $i == $_POST["EndTime"] ) {
						$FlagConflict = "true";
						break;
					}
				}
			};
			// if RoomTime is conflict, then display error message.
			if($FlagConflict == "true"){
				echo "<script>alert(\"使用節次「衝堂」！\");</script>";
			// add a new record.
			}else{
				$SqlQuery = "INSERT INTO `booking` (`PriKey`, `DateApply`, `DateReg`,
	 	    		                                `RoomKey`, `RoomHall`, `RoomNum`, `StartTime`, `EndTime`,
									                `UserOrg`, `UserName`, `UserPhone`, `Active`, `Persons`, `Remarks`)
	      	        		                VALUES (uuid(), '".date("y-m-d")."', '{$_POST["DateReg"]}',
								                    '{$_POST["RoomKey"]}', '{$_POST["RoomHall"]}', '{$_POST["RoomNum"]}', '{$_POST["StartTime"]}', '{$_POST["EndTime"]}',
					        		                '{$_POST["UserOrg"]}', '{$_POST["UserName"]}', '{$_POST["UserPhone"]}',
				    	        		            '{$_POST["Active"]}', '{$_POST["Persons"]}', '{$_POST["Remarks"]}')";
				mysql_query($SqlQuery);
			
				$SqlQuery = "SELECT * FROM `booking` WHERE `DateReg` = '{$_POST["DateReg"]}' AND `RoomKey` = '{$_POST["RoomKey"]}' AND `StartTime` = '{$_POST["StartTime"]}'";
				$SqlResult = mysql_query($SqlQuery);
				$RowResult = mysql_fetch_assoc($SqlResult);
			
				// go to confirm page.
				echo "<meta http-equiv=\"refresh\" content=\"0; URL=confirm.php?Pages=".$_GET["Pages"]."&PriKey=".$RowResult["PriKey"]."&Action=".$_POST["Action"]."\"/>";
			}
		}
	}
?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>教室借用登記查詢系統 - 新增登記</title>
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
			<h1>新增登記</h1>
			<hr width="100%">
		</td></tr>
    </table>
	<!-- top message end -->
    
    <br>
    
    <form method="post" action="reg.php?Pages=<?php echo $_GET["Pages"];?>">
      	<table border="0" align="center" cellspacing="1" cellpadding="5">
      		<!--
      		<tr>
      			<td><b>申請日期</b>*</td>
      			<td><input type="text" name="DateApply" size="13" maxlength="10"
      					   value="<?php if(!empty($_POST["DateApply"])) echo $_POST["DateApply"];?>"
      					   class="Wdate" onFocus="WdatePicker({lang:'zh-tw'})"
      				/>
      			</td>
      		</tr>
      		-->
      		<tr>
            	<td><b>借用日期</b>*</td>
            	<td><input type="text" name="DateReg" size="13" maxlength="10"
            		       value="<?php if(!empty($_POST["DateReg"])) echo $_POST["DateReg"]; else echo date("Y-m-d"); ?>"
            		       class="Wdate" onFocus="WdatePicker({lang:'zh-tw'})"
            		/>
            	</td>
            </tr>
            <tr>
            	<td><b>使用節次</b>*</td>
            	<td>
            	    第<select id="StartTime" name="StartTime"></select>節&nbsp;至&nbsp;
		  			第<select id="EndTime" name="EndTime"></select>節
                    <!-- To initial StartTime and EndTime of 2 order selection -->
                    <script language="javascript">
						time();
						// If StartTime is selected, then set it.
						var StartTimeValue = "<?php echo $_POST["StartTime"] ?>";
						if ( StartTimeValue.length > 0 ) change_time ( "StartTime", StartTimeValue );
						if ( StartTimeValue.length == 0 ) change_time ( "StartTime", 5 );
						// If EndTime is selected, then set it.
						var EndTimeValue = "<?php echo $_POST["EndTime"] ?>";
						if ( EndTimeValue.length > 0 ) change_time ( "EndTime", EndTimeValue );
						if ( EndTimeValue.length == 0 ) change_time ( "EndTime", 6 );
                    </script>
            	</td>
            </tr>
        	<tr>
        		<td><b>借用場地</b>*</td>
        		<td>
          			<select id="RoomHall" name="RoomHall"></select>大樓
		  			<select id="RoomNum" name="RoomNum"></select>教室
          			<input type="hidden" id="RoomKey" name="RoomKey" size="5" maxlength="5"/>
                    <!-- initial RoomHall and RoomNum of 2 order selection -->
                    <script language="javascript">
						room(false);
						// if RoomHall is selected, then set it.
						var HallValue = "<?php echo $_POST["RoomHall"]?>";
						if(HallValue.length > 0) change_choice("RoomHall", HallValue);
						// if RoomNum is selected, then set it.
						var RoomValue = "<?php echo $_POST["RoomNum"]?>";
						if(RoomValue.length > 0) change_choice("RoomNum", RoomValue);
                    </script>
        		</td>
        	</tr>
        	<tr>
        		<td><b>申請單位</b>*</td>
        		<td><input type="text" name="UserOrg" size="18" maxlength="9" value="<?php if(!empty($_POST["UserOrg"])) echo $_POST["UserOrg"];?>"/></td>
        	</tr>
          	<tr>
          		<td><b>申請人</b>*</td>
          		<td><input type="text" name="UserName" size="18" maxlength="9" value="<?php if(!empty($_POST["UserName"])) echo $_POST["UserName"];?>"/></td>
          	</tr>
          	<tr>
          		<td><b>聯絡電話</b>*</td>
          		<td>
          			<!-- keyCode 35 is '#', keyCode 45 is '-', keyCode between 48 and 57 is numbers. -->
          			<input type="text" name="UserPhone" size="36" maxlength="36"
          				   value="<?php if(!empty($_POST["UserPhone"])) echo $_POST["UserPhone"];?>"
          		           onKeypress="if(event.keyCode!=35 && event.keyCode!=45  && (event.keyCode<48 || event.keyCode>57)) event.returnValue = false;"/>
          		</td>
        	</tr>
        	<tr>
        		<td><b>活動內容</b>*</td>
          		<td><input type="text" name="Active" size="36" maxlength="18" value="<?php if(!empty($_POST["Active"])) echo $_POST["Active"];?>"/></td>
	        </tr>
	        <tr>
          		<td><b>使用人數</b></td>
          		<td>
          			<!-- keyCode between 48 and 57 is numbers. -->
          			<input type="text" name="Persons" size="3" maxlength="3"
          				   value="<?php if(!empty($_POST["Persons"])) echo $_POST["Persons"];?>"
          			       onKeypress="if(event.keyCode<48 || event.keyCode>57) event.returnValue = false;"/>
          		</td>
        	</tr>
        	<tr>
        		<td><b>備註</b></td>
            	<td><input type="text" name="Remarks" size="36" maxlength="18" value="<?php if(!empty($_POST["Remarks"])) echo $_POST["Remarks"];?>"/></td>
          	</tr>
        	<tr>
        		<td colspan="2" align="center">
        			<br><br>
        			<input type="hidden" name="Action" value="reg"/>
        			<input type="submit" value="送出"/>
                	&nbsp;<input type="button" value="重置" onClick="location.href='reg.php?Pages=<?php echo $_GET["Pages"];?>'"/>
        			&nbsp;<input type="button" value="取消" onClick="location.href='query.php?Pages=<?php echo $_GET["Pages"];?>'"/>
                </td>
            </tr>
		</table>
    </form>
 	
 	<br>
 	
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