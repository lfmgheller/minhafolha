<h2><?=$action?></h2>

<p>&nbsp;</p>
<?=$pagination_links;?>
<?php
//if no records in DB don't display the result table
if (isset($reg)) 
  {?>
<?=form_open('admin/'.$controller.'/add')?>
<?=form_submit(array('class'=>'submit',
                     'name'=>'Add', 
                     'id'=>'submit',
                     'value'=> 'Add Country'))?>
<?=form_close()?>
<table width="50%" border="0">
  <tr>
    <th scope="col" align="left">Sr No #</th>
    <th scope="col" align="left">Country</th>
    <th scope="col" align="left">Edit</th>
  </tr>
  <?php foreach($reg as $loop):?>
  <tr class="center">
    <td align="left"><?=$loop['cat_id'];?></td>
    <td align="left"><?=$loop['country'];?></td>
    <td>
	
	 <?php
        if ($loop['show_edit_link'])
            echo anchor('admin/'.$controller.'/edit/'.$loop['cat_id'], '<img src="'.base_url().$this->config->item('FAL_assets_admin').'/'.$this->config->item('FAL_images').'/pencil.png" alt="edit" title="edit">', array('title' => 'edit'));
        if ($loop['show_delete_link'])
            echo anchor('admin/'.$controller.'/del/'.$loop['cat_id'], '<img src="'.base_url().$this->config->item('FAL_assets_admin').'/'.$this->config->item('FAL_images').'/cross.png" alt="delete" title="delete">', array('onCLick' => "return confirm('".$this->lang->line('FAL_confirm_delete')."')", 'title' => 'delete'));
        ?>
    </td>
  </tr>
  <?php endforeach;?>
</table>
<?php } 
else { ?>
<table>
<tr>
<td>No record to display</td>
</tr>
</table>
<? } ?>
<?=form_open('admin/'.$controller.'/add')?>
<?=form_submit(array('class'=>'submit',
                     'name'=>'Add', 
                     'id'=>'submit',
                     'value'=> 'Add Country'))?>
<?=form_close()?>
<?=$pagination_links;?>
