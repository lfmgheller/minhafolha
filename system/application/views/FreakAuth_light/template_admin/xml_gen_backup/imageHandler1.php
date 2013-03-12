<?php
include("content.php");
  class imageHandler1 {
		public function ary2xml($d=0, $forcetag='', $file_name='') {
			
   
		 $data='<?xml version="1.0"?>';
		
		  
				$data.="\r\n<outertag>\r\n<innertag sampleattribute='innertagAttribute'>\r\n<mytag>";
				$fetch_tips=mysql_query("select * from tips_links");
                 $count_tips=0;
				while($r=mysql_fetch_array($fetch_tips))
				{
					$tips_title['file_name'][$count_tips]=$r['file_name'];			
					$count_tips++;
				}	  
				
				for($i=0; $i<$count_tips; $i++) 
		  		{
                                    if($i==($count_tips-1))
                                    {
					$data.=$tips_title['file_name'][$i];
                                    }
                                    else
                                    {
                                        $data.=$tips_title['file_name'][$i]." ";
                                    }
				}
				
				$data.="\r\n</mytag>\r\n</innertag></outertag>\r\n\r\n";		
		
		  
                  
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