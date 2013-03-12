
<h2><?=$action?></h2>
<p>&nbsp;</p>
<?=form_open('admin/'.$controller.'/edit/'.$this->uri->segment(4,0))?>
<fieldset>
<legend>Catagory Details</legend>
	<input type='hidden' name='cat_id' value="<?=$reg['cat_id']?>">
	<!--______________________________Frame Title___________________________________________-->
      <p><label for="name">Catagory Name:</label>
       <?=form_input(array('name'=>'country',
                           'id'=>'country',
                           'maxlength'=>'45',
                           'size'=>'35',
                            'value' => $reg['country']
                           ))?>
                 <?=(isset($this->fal_validation) ? $this->fal_validation->{'country'.'_error'} : '')?>

      </p>

        
</fieldset>	 
     	<input type="submit" name="Submit" value="Save" class="submit" />		
      	<input type="button" name="Back" value="Back" class="submit" onClick="location.href ='<?=site_url('admin/'.$controller)?>'" />
<?=form_close()?>