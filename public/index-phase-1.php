<?php
// function to geocode address, it will return false if unable to geocode address
function geocode($address){

    // url encode the address
    $address = urlencode($address);

    // google map geocode api url
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyCHfBAxW62Gpotc4vwI_JGaLHjluAnMTlw";

    // get the json response
    $resp_json = file_get_contents($url);

    // decode the json
    $resp = json_decode($resp_json, true);

    // response status will be 'OK', if able to geocode given address
    if($resp['status']=='OK'){

        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";

        // verify if data is complete
        if($lati && $longi && $formatted_address){
            // put the data in the array
            $data_arr = array();
            array_push(
                $data_arr,
                    $lati,
                    $longi,
                    $formatted_address
                );

            return $data_arr;

        }else{
            return false;
        }

    }

    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}

function getdestination($address){
  // url encode the address
  $address = urlencode($address);

  // google map geocode api url
  $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyBmVD9vSThqp7gggOXQHB8aNOzC8gjyvLA";

  // get the json response
  $resp_json = file_get_contents($url);

  // decode the json
  $resp = json_decode($resp_json, true);

  // response status will be 'OK', if able to geocode given address
  if($resp['status']=='OK'){

      // get the important data
      $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
      $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
      if($lati && $longi ){
          // put the data in the array
          $desti_arr = array();
          array_push(
              $desti_arr,
                  $lati,
                  $longi
              );
          return $desti_arr;
      }else{
          return false;
      }
    }

    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}
?>
<?php
if(isset($_POST['address'])){

    // get latitude, longitude and formatted address
    $data_arr = geocode($_POST['address']);

    // if able to geocode the address
    if($data_arr){

        $latitude = $data_arr[0];
        $longitude = $data_arr[1];
        $formatted_address = $data_arr[2];


    // if unable to geocode the address
    }else{
        echo "No map found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Live Demo of Google Maps Geocoding Example with PHP</title>

	<style>
	body{
		font-family:arial;
		font-size:.8em;
	}

	input[type=text]{
		padding:0.5em;
		width:20em;
	}

	input[type=submit]{
		padding:0.4em;
	}

  #map{
    float: right;
    width:70%;
    height:720px;
  }

	#map-label,
	#address-examples{
		margin:1em 0;
	}
	</style>

</head>
<body>


	<!-- google map will be shown here -->
	<div id="map">Loading map...</div>
	<div id='map-label'>Map shows approximate location.</div>

	<!-- JavaScript to show google map -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBaX9M1HFn9grabVLMZTHgFTaXYzgSjAow&callback=initMap"></script>
	<script type="text/javascript">
		function initMap() {
            var myOptions = {
                zoom: 14,
                center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map"), myOptions);
            marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>)
            });


        }
        google.maps.event.addDomListener(window, 'load', initMap);

    </script>


<!-- enter any address -->
<form action="" method="post">
	<input type='text' name='address' placeholder='Enter any address here' />
	<input type='submit' value='Search' /><br>


</form>




<p>Coordinate's Latitude and Longitude</p>
<?php echo $latitude; ?>, <?php echo $longitude; ?><br>
<div id="journey">

</div>
<p>Customize maker</p>
<p>Color:</p>
<form action="">
<select>
  <option value="Red">Red</option>
  <option value="Blue">Blue</option>
  <option value="Green">Green</option>
</select>
</form>

</body>
</html>
