<?php
include("connect.php");
  class imageHandler {
		public function ary2xml($d=0, $forcetag='', $file_name='') {			
		  $data='<?xml version="1.0"?>';				  
				$data.="<outertag>\r\n<innertag sampleattribute='innertagAttribute'>\r\n";
				$fetch_tips=mysql_query("select * from tips");                                
				while($r=mysql_fetch_array($fetch_tips))
				{
					$tips_title['id'][$count_tips]=$r['id'];
					$tips_title['title'][$count_tips]=$r['tips_title'];
					$tips_title['dec'][$count_tips]=$r['tips_dec'];                                       
					$count_tips++;
				}	  
				for($i=0; $i<$count_tips; $i++) 
		  		{
					$data.="<information>".$tips_title['dec'][$i]."</information>";
			  		$data.="<id>".$tips_title['id'][$i]."</id>";
			  		$data.="<name>".$tips_title['title'][$i]."</name>\r\n";
				}
				$data.="</innertag></outertag>\r\n\r\n";						                    
		  if($file_name!='') {
			  @unlink($file_name);
			  $myFile = $file_name;
			  $fh = fopen($myFile, 'w');
			  fwrite($fh, $data);
			  fclose($fh);
			  return $file_name;
		  }
		  else return $data;
   	}
  }
?>