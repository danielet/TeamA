<?php
//. substr( $_FILES['uploaded_file']['name'], 0, -4)
$fullfilename = substr(basename( $_FILES['uploaded_file']['name']),0,-4);
$file_path = "../upload/".$fullfilename."/";
$filename = substr($fullfilename,0.10);
mkdir($file_path);
$file_path = $file_path .basename( $_FILES['uploaded_file']['name']);
move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path);
//
//세션아이디를 검색할 유저아이디와 디바이스 아이디 설정
//set user_id,device_id to retrieve for session_id 
$uid = "test";
$did = "1";

//zip 파일 풀기
//unzip zip files
$zip = new ZipArchive;
if ($zip->open('./airoundu/upload/'.$fullfilename.'/'.$fullfilename.'.zip') === TRUE) {
	$zip->extractTo('./airoundu/upload/test');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}  

//appdata 의 csv파일 열어서 읽기
//read data from appdata's csv file
$data = array();
if (($handle = fopen('./airoundu/upload/'.$fullfilename."/".$filename.'GPSinfo.csv', 'r')) !== FALSE) {
    while (($line = fgetcsv($handle, 0, ',')) !== FALSE) {
        $memberId = $line[0];
        unset($line[0]);
        $data[$memberId] = $line;
    }
    fclose($handle);
}
//sensordata의 csv파일 열어서 읽기
//read data from sensor's csv file
if (($handle = fopen('./airoundu/upload/'.$fullfilename."/".$filename.'airinfo.csv', 'r')) !== FALSE) {
    while (($line = fgetcsv($handle, 0, ',')) !== FALSE) {
        $memberId = $line[0];
        unset($line[0]);
        $data[$memberId] = array_merge($data[$memberId], $line);
    }
    fclose($handle);
}
//csv파일 두개를 제일 앞의 키를 읽어서 그것을 기준으로 합치기
//merge two csv files with common key
ksort($data);       // not needed, but puts records in order by member
if (($handle = fopen('./airoundu/upload/'.$fullfilename.'.csv', 'w')) !== FALSE) {
    foreach($data as $key => $value) {
        fwrite($handle, "$key," . implode(',', $value) . "\r");
    }
    fclose($handle);
	
}
//합친 최종 파일을 세션 테이블에 경로 넣어주기
//set final combined direction on session ADDFILENAME column at data base
//$query = "UPDATE session SET ADDFILENAME = './test/'.$fullfilename.'.csv' WHERE S_ID = '$sid[0]'";
//$result = mysqli_query($connect, $query);

//합치는데 필요했던 알집파일들과 csv파일들 삭제하기 
//delete zip files and csv files to need to combine final csv files
  //  unlink($filename.'airinfo.csv');
	//unlink($filename.'.zip');
	//unlink($filename.'GPSinfo.csv');
//
//  
//$file_path = "../upload/";
//     
//$file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
//if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
//    echo "success";
//} else{
//    echo "fail";
//}
////Just Use file address
//
//
//$file_path = "../upload/";
//$file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
//	
//if (is_uploaded_file($_FILES['userfile']['tmp_name']))
//{
//	//SUCCESS
//	$info =  "File ". $_FILES['userfile']['tmp_name'] ." uploaded successfully.\n";
//	//Make files address
//	if(is_dir($file_path)){
//		if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
//			echo "success";
//		} else{
//			echo "fail";
//		}
//	//Just Use file address
//	} else{
//		if(mkdir($file_path)){
//			move_uploaded_file ($_FILES['userfile'] ['tmp_name'], $_FILES['userfile'] ['tmp_name'], $file_path);
//			echo "saved";
//		} else {
//			echo "address not made";
//			exit;
//		}	
//			
//	}
//} else {
//	//FAIL
//	$info =  "file no exist.";
//
//	print_r($info);
//
//}
//
//////////////
////SUCCESS
//
//
//$file_path = "../upload/";
//$file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
//$info =  "File ". $_FILES['userfile']['tmp_name'] ." uploaded successfully.\n";
////Make files address
//if(is_dir($file_path)){
//	if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
//		echo "success";
//	} else{
//		echo "fail";
//	}
//	//Just Use file address
//} else{
//	if(mkdir($file_path)){
//		move_uploaded_file ($_FILES['userfile'] ['tmp_name'], $_FILES['userfile'] ['tmp_name'], $file_path);
//		echo "saved";
//	} else {
//		echo "address not made";
//		exit;
//	}	
//	
//}