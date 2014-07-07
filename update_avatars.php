<?php
require 'functions.php';

$time_start = microtime(true);

//Update all staff avatars  

// File Processing
	$month=date('n');
	
	switch ($month) {
		case 1:
			$file = 'sp';
			break;
		case 2:
			$file = 'sp';
			break;
		case 3:
			$file = 'sp';
			break;
		case 4:
			$file = 'ma';
			break;
		case 5:
			$file = 'ma';
			break;
		case 6:
			$file = 's1';
			break;
		case 7:
			$file = 's2';
			break;
		case 8:
			$file = 'fa';
			break;
		case 9:
			$file = 'fa';
			break;
		case 10:
			$file = 'fa';
			break;
		case 11:
			$file = 'fa';
			break;
		case 12:
			$file = 'sp';
			break;
	}

/*
 * 
 * Update Faculty
 * 
 */
 
	$file=$samba_share.$file."_users.csv";
	if (file_exists($file)) {
		$importer2 = new CsvImporter($file,true); 
		$data = $importer2->get(); 
		
		foreach ($data as $faculty) {
			$ID=$faculty['user_id'];
			
				update_avatar($ID,'staff');
				
		}
	}

/*
 * 
 * Update Students
 * 
 */	
	
	$file=$samba_share.$file."_users_stu.csv";
	if (file_exists($file)) {
		$importer3 = new CsvImporter($file,true); 
		$data = $importer3->get(); 
		
		foreach ($data as $stud) {
			$ID=$stud['user_id'];
			update_avatar($ID);
		}
	}
	
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo "\n\n\n===========================================================================\n\n\nTotal run time: ".$execution_time." seconds\n";

?>