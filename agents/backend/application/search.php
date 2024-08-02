<?php
include("../../db.php");
header('Content-type: application/json');


$searchTerm = $_GET['term']; 
$query = mysqli_query($con, "SELECT DISTINCT refid, student_id, fname, lname FROM st_application WHERE refid LIKE '%".$searchTerm."%' OR student_id LIKE '%".$searchTerm."%' OR fname LIKE '%".$searchTerm."%' OR lname LIKE '%".$searchTerm."%'");

	while ($row = mysqli_fetch_array($query)) {
        $data[] = $row['refid'];
        $data[] = $row['student_id'];
        $data[] = $row['fname'].' '.$row['lname'];
    }	
	$list = isset($data) ? $data : '';
	echo json_encode($list);
?>