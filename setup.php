<?php
$conf_file = fopen('env.conf','w');
$file_content="<?php \n";
$file_content.='$MAIL_SERVER=\''.$_POST['MAIL_SERVER']."';\n";
$file_content.='$USERNAME=\''.$_POST['USERNAME']."';\n";
$file_content.='$PASS="'.$_POST['PASS']."\";\n";
$file_content.='$DIR_PATH=\''.$_POST['DIR_PATH']."';\n";
$file_content.='$MAIL_SUBJ="'.$_POST['MAIL_SUBJ']."\";\n";
$file_content.='$MAIL_ATTACH="'.$_POST['MAIL_ATTACH']."\";\n";
$file_content.="?>";
fwrite($conf_file,$file_content);
fclose($conf_file);
echo("<a href=http://77.89.224.12/getmail>Back</a>");
?>
