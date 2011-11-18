<?php
//Must be on top of everything to function correctly
include 'includes/headerbarFunctions.php';
//Include this inside the <head> tag to require user to be logged in to view the page.
include 'includes/membersOnly.php';

function printAllNotepads($userid)
{
	$userid = mysql_real_escape_string($userid);
	$padRow = mysql_query("SELECT id FROM notebooks WHERE userid='$userid'");
	$notepadHTML = "";
	
	while ($row = mysql_fetch_assoc($padRow))
	{
		$notepadHTML = $notepadHTML.getNotepadRow($userid, $row['id']);
	}
	mysql_free_result($padRow);
	
	return $notepadHTML;
}

function getNotepadRow($userid, $id)
{
	$padRow = mysql_query("SELECT name,description,created,modified FROM notebooks WHERE userid='$userid' AND id='$id'");
	$row = mysql_fetch_assoc($padRow);
	
	$rowHTML = '';
	
	if($row){
		$rowHTML = '
			<tr>
				<td>
					
				</td>
				<td align="left">
					<a href="canvas.php?id='.$id.'">'.$row['name'].'</a>
				</td>
				<td align="center">
					'.$row['modified'].'
				</td>
				<td align="center">
					'.$row['created'].'
				</td>
				<td align="center">
					<a href="#"><img src="img/buttons/pencl_edit.png" title="Edit" alt="Edit"></a>
					<a href="#"><img src="img/buttons/pencl_share.png" title="Share" alt="Share"></a>
					<a href="#"><img src="img/buttons/pencl_export.png" title="Export" alt="Export"></a>
					<a href="#"><img src="img/buttons/pencl_delete.png" title="Delete" alt="Delete"></a>
					
				</td>
			</tr>
					';
	}
	mysql_free_result($padRow);
	return $rowHTML;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Notepad Selection - Pencl</title>

<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen">
<?php
//Put this at the end of the <head> tag to track
include 'includes/topbar_header.php';
include 'includes/tracker.php';
?>
</head>

<body>
<?php
//Must be first thing in the <body> tag to function correctly
include 'includes/topbar.php';
?>


<div id="pagewide">
	<h1>Which notepad would you like to open?</h1>
	<div class="notebook">
		<table>
			<thead>
				<tr class="head">
					<td>
						<!-- Preview -->
					</td>
					<td>
						<strong>Notepad</strong>
					</td>
					<td>
						<strong>Modified</strong>
					</td>
					<td>
						<strong>Created</strong>
					</td>
					<td>
						<strong>Options</strong>
					</td>
				</tr>
			</thead>
			<tbody>
				<?php
					//Grab our notepads
					echo printAllNotepads($_SESSION['id']);
				?>
			</tbody>
		</table>
	</div>
	<br>
	<p>Tip: Choose other options in the drop down menu at the top-right!</p>
</div>
</body>
</html>
