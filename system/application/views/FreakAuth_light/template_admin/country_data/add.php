<h2><?=$action?></h2>

<p>&nbsp;</p>
<?=form_open_multipart('admin/country/add')?>
   
<fieldset>
<legend>Catagory Details</legend>
        
      <p><label for="name">Catagory Name:</label>
       <?=form_input(array('name'=>'country',
                           'id'=>'country',
                           'maxlength'=>'45',
                           'size'=>'35',
                           ))?>
           <?=(isset($this->fal_validation) ? $this->fal_validation->{'country'.'_error'} : '')?>

      </p>
      

</fieldset>	 
   <input type="submit" class="submit" name="Submit" value="Add" />
   <input type="reset" name="Reset"  class="submit" value="Reset" />
   <input type="button" name="Back" value="Back" class="submit" onclick="location.href ='<?=site_url('admin/'.$controller.'/')?>'" />

<?=form_close()?>
