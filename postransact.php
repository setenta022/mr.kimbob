<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Transactions Page | Mr. Kimbob</title>
<link rel="stylesheet" type="text/css" href="transactions.css"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Ubuntu:wght@300&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="transacstyle.css">
<link rel="stylesheet" type="text/css" rel="stylesheet" href="search.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Arial;
}
* {
  box-sizing: border-box;
}
form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #f1f1f1;
}
form.example button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}
form.example button:hover {
  background: #0b7dda;
}
form.example::after {
  content: "";
  clear: both;
  display: table;
}
</style>
</head>
<body>
<?php 
session_start(); 
if(!isset($_SESSION['status']))
{
	header("Location: index.php");
	exit();
}
?>
<div class="sidebar">
	<div class="logo-details">
		<img src="dpkimbob.jpg" alt="logo" style = "margin-top:50px;"/>
    </div><br><br><br><br><br><br>
    <div><br>
		<h1>Welcome,</h1><br>
		<?php
		echo"<h1 style ='font-size:30px; color: white; '><b>".$_SESSION['username']."</b></h1>";     
		?>	  
    </div><br>
    <ul class="nav-links">
        <li>
			<a href="pos.php">
				<i class='bx bxs-dashboard'></i>
				<span class="links_name">Point-of-Sales</span>
			</a>
        </li>
		 <li>
          <a href="#" class="active">
            <i class='bx bxs-low-vision'></i>
            <span class="links_name">View Transaction</span></a>
        </li>
        <li class="log_out">
			<a href="logout.php">
				<i class='bx bx-log-out-circle' ></i>
				<span class="links_name">Log out</span>
			</a>
        </li>
    </ul>
</div>

<div class="home-section"><br>

	<?php
	include 'db_connection.php';
	$dt = date('m/d/Y');
	$sql = "SELECT SUM(qty) AS qty FROM tbl_sales WHERE dt_sold = '".$dt."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
			echo "
			<div class='alert alert-info alert-dismissible fade show' role='alert'>
			We have a total of <strong><i>".number_format($row["qty"])." items sold</i></strong> today! You should check in on some of those below.
			</div>";
			}
	}
	?>  
	<?php
	include 'db_connection.php';
	$dt = date('m/d/Y');
	$sql = "SELECT SUM(total) AS total FROM tbl_sales WHERE dt_sold = '".$dt."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) 
	{
		while ($row = mysqli_fetch_assoc($result))
		{
			echo "
			<div class='alert alert-info alert-dismissible fade show' role='alert'>
			The total amount of sales today is: <strong><i>₱".number_format($row["total"]).".00! </i></strong> Keep it going.
			</div>";
		}
	}
	?> 
	<div class="container-fluid">
		<div class="row">
			<!-- Form code begins -->
				<form  class="example" method="post" action="transactions.php" style="  display: inline-block;
       margin-left:10px;max-width:300px">
					<div class="form-group"> <!-- Date input -->
					<label class="control-label" for="date">Search Date:</label>
					<input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text" required READONLY/>
						<div class="form-group"> <!-- Submit button -->
							<button class="btn btn-primary " name="search" type="submit"><i class="fa fa-search"></i></button>
						</div>
						
				</form>
			</div>
			<form  class="example" method="post" action="transactions.php">
			<!-- Form code ends -->
			<br><button class="btn btn-primary " style ="margin-left: 710px; width: 255px;" name ="history" type="submit">View History</button><br>
		<a href="transactions.php" style ="display: inline;text-align: right"><button class="btn btn-primary " name="refresh" style="margin-left: 1000px; margin-top: -48px;">Refresh Table</button></a>
		</form>
    </div>    
