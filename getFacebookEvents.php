<?php
    $fb_page_id = "628344893968942"; 
    $access_token = "1691046484469603|dTJsfLPx5m5uppXQ4A5Flw49WFs";
    $year_range = 2;
     
    // automatically adjust date range
    // human readable years
    $since_date = date('Y-01-01', strtotime('-' . $year_range . ' years'));
    $until_date = date('Y-01-01', strtotime('+' . $year_range . ' years'));
     
    // unix timestamp years
    $since_unix_timestamp = strtotime($since_date);
    $until_unix_timestamp = strtotime($until_date);
     
    // or you can set a fix date range:
    // $since_unix_timestamp = strtotime("2012-01-08");
    // $until_unix_timestamp = strtotime("2018-06-28");

    // $fields="id,name,description,place,timezone,start_time,cover";
    $fields="name,start_time,timezone";
     
    $json_link = "https://graph.facebook.com/v2.7/{$fb_page_id}/events/attending/?fields={$fields}&access_token={$access_token}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
     
    $jsonTemp = file_get_contents($json_link);
    //echo $json;

    $obj = json_decode($jsonTemp, true, 512, JSON_BIGINT_AS_STRING);
    //echo $json['name'][0][]
    $event_count = count($obj['data']);
    $json = "[";
    //var_dump $obj;
    for($x=0; $x<$event_count; $x++){
        date_default_timezone_set($obj['data'][$x]['timezone']);
        // $start_date = date( 'Y, m, d, G', strtotime($obj['data'][$x]['start_time']));
        $start_date = date( 'Y-m-d', strtotime($obj['data'][$x]['start_time']));
        $name = $obj['data'][$x]['name'];
        $json .= "{title: '${name}', description: '', datetime: '".date($start_date)."}'";
        //$description = isset($obj['data'][$x]['description']) ? $obj['data'][$x]['description'] : "";
        
        //echo $start_date . "." . $start_time . " time: " . $obj['data'][$x]['start_time'] . " " . $name . "<br>";
        //echo "{title: '".$name."'', description: '', datetime: new Date(".$start_date.")}";
        if ($x+1 != $event_count) $json .= ",";

    }
    //echo $json;

?>