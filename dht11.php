<?php
class dht11{
 public $link='';
 function __construct( $temperature,  $humidity,  $moisture, $gas, $rain){
  $this->connect();
  $this->storeInDB($temperature, $humidity, $moisture, $gas, $rain);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'iot_farm_monitoring') or die('Cannot select the DB');
 }
 
 function storeInDB($temperature, $humidity, $moisture, $gas, $rain){
  $query = "INSERT INTO dht_new (temperature, humidity, moisture, gas, rain) VALUES ('$temperature', '$humidity', '$moisture', '$gas', '$rain')";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['temperature'] != '' and  $_GET['humidity'] != '' and $_GET['moisture'] != '' and $_GET['gas'] != '' and $_GET['rain'] != ''){
 $dht11=new dht11($_GET['temperature'],$_GET['humidity'],$_GET['moisture'], $_GET['gas'], $_GET['rain'] );
}
?>
