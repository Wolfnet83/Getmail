<?php
include 'env.conf';
//making directory to save files
opendir($DIR_PATH) or system('mkdir '.$DIR_PATH.';');


$mbox=imap_open('{'.$MAIL_SERVER.'/ssl/imap4/novalidate-cert}INBOX',$USERNAME,$PASS);
//$folders=imap_listmailbox($mbox,'{'.$MAIL_SERVER.'/pop3/novalidate-cert}INBOX','*');

//count the number of letters
$total_count = imap_num_msg($mbox);
echo "\n".'Total_messages:'.$total_count."\n";

//Check all emails 
for ($i = 1; $i <= $total_count; $i++)
{
		$msg_subject= imap_headerinfo($mbox,$i)->Subject;
//		print_r (imap_headerinfo($mbox,$i));
//		$date = imap_headerinfo($mbox,$i)->udate;
		//		if (fnmatch("qwer??",$msg_subject)) echo $MAIL_SUBJ;
		if (fnmatch($MAIL_SUBJ,$msg_subject)) saveAttachment($DIR_PATH,$mbox,$i,imap_headerinfo($mbox,$i)->udate); 

		$struct=imap_fetchstructure($mbox,$i);
		$filenames=getAttachment($struct);
//		print_r ($filenames);
		foreach($filenames as $attach){
			if (fnmatch($MAIL_ATTACH,$attach)) saveAttachment($DIR_PATH,$mbox,$i,imap_headerinfo($mbox,$i)->udate); 
		}
}

$files=scandir($DIR_PATH);
foreach($files as $file) echo ($file.'<br>');
echo("<a href=http://77.89.224.12/getmail>Back</a>");

imap_close ($mbox);

//This function will save file attachments to folder $DIR_PATh
function saveAttachment($directory,$connection,$msg_number,$date){
	$structure=imap_fetchstructure($connection,$msg_number);
	$attachments = array();
	if (isset($structure->parts) && count($structure->parts)){
		for($i = 0; $i < count($structure->parts); $i++) {
			$attachments[$i] = array(
			'is_attachment' => false,
			'filename' => '',
			'name' => '',
			'attachment' => ''
			);
		
			if($structure->parts[$i]->ifdparameters) {
				foreach($structure->parts[$i]->dparameters as $object) {
					if(strtolower($object->attribute) == 'filename') {
						$attachments[$i]['is_attachment'] = true;
						$attachments[$i]['filename'] = $object->value;
					}
				}
			}
		
			if($structure->parts[$i]->ifparameters) {
				foreach($structure->parts[$i]->parameters as $object) {
					if(strtolower($object->attribute) == 'name') {
						$attachments[$i]['is_attachment'] = true;
						$attachments[$i]['name'] = $object->value;
					}
				}
			}
		
			if($attachments[$i]['is_attachment']) {
				$attachments[$i]['attachment'] = imap_fetchbody($connection, $msg_number, $i+1);
				if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
					$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
				}
				elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
					$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
				}
				//Save filename with data prefix to use
			$temp_file=$directory.'/'.$date.'_'.$attachments[$i]['filename'];
				//Check if such file doesn't exist
			if (!file_exists($temp_file)){
				$file = fopen($temp_file,'w');
				fwrite ($file,$attachments[$i]['attachment']);
				fclose($file);
			}	
			}
		}
	}			
}

//This function checks if attachments exist, and return array with the filenames
function getAttachment($part){
	$arr = array();
	if(isset($part->parts)){
		foreach($part->parts as $partOfPart){
			foreach(getAttachment($partOfPart)as $val){
				$arr[]=$val;
			}
		}
	}
	else{
		if (isset($part->disposition)&& $part->disposition == 'ATTACHMENT'){
			$arr[]=$part->dparameters[0]->value;
		}
	}
	return $arr;
}
?>
