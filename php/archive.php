<?php
$md5= $_POST['md5'];
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

function archive($md5) {
    $res = 'no';
    $con=mysqli_connect("31.22.4.32","feifeiha_public","p0OnMM722iqZ","feifeiha_cloud_stacks");

    // Check connection
    if (mysqli_connect_errno($con))
    {
        $res = "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($con,"SELECT * FROM messages WHERE md5='" . $md5 . "'");
    while($row = mysqli_fetch_array($result)) {
        if($row['archived'] == 'no') {
            $res = 'yes';
        }
        else {
            $res = 'no';
        }
    }
    mysqli_query($con, "UPDATE messages SET archived='" . $res . "' WHERE md5='" . $md5 . "'");

    mysqli_close($con);
}

echo archive($md5);
?>
