<h2><?=$action?></h2>

<p>&nbsp;</p>

<?php
//if no records in DB don't display the result table
if (isset($reg)) 
  {?>
<?=form_open('admin/'.$controller.'/add')?>
<?=form_submit(array('class'=>'submit',
                     'name'=>'Add', 
                     'id'=>'submit',
                     'value'=> 'Add Movie'))?>
<?=form_close()?>
<table width="50%" border="0">
  <tr>
    <th scope="col" align="left">Movie</th>
    <th scope="col" align="left">Date</th>
    <th scope="col" align="left">Director</th>
    <th scope="col" align="right">Stars</th>
    <th scope="col" align="right">Action</th>
  </tr>
  <?php foreach($reg as $loop):?>
  <tr class="center">
    <td align="left"><?=$loop['movie_name'];?></td>
    <td align="left"><?=$loop['movie_date'];?></td>
    <td align="left"><?=$loop['movie_director'];?></td>
    <td align="left"><?=$loop['movie_stars'];?></td>
    


    <td>
	<?=anchor('admin/'.$controller.'/show/'.$loop['movie_id'],
            '<img src="'.base_url().$this->config->item('FAL_assets_admin').'/'.$this->config->item('FAL_images').
            '/zoom.png" alt="view" title="view">', array('title' => 'view'));?>
	 <?php
        if ($loop['show_edit_link'])
            echo anchor('admin/'.$controller.'/edit/'.$loop['movie_id'], '<img src="'.base_url().$this->config->item('FAL_assets_admin').'/'.$this->config->item('FAL_images').'/pencil.png" alt="edit" title="edit">', array('title' => 'edit'));
        if ($loop['show_delete_link'])
            echo anchor('admin/'.$controller.'/del/'.$loop['movie_id'], '<img src="'.base_url().$this->config->item('FAL_assets_admin').'/'.$this->config->item('FAL_images').'/cross.png" alt="delete" title="delete">', array('onCLick' => "return confirm('".$this->lang->line('FAL_confirm_delete')."')", 'title' => 'delete'));
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
                     'value'=> 'Add Movie'))?>
<?=form_close()?>

