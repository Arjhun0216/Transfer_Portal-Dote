<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>Change Password</title>
    <link rel="stylesheet" href="../../courses/bootstrap.min.css" />
    <link rel="stylesheet" href="../../courses/loader.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#msg").css("display", "block");
        $("#msg").hide();
        $("#loader").hide();
        $("#save").click(function() {
          if ($("#newpass").val() == "" || $("#newpass").val().length < 8) {
            $("#msg").show();
            $("#msg")
              .removeClass("alert alert-success")
              .addClass("alert alert-danger");
            $("#msg")
              .delay(5000)
              .fadeOut();
            $("#msg").text("A valid Password must contain 8 characters");
            return;
          } else {
            $("#loader").show();
            //header("Location:update_pass.php");
            $.post("../update_pass.php",
              {
                pass: $("#newpass").val()
              },
              function(data, status) {
                $("#loader").hide();
                
                if (data === "Success") {
                  
                  $("#msg").show();
                  $("#msg")
                    .removeClass("alert alert-danger")
                    .addClass("alert alert-success");
                  $("#msg").text("Password Changed Successfully");
                  $("#msg")
                    .delay(5000)
                    .fadeOut();
                } else {
                  $("#msg").show();
                  $("#msg")
                    .removeClass("alert alert-success")
                    .addClass("alert alert-danger");
                  $("#msg").text(data);
                  $("#msg")
                    .delay(5000)
                    .fadeOut();
                }
              }
            );
          }
        });
      });
    </script>
  </head>
  <body>
    <div  style="text-align: center;width:50%;margin:0px auto;">
      <div
        id="msg"
        class="alert alert-danger"
        style="display: none;"
        role="alert"
      >
        Something went Wrong!!!
      </div>
      <h4>Change Password</h4>
      <br />
      <div class="form-group row" style="border: black; border-width: 20px;">
        <div class="col col-4">
          <label name="New password">New Password</label>
        </div>
        <div class="col col-4">
          <input class="form-control" type="password" id="newpass" />
        </div>
      </div>

      <div class="form-group row  align-items-center">
        <div class="col">
          <button id="save" class="btn btn-success">Save</button>
        </div>
      </div>
    </div>
  </body>
</html>
