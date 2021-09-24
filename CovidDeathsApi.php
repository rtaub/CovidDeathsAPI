<DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Top Ten Countries with Highest # Of Covid Deaths</title>
        <meta charset="hutf-8" />
    </head>
    
    <body>
        <div class = "container">
        <?php
        echo "<div class='page-header'>
                <h1>Covid-19 Deaths api</h1>
                <a href='https://github.com/rtaub/api'>Github code</a>
            </div>";
        ?>
                         
<?php

// Calls main so the table can be displayed/printed
main();

function main () {
    // Covid19api.com deaths data
	$apiCall = 'https://api.covid19api.com/summary';
    // Reads the data from the website and puts it into a JSON string
	$json_string = curl_get_contents($apiCall);
    // Stores the JSON string into an object
	$obj = json_decode($json_string);
	//arrays to hold both countries, and their deaths
    $arr1 = Array();
	$arr2 = Array();
	
	foreach($obj->Countries as $i)
	{
		array_push($arr1, $i->Country );
		array_push($arr2, $i->TotalDeaths );
	}
	//sort the arrays descending 
	array_multisort($arr2, SORT_DESC, $arr1);
    
    //generate json object with the countries with the top 10 highest numer of deaths and print it
    $arr1 = array_slice($arr1, 0, 10);
    $arr1 = json_encode($arr1);
    $arr1 = json_decode($arr1);
    echo "<h4><b>JSON object</b></h4>";
    print_r($arr1);
    
    // Create the header
	echo "<div><h3><b>10 Countries with highest covid-19 deaths</b></h3>";
    // Create the table
	echo "<table class='table'>";
        echo "<tr>";
            // Create the column headers
            echo "<th>Country Name</th>";
            echo "<th>Number of Deaths</th>";
		echo "</tr>";

        // For loop to add the top 10 countries-arr1 (and their deaths-arr2) to the table 
		for ($x = 0; $x < 10 ; $x++) {
			echo "<tr>";
			echo "<td>{$arr1[$x]}</td>";
			echo "<td>{$arr2[$x]}</td>";
			echo "</tr>";
		 }

	echo "</table>";
	echo '</div>';
}

// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
