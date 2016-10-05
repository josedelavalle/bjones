<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
 	
    <title>B.Jones Events</title>
 
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
 	
 	<link rel="stylesheet" href="gallery/assets/css/main.css" />
 	<link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
</head>
<body>
     
 
<div id="wrapper">
	<header id="header">
		<h1><a href="index.php"><strong>back</strong> - b.jones</a></h1>
	</header>
<?php 
	$fb_page_id = "628344893968942"; 
    $access_token = "1691046484469603|dTJsfLPx5m5uppXQ4A5Flw49WFs";
    $year_range = 2;
     
    // automatically adjust date range
    // human readable years
    //$since_date = date('Y-01-01', strtotime('-1 day'));
    
    // $since_date = date('Y-01-01', strtotime('today UTC'));
    // $until_date = date('Y-01-01', strtotime('+' . $year_range . ' years'));
    $since_date = date('Y-m-d');
    $until_date = date('Y-12-31', strtotime('+' . $year_range . ' years'));
     
    // unix timestamp years
    $since_unix_timestamp = strtotime($since_date);
    $until_unix_timestamp = strtotime($until_date);
     
    // or you can set a fix date range:
    // $since_unix_timestamp = strtotime("2012-01-08");
    // $until_unix_timestamp = strtotime("2018-06-28");

    $fields="name,description,place,timezone,start_time,cover";
    //$fields="name,start_time,timezone";
     
     $json_link = "https://graph.facebook.com/v2.7/{$fb_page_id}/events/attending/?fields={$fields}&access_token={$access_token}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
     
    // $json_link = "https://graph.facebook.com/v2.7/{$fb_page_id}/events/attending/?fields={$fields}&access_token={$access_token}&until={$until_unix_timestamp}";
     
    $json = file_get_contents($json_link);


    $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
    // echo "<table id='fbEvents' class='table table-responsive table-bordered'>";
    echo "<div id='main'>";
    //echo "<div id='fbEvents' class='table table-responsive table-bordered'>";
	 
	    // count the number of events
	    $event_count = count($obj['data']);
	 	function sortFunction($a,$b){
	 	    if ($a['start_time'] == $b['start_time']) return 0;
	 	    return strtotime($a['start_time']) - strtotime($b['start_time']);
	 	}
	 	usort($obj['data'],"sortFunction");
	    for($x=0; $x<$event_count; $x++){
	        // set timezone
	        date_default_timezone_set($obj['data'][$x]['timezone']);
	         
	        $start_date = date( 'D, M d', strtotime($obj['data'][$x]['start_time']));
	        $start_time = date('g:i a', strtotime($obj['data'][$x]['start_time']));
	          
	        $pic_big = isset($obj['data'][$x]['cover']['source']) ? $obj['data'][$x]['cover']['source'] : "https://graph.facebook.com/v2.7/{$fb_page_id}/picture?type=large";
	         
	        $eid = $obj['data'][$x]['id'];
	        $name = $obj['data'][$x]['name'];
	        $description = isset($obj['data'][$x]['description']) ? $obj['data'][$x]['description'] : "";
	         
	        // place
	        $place_name = isset($obj['data'][$x]['place']['name']) ? $obj['data'][$x]['place']['name'] : "";
	        $city = isset($obj['data'][$x]['place']['location']['city']) ? $obj['data'][$x]['place']['location']['city'] : "";
	        $country = isset($obj['data'][$x]['place']['location']['country']) ? $obj['data'][$x]['place']['location']['country'] : "";
	        $zip = isset($obj['data'][$x]['place']['location']['zip']) ? $obj['data'][$x]['place']['location']['zip'] : "";
	         
	        $location="";
	         
	        if($place_name && $city && $country && $zip){
	            $location="{$place_name}, {$city}, {$country}, {$zip}";
	        }else{
	            $location="Location not set or event data is too old.";
	        }


	        echo "<article class='thumb caption'>";
	        	echo "<img src='${pic_big}' alt='' />";
	        	echo "<div class='caption-overlay'>";
	        	echo "<a href='#'><h1 class='caption__overlay__title'>${start_date}&nbsp;${start_time}</a></h1>";
	        	echo "<div class='caption__overlay__content'>";
	        	echo "<h2>${name}<a href='https://www.facebook.com/events/{$eid}/' target='_blank'><i class='fa fa-facebook-official myIcon'></i></a></h2>";
	        	echo "<p>${description}</p>";
	        	echo "</div>";
	        	echo "</div>";
	        echo "</article>";
	        // echo "<div class='row'>";

	        // echo "<div class='col-lg-6'><img src='{$pic_big}'/></div>";
	        // echo "<div class='col-lg-6'></div>";
	        // echo "</div>";
	        
	        // echo "<tr>";
	        //     echo "<td colspan=2 style='width:20em;'>";
	            	// echo "<div class='image-container'>";
	             //    	echo "<img src='{$pic_big}'/>";
	             //    	echo "<div class='image-date-overlay'>{$start_date}<br><img src='images/logo.jpg'/></div>";
	             //    echo "</div>";
	        //     echo "</td>";
	        // echo "</tr>";
	          
	        // echo "<tr>";
	        //     echo "<td style='width:15em;'>What:</td>";
	        //     echo "<td><b>{$name}</b></td>";
	        // echo "</tr>";
	          
	        // echo "<tr>";
	        //     echo "<td>When:</td>";
	        //     echo "<td>{$start_date} at {$start_time}</td>";
	        // echo "</tr>";
	          
	        // echo "<tr>";
	        //     echo "<td>Where:</td>";
	        //     echo "<td>{$location}</td>";
	        // echo "</tr>";
	          
	        // echo "<tr>";
	        //     echo "<td>Description:</td>";
	        //     echo "<td>{$description}</td>";
	        // echo "</tr>";
	          
	        // echo "<tr>";
	        //     echo "<td>Facebook Link:</td>";
	        //     echo "<td>";
	        //         echo "<a href='https://www.facebook.com/events/{$eid}/' target='_blank'>View on Facebook</a>";
	        //     echo "</td>";
	        // echo "</tr>";
	        
	    }
		// echo"</table>";
	    echo "</div>";
 ?>
 
</div>

 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="gallery/assets/js/jquery.poptrox.min.js"></script>
<script src="gallery/assets/js/skel.min.js"></script>
<script src="gallery/assets/js/util.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="gallery/assets/js/main.js"></script>
 
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
 
</body>
</html>
