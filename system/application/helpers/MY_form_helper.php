<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Drop-down Menu FROM database
*
* @access    public
* @param    string
* @param    array
* @param    string
* @param    string
* @return    string
*/

    function form_dropdown_from_db($name = '', $sql, $selected = array(), $extra = '')
    {
        $CI =& get_instance();
        if ( ! is_array($selected))
        {
            $selected = array($selected);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if (count($selected) === 0)
        {
            // If the form name appears in the $_POST array we have a winner!
            if (isset($_POST[$name]))
            {
                $selected = array($_POST[$name]);
            }
        }

        if ($extra != '') $extra = ' '.$extra;

        $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

        $form = '<select name="'.$name.'"'.$extra.$multiple.">\n";
        $query=$CI->db->query($sql);
        if ($query->num_rows() > 0)
        {
           foreach ($query->result_array() as $row)
           {
                  $values = array_values($row);
                  if (count($values)===2){
                    $key = (string) $values[0];
                    $val = (string) $values[1];
                    //$this->option($values[0], $values[1]);
                  }

                $sel = (in_array($key, $selected))?' selected="selected"':'';

                $form .= '<option value="'.$key.'"'.$sel.'>'.ucwords(strtolower($val))."</option>\n";
           }
        }
        $form .= '</select>';
        return $form;
    } 
    function form_check_from_db($name = '', $sql, $checked = array(), $extra = '')
    {
        $CI =& get_instance();
        if ( ! is_array($checked))
        {
            $checked = array($checked);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if ($extra != '') $extra = ' '.$extra;

        //$multiple = (count($c) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';
        $query=$CI->db->query($sql);
      	$form='<table><tr>';
      	$count=0;
        if ($query->num_rows() > 0)
        {
           foreach ($query->result_array() as $row)
           {
                  $values = array_values($row);
                  if (count($values)===2){
                    $key = (string) $values[0];
                    $val = (string) $values[1];
                    //$this->option($values[0], $values[1]);
                  }
				 // print_r($key."------".$val);
                $chk = (in_array($key, $checked))?' checked="checked"':'';
                $form .= '<td><input type="checkbox" value="'.$key.'" name="'.$name.'[]"'.$chk.' >'.$val.'</td>';$count++;
                if($count % 3 == 0)
	            {
	            	$form .='</tr><tr>';
	            }
           }
           $form .='</tr></table>';
        }
      
        return $form;
    }
     /*function form_check_from_db_list($name = '', $sql, $checked = array(), $extra = '')
    {
        $CI =& get_instance();
        if ( ! is_array($checked))
        {
            $checked = array($checked);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if ($extra != '') $extra = ' '.$extra;

        //$multiple = (count($c) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';
        $query=$CI->db->query($sql);
      	$form='<table><tr>';
      	$count=0;
        if ($query->num_rows() > 0)
        {
           foreach ($query->result_array() as $row)
           {
                  $values = array_values($row);
                  if (count($values)===2){
                    $key = (string) $values[0];
                    $val = (string) $values[1];
                    //$this->option($values[0], $values[1]);
                  }
				 // print_r($key."------".$val);
                $chk = (in_array($key, $checked))?' checked="checked"':'';
                $form .= '<td><input type="checkbox" value="'.$key.'" name="'.$name.'[]"'.$chk.' >'.$val.'</td>';$count++;
                
	            	$form .='</tr><tr>';
	        }
           $form .='</tr></table>';
        }
      
        return $form;
    }*/
    //=======================================BreadCrum===========================================
    function breadcrumb($data, $config = null)
	{
	    $class = (isset($config['class'])? $config['class'] : 'bread' );
	    $prefix = (isset($config['prefix'])? '<span class="prefix">'.trim($config['prefix']).'</span>' : '' );
	    
	    // If data is an array
	    if (is_array($data) && count($data)>0)
	    {
	        $html = '';
	        $html .= '<div class="'.$class.'">';
	        $html .= $prefix;
	        // Iterate data array
	        $count = 0;
	        foreach( $data as $key => $value )
	        {
	            // check the first element
	            $class = ($count == 0 ? 'first' : '');
	            $class = ($count == count($data)-1 ? 'last' : $class);
	            
	            // generate list item
	            //$html .= '<ul><li class="'.$class.'">';
	            $count++;
	            if(count($data)==$count)
		        {
		        	$html.=$value;
		        }
		        else
			    {
	            	$html .= $value." > ";
	            }
	            
	        }
	        
	        // close opened tags
	       /* for($i=0;$i<$count;$i++)
	        {
	            $html .= '</li></ul>';
	        }*/
	        $html .= '</div>';
	
	    } else {
	        
	        $html = '<div class="'.$class.'">'.$data.'</div>';
	    }
	    return $html;
	}
	function RandomPlaces()
	{
		 $obj =& get_instance();
		//loadFalExtension();
		$obj->load->model('placesmodel');
		$places=$obj->placesmodel->getRandomPlaces();
		$html="<ul>";
		foreach($places as $row)
		{
			$html=$html."<li><a href='".base_url()."index.php/attractions/".$row->place_title."'>".$row->place_title." Attractions</a></li>";
		}
		$html=$html."</ul>";	
		return $html;
	}
        
?>