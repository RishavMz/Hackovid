<?php
session_start();

if(!isset($_SESSION['username']))
{
    header("location:login.php");
}
if(isset($_GET['EVENT_ID']))
{      
    $_SESSION['temp'] = $_GET['EVENT_ID'];
}
if(!isset($_SESSION['temp']))
{
    header("location:login.php");
}
require_once "pdo.php";
if(isset($_POST['SDATE']) && isset($_POST['STIME']) && isset($_POST['EDATE']) && isset($_POST['ETIME']) && isset($_POST['PRIZES']) && isset($_POST['DESCRIPTION']) && isset($_POST['REGISTRATION_FORM']))
{	$begin=$_POST['SDATE']." ".$_POST['STIME'].":00";
	$end=$_POST['EDATE']." ".$_POST['ETIME'].":00";
	$sql = "UPDATE EVENTS SET  BEGIN_DATE_TIME = :V3 , END_DATE_TIME = :V4, PRIZES = :V6 , DESCRIPTION = :V7 , REGISTRATION_form = :V8 WHERE EVENT_ID = :SEID";
    $stmt = $pdo -> prepare($sql);
	$stmt -> execute(array( 
							':V3' => $begin,
							':V4' => $end,
							':V6' => $_POST['PRIZES'],
							':V7' => $_POST['DESCRIPTION'],
							':V8' => $_POST['REGISTRATION_FORM'],
                            ':SEID' => $_SESSION['temp'],));
		unset($_SESSION['temp']);
	    unset($_SESSION['H']);
	    $_SESSION['message'] = "Event successfully editted.";
        echo("<script>window.location.replace('organiser_dashboard.php');</script>")        ;            
                                                }


?>
<html>
	<head>
		<title>Organiser Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body class = "subpage">
	
		
		<header id="header" class="reveal" >
			<div class="logo">
			    <a href = organiser_dashboard.php>Back to Dashboard</a>
			</div>
			<a href = "index.php" >Log out</a>
		</header>
		
		<section id="One" class="wrapper style3">			
			<div class="inner">
				<header class="align-center">
					<p><?php echo($_SESSION['Organiser_Institute'])?></p>
					<h2><?php echo($_SESSION['Organiser_Name'])?></h2>
				</header>
			</div>
		</section>
		<div id="main" class="container">
        <br><br><br>

    <?php
    //Edit code
			$ename = "";
			$sdate = "";
			$stime	= "";		
			$edate = "";
			$etime = "";
			$prizes = "";
			$description = "";
			$regisform = "";		
				$sql = "SELECT * FROM EVENTS  WHERE EVENT_ID = :Data";
				$stmt = $pdo -> prepare($sql);
				$stmt -> execute(array(':Data' => $_GET['EVENT_ID']));
				$row3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach($row3 as $row2)
                {   $evid = $row2['EVENT_ID'];
					$ename = $row2['EVENT_NAME'];
                    $sdate = $row2['BEGIN_DATE_TIME'];
                    $edate = $row2['END_DATE_TIME'];
                    $prizes = $row2['PRIZES'];
					$description = $row2['DESCRIPTION'];
					$regisform = $row2['REGISTRATION_FORM'];
                    $stime = substr($stime,11,16);
                    $etime = substr($etime,11,16);
                    $sdate = substr($sdate,0,10);
                    $edate = substr($edate,0,10);
                    break;     
            }	
            
            ?>
        <div class="content">
				<br>Edit an event:
					<br><br>
					<center>
				<?php echo("<img src='images/".$evid.".jpeg' width = 500em height = auto style='max-width:100%;' alt ='Image Unavailable'/>");?>
		</center>
					
					<br>
				<form method = "post">
					
					<div class = "6u 12u$(small)">
						<label for="Ename">Event Name</label><input type="text" name="ENAME" id="Ename" value =<?php echo($ename);?> required disabled>
					</div><br>
					<div class = "6u 12u$(small)">
						<label for="start_date">Start  Date  &  Time</label><input type="date" name="SDATE" id="date"  required>    <input type="time" name="STIME" id="time" required>
					</div><br>
					<div class = "6u 12u$(small)">  
						<label for="end_date">End  Date  &  Time</label><input type="date" name="EDATE" id="date" required>    <input type="time" name="ETIME" id="time" required>
					</div><br>
					<div class = "6u 12u$(small)">
						<label for="Rform">Registration form link</label><input type="text" name="REGISTRATION_FORM" id="Rform" value =<?php echo($regisform);?> required>
					</div><br>
					<div class="12u$">
						<label for="Prizes">Prizes</label>
						<textarea name="PRIZES" id="message" placeholder="Enter delails about prizes(if applicable)." rows="6" cols="20"><?php echo($prizes);?></textarea>
					</div><br>
					<div class="12u$">
						<label for="description">Description</label>
						<textarea name="DESCRIPTION" id="message" placeholder="Enter a breif description of your competition." rows="6" cols="20"><?php echo($description);?></textarea>
					</div><br>
										<i style="font-size:0.8em;">To change the poster for your event, send CHANGE with a new image along with event name and username on<img src = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png"   style="width :20px; height:auto;"> XXXXXXXXXX .</i>

					<br>
					<input type = "submit" value="EDIT" name="EDIT" class = "button special ">              
					<button type = "button" value="DASHBOARD" name="DASHBOARD" class = "button special " onclick="location.href='organiser_dashboard.php';">DASHBOARD</button>
				</form>
				</form>
		</div></div>
<br><br>
<!-- Footer -->
<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="https://twitter.com/IIITRanchi" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="https://www.facebook.com/IIITRanchiOfficial/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="https://www.instagram.com/its_iiit_ranchi/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
					</ul>
				</div>
				<div class="copyright">
					&copy; IIITRANCHI. All rights reserved.
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>


	</body>
</html>