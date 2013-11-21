<?php
$md5= $_POST['md5'];
$username= $_POST['username'];
header('Content-Type: text/plain');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

function archive($md5, $username) {
    $res = '';
    $con=mysqli_connect("31.22.4.32","feifeiha_public","p0OnMM722iqZ","feifeiha_cloud_stacks");

    // Check connection
    if (mysqli_connect_errno($con))
    {
        $res = "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($con,"SELECT * FROM messages WHERE md5='" . $md5 . "'");
    while($row = mysqli_fetch_array($result)) {
        if(strpos($row['archived'], $username) == false) {
            $res = $row['archived'] . ' ' . $username;
        }
        else {
            $res = str_replace($username, "", $row['archived']);
        }
    }
    mysqli_query($con, "UPDATE messages SET archived='" . $res . "' WHERE md5='" . $md5 . "'");

    mysqli_close($con);

    return $res;
}

echo archive($md5, $username);
?>
