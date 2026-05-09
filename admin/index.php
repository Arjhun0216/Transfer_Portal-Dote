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
<head>
  <title>Admin Home</title>
  <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
</head>  <meta name="viewport" content="width=device-width, initial-scale=1" />
 <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <!-- <link rel="stylesheet" href="../../styles/.css" />
  <link rel="stylesheet" href="../../styles/modal.css" /> -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
  <script>
    $(document).ready(function() {
      $("#loader").hide();

      $("#transfer_btn").click(function() {
        $("#order_issue").hide();
        $("#re_approved_list_btn").css("background-color", "");
        $("#re_order_issue_btn").css("background-color", "");
        $("#transfer_btn").css("background-color", "#adadeb");
        $("#readmission_btn").css("background-color", "");
        $("#approved_list_btn").css("background-color", "");
        $("#order_issue_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").show();
        $("#readmission").hide();
        $("#order_list").hide();
        $("#order_issue").hide();
        $("#re_order_list").hide();
        $("#re_order_issue").hide();

      });
      $("#transfer_btn").click();
     
      $("#readmission_btn").click(function() {
        $("#order_issue").hide();
        $("#re_approved_list_btn").css("background-color", "");
        $("#re_order_issue_btn").css("background-color", "");
        $("#readmission_btn").css("background-color", "#adadeb");
        $("#transfer_btn").css("background-color", "");
        $("#approved_list_btn").css("background-color", "");
        $("#order_issue_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").hide();
        $("#readmission").show();
        $("#order_list").hide();
        $("#order_issue").hide();
        $("#re_order_list").hide();
        $("#re_order_issue").hide();
      });
      
      $("#order_issue_btn").click(function() {
        document.getElementById("order_issue_date").valueAsDate = new Date();
        $("#order_issue_btn").css("background-color", "#adadeb");
        $("#transfer_btn").css("background-color", "");
        $("#approved_list_btn").css("background-color", "");
        $("#re_approved_list_btn").css("background-color", "");
        $("#re_order_issue_btn").css("background-color", "");
        $("#readmission_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").hide();
        $("#readmission").hide();
        $("#order_list").hide();
        $("#order_issue").show();
        $("#re_order_list").hide();
        $("#re_order_issue").hide();
      });
      $("#re_order_issue_btn").click(function() {
        document.getElementById("order_issue_date").valueAsDate = new Date();
        $("#order_issue_btn").css("background-color", "");
        $("#transfer_btn").css("background-color", "");
        $("#re_order_issue_btn").css("background-color", "#adadeb");
        $("#re_transfer_btn").css("background-color", "");
        $("#approved_list_btn").css("background-color", "");
        $("#readmission_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").hide();
        $("#readmission").hide();
        $("#order_list").hide();
        $("#order_issue").hide();
        $("#re_order_list").hide();
        $("#re_order_issue").show();
      });
      $("#re_approved_list_btn").click(function() {
        $("#order_issue_btn").css("background-color", "");
        $("#approved_list_btn").css("background-color", "");
        $("#re_order_issue_btn").css("background-color", "");
        $("#re_approved_list_btn").css("background-color", "#adadeb");
        $("#transfer_btn").css("background-color", "");
        $("#readmission_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").hide();
        $("#readmission").hide();
        $("#order_list").hide();
        $("#order_issue").hide();
        $("#re_order_list").show();
        $("#re_order_issue").hide();
      });
      $("#approved_list_btn").click(function() {
        $("#order_issue_btn").css("background-color", "");
        $("#approved_list_btn").css("background-color", "#adadeb");
        $("#transfer_btn").css("background-color", "");
        $("#readmission_btn").css("background-color", "");
        $("#re_approved_list_btn").css("background-color", "");
        $("#re_order_issue_btn").css("background-color", "");
        $("#main_div").show();
        $("#transfer").hide();
        $("#readmission").hide();
        $("#order_list").show();
        $("#order_issue").hide();
        $("#re_order_list").hide();
        $("#re_order_issue").hide();
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
                  batch_no:$("#batch_no").val(),
                  order_issue_date: $("#order_issue_date").val()
                },
                function(data, status) {
                  $("#loader").hide();
                  console.log(data);
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
      $("#re_order_issue_save_btn").click(function() {
              $("#loader").show();
              $.post(
                "batch_issue.php",
                {
                  re_batch_no:$("#re_batch_no").val(),
                  re_order_issue_date: $("#re_order_issue_date").val()
                },
                function(data, status) {
                  $("#loader").hide();
                  console.log(data);
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
      
        $("#re_order_list_save_btn").click(function() {
        $("#loader").show();
        $.post(
          "batch_list.php",
          {
            re_batch_no:$("#re_batch_number").val(),
            re_from_date:$("#re_from_date").val(),
            re_to_date:$("#re_to_date").val()
          },
          function(data, status) {
            $("#loader").hide();
            console.log(data);
            if (data == "success") {
              $("#myModal").css("display", "block");
              $(".modal-content").css("background-color", "green");
              $("#message").text("Success");
              header("Location:../report_generation/order_list_admin.php");
            } else {
              $("#myModal").css("display", "block");
              $(".modal-content").css("background-color", "failed");
              $("#message").text(data);
            }
          }
        );
      });

      $("#order_list_save_btn").click(function() {
        $("#loader").show();
        $.post(
          "order_list.php",
          {
            batch_no:$("#batch_number").val(),
            from_date:$("#from_date").val(),
            to_date:$("#to_date").val()
          },
          function(data, status) {
            $("#loader").hide();
            console.log(data);
            if (data == "success") {
              $("#myModal").css("display", "block");
              $(".modal-content").css("background-color", "green");
              $("#message").text("Success");
              header("Location:../report_generation/order_list_admin.php");
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
        Transfer/Readmission cum Transfer 
      </p>
      <p id="readmission_btn" class="w3-bar-item w3-button">Readmission</p>
      
      <p id="approved_list_btn" class="w3-bar-item w3-button">Approved List</p>
      <p id="order_issue_btn" class="w3-bar-item w3-button">Order Issue</p>
      <p id="re_approved_list_btn" class="w3-bar-item w3-button">Readmission Approved List</p>
      <p id="re_order_issue_btn" class="w3-bar-item w3-button">Readmission Order Issue</p>
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
          <h4>Transfer/Readmission Cum Transfer</h4>
          <form action="transfer/add_new_transfer.php">
            <label for="u_id">Register Number</label>
            <input type="text" name="u_id" />
            <button type="submit" class="btn btn-success">Show</button>
          </form>
          <button ><a href="transfer/request_transfer.php">Add New</a></button>
        </div>
        <div id="readmission">
          <h4>Readmission</h4>
          <form action="readmission/readmission_request.php">
            <label for="u_id">Register Number</label>
            <input type="text" name="u_id" />
            <button type="submit" class="btn btn-success">Show</button>
          </form>
          <button ><a href="readmission/manual_readmission.php">Add New</a></button>
     
        </div>
        <div id="order_list">
        <button class="open-button" onclick="openForm()">Get Access</button>

        <div class="form-popup" id="myForm">
          <div class="form-container">
            <h1>Access</h1>

            <label for="admin"><b>Username</b></label>
            <input id="admin" type="text" placeholder="Username" name="admin" required>

            <label for="code"><b>Password</b></label>
            <input id="code" type="password" placeholder="Password" name="code" required>

            <button id="access" class="btn" onclick="Access()">Login</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            <button class="btn" onclick="Denied()">Log Out</button>
          </div>
  <script>
  function Denied()
        {
          document.getElementById("order_list_save_btn").disabled=true;
          document.getElementById("re_order_list_save_btn").disabled=true;
          document.getElementById("order_issue_save_btn").disabled=true;
          document.getElementById("re_order_issue_save_btn").disabled=true;
        }
      function Access()
      {
        if(document.getElementById("admin").value == "jsection")
        {
          if(document.getElementById("code").value == "admin")
          {
            document.getElementById("order_list_save_btn").disabled=false;
            document.getElementById("re_order_list_save_btn").disabled=false;
            document.getElementById("order_issue_save_btn").disabled=false;
            document.getElementById("re_order_issue_save_btn").disabled=false;
          }
        }
        
      }
  </script>
</div>
          <h4>Transfer Note Order</h4>
          <div>
          <form action="../report_generation/order_list_admin.php">
          <label for="batch_number">Batch Number</label>
          <input type="text" name="batch_number" id="batch_number" />
          <label for="from_date">From Date</label>
          <input type="date" name="from_date" id="from_date"" />
          <label for="to_date">To Date</label>
          <input type="date" name="to_date" id="to_date" />
          <button disabled id="order_list_save_btn" class="btn btn-primary">
            Generate
          </button>
          <!-- <button type="submit" class="btn btn-success">
            Download
          </button><br> -->
         </form>
         <div>
         <h4>BATCHES INFO</h4>
         <table >
         <thead>
            <tr>
              <th>Batch No</th>
              <th>Order Status</th>
              <th>From Date</th>
              <th> To Date</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            include '../user/database.php';
            if($stmt=$conn->query("select * from batch "))
            {
               
            }
            else
                {
                    echo $conn->error;
                }

            $count=1;
            while($row=$stmt->fetch_assoc()):?>
              <tr>
                <td><?php echo $row['batch_no']?></td>
                <td><?php if($row['order_status'] == 1) echo "Order Generated"; else echo "Pending";?></td>
                <td><?php echo $row['from_date']?></td>
                <td><?php echo $row['to_date']?></td>
                </tr>
              <?php endwhile?>
            </tbody>
        </table>
         </div>
          </div>
          </div>
            
      <div id="order_issue">
        <h3>Order Issue Date</h3>
        <div>
        <label for="batch_no">Batch Number</label>
          <input type="text" name="batch_no" id="batch_no" />
          <label for="order_issue_date">Issue Date</label>
          <input type="date" name="order_issue_date" id="order_issue_date" />
          <button disabled id="order_issue_save_btn" class="btn btn-success">
            Save
          </button>
        </div>

        <div>
         <h4>BATCHES INFO</h4>
         <table >
         <thead>
            <tr>
              <th>Batch No</th>
              <th>Order Status</th>
              <th>Dated</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            include '../user/database.php';
            if($stmt=$conn->query("select * from batch "))
            {
               
            }
            else
                {
                    echo $conn->error;
                }

            $count=1;
            while($row=$stmt->fetch_assoc()):?>
              <tr>
                <td><?php echo $row['batch_no']?></td>
                <td><?php if($row['order_status'] == 1) echo "Order Generated"; else echo "Pending";?></td>
                <td><?php echo $row['order_date']?></td>
                </tr>
              <?php endwhile?>
            </tbody>
        </table>
         </div>

        </div>

        <div id="re_order_list">
        
          <h4>Readmission Note Order</h4>
          <div>
          <form action="../report_generation/re_order_list_admin.php">
          <label for="re_batch_number">Batch Number</label>
          <input type="text" name="re_batch_number" id="re_batch_number" />
          <label for="re_from_date">From Date</label>
          <input type="date" name="re_from_date" id="re_from_date"" />
          <label for="re_to_date">To Date</label>
          <input type="date" name="re_to_date" id="re_to_date" />
          <button disabled id="re_order_list_save_btn" class="btn btn-primary">
            Generate
          </button>
          <!-- <button type="submit" class="btn btn-success">
            Download
          </button><br> -->
         </form>
         <div>
         <h4>BATCHES INFO</h4>
         <table >
         <thead>
            <tr>
              <th>Batch No</th>
              <th>Order Status</th>
              <th>From Date</th>
              <th> To Date</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            include '../user/database.php';
            if($stmt=$conn->query("select * from re_batch "))
            {
               
            }
            else
                {
                    echo $conn->error;
                }

            $count=1;
            while($row=$stmt->fetch_assoc()):?>
              <tr>
                <td><?php echo $row['batch_no']?></td>
                <td><?php if($row['order_status'] == 1) echo "Order Generated"; else echo "Pending";?></td>
                <td><?php echo $row['from_date']?></td>
                <td><?php echo $row['to_date']?></td>
                </tr>
              <?php endwhile?>
            </tbody>
        </table>
         </div>
          </div>
          </div>
            
          <div id="re_order_issue">
        <h3>Readmission Order Issue Date</h3>
        <div>
        <label for="re_batch_no">Batch Number</label>
          <input type="text" name="re_batch_no" id="re_batch_no" />
          <label for="re_order_issue_date">Issue Date</label>
          <input type="date" name="re_order_issue_date" id="re_order_issue_date" />
          <button disabled id="re_order_issue_save_btn" class="btn btn-success">
            Save
          </button>
        </div>

        <div>
         <h4>BATCHES INFO</h4>
         <table >
         <thead>
            <tr>
              <th>Batch No</th>
              <th>Order Status</th>
              <th>Dated</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            include '../user/database.php';
            if($stmt=$conn->query("select * from re_batch "))
            {
               
            }
            else
                {
                    echo $conn->error;
                }

            $count=1;
            while($row=$stmt->fetch_assoc()):?>
              <tr>
                <td><?php echo $row['batch_no']?></td>
                <td><?php if($row['order_status'] == 1) echo "Order Generated"; else echo "Pending";?></td>
                <td><?php echo $row['order_date']?></td>
                </tr>
              <?php endwhile?>
            </tbody>
        </table>
         </div>

        </div>

      </div>
      </div>
  </body>
</html>
