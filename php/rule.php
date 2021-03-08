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

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>教室借用規則</title>
</head>

<body>
	<!-- Start of top message -->
	<table border="0" width="1000" align="center">
		<tr>
        	<td align="right" width="57%" nowrap><img src="logo.png" height="40"></td>
            <td align="left" width="43%" nowrap><font size="6">教室借用規則</font><br></td>
        </tr>
    	<tr>
        	<td align="center" colspan="2"><hr width="100%"></td>
        </tr>
    </table>
   	<!-- End of top message -->
	
    <!-- Start of info. -->
	<?php if ( $_GET["Room"] == "General" ) { ?>
		<table border="0" width="1000" align="center">
    		<tr>
            	<td align="center"><h1>誠正樸大樓普通e化教室借用辦法</h1></td>
            </tr>
    		<tr>
            	<td align="center">
                    <font size="7">請冾教務處課務組</font><br>
                    <font size="5">(02-7734-1182)</font>
				</td>
    		</tr>
    	</table>
        <br><br><br><br>
    <?php } ?>
	<!-- End of info. -->
    
	<!-- Start of info. -->
	<?php if ( $_GET["Room"] == "Lecture" ) { ?>
		<table border="0" width="1000" align="center">
    		<tr><td align="center"><h1>誠大樓階梯教室借用辦法</h1></td></tr>
    		<tr>
            	<td align="center">
                    <font size="7">填寫階梯教室借用申請表(<a href="form/lecture.doc" target="_blank">下載</a>)</font><br>
                    <font size="5">▼</font>
				</td>
    		</tr>
    		<tr>
            	<td align="center">
                    <font size="7">教務處課務組確認並登記場地</font><br>
                    <font size="5">▼</font>
				</td>
    		</tr>
    		<tr>
            	<td align="center">
                    <font size="7">總務處事務組計算場地租金</font><br>
                    <font size="5">▼</font>
				</td>
    		</tr>
    		<tr>
            	<td align="center">
                    <font size="7">教室借用登記完成！</font>
				</td>
    		</tr>
    	</table>
        <br><br><br><br>
    <?php } ?>
	<!-- End of info. -->

	<!-- Start of info. -->
    <?php if ( $_GET["Room"] == "Lyceum" ) { ?>
		<table border="0" width="1000" align="center">
    		<tr>
            	<td align="center"><h1>綜合\教育大樓‧演講廳\會議室借用辦法</h1></td>
            </tr>
    		<tr>
            	<td align="center">
                    <font size="7">填寫演講廳\會議室借用申請表(<a href="form/lyceum.doc" target="_blank">下載</a>)</font><br>
                    <font size="5">▼</font>
				</td>
    		</tr>
    		<tr>
            	<td align="center">
                    <font size="7">教務處課務組確認並登記場地</font><br>
                    <font size="5">▼</font>
				</td>
    		</tr>
    		<tr>
            	<td align="center">
                    <font size="7">總務處事務組計算場地租金</font><br>
                    <font size="5">▼</font>
				</td>
    		</tr>
    		<tr>
            	<td align="center">
                    <font size="7">教室借用登記完成！</font>
				</td>
    		</tr>
    	</table>
        <br><br><br><br>
    <?php } ?>
	<!-- End of info. -->
    
	<!-- Start of question. -->
	<?php if ( $_GET["Time"] == "Workday" ) { ?>
		<table border="0" width="1000" align="center">
    		<tr><td colspan="3" align="center"><h1>請問您欲借用教室類型？</h1></td></tr>
    		<tr>
            	<td align="right" width="33%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:green;" 
                    	    onClick="location.href='rule.php?Room=General'">
                    	<font size="7">普通e化教室</font><br>
                        <font size="5">(校本部誠正樸大樓)</font>
                    </button>                   
                </td>
                <td align="center" width="33%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:blue;" 
                    	    onClick="location.href='rule.php?Room=Lecture'">
                    	<font size="7">階梯教室</font><br>
                        <font size="5">(校本部誠大樓)</font>
                    </button>
				</td>
                <td align="left" width="33%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:red;" 
                    	    onClick="location.href='rule.php?Room=Lyceum'">
                    	<font size="7">演講廳或會議室</font><br>
                        <font size="5">(圖書館校區綜合&教育大樓)</font>
                    </button>
				</td>
    		</tr>
    	</table>
    	<br><br><br><br>
    <?php } ?>	
    <!-- End of question. -->
	
	<!-- Start of info. -->
    <?php if ( $_GET["Time"] == "Others" ) { ?>
		<table border="0" width="1000" align="center">
    		<tr><td align="center"><h1>校本部教室借用方法</h1></td></tr>
    		<tr>
            	<td align="center">
                    <font size="7">請冾總務處事務組</font><br>
                    <font size="5">王美蘭小姐(02-7734-1925)</font>
				</td>
    		</tr>
    	</table>
        <br><br><br><br>
    <?php } ?>
	<!-- End of info. -->
    
	<!-- Start of 1st question -->
    <?php if ( $_GET["Campus"] == "Main" ) { ?>
		<table border="0" width="1000" align="center">
    		<tr><td colspan="2" align="center"><h1>請問您欲借用教室的時段是？</h1></td></tr>
    		<tr>
            	<td align="right" width="50%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:green;" 
                    	    onClick="location.href='rule.php?Time=Workday'">
                    	<font size="7">平日上課時段</font><br>
                        <font size="5">開學期間第1-10節(8:00~18:00)</font>
                    </button>                   
                </td>
                <td align="left" width="50%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:red;" 
                    	    onClick="location.href='rule.php?Time=Others'">
                    	<font size="7">其他時段</font><br>
                        <font size="5">含開學期間第10節(18:00)以後</font>
                    </button>
				</td>
    		</tr>
    	</table>
        <br><br><br><br>
    <?php } ?>
	<!-- End of 1st question -->
    
	<!-- Start of info. -->
    <?php if ( $_GET["Campus"] == "Gongguan" ) { ?>
		<table border="0" width="1000" align="center">
    		<tr><td align="center"><h1>公館校區教室借用方法</h1></td></tr>
    		<tr>
            	<td align="center">
                    <font size="7">請冾公館校區總務組</font><br>
                    <font size="5">劉慧雯小姐(02-7734-6489)</font>
				</td>
    		</tr>
    	</table>
        <br><br><br><br>
    <?php } ?>
	<!-- End of info. -->
	
	<!-- Start of info. -->
    <?php if ( $_GET["Campus"] == "Linkou" ) { ?>    	
		<table border="0" width="1000" align="center">
    		<tr><td align="center"><h1>林口校區教室借用方法</h1></td></tr>
    		<tr>
            	<td align="center">
                    <font size="7">請冾林口校區總務組</font><br>
                    <font size="5">李芳玲小姐(02-7734-8609)</font>
				</td>
    		</tr>
    	</table>
        <br><br><br><br>
    <? } ?>
	<!-- End of info. -->
	
    <!-- To ask which classroom of campus, does user want rent? -->
    <?php if ( !isset($_GET["Room"]) && !isset($_GET["Time"]) && !isset($_GET["Campus"]) ) { ?>
		<table border="0" width="1000" align="center">
    		<tr><td colspan="3" align="center"><h1>請問您欲借用教室的所屬校區是？</h1></td></tr>
    		<tr>
            	<td align="right" width="33%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:green;" 
                    	    onClick="location.href='rule.php?Campus=Main'">
                    	<font size="7">校本部</font><br>
                        <font size="3">(含圖書館校區)</font>
                    </button>                   
                </td>
                <td align="center" width="33%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:blue;" 
                    	    onClick="location.href='rule.php?Campus=Gongguan'">
                    	<font size="7">公館校區</font>
                    </button>
				</td>
                <td align="left" width="33%" nowrap>
					<button style="filter:Alpha(style=2,opacity=100,finishOpacity=0);background:red;" 
                    	    onClick="location.href='rule.php?Campus=Linkou'">
                    	<font size="7">林口校區</font>
                    </button>
				</td>
    		</tr>
    	</table>
    	<br><br><br><br>
    <?php } ?>
	<!-- End of question -->
	
	<!-- Start of bottom message. -->
	<table border="0" width="1000" align="center">
		<tr><td colspan="2"><hr width="100%"></td></tr>
		<tr>
			<td width="190" nowrap></td>
			<td>
				本組僅負責「校本部(含圖書館校區)」「開學期間」第「1-10」節課程之教室借用登記。<br>
				其餘時段及場地，請冾總務處事務組(02-7734-1925)。<br>
			</td>
		</tr>
		<tr>
			<td width="190" nowrap></td>
			<td>
				借用教室前請先閱讀：<a href="rule.php" target="_blank">教室借用規則</a>
				&nbsp;網頁程式設計：<a href="mailto:lenbo.mamiya@gmail.com">lenbo</a>
			</td>
		</tr>
	</table>
    <!-- End of bottom message. -->
	
</body>
</html>