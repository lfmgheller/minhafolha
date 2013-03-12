<?php
include("content.php");
  class imageHandler {
		public function ary2xml($d=0, $forcetag='', $file_name='') {
			
   
		  $data='<?xml version="1.0"?>';
		
		  
				$data.="\r\n<outertag>\r\n<innertag sampleattribute='innertagAttribute'>\r\n";
				$fetch_tips=mysql_query("select * from tips");
                                $count_tips=0;
				 $flag=0;
				while($r=mysql_fetch_array($fetch_tips))
				{					
					$tips_title['id'][$count_tips]=$r['id'];
					$tips_title['cat_id'][$count_tips]=$r['cat_id'];					
					$cat_id=$tips_title['cat_id'][$count_tips];
					$fetch_catagory=mysql_query("select * from catagory where cat_id=$cat_id");
					  while($r_cat=mysql_fetch_array($fetch_catagory))
						{
							$tips_title['catagory'][$count_tips]=$r_cat['catagory'];
						}						
					$tips_title['title'][$count_tips]=$r['tips_title'];
					$tips_title['dec'][$count_tips]=$r['tips_dec'];
					$count_tips++;
					$file="tipsid.xml";												
				}
                                
				for($i=0; $i<$count_tips; $i++) 
		  		{
					$data.="\r\n\r\n<status>\r\n<information>".$tips_title['dec'][$i]."=</information>";
			  		$data.="\r\n<id>".$tips_title['id'][$i]."=</id>";
			  		$data.="\r\n<name>".$tips_title['title'][$i]."=</name>";
					$data.="\r\n<catagary>".$tips_title['catagory'][$i]."=</catagary>\r\n</status>";
				}
				$data.="\r\n\r\n</innertag></outertag>\r\n\r\n";		
		
		
		
          
		  if($file_name!='') {
			  @unlink($file_name);
			  $myFile = $file_name;
			  $fh = fopen($myFile, 'w');
			  fwrite($fh, $data);
			  fclose($fh);			  		
			  //return $file_name2;
		  }
		 
   	}
	
	
	
  }
?>