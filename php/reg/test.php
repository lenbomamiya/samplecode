<script language="javascript" type="text/javascript" src="../datepicker/WdatePicker.js"></script>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>教室借用登記系統 - 測試頁</title>
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
			<h1>測試頁</h1>
			<hr width="100%">
		</td></tr>
    </table>
	<!-- top message end -->
    
    <?php if(!isset($_POST["DateReg"])){ ?>
    	<form method="post" action="test.php">
    		<table border="0" align="center" cellspacing="1" cellpadding="5">
    			<tr>
            		<td><b>借用日期</b>*</td>
            		<td><input type="text" name="DateReg" size="13" maxlength="10"
            			       value="<?php if(!empty($_POST["DateReg"])) echo $_POST["DateReg"];?>"
            		    	   class="Wdate" onFocus="WdatePicker({lang:'zh-tw'})"
            			/>
            		</td>
        		</tr>
        		<tr>
            		<td><b>連續借用</b></td>
            		<td><select name="Week">
            			<option value=1 selected>1</option>
            			<option value=2>2</option>
            			<option value=3>3</option>
            			<option value=4>4</option>
            			<option value=5>5</option>
            			<option value=6>6</option>
            			<option value=7>7</option>
            			<option value=8>8</option>
            			<option value=9>9</option>
            			<option value=10>10</option>
            			<option value=11>11</option>
            			<option value=12>12</option>
            			<option value=13>13</option>
            			<option value=14>14</option>
            			<option value=15>15</option>
            			<option value=16>16</option>
            			<option value=17>17</option>
            			<option value=18>18</option>
            			</select>
            			週
         			</td>
    			</tr>
    			<tr>
        			<td colspan="2" align="center">
        				<br><br>
        				<input type="submit" value="送出"/>
            		</td>
         		</tr>
    		</table>
   		</form>
   	<?php }else{ ?>
   		<center>
   		<?php
   			$tmp = $_POST["DateReg"];
    		for($i = 0; $i<$_POST["Week"]; $i++){
   				echo date("y-m-d", strtotime("$tmp + $i week"))."<br>";
   			}
   		?>
   		</center>
    <?php } ?>
    
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