<?php
$username= $_GET['username'];
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

function fetchDB($username) {
    $res = '';
    $con=mysqli_connect("31.22.4.32","feifeiha_public","p0OnMM722iqZ","feifeiha_cloud_stacks");

    // Check connection
    if (mysqli_connect_errno($con))
    {
        $res = "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($con,"SELECT * FROM messages WHERE recipient LIKE '%" . $username . "%' ORDER BY id DESC");
    while($row = mysqli_fetch_array($result))
    {
        if(strpos($row['archived'], $username) == false) {
            continue;
        }

        $importance = 'panel panel-success';
        if($row['importance'] == 1) {
            $importance = 'panel panel-warning';
        }
        else if($row['importance'] == 2) {
            $importance = 'panel panel-danger';
        }
        $res = $res . '<div id="title-' . $row['md5'] . '" class="' . $importance . '" ><div class="panel-heading" style="cursor:pointer;" onclick="reply(\'' . $row['sender'] . '\');"> <h3 class="panel-title">From: #' . $row['sender'] . ' (' . $row['timestamp'] . ')</h3></div><div class="panel-body"><div class="message-body">' . $row['message'] . '</div><br/><div style="cursor:pointer;" class="label label-default" onclick="archive(\'' . $row['md5'] . '\');">Unarchive</div></div></div>';
    }

    if($res == '') {
        $res = '<div class="well well-lg">You archived no messages.</div>';
    }

    mysqli_close($con);
    return $res;
}

echo fetchDB($username);
?>
