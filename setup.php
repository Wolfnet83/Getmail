<?php
$jobs = load_jobs();

if ($_POST['action']=='add')
{
	foreach ($jobs as $id=>$value){
	}
	$new_id=$id+1;
	$jobs[$new_id]['mailserver']=$_POST['mailserver'];
	$jobs[$new_id]['username']=$_POST['username'];
	$jobs[$new_id]['pass']=$_POST['pass'];
	$jobs[$new_id]['mail_from']=$_POST['mail_from'];
	$jobs[$new_id]['mail_subject']=$_POST['mail_subject'];
	$jobs[$new_id]['mail_filename']=$_POST['mail_filename'];
	$jobs[$new_id]['directory']=$_POST['directory'];
	$jobs[$new_id]['is_replace']=$_POST['is_replace'];
	$jobs[$new_id]['filename_ptr']=$_POST['filename_ptr'];
	$jobs[$new_id]['cron']=$_POST['cron'];
	save_jobs($jobs);
}

if ($_POST['action']=='delete'){
	$id=(int) $_POST['id'];
	unset($jobs[$id]);
	save_jobs($jobs);
}
function save_jobs($arr){
	$file = fopen('config.php','w');
	fwrite($file,serialize($arr));
	fclose ($file);
}
function load_jobs(){
	$file=fopen('config.php',"r");
	$string = fread($file,filesize("config.php"));
	fclose($file);
	return(unserialize($string));
}
echo("<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">");
?>
