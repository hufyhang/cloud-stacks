<?php
$username= $_POST['username'];
$password= $_POST['password'];
header('Content-Type: text/plain');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

$res = '';
$con=mysqli_connect("31.22.4.32","feifeiha_public","p0OnMM722iqZ","feifeiha_cloud_stacks");

// Check connection
if (mysqli_connect_errno($con))
{
    $res = "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM users WHERE username LIKE '%" . $username . "%'");
while($row = mysqli_fetch_array($result))
{
    echo 'ERROR';
    return;
}

mysqli_query($con, "INSERT INTO users (username, password) VALUES('" . $username . "','" . $password . "')");
$res = 'OK';

mysqli_close($con);
echo $res;
?>
