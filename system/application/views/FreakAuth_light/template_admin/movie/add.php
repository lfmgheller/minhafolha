        <link type="text/css" rel="stylesheet" href="<?=base_url()?>public/admin/css/multiselect/smoothness/jquery-ui-1.8.2.custom.css" />
	<link type="text/css" href="<?=base_url()?>public/admin/css/multiselect/ui.multiselect.css" rel="stylesheet" />
        <script src="<?=base_url()?>public/admin/js/jquery.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?=base_url()?>public/admin/js/multiselect/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/admin/js/multiselect/plugins/localisation/jquery.localisation-min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/admin/js/multiselect/plugins/scrollTo/jquery.scrollTo-min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/admin/js/multiselect/ui.multiselect.js"></script>
	<script type="text/javascript">
		$(function(){
			$(".multiselect").multiselect();
		});
	</script>
<h2><?=$action?></h2>

<p>&nbsp;</p>
<?=form_open_multipart('admin/movie/add')?>
   
<fieldset>
    
    <p>
        Movie Name
        <input type="text" name="movie_name" id="movie_name">
    </p>

    <p>
        Date
        <input type="text" name="movie_date" id="movie_date">
    </p>

    <p>
        Director
        <input type="text" name="movie_director" id="movie_director">
    </p>

    <p>
        Stars
        <input type="text" name="movie_starts" id="movie_stars">
    </p>

    <p>
        Rated
        <input type="text" name="movie_rated" id="movie_rated">
    </p>

    <p>
        Studio
        <input type="text" name="movie_studio" id="movie_studio">
    </p>

    <p>
        Synopsis
        <input type="text" name="movie_synopsis" id="movie_synopsis">
    </p>

    <p>
        Geners
        <input type="text" name="movie_geners" id="movie_geners">
    </p>

    <p>
        Country
        <hr width="50%" align="left"/>
     <?=form_dropdown_from_db('movie_country[]', 'select cat_id,country from country','', 'multiple="multiple" class="multiselect" ')?>
  
    

    <p>
        Wallpaper
        <input type="file" name="movie_wallpaper" id="movie_wallpaper">
    </p>
    


     

   

</fieldset>	 
   <input type="submit" class="submit" name="Submit" value="Submit" />
   <input type="reset" name="Reset"  class="submit" value="Reset" />
   <input type="button" name="Back" value="Back" class="submit" onclick="location.href ='<?=site_url('admin/'.$controller.'/')?>'" />

<?=form_close()?>
