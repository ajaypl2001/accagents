<?php
$con = mysqli_connect("localhost", "root", "", "acc_portal_new");
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
// mysqli_close($con);
?>
