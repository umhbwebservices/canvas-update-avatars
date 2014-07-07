<?php

// Enter a Canvas Access Token here
// Generate tokens at http://YOURINSTITUTION.instructure.com/profile/settings
$access_token = "YOUR-TOKEN-HERE";

// Update this variable to the folder your Canvas SIS import files are stored
// Include trailing slash.
$samba_share = "/path/to/canvas/files/"; 

// Update this variable to include your Platform URL
$platform_url = "https://YOURINSTITUTION.instructure.com/";

// Update this variable to the URL where faculty/staff avatars are served
$faculty_staff_avatar_url = "https://www.yourschool.edu/avatars/faculty/";

// and this one to the URL where student avatars are served
$student_avatar_url = "https://www.yourschool.edu/avatars/students/";

// update_avatar - just pass in the ID number of your target as well as 'staff' if you're updating a faculty/staff photo 
function update_avatar ( $ID, $student_or_staff='student' ) {
	global $access_token;
	
	$url=$platform_url."api/v1/users/sis_user_id:".$ID.".json";
	
	$nine_digit = str_pad($ID, 9, "0", STR_PAD_LEFT);

	if ($student_or_staff == 'staff') {
		$avatar_url = $faculty_staff_avatar_url.$ID;
	}
	else {
		$avatar_url = $student_avatar_url.$nine_digit.'.jpg';
	}

	system("curl $url -X PUT -F 'user[avatar][url]=$avatar_url' -H 'Authorization: Bearer $access_token'");
	
}

/*
 * 
 * CSV Importer Yo!
 * 
 */

class CsvImporter 
{ 
    private $fp; 
    private $parse_header; 
    private $header; 
    private $delimiter; 
    private $length; 
    //-------------------------------------------------------------------- 
    function __construct($file_name, $parse_header=false, $delimiter=",", $length=8000) 
    { 
        $this->fp = fopen($file_name, "r"); 
        $this->parse_header = $parse_header; 
        $this->delimiter = $delimiter; 
        $this->length = $length; 
        $this->lines = $lines; 

        if ($this->parse_header) 
        { 
           $this->header = fgetcsv($this->fp, $this->length, $this->delimiter); 
        } 

    } 
    //-------------------------------------------------------------------- 
    function __destruct() 
    { 
        if ($this->fp) 
        { 
            fclose($this->fp); 
        } 
    } 
    //-------------------------------------------------------------------- 
    function get($max_lines=0) 
    { 
        //if $max_lines is set to 0, then get all the data 

        $data = array(); 

        if ($max_lines > 0) 
            $line_count = 0; 
        else 
            $line_count = -1; // so loop limit is ignored 

        while ($line_count < $max_lines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) 
        { 
            if ($this->parse_header) 
            { 
                foreach ($this->header as $i => $heading_i) 
                { 
                    $row_new[$heading_i] = $row[$i]; 
                } 
                $data[] = $row_new; 
            } 
            else 
            { 
                $data[] = $row; 
            } 

            if ($max_lines > 0) 
                $line_count++; 
        } 
        return $data; 
    } 
    //-------------------------------------------------------------------- 

} 

?>