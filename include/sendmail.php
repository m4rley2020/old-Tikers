<?php  
	function sendmail($to,$subject,$mailcontent,$from)
	{
		$array = split("@",$from,2);
		$SERVER_NAME = $array[1];
		$username =$array[0];
		$fromnew = "From: $username@$SERVER_NAME\nReply-To:$username@$SERVER_NAME\nX-Mailer: PHP";
		mail($to,$subject,$mailcontent,$fromnew);
	}
	function SendHTMLMail1($to1,$subject2,$mailcontent1,$from1,$cc="")
	{
		$limite = "_parties_".md5 (uniqid (rand()));
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: $from1\r\n";
		
		if($cc)
			$headers .= "Cc: $cc\r\n";
		
		mail($to1,$subject2,$mailcontent1,$headers);
		
	}
?>