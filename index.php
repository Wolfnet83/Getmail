<html>
<title>
   GetMail Settings
</title>
<body>
<h3>Jobs currently added</h3>
<table border=3 width=100%>
	<tr align=center>
		<td width=5%>Job ID</td>
		<td width=20%>Mailserver</td>
		<td width=10%>Username</td>
		<td width=10%>Password</td>
		<td width=20%>Source Address</td>
		<td width=10%>Filename</td>
		<td width=10%>Subject</td>
		<td width=10%>Directory</td>
		<td width=5%>Is_replace_files</td>
		<td width=10%>Filename Pattern</td>
		<td width=5%>Period(min)</td>
	</tr>
<?php
	$jobs=load_jobs();
	$i=0;
	foreach ($jobs as $id=>$job) {
		echo "<tr>";
		echo "<td>",$id,"</td>";
		echo "<td>",$job['mailserver'],"</td>";
		echo "<td>",$job['username'],"</td>";
		echo "<td>",$job['pass'],"</td>";
		echo "<td>",$job['mail_from'],"</td>";
		echo "<td>",$job['mail_filename'],"</td>";
		echo "<td>",$job['mail_subject'],"</td>";
		echo "<td>",$job['directory'],"</td>";
		echo "<td>",$job['is_replace'],"</td>";
		echo "<td>",$job['filename_ptr'],"</td>";
		echo "<td>",$job['cron'],"</td>";
		echo "</tr>";
		$i++;
	}

function load_jobs(){
	$file=fopen('config.php',"r");
	$string = fread($file,filesize("config.php"));
	fclose($file);
	return(unserialize($string));
}
?>
</table>
<br>
<form action=setup.php method=POST>
<input type=text name=mailserver> Mailserver stroke<BR>
<input type=text name=username> Username <BR>
<input type=password name=pass> Password <BR>
<input type=text name=mail_from> Source Address <BR>
<input type=text name=mail_filename> Attachment filter <BR>
<input type=text name=mail_subject> Subject of Letter <BR>
<input type=text name=directory> Saving Directory <BR>
<input type=checkbox name=is_replace>Replace files <BR>
<input type=text name=filename_ptr> Pattern for saving filename <BR>
<input type=text name=cron> Period of checking <BR>
<input type=hidden name='action' value='add'>
<input type=submit  value="Add Job">
</form>
<form action=setup.php method=POST>
Please enter Job ID, you want to delete<BR>
<input type text name=id>
<input type=hidden name='action' value='delete'>
<input type=submit  value="Delete Job">
</form>
</body>
</html>
