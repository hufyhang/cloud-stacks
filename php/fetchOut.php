<?php
$username= $_POST['username'];
$password = $_POST['password'];
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

    $result = mysqli_query($con,"SELECT * FROM messages WHERE sender='" . $username . "' ORDER BY id DESC");
    while($row = mysqli_fetch_array($result))
    {
        $importance = 'panel panel-success';
        if($row['importance'] == 1) {
            $importance = 'panel panel-warning';
        }
        else if($row['importance'] == 2) {
            $importance = 'panel panel-danger';
        }
        $res = $res . '<div class="' . $importance . '" ><div class="panel-heading"> <h3 class="panel-title">To: #' . $row['recipient'] . ' (' . $row['timestamp'] . ')</h3></div><div class="panel-body"><div class="message-body">' . $row['message'] . '</div></div></div>';
    }

    if($res == '') {
        $res = '<div class="well well-lg">You sent no messages.</div>';
    }

    mysqli_close($con);
    return $res;
}

echo fetchDB($username, $password);
?>
