<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"> 

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> 
		Visitor Vehicle Registration 
	</title>


	<style>
		.error {color: #FF0000;}
	</style>

	<!-- Include CSS for different screen sizes -->
	<link rel="stylesheet" type="text/css" href="defaultstyle.css">
</head>

<body>

<?php
	
	require 'connectToDatabase.php';

	// Connect to Azure SQL Database
	$conn = ConnectToDabase();

	// Get data for expense categories
	$tsql="SELECT CATEGORY FROM Expense_Categories ORDER BY CATEGORY ASC";
	$expenseCategories= sqlsrv_query($conn, $tsql);

	// Populate dropdown menu options 
	$options = '';
	while($row = sqlsrv_fetch_array($expenseCategories)) {
		$options .="<option>" . $row['CATEGORY'] . "</option>";
	}

	// Close SQL database connection
	sqlsrv_close ($conn);

	// Get the session data from the previously selected Expense Month, if it exists
	session_start();
	if ( !empty( $_SESSION['prevSelections'] ))
	{ 
		$prevSelections = $_SESSION['prevSelections'];
		unset ( $_SESSION['prevSelections'] );
	}

	// Extract previously-selected Month and Year
	$prevExpenseMonth= $prevSelections['prevExpenseMonth'];
	$prevExpenseYear= $prevSelections['prevExpenseYear'];
?>

<div class="intro">

	<h2> Input Expense Form </h2>

	<!-- Display redundant error message on top of webpage if there is an error -->
	<h3> <span class="error"> <?php echo $prevSelections['errorMessage'] ?> </span> </h3>

</div>

<!-- Define web form. 
The array $_POST is populated after the HTTP POST method.
The PHP script insertToDb.php will be executed after the user clicks "Submit"-->
<div class="container">
	<form action="insertToDb.php" method="post">
	
		<label>Name of Employee:</label>
		<input type="text" step="1" name="employee_name" required>

		<label>Vehicle Make:</label>
		<input type="text" step="1" name="make" required>
		
		<label>Vehicle Model:</label>
		<input type="text" step="1" name="model" required>
		
		<label>License Plate:</label>
		<input type="text" step="1" name="license_plate" required>

	<?php
	  $myCalendar = new tc_calendar("date1", true);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setDate(01, 03, 1960);
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(1960, 2015);
	  $myCalendar->dateAllow('1960-01-01', '2015-03-01');
	  $myCalendar->setSpecificDate(array("2011-04-01", "2011-04-13", "2011-04-25"), 0, 'month');
	  $myCalendar->setOnChange("myChanged('test')");
	  $myCalendar->writeScript();
	  ?>

<script language="javascript">
<!--
function myChanged(v){
	alert("Hello, value has been changed : "+document.getElementById("date1").value+"["+v+"]");
}
//-->
</script>


		<label>Notes (optional) [no accents or tildes]:</label>
		<input type="text" name="input_note" ><br>

		<button type="submit">Submit</button>
	</form>
</div>

<h3> Previous Input (if any) - for verification purposes:</h3>
<p> Name of Employee: <?php echo $prevSelections['prevExpenseDay'] ?> </p>
<p> Date 1: </p>
<p> Expense Note: <?php echo $prevSelections['prevExpenseNote'] ?> </p>
<p> <span class="error"> <?php echo $prevSelections['errorMessage'] ?> </span> </p>

</body>
</html>
