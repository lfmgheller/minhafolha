<script language="javascript">
function add(type) {
	    //Create an input type dynamically.
	    
	    var count=parseInt(document.getElementById("count").value);
	   
	    var element = document.createElement("input");
	 
	    //Assign different attributes to the element.
	    element.setAttribute("type", type);
	  	element.setAttribute("name", "image_upload"+count) ; 
	  	element.setAttribute("id", "image_upload"+count) ;
		count=count+1;
		 
	    document.getElementById("count").value=count;
	    var foo = document.getElementById("fooBar");
 // alert(foo.innerHTML);
	    //Append the element in page (in span).
	    foo.appendChild(element);
		foo.appendChild(document.createElement("p")); 

	 
	}
</script>

<script type="text/javascript" src="<?=base_url()?>public/shared/js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="<?=base_url()?>public/shared/js/thickbox.js"></script>
<link rel="stylesheet" href="<?=base_url()?>public/shared/css/thickbox.css" type="text/css" media="screen" />
<h2><?=$action?></h2>
<p>&nbsp;</p>
<?=form_open_multipart('admin/frames/addImg/'.$reg['frame_id'])?>
<?php /*?><?=form_open('admin/'.$controller.'/addImg')?><?php */?>

<?php
//if no records in DB don't display the result table
if (isset($reg)) 
  { $count=0;?> 
<input type="hidden" name="count" id="count" value="1">
<div style="left:850px; position:absolute;">
<fieldset style="width:630px; height:100%;">
	<legend>Current Images</legend>
	<table>
		<tr>
	<?php if(isset($img)){foreach($img as $row){$count++;?>
		<td><a href="<?=base_url().'uploads/'.$row['image']?>" class="thickbox"><img style="width:60px; height:60px; margin-left:30px;" src="<?=base_url().'uploads/'.$row['image_thumb']?>" /></a><br/><br/>
			<?=anchor('admin/'.$controller.'/delImg/'.$row['frame_image_id'],"Delete",array('class'=>'submit',
			                     'name'=>'delete', 
			                     'id'=>'delete',
			                     'title'=> 'Delete',
			                     'style'=>"margin-left:35px;"))?>
			
		</td>
	<? if($count%6==0){echo "</tr><tr>";}} } else{ echo "Images not available";}?>
	</tr>
	</table>
</fieldset>
</div>
<table border="0">
  <tr>
    <th scope="col" align="left">Sr No #</th>
    <td align="left"><?=$reg['frame_id'];?></td>
  </tr>
  <tr>
    <th scope="col" align="left">Model Number</th>
    <td align="left"><?=$reg['model_number'];?></td>
    </tr>
  <tr>
    <th scope="col" align="left">Temple Length</th>
    <td align="left"><?=$reg['temple_length'];?></td>
  </tr>
  <tr>
  <th scope="col" align="left">Bridge</th>
    <td align="left"><?=$reg['bridge'];?></td>
    </tr>
  <tr>
    <th scope="col" align="left">Frame Width</th>
    <td align="left"><?=$reg['frame_width'];?></td>
  </tr>
  <tr>
    <th scope="col" align="left">Frame Weight</th>
    <td align="left"><?=$reg['frame_weight'];?></td>
  </tr>
    <?if(!isset($img)){?>
  <tr>
	<th scope="col" align="left">Frame Image:</th>
    <td align="left"><input type="file" name="image_upload" id="image_upload"/>&nbsp;(Max allowed size: 750KB)</td>
  </tr>
  <tr>
    <td colspan="2" style="padding-left:96px;"> <span id="fooBar"></span><!--input class="submit" type="button" value="Add More" onclick="add('file')"/--></td>
  </tr>
  <?}?>
</table>
<?php } 
else { ?>
<table>
<tr>
<td>No record to display</td>
</tr>
</table>
<? } ?>
<?if(!isset($img)){?>
<?=form_open('admin/'.$controller.'/addImg')?>
<?=form_submit(array('class'=>'submit',
					 'name'=>'Add', 
					 'id'=>'submit',
	                 'value'=> 'Add Image'))?>

<?=form_close()?>
<?}?>
<input type="button" name="Back" value="Back" class="submit" onclick="location.href ='<?=site_url('admin/'.$controller.'/')?>'" />