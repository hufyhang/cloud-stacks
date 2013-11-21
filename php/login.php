<?php
$username= $_GET['username'];
$password= $_GET['password'];
header('Content-Type: text/plain');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

function login($username, $password) {
    $res = 'ERROR';
    $con=mysqli_connect("31.22.4.32","feifeiha_public","p0OnMM722iqZ","feifeiha_cloud_stacks");

    // Check connection
    if (mysqli_connect_errno($con))
    {
        $res = "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($con,"SELECT * FROM users WHERE username='" . $username . "'");
    while($row = mysqli_fetch_array($result))
    {
        if($row['password'] == $password) {
            $res = 'OK';
        }

    }
    mysqli_close($con);
    return $res;
}

echo login($username, $password);
?>
