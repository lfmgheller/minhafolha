
<h2><?=$action?></h2>
<p>&nbsp;</p>
<?=form_open_multipart('admin/tips/edit')?>
<fieldset>
<legend>Tips Details</legend>
<input type='hidden' name='tips_id' id="tips_id" value="<?=$reg['tips_id']?>">
	<!--______________________________Frame Title___________________________________________-->
      <p><label for="name">Tips Title:</label>
       <?=form_input(array('name'=>'tips_title',
                           'id'=>'tips_title',
                           'maxlength'=>'45',
                           'size'=>'35',
                            'value' => $reg['tips_title']
                           ))?>
                 <?=(isset($this->fal_validation) ? $this->fal_validation->{'tips_title'.'_error'} : '')?>

      </p>
	<!--______________________________Frame Description___________________________________________-->
      <p><label for="name">Tips Description</label>
       <?=form_input(array('name'=>'tips_dec',
                           'id'=>'tips_dec',
                           'maxlength'=>'45',
                           'size'=>'35',
                           'value' => $reg['tips_dec']
                           ))?>
 <?=(isset($this->fal_validation) ? $this->fal_validation->{'tips_dec'.'_error'} : '')?>
      </p>
      <!--______________________________Frame Description___________________________________________-->
        
</fieldset>	 
     	<input type="submit" name="Submit" value="Save" class="submit" />		
      	<input type="button" name="Back" value="Back" class="submit" onClick="location.href ='<?=site_url('admin/'.$controller)?>'" />
<?=form_close()?>