<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    header("Location:log_in.php");
}
?>

<!DOCTYPE html>
<html>
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
<style>
a{
  text-decoration:none;
}
</style>
<link rel="stylesheet" href="../../styles/loader.css">
<link rel="icon" href="/favicon.png"  type="image/png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#loader").hide();
      $("#from").click(function () {
        $("#loader").show();
        $("#from").css("background-color", "#c2c2f0");
        $("#order").css("background-color", "");
        $("#to").css("background-color", "");
        $("#order_to").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#changepass").css("background-color", "");
        $("#for_from").load("../from.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
    
      $("#to").click(function () {
        $("#loader").show();
        $("#to").css("background-color", "#c2c2f0");
        $("#from").css("background-color", "");
        $("#order").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#status").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#order_to").css("background-color", "");
        $("#changepass").css("background-color", "");
        $("#for_from").load("../to.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
      $("#readmission").click(function () {
        $("#loader").show();
        $("#readmission").css("background-color", "#c2c2f0");
        $("#from").css("background-color", "");
        $("#to").css("background-color", "");
        $("#order_to").css("background-color", "");
        $("#order").css("background-color", "red");
        $("#changepass").css("background-color", "");
        $("#status").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#for_from").load("../readmission.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
      $("#status").click(function () {
        $("#loader").show();
        $("#status").css("background-color", "#c2c2f0");
        $("#from").css("background-color", "");
        $("#to").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#order").css("background-color", "");
        $("#order_to").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#changepass").css("background-color", "");
        $("#for_from").load("../status.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
      $("#re_status").click(function () {
        $("#loader").show();
        $("#status").css("background-color", "");
        $("#re_status").css("background-color", "#c2c2f0");
        $("#from").css("background-color", "");
        $("#to").css("background-color", "");
        $("#order_to").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#order").css("background-color", "red");
        $("#re_order").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#changepass").css("background-color", "");
        $("#for_from").load("../re_status.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
      $("#status_to").click(function () {
        $("#loader").show();
        $("#status").css("background-color", "");
        $("#from").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#to").css("background-color", "");
        $("#order_to").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#order").css("background-color", "");
        $("#status_to").css("background-color", "#c2c2f0");
        $("#changepass").css("background-color", "");
        $("#for_from").load("../status_to.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });

      $("#changepass").click(function () {
        $("#loader").show();
        $("#order_to").css("background-color", "");
        $("#changepass").css("background-color", "#c2c2f0");
        $("#from").css("background-color", "");
        $("#to").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#for_from").load("../changepass.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
       
      $("#order").click(function () {
        $("#order").css("background-color", "#c2c2f0");
        $("#order_to").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#from").css("background-color", "");
        $("#to").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#status").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#changepass").css("background-color", "");
        $("#loader").show();
        $("#for_from").load("../order_list.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
      $("#order_to").click(function () {
        $("#order_to").css("background-color", "#c2c2f0");
        $("#order").css("background-color", "");
        $("#re_order").css("background-color", "");
        $("#from").css("background-color", "");
        $("#to").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#status").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#changepass").css("background-color", "");
        $("#loader").show();
        $("#for_from").load("../order_to.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
      $("#re_order").click(function () {
        $("#order").css("background-color", "red");
        $("#re_order").css("background-color", "#c2c2f0");
        $("#from").css("background-color", "");
        $("#to").css("background-color", "");
        $("#readmission").css("background-color", "");
        $("#status").css("background-color", "");
        $("#re_status").css("background-color", "");
        $("#status_to").css("background-color", "");
        $("#changepass").css("background-color", "");
        $("#loader").show();
        $("#for_from").load("../re_order_list.php",function(v1,v2,v3){
          $("#loader").hide();       });
        $("#loader").hide();
      });
           
      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];
      span.onclick = function () {
        modal.style.display = "none";
      };
      var hashval=window.location.hash.substr(1);
      if(hashval!=""){
      $("#"+hashval).click();
      console.log(hashval);
      }
      else{
        $("#from").click();
      }
      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function (event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };
    });
  </script>

  <body>
    <!-- Sidebar -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content" style="width: 50%; background-color: #f08585;">
        <span class="close" style="margin-left: 80%;">&times;</span>
        <h5 id="message" style="color: white;"></h5>
      </div>
    </div>
    <div id="loader"></div>

    <div class="w3-sidebar w3-light-grey w3-bar-block" style="width: 15%;">
      <h3 class="w3-bar-item">Menu</h3>
      <!-- <a href="#from" id="from" class="w3-bar-item w3-button">
        Transfer/Transfer Cum Readmission From
      </a>
      <a href="#to" id="to" class="w3-bar-item w3-button">
        Transfer/Transfer Cum Readmission To
      </a> -->
      <a href="#readmission" id="readmission" class="w3-bar-item w3-button">Readmission</a>
      <!-- <a href="#status" id="status" class="w3-bar-item w3-button">Status(Transfer From)</a>
      <a href="#status_to" id="status_to" class="w3-bar-item w3-button">Status(Transfer To)</a> -->
      <a href="#re_status" id="re_status" class="w3-bar-item w3-button">Status(Readmission)</a>
      <!-- <a href="#status" id="status" class="w3-bar-item w3-button">Status(Readmission)</a> -->
      <!-- <a href="#order" id="order" class="w3-bar-item w3-button" >Order List(Transfer From)</a>
      <a href="#order_to" id="order_to" class="w3-bar-item w3-button" >Order List(Transfer To)</a> -->
      <a href="#re_order" id="re_order" class="w3-bar-item w3-button">Order List(Readmission)</a>
      <a href="#changepass" id="changepass" class="w3-bar-item w3-button">Change Password</a>
      <a  style="color:white;"href="logout.php"><p
        id="order"
        class="w3-bar-item w3-button"
        style="
          color: white;
          background-color: red;
          border-radius: 7px;
        "
      >
        Logout
      </p></a>
    </div>

    <!-- Page Content -->
    <div style="margin-left: 15%;">
      <div class="w3-container w3-teal" style="text-align: center;">
        <h1>DIRECTORATE OF TECHNICAL EDUCATION</h1>
      </div>
      <div class="w3-container w3-green" style="text-align: center;background-color:green;">
        <h6><?php echo $_SESSION['college_name'];?></h6>
      </div>
      <div id="for_from"></div>
    </div>
  </body>
</html>
