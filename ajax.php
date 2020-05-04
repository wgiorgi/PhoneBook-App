<?php
    session_start();

    $time = time();

    if($time > $_SESSION['sendtime'])
    {
        $_SESSION['sendtime'] = time() + 30;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://simpleapi.info/apps/numbers-info/info.php?");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "number=" . $_GET['number'] . "&results=json");
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);
        
        echo $server_output;
    } else {
        $data = [];
        $data['err'] = 'timelimit';
        $data['seconds'] = $_SESSION['sendtime'] - $time;
        echo json_encode($data);
    }
    


