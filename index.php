<html>
<title>
	Setup page for getmail script
</title>
<body>
<h3>Main settings for script</h3>
<form action=setup.php method=POST>
<?php
include 'env.conf';
//echo $MAIL_SERVER;
echo ('<input type=text name=MAIL_SERVER'); 
if (isset($MAIL_SERVER)) echo (' value='.$MAIL_SERVER); 
echo('> Mailserver <BR>');
echo ('<input type=text name=USERNAME');
if (isset($USERNAME)) echo (' value='.$USERNAME);
echo ('> Username <BR>');
echo ('<input type=password name=PASS');
if (isset($PASS)) echo(' value='.$PASS);
echo ('> Password <BR>');
echo ('<input type=text name=DIR_PATH');
if (isset($DIR_PATH)) echo(' value='.$DIR_PATH);
echo ('> Directory <BR>');
//echo (<h3>Filter settings</h3>);
echo ('<input type=text name=MAIL_SUBJ');
if (isset($MAIL_SUBJ)) echo (' value='.$MAIL_SUBJ);
echo ('> Subject of Letter <BR>');
echo ('<input type=text name=MAIL_ATTACH');
if (isset($MAIL_ATTACH)) echo (' value='.$MAIL_ATTACH);
echo ('> Attachment filter <BR>');
echo ('<input type=submit value="Save settings">');
?>
</form>
</body>
</html>
