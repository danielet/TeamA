<?

	include ("./include.php");
	
	if (($handle = fopen("test.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$sql = "INSERT INTO test (id, name, marks) VALUES ( '".mysql_escape_string($data[0])."','".mysql_escape_string($data[1])."','".mysql_escape_string($data[2])."')";
			$DB->query($sql);
			if($DB){
				echo "row inserted\n";
			}
			else{
				echo die(mysql_error());
			}
		}
		fclose($handle);
	}
	
	function readCSV($csvFile){
		$file_handle = fopen($csvFile, 'r');
		while (!feof($file_handle) ) {
			$line_of_text[] = fgetcsv($file_handle, 1024);
		}
		fclose($file_handle);
		return $line_of_text;
	}


	// Set path to CSV file
	$csvFile = 'test.csv';

	$csv = readCSV($csvFile);
	echo '<pre>';
print_r($csv[1][0]);
	echo '</pre>';
?>