</div>
<?php 
			include 'db_connection.php';
			if(isset($_POST['search']))
			{
				$search = $_POST['search'];
				$date = $_POST['date'];
				if($date=="MM/DD/YYYY")
				{
				}
				else if($date=="")
				{
				}
				else
				{
					$sql = "SELECT * from tbl_sales where dt_sold LIKE '%$date%' ORDER BY t_sold DESC";
					$result = mysqli_query($conn, $sql) or die("Could not search!");
					$count = mysqli_num_rows($result);
					echo "<h2>Search results:</h2>";
					echo "<h3>$count results found searching for the sales of '$date'</h3>";
				}
			}
			else if(isset($_POST['history']))
			{
					$sql = "SELECT * from tbl_sales ORDER BY t_sold ASC";
					$result = mysqli_query($conn, $sql);
					$count = mysqli_num_rows($result);
					echo "<br><h3>The sales history displays <b>$count records</b>!</h3>";
			}
			else
			{
			}
			?>
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script><br>
<div style ="overflow:hidden;overflow-y: scroll;height: 300px; width: auto; padding-bottom: auto; border-style: solid;border-width: 2.5px;border-color: black;">
    <table class="table" cellspacing="0" width="100%" bgcolor = "white">
        <thead class="thead-dark">
            <tr>
                <th scope ="col" style="top: 0;z-index: 2;position: sticky;background-color: black; color:white;">ID</th>
                <th scope ="col" style="top: 0;z-index: 2;position: sticky;background-color: black; color:white;">Desc</th>
				<th scope ="col" style="top: 0;z-index: 2;position: sticky;background-color: black; color:white;">Price</th>
                <th scope ="col" style="top: 0;z-index: 2;position: sticky;background-color: black; color:white;">Qty</th>
                <th scope ="col" style="top: 0;z-index: 2;position: sticky;background-color: black; color:white;">Total</th>
                <th scope ="col" style="top: 0;z-index: 2;position: sticky;background-color: black; color:white;">Date</th>
				<th scope ="col" style="top: 0;z-index: 2;position: sticky;background-color: black; color:white;">Time</th>
            </tr>
        </thead>
        <tbody>
			<?php 
			include 'db_connection.php';
			if(isset($_POST['search']))
			{
				$date = $_POST['date'];
				if($date=="MM/DD/YYYY")
				{
				}
				else if($date=="")
				{
				}
				else
				{
					$sql = "SELECT * from tbl_sales where dt_sold LIKE '%$date%' ORDER BY t_sold DESC";
					$result = mysqli_query($conn, $sql) or die("Could not search!");
					if (mysqli_num_rows($result) > 0) 
					{
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>" . $row['sales_id'] . "</td>";
							echo "<td>" . $row['description'] . "</td>";
							echo "<td>₱" . number_format($row['price']) . ".00</td>";
							echo "<td>" . number_format($row['qty']) . "</td>";
							echo "<td>₱" . number_format($row['total']) . ".00</td>";
							echo "<td>" . $row['dt_sold'] . "</td>";
							echo "<td>" . $row['t_sold'] . "</td>";
							echo "</tr>";
						}
				    }
					else
				    {
						echo "<tr><td colspan='7'>No data found!</td></tr>";
				    }
				}
			}
			else if(isset($_POST['history']))
			{
				$sql = "SELECT * from tbl_sales ORDER BY dt_sold,t_sold ASC";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) 
				{
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo "<tr>";
						echo "<td>" . $row['sales_id'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";
						echo "<td>₱" . number_format($row['price']) . ".00</td>";
						echo "<td>" . number_format($row['qty']) . "</td>";
						echo "<td>₱" . number_format($row['total']) . ".00</td>";
						echo "<td>" . $row['dt_sold'] . "</td>";
						echo "<td>" . $row['t_sold'] . "</td>";
						echo "</tr>";
					}
				}
				else 
				{
					echo "<tr><td colspan='7'>No sales yet!</td></tr>";
				}
			}
			else
			{
			$dt = date('m/d/Y');
              $sql = "SELECT * from tbl_sales where dt_sold = '".$dt."' ORDER BY dt_sold,t_sold ASC";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) 
			  {
                while ($row = mysqli_fetch_assoc($result)) 
				{
                    echo "<tr>";
                    echo "<td>" . $row['sales_id'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>₱" . number_format($row['price']) . ".00</td>";
                    echo "<td>" . number_format($row['qty']) . "</td>";
                    echo "<td>₱" . number_format($row['total']) . ".00</td>";
					echo "<td>" . $row['dt_sold'] . "</td>";
					echo "<td>" . $row['t_sold'] . "</td>";
                    echo "</tr>";
                }
              }
			  else 
			  {
                  echo "<tr><td colspan='7'>No sales yet!</td></tr>";
              }
			}
			?>
        </tbody>
    </table>
</div><br><hr>
</body>
</html>
<script type="text/javascript">
function do_search()
{
	var search_box =$("#search_box").val();
	$.ajax(
	{
		type:'post',
		url:'transactions.php',
		data:{search:"search",search_box:search_box},
		success:function(response) 
		{
			document.getElementById("result_div").innerHTML=response;
		}
	});
return false;
}
</script>
<script type="text/javascript">
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() 
{
	sidebar.classList.toggle("active");
	if(sidebar.classList.contains("active"))
	{
		sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
	}
	else
	{
		sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
	}
}
</script>