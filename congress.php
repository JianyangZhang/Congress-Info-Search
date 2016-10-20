<!DOCTYPE html>
<html>
	<head>
		<title>Congress Info</title>
		<meta charset="utf-8">
		<style type="text/css">
			body {
				margin:auto;
				margin-top:50px;
				width:800px;
				white-space:nowrap;
				text-align:center;
				font-size:13px;
			}	
			.textCenter {
				text-align:center;
			}
			.center {
				margin:auto;
				display:block;
			}
			.hide {
				display:none;
			}
			#resultTable1 th, #tbody1 td, 
			#resultTable2 th, #tbody2 td, 
			#resultTable3 th, #tbody3 td,
			#resultTable4 th, #tbody4 td {
				padding-left:40px;
				padding-right:40px;
			}
			#div1 {
				border:solid black 2px;
				padding:5px;
				padding-top:10px;
				padding-right:18px;
				margin-bottom:20px;
				overflow:hidden;
				width:auto;
				font-size:13px;
				display:inline-block;
			}
			#div2 {
				font-size:13px;
			}
			#div3, #div4 {
				border:solid black 2px;
				margin:0 auto;	
				font-size:13px;					
				text-align:left;			
			}
			#photo {
				text-align:center;
				
			}
			#btn1 {
				display:inline-block;
				float:right;
			}
			#btn2 {
				display:inline-block;
				float:right;
			}	
			.textCenter {
				text-align:center;
			}
			#info2 {
				padding-left:27px;
				padding-top:5px;
			}
			#info3 {
				padding-left:37px;
				padding-top:5px;
			}
			#info4 {
				padding-right:17px;
				padding-top:8px;
			}
			#info5 {
				padding-top:3px;
				clear:right;
			}
		</style>
		<script type="text/javascript">
			window.onload = function () {
				var oSelect1 = document.getElementById("select1");
				var otextKeyWord = document.getElementById("textKeyWord"); 	
				var oinfo3 = document.getElementById("info3");
				var oForm1 = document.getElementById("form1"); 
				var oIframe = document.getElementById("noRefresh");	
				var oDiv2 = document.getElementById("div2");
				var oDiv3 = document.getElementById("div3");
				var oDiv4 = document.getElementById("div4");
				var oJason = "noEcho";	
				oSelect1.onchange = function () {
					var newValue = this.options[this.selectedIndex].value;
					if (newValue == "legislators") {
						oinfo3.style.padding= "5px 0px 0px 5px"; 
						otextKeyWord.innerHTML = "State/Representative*"							
					} else if (newValue == "committees") {
						oinfo3.style.padding= "5px 0px 0px 22px"; 
						otextKeyWord.innerHTML = "Committee ID*&nbsp;&nbsp;"						
					} else if (newValue == "bills") {
						oinfo3.style.padding= "5px 0px 0px 46px"; 
						otextKeyWord.innerHTML = "Bill ID*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"						
					} else if (newValue == "amendments") {
						oinfo3.style.padding = "5px 0px 0px 22px";
						otextKeyWord.innerHTML = "Amendment ID*&nbsp;"						
					}					
				}			
				function resetDivs() {
					oDiv2.style = "display:none";
					oDiv3.style = "display:none";
					oDiv4.style = "display:none";
					for (var i = 0; i < oDiv2.children.length; i++) {
						oDiv2.children[i].style = "display:none";
					}	
					clearTr();					
				}
				function clearTr() {
					for (var i = 0; i < document.getElementsByTagName("tbody").length; i++) {						
						if (document.getElementsByTagName("tbody")[i].getAttribute("name") == "clearFlag") {
							while (document.getElementsByTagName("tbody")[i].children.length > 1) {
								document.getElementsByTagName("tbody")[i].removeChild(document.getElementsByTagName("tbody")[i].lastElementChild);				
							}
						}	
					}
				}				
				oForm1.onreset = function () {
					oinfo3.style.padding = "5px 0px 0px 37px";
					otextKeyWord.innerHTML = "Keyword*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					resetDivs();
				}	
				oIframe.onload = function () {
					if (!this.contentWindow.oJson) {
						return;
					}		
					resetDivs();	
					oJson = this.contentWindow.oJson;
					oDiv2.style = "display:block";	
					if (oJson.count == 0) {
						oDiv2.children[0].style = "display:inline-block";
					} else {	
						if (this.contentWindow.dataBase == "legislators") {
							document.getElementById("resultTable1").style = "display:inline-block";
							for (var i = 0; (i < oJson.count) && (i < 20); i++) {	
								var thisId = "tr" + parseInt(i);							
								var thisRow = document.getElementById(thisId);											
								thisRow.children[0].innerHTML = oJson.results[i].first_name + " " + oJson.results[i].last_name;
								thisRow.children[1].innerHTML = oJson.results[i].state_name;
								thisRow.children[2].innerHTML = oJson.results[i].chamber;	
								var flag = 1000;
								var anchorJs = "<a href='javascript:showDetails(" + parseInt(i) + ", " + parseInt(flag) + ")'>View Details</a>";
								thisRow.children[3].innerHTML = anchorJs;	
								if ((i + 1) < oJson.count) {
									var nextId = "tr" + parseInt(i + 1);
									var nextRow = thisRow.cloneNode(true);
									nextRow.setAttribute("id", nextId);								
									document.getElementById("tbody1").appendChild(nextRow);
								}
							}
							if (i == 20) {
								document.getElementById("tbody1").lastElementChild.remove();
							}			
						} else if (this.contentWindow.dataBase == "committees") {
							document.getElementById("resultTable2").style = "display:inline-block";	
							for (var i = 10; i < (oJson.count + 10) && (i < 30); i++) {							
								var thisId = "tr" + parseInt(i);							
								var thisRow = document.getElementById(thisId);											
								thisRow.children[0].innerHTML = oJson.results[i - 10].committee_id;
								thisRow.children[1].innerHTML = oJson.results[i - 10].name;
								thisRow.children[2].innerHTML = oJson.results[i - 10].chamber;
								if ((i + 1) < oJson.count) {
									var nextId = "tr" + parseInt(i + 1);
									var nextRow = thisRow.cloneNode(true);
									nextRow.setAttribute("id", nextId);								
									document.getElementById("tbody2").appendChild(nextRow);
								}
							}
							if (i == 30) {
								document.getElementById("tbody2").lastElementChild.remove();
							}							
						} else if (this.contentWindow.dataBase == "bills") {
							document.getElementById("resultTable3").style = "display:inline-block";	
							for (var i = 20; i < (oJson.count + 20) && (i < 40); i++) {							
								var thisId = "tr" + parseInt(i);							
								var thisRow = document.getElementById(thisId);											
								thisRow.children[0].innerHTML = oJson.results[i - 20].bill_id;
								if (oJson.results[i - 20].short_title != null) {
									thisRow.children[1].innerHTML = oJson.results[i - 20].short_title;
								} else {
									thisRow.children[1].innerHTML = "N.A.";
								}	
								thisRow.children[2].innerHTML = oJson.results[i - 20].chamber;	
								var flag = 1020;
								var anchorJs = "<a href='javascript:showDetails(" + parseInt(i - 20) + ", " + parseInt(flag) + ")'>View Details</a>";
								thisRow.children[3].innerHTML = anchorJs;	
								if ((i + 1) < oJson.count) {
									var nextId = "tr" + parseInt(i + 1);
									var nextRow = thisRow.cloneNode(true);
									nextRow.setAttribute("id", nextId);								
									document.getElementById("tbody3").appendChild(nextRow);
								}
							}
							if (i == 40) {
								document.getElementById("tbody3").lastElementChild.remove();
							}							
						} else if (this.contentWindow.dataBase == "amendments") {
							document.getElementById("resultTable4").style = "display:inline-block";	
							for (var i = 30; i < (oJson.count + 30) && (i < 50); i++) {							
								var thisId = "tr" + parseInt(i);							
								var thisRow = document.getElementById(thisId);											
								thisRow.children[0].innerHTML = oJson.results[i - 30].amendment_id;
								thisRow.children[1].innerHTML = oJson.results[i - 30].amendment_type;
								thisRow.children[2].innerHTML = oJson.results[i - 30].chamber;
								thisRow.children[3].innerHTML = oJson.results[i - 30].introduced_on;
								if ((i + 1) < oJson.count) {
									var nextId = "tr" + parseInt(i + 1);
									var nextRow = thisRow.cloneNode(true);
									nextRow.setAttribute("id", nextId);								
									document.getElementById("tbody4").appendChild(nextRow);
								}
							}
							if (i == 50) {
								document.getElementById("tbody4").lastElementChild.remove();
							}								
						}			
					}	
				}		
			}	
			function showDetails(index, flag) {
				if (flag == 1000) { 
					document.getElementById("div2").style = "display:none";
					document.getElementById("div3").style = "display:block";
					var bioImg = "http://theunitedstates.io/images/congress/225x275/" + oJson.results[index].bioguide_id + ".jpg";
					document.getElementById("photo").innerHTML = "<img src='" + bioImg + "' />";
					document.getElementById("fullname").innerHTML = oJson.results[index].title + " " + oJson.results[index].first_name + " " + oJson.results[index].last_name;
					document.getElementById("term").innerHTML = oJson.results[index].term_end;
					if (oJson.results[index].website && oJson.results[index].website != null) {
						document.getElementById("website").innerHTML = "<a target='_blank' href='" + oJson.results[index].website + "'>" + oJson.results[index].website + "</a>";
					} else {
						document.getElementById("website").innerHTML = "N.A.";
					}	
					if (oJson.results[index].office && oJson.results[index].office != null) {
						document.getElementById("office").innerHTML = oJson.results[index].office;
					} else {
						document.getElementById("office").innerHTML = "N.A.";
					}	
					if (oJson.results[index].facebook_id && oJson.results[index].facebook_id != null) {			
						document.getElementById("facebook").innerHTML = "<a target='_blank' href='http://facebook.com/" + oJson.results[index].facebook_id + "'>" + oJson.results[index].first_name + " " + oJson.results[index].last_name + "</a>";
					} else {
						document.getElementById("facebook").innerHTML = "N.A.";
					}
					if (oJson.results[index].twitter_id && oJson.results[index].twitter_id != null) {					
						document.getElementById("twitter").innerHTML = "<a target='_blank' href='http://twitter.com/" + oJson.results[index].twitter_id + "'>" + oJson.results[index].first_name + " " + oJson.results[index].last_name + "</a>";
					} else {
						document.getElementById("twitter").innerHTML = "N.A.";
					}					
				} else if (flag = 1020) {
					document.getElementById("div2").style = "display:none";
					document.getElementById("div4").style = "display:block";
					document.getElementById("billId").innerHTML = oJson.results[index].bill_id;
					if (oJson.results[index].short_title && oJson.results[index].short_title != null) {
						document.getElementById("billTitle").innerHTML = oJson.results[index].short_title;
					} else {
						document.getElementById("billTitle").innerHTML = "N.A.";
					}
					if (oJson.results[index].sponsor && oJson.results[index].sponsor != null) {
						document.getElementById("sponsor").innerHTML = oJson.results[index].sponsor.title + " " + oJson.results[index].sponsor.first_name + " " + oJson.results[index].sponsor.last_name;
					} else {
						document.getElementById("sponsor").innerHTML = "N.A.";
					}
					if (oJson.results[index].introduced_on && oJson.results[index].introduced_on != null) {	
						document.getElementById("introducedOn").innerHTML = oJson.results[index].introduced_on;
					} else {
						document.getElementById("introducedOn").innerHTML = "N.A.";
					}
					if ((oJson.results[index].last_version.version_name || oJson.results[index].last_action_at) && (oJson.results[index].last_version.version_name != null || oJson.results[index].last_action_at != null)) {
						document.getElementById("lastAction").innerHTML = oJson.results[index].last_version.version_name + " " + oJson.results[index].last_action_at;
					} else {
						document.getElementById("lastAction").innerHTML = "N.A.";
					}	
					if (oJson.results[index].last_version.urls.pdf && oJson.results[index].last_version.urls.pdf != null) {
						if (oJson.results[index].short_title && oJson.results[index].short_title != null) {
							document.getElementById("billUrl").innerHTML = "<a target='_blank' href='" + oJson.results[index].last_version.urls.pdf + "'>" + oJson.results[index].short_title + "</a>";
						} else {
							document.getElementById("billUrl").innerHTML = "<a target='_blank' href='" + oJson.results[index].last_version.urls.pdf + "'>" + oJson.results[index].bill_id + "</a>";
						}
					} else {
						document.getElementById("billUrl").innerHTML = "N.A.";
					}	
				}	
			}	
		</script>
	</head>
	
	<!--<body>-->
		<?php
			$dataBase = $chamber = $originKeyWord = $rawKeyWord = $keyWord = $keyWordForName = "";		
			$errArray = array("Congress database", "keyword");
			if (isset($_POST['search'])) {				
				main();
			}
			function main() {
				global $errArray, $dataBase;
				if (hasBlank($errArray)) {					
					return;
				}
				$jsonData = retrieveData();
				if ($jsonData != null) {	
					dataToJs($jsonData, $dataBase);
				}	
			}	
			function hasBlank($errArray) {	
				$errMessage = "Please enter the following missing information: ";
				$errFlag = false;
				$_POST["keyWord"] = trim($_POST["keyWord"]);
				if (empty($_POST["dataBase"])) {
					$errMessage = $errMessage.$errArray[0];
					$errFlag = true;
				}
				if (empty($_POST["keyWord"])) {
					if ($errFlag) {
						$errMessage = $errMessage.", ".$errArray[1];
					} else {
						$errMessage = $errMessage.$errArray[1];
					}					
					$errFlag = true;
				}	
				if ($errFlag) {
					// echo "alert('$errMessage')";
					echo "<script type='text/javascript'>alert('$errMessage');</script>";					
				}
				return $errFlag;
			}		
			function retrieveData() {
				global $dataBase, $chamber, $rawKeyWord, $keyWord, $keyWordForName;
				$dataBase = $_POST["dataBase"];
				$chamber = $_POST["chamber"];
				$originKeyWord = $_POST["keyWord"];
				$rawKeyWord = strtolower($_POST["keyWord"]);
				$keyWord = $rawKeyWord;
				if (strpos($keyWord, " ")) {
					if ($dataBase != "legislators") {
						echo "<script type='text/javascript'>alert('ID should have no space!');</script>";
						return null;
					}
				}
				if (strpos($rawKeyWord, " ")) {
					$keyWordForName = $rawKeyWord;
					$spaceIndex = strpos($keyWordForName, " ");					
					$replaceChar1 = strtoupper(substr($keyWordForName, 0, 1));
					$replaceChar2 = strtoupper(substr($keyWordForName, ($spaceIndex + 1), 1));
					$keyWordForName = substr_replace($keyWordForName, $replaceChar1, 0, 1); 
					$keyWordForName = substr_replace($keyWordForName, $replaceChar2, ($spaceIndex + 1), 1);
					$keyWordForName = "first_name=".$keyWordForName;
					$keyWordForName = str_replace(" ", "&last_name=", $keyWordForName);
				}
				$apiKey = "eb6dfc9cff4c446080d50c4513d41c2f";				
				// echo "<script type='text/javascript'>var dataBase = '$dataBase';</script>";				
				if ($dataBase == "legislators") {
					// echo $keyWord."<br/>";
					// echo toStateAbbreviation($keyWord)."<br/>";
					$stateAbbreviation = toStateAbbreviation($rawKeyWord);	
					if ($stateAbbreviation != "N.A") {
						$dataUrl = "http://congress.api.sunlightfoundation.com/".$dataBase."?".
						"state=".$stateAbbreviation."&"."chamber=".$chamber."&"."apikey=".$apiKey;
					} else {
						if (strpos($rawKeyWord, " ")) {
							$dataUrl = "http://congress.api.sunlightfoundation.com/".$dataBase."?".
							$keyWordForName."&"."chamber=".$chamber."&"."apikey=".$apiKey;							
							$jsonTest = json_decode(file_get_contents($dataUrl));							
							if ($jsonTest->{'count'} == 0) {
								$keyWordForName = $originKeyWord;
								$keyWordForName = str_replace(" ", "&query=", $keyWordForName);
								$dataUrl = "http://congress.api.sunlightfoundation.com/".$dataBase."?".
								"query=".$keyWordForName."&"."chamber=".$chamber."&"."apikey=".$apiKey;								
							}
						} else {
							$dataUrl = "http://congress.api.sunlightfoundation.com/".$dataBase."?".
							"query=".$keyWord."&"."chamber=".$chamber."&"."apikey=".$apiKey;
						}	
					}					
				} else if ($dataBase == "committees") {
					$dataUrl = "http://congress.api.sunlightfoundation.com/".$dataBase."?".
					"committee_id=".strtoupper($keyWord)."&"."chamber=".$chamber."&"."apikey=".$apiKey;
				} else if ($dataBase == "bills") {
					$dataUrl = "http://congress.api.sunlightfoundation.com/".$dataBase."?".
					"bill_id=".$keyWord."&"."chamber=".$chamber."&"."apikey=".$apiKey;
				} else if ($dataBase == "amendments") {
					$dataUrl = "http://congress.api.sunlightfoundation.com/".$dataBase."?".
					"amendment_id=".$keyWord."&"."chamber=".$chamber."&"."apikey=".$apiKey;
				}		
				echo "<script type='text/javascript'>console.log('$dataUrl');</script>";					
				$jsonData = file_get_contents($dataUrl);
				// echo $jsonData;
				return $jsonData;
			}
			function dataToJs($jsonData, $dataBase) {
				echo "<script type='text/javascript'>var dataBase = '$dataBase';</script>";	
				echo "<script type='text/javascript'>var oJson = $jsonData;</script>";
			}		
			function toStateAbbreviation($stateFullName) {
				switch ($stateFullName) {
					case "alabama":return "AL";
					case "alaska":return "AK";
					case "arizona":return "AZ";
					case "arkansas":return "AR";
					case "california":return "CA";
					case "colorado":return "CO";
					case "connecticut":return "CT";
					case "delaware":return "DE";
					case "district of columbia":return "DC";
					case "montana":return "MT";
					case "nebraska":return "NE";
					case "nevada":return "NV";
					case "new hampshire":return "NH";
					case "new jersey":return "NJ";
					case "new mexico":return "NM";
					case "new york":return "NY";
					case "north carolina":return "NC";
					case "north dakota":return "ND";
					case "florida":return "FL";
					case "georgia":return "GA";
					case "hawaii":return "HI";
					case "idaho":return "ID";
					case "illinois":return "IL";
					case "indiana":return "IN";
					case "iowa":return "IA";
					case "kansas":return "KS";
					case "kentucky":return "KY";
					case "louisiana":return "LA";
					case "maine":return "ME";
					case "maryland":return "MD";
					case "massachusetts":return "MA";
					case "michigan":return "MI";	
					case "minnesota":return "MN";
					case "mississippi":return "MS";	
					case "missouri":return "MO";
					case "ohio":return "OH";
					case "oklahoma":return "OK";
					case "oregon":return "OR";
					case "pennsylvania":return "PA";
					case "rhode island":return "RI";
					case "south carolina":return "SC";
					case "south dakota":return "SD";
					case "tennessee":return "TN";
					case "texas":return "TX";	
					case "utah":return "UT";
					case "vermont":return "VT";
					case "virginia":return "VA";
					case "washington":return "WA";
					case "west virginia":return "WV";
					case "wisconsin":return "WI";
					case "wyoming":	return "WY";						
					default:return "N.A";
				}
			}	
		?>
		<h2 class="textCenter">Congress Information Search</h2>
		<div id="div1" class="center">			
			<form id="form1" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="noRefresh">
				<!--------------------------------------------------------->
				<div id="info1" class="textCenter">
					<span>Congress Database</span>&nbsp;
					<select id="select1" name="dataBase">  
						<option value="default" selected = "selected" disabled="disabled">Select your option</option> 
						<option value="legislators">Legislators</option>  
						<option value="committees">Committees</option>  
						<option value="bills">Bills</option>  
						<option value="amendments">Amendments</option>  
					</select>
				</div>
				<!--------------------------------------------------------->
				<div id="info2" class="textCenter">
					<span>Chamber</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="chamber" value="senate" checked />Senate
					<input type="radio" name="chamber" value="house" />House
				</div>
				<!--------------------------------------------------------->
				<div id="info3" class="textCenter">
					<span id="textKeyWord">Keyword*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<input type="text" id="txt1" name="keyWord" value="" />
				</div>
				<!--------------------------------------------------------->	
				<div id="info4">	
					<input type="reset" id="btn2" name="clear" value="Clear" />
					<input type="submit" id="btn1" name="search" value="Search" />					
				</div>
				<!--------------------------------------------------------->
				<div id="info5" class="textCenter">
					<a href="http://sunlightfoundation.com/" target="_blank">Powered by Sunlight Foundation</a>				
				</div>
				<!--------------------------------------------------------->
			</form>	
		</div>
		<iframe class="hide" id="noRefresh" name="noRefresh"></iframe>
		<div id="div2" class="hide">
			<span class="hide textCenter">The API returned zero results for the request</span>
			<table id="resultTable1" class="hide" align="center" border="2" cellspacing="1" cellpadding="1">	
					<thead>
						<tr>
							<th>Name</th><th>State</th><th>Chamber</th><th>Details</th>
						</tr>
					</thead>	
					<tbody id="tbody1" name="clearFlag">
						<tr id="tr0">
							<td style="text-align:left"></td><td></td><td></td><td></td>						
						</tr>
					</tbody>	
				</table>
				<table id="resultTable2" class="hide" align="center" border="2" cellspacing="1" cellpadding="1">
					<thead>
						<tr>
							<th>Committee ID</th><th>Committee Name</th><th>Chamber</th>
						</tr>
					</thead>	
					<tbody id="tbody2" name="clearFlag">
						<tr id="tr10">
							<td></td><td></td><td></td>						
						</tr>
					</tbody>
				</table>	
				<table id="resultTable3" class="hide" align="center" border="2" cellspacing="1" cellpadding="1">
					<thead>
						<tr>
							<th>Bill ID</th><th>Short Title</th><th>Chamber</th><th>Details</th>
						</tr>
					</thead>	
					<tbody id="tbody3" name="clearFlag">
						<tr id="tr20">
							<td></td><td></td><td></td><td></td>						
						</tr>
					</tbody>
				</table>
				<table id="resultTable4" class="hide" align="center" border="2" cellspacing="1" cellpadding="1">
					<thead>
						<tr>
							<th>Amendment ID</th><th>Amendment Type</th><th>Chamber</th><th>Introduced on</th>
						</tr>
					</thead>	
					<tbody id="tbody4" name="clearFlag">
						<tr id="tr30">
							<td></td><td></td><td></td><td></td>						
						</tr>
					</tbody>
				</table>
		</div>	
		<div id="div3" class="hide">
			<div id="photo"></div>
			<table align="center">
				<tr><td style="padding-left:50px">Full Name</td><td id="fullname" style="padding-left:130px"></td></tr>			
				<tr><td style="padding-left:50px">Term Ends on</td><td id="term" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Website</td><td id="website" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Office</td><td id="office" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Facebook</td><td id="facebook" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Twitter</td><td id="twitter" style="padding-left:130px"></td></tr>
			</table>
		</div>	
		<div id="div4" class="hide">
			<table align="center">
				<tr><td style="padding-left:50px">Bill ID</td><td id="billId" style="padding-left:130px"></td></tr>			
				<tr><td style="padding-left:50px">Bill Title</td><td id="billTitle" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Sponsor</td><td id="sponsor" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Introduced On</td><td id="introducedOn" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Last action with date</td><td id="lastAction" style="padding-left:130px"></td></tr>
				<tr><td style="padding-left:50px">Bill URL</td><td id="billUrl" style="padding-left:130px"></td></tr>
			<table>
		</div>			
	</body>
</html>

