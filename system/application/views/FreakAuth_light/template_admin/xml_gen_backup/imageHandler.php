<?php
include("content.php");
  class imageHandler {
		public function ary2xml($d=0, $forcetag='', $file_name='',$id,$file_name2='') {
			
   
		  $data='<?xml version="1.0"?>';
		
		  
				$data.="\r\n<outertag>\r\n<innertag sampleattribute='innertagAttribute'>\r\n";
				$fetch_tips=mysql_query("select * from tips where id=$id");
                 $count_tips=0;
				 $flag=0;
				while($r=mysql_fetch_array($fetch_tips))
				{
					$tips_title['id'][$count_tips]=$r['id'];
					$tips_title['cat_id'][$count_tips]=$r['cat_id'];
					$tips_title['title'][$count_tips]=$r['tips_title'];
					$tips_title['dec'][$count_tips]=$r['tips_dec'];
					$file="tipsid".$id.".xml";		
					$fetch_tips_link=mysql_query("select * from tips_links where file_name='$file'");
									while($r=mysql_fetch_array($fetch_tips_link))
									{
										$flag=1;
										break;
									}
									if($flag==0)
									{
										$query_insert=mysql_query("insert into tips_links values($id,'$file')");
									}
					
				}	  
				for($i=0; $i<=$count_tips; $i++) 
		  		{
					$data.="\r\n\r\n<information>".$tips_title['dec'][$i]."</information>";
			  		$data.="\r\n<id>".$tips_title['id'][$i]."</id>";
			  		$data.="\r\n<name>".$tips_title['title'][$i]."</name>";
				}
				$data.="\r\n\r\n</innertag></outertag>\r\n\r\n";		
		
		
		$data2='<?xml version="1.0"?>';
		
		  
				$data2.="\r\n<outertag>\r\n<innertag sampleattribute='innertagAttribute'>\r\n<mytag>";
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
					$data2.=$tips_title['file_name'][$i];
                                    }
                                    else
                                    {
                                        $data2.=$tips_title['file_name'][$i]." ";
                                    }
				}
				
				$data2.="\r\n</mytag>\r\n</innertag></outertag>\r\n\r\n";		
		  
          
		  if($file_name!='') {
			  @unlink($file_name);
			  $myFile = $file_name;
			  $fh = fopen($myFile, 'w');
			  fwrite($fh, $data);
			  fclose($fh);
			  
			  @unlink($file_name2);
			  $myFile2 = $file_name2;
			  $fh2 = fopen($myFile2, 'w');
			  fwrite($fh2, $data2);
			  fclose($fh2);
			  //return $file_name2;
		  }
		 
   	}
	
	
	
  }
?>