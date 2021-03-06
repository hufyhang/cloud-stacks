<?php
$username= $_POST['username'];
$password= $_POST['password'];
header('Content-Type: text/plain');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

function fetchDB($username, $password) {
    $res = '';
    $con=mysqli_connect("31.22.4.32","feifeiha_public","p0OnMM722iqZ","feifeiha_cloud_stacks");

    // Check connection
    if (mysqli_connect_errno($con))
    {
        $res = "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($con,"SELECT * FROM users WHERE username='" . $username . "'");
    while($row = mysqli_fetch_array($result)) {
        if($row['password'] !== $password) {
            return 'Invalid username or password.';
        }
    }


    // $result = mysqli_query($con,"SELECT * FROM messages WHERE recipient LIKE '%" . $username . "%' ORDER BY id DESC");
    $result = mysqli_query($con,"SELECT * FROM messages WHERE recipient REGEXP '" . $username . "[^A-Za-z0-9\.\-]' ORDER BY id DESC");
    while($row = mysqli_fetch_array($result))
    {
        if(strpos($row['archived'], $username) !== false) {
            continue;
        }

        $importance = 'panel panel-success';
        if($row['importance'] == 1) {
            $importance = 'panel panel-warning';
        }
        else if($row['importance'] == 2) {
            $importance = 'panel panel-danger';
        }

        $res = $res . '<div id="title-' . $row['md5'] . '" class="' . $importance . '" ><div class="panel-heading" style="cursor:pointer;" onclick="reply(\'' . $row['sender'] . '\');"> <h3 class="panel-title">From: #' . $row['sender'] . ' (' . $row['timestamp'] . ')</h3></div><div class="panel-body"><div class="message-body">' . $row['message'] . '</div><br/><div style="cursor:pointer;" class="label label-default" onclick="archive(\'' . $row['md5'] . '\');">Archive</div></div></div>';
    }

    if($res == '') {
        $res = '<div class="well well-lg">You got no messages.</div>';
    }

    mysqli_close($con);
    return $res;
}

echo fetchDB($username, $password);
?>
