<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
      setInterval(function() {
        fetchData();
      }, 6000); // Fetch data every 5 seconds
      function fetchData() {
        $.ajax({
          url: 'dbh.php', // Replace with the path to your server-side script
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            // Process the received data
            console.log(JSON.stringify(data[0]));
            // Update the DOM with the new data
            // Example: $('#result').text(data);
            document.getElementById("temp").innerHTML = JSON.stringify(data[0]["temperature"]);
            document.getElementById("humidity").innerHTML = JSON.stringify(data[0]["humidity"]);
            document.getElementById("gas").innerHTML = JSON.stringify(data[0]["gas"]);
            document.getElementById("moist").innerHTML = JSON.stringify(data[0]["moisture"]);
            document.getElementById("rain").innerHTML = JSON.stringify(data[0]["rain"]);
            // document.getElementById("time").innerHTML = JSON.stringify(data[0]["date"]);
          },
          error: function(xhr, status, error) {
            console.log('Error:', error);
          }
        });
      }
    });
  </script>
</head>
<body>
    <h1>WELCOME TO FARM WATCH</h1>
    <div class="flex-container">
        <div class="splash-image">
            <img src = "images/main.png">
        </div>
    </div>
    <div id="result">
        <p>Humidity: <p id="humidity"> </p></p>
        <p>Temperature: <p id="temp"> </p></p>
        <p>Gas Levels: <p id="gas"> </p></p>
        <p>Moisture Levels: <p id="moist"> </p></p>
        <p>Rain Detection: <p id="rain"> </p></p>
        <!-- <p>TimeStamp: <p id="time"> </p></p> -->
    </div>

    
</body>
</html>