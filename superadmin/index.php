<?php
session_start();
//$allowedIps = ['198', '200','::1'];
//$userIp = $_SERVER['REMOTE_ADDR'];
//echo $_SERVER['REMOTE_ADDR'];
//if (!in_array($userIp, $allowedIps)) {
  //  exit('Unauthorized');
//}
if(!isset($_SESSION['admin_login']))
{
    header("Location:log_in.php");
}
?>
<!DOCTYPE html>
<html>
  <title>Admin Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../styles/.css" />
  <link rel="stylesheet" href="../../styles/modal.css" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#loader").hide();

      $("#transfer_btn").click(function() {
        $("#order_issue").hide();
        $("#transfer_btn").css("background-color", "#adadeb");
        $("#readmission_btn").css("background-color", "");
        $("#order_issue_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").show();
        $("#readmission").hide();
      });
      $("#transfer_btn").click();
      $("#readmission_btn").click(function() {
        $("#order_issue").hide();
        $("#readmission_btn").css("background-color", "#adadeb");
        $("#transfer_btn").css("background-color", "");
        $("#order_issue_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").hide();
        $("#readmission").show();
      });
      $("#order_issue_btn").click(function() {
        document.getElementById("order_issue_date").valueAsDate = new Date();
        $("#main_div").hide();
        $("#order_issue").show();
        $("#order_issue_btn").css("background-color", "#adadeb");
        $("#transfer_btn").css("background-color", "");
        $("#readmission_btn").css("background-color", "");
      });
      $("#show").click(function() {
        //$("#main").load("add_new_transfer.php");
      });
      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];
      span.onclick = function() {
        modal.style.display = "none";
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };
      $("#order_issue_save_btn").click(function() {
        $("#loader").show();
        $.post(
          "order_issue.php",
          {
            issue_date: $("#order_issue_date").val()
          },
          function(data, status) {
            $("#loader").hide();
            if (data == "success") {
              $("#myModal").css("display", "block");
              $(".modal-content").css("background-color", "green");
              $("#message").text("Success");
            } else {
              $("#myModal").css("display", "block");
              $(".modal-content").css("background-color", "failed");
              $("#message").text(data);
            }
          }
        );
      });
    });
  </script>

  <body>
    <!-- Sidebar -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content" style="width:50%;background-color: #f08585;">
        <span class="close" style="margin-left:80%;">&times;</span>
        <h5 id="message" style="color:white;"></h5>
      </div>
    </div>
    <div id="loader"></div>

    <div class="w3-sidebar w3-light-grey w3-bar-block" style="width:15%">
      <h3 class="w3-bar-item">Menu</h3>
      <p id="transfer_btn" class="w3-bar-item w3-button">
        Transfer/Transfer cum Readmission
      </p>
      <p id="readmission_btn" class="w3-bar-item w3-button">Readmission</p>
      <p id="order_issue_btn" class="w3-bar-item w3-button">Order Issue</p>
      <a href="../report_generation/order_list_admin.php"
        ><p id="approved_list_btn" class="w3-bar-item w3-button">
          Approved List
        </p></a
      >
      <a  style="color:white;" href="logout.php"><p
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
    <div style="margin-left:15%">
      <div class="w3-container w3-teal" style="text-align: center;">
        <h1>DIRECTORATE OF TECHNICAL EDUCATION</h1>
      </div>
      <div id="main_div">
        <div id="transfer">
          <h4>Transfer/Transfer Cum Readmission</h4>
          <form action="transfer/add_new_transfer.php">
            <label for="transfer">Register Number</label>
            <input type="text" name="u_id" />
            <button type="submit" class="btn btn-success">Show</button>
          </form>
        </div>
        <div id="readmission">
          <h4>Readmission</h4>
          <form action="readmission/readmission_request.html">
            <label for="transfer">Register Number</label>
            <input type="text" name="u_id" />
            <button type="submit" class="btn btn-success">Show</button>
          </form>
        </div>
      </div>
      <div id="order_issue">
        <h3>Order Issue Date</h3>
        <div>
          <input type="date" id="order_issue_date" />
          <button id="order_issue_save_btn" class="btn btn-success">
            Save
          </button>
        </div>
      </div>
    </div>
  </body>
</html>
