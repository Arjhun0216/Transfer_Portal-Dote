<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
include '../user/database.php';
//echo $_SESSION['c_code'];
$sql="select reg_no,name_of_student,tcollege,b_name,sem_to,tcollege_sanctioned_intake,tcollege_total_students,tcollege_total_after,freezed_to from transfer_details where reg_no='".$_GET['u_id']."' and tcollege_c_code=".$_SESSION['c_code'];
if($stmt=$conn->query($sql)) { if($stmt->num_rows<=0) die("INVALID");
$result=$stmt->fetch_assoc(); } ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>College Details</title>
    <!--  meta tags -->
    <meta charset="utf-8" />

    <!-- Bootstrap CSS -->
    <style>
      .switch {
        position: relative;
        display: inline-block;
        width: 70px;
        height: 40px;
      }

      .switch input {
        opacity: 0;
        width: 0;
        height: 0;
      }

      .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: 0.4s;
        transition: 0.4s;
      }

      .slider:before {
        position: absolute;
        content: "";
        height: 33px;
        width: 33px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: 0.4s;
        transition: 0.4s;
      }

      input:checked + .slider {
        background-color: #2196f3;
      }

      input:focus + .slider {
        box-shadow: 0 0 1px #2196f3;
      }

      input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
        border-radius: 34px;
      }

      .slider.round:before {
        border-radius: 50%;
      }
    </style>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="transfer.css" />
    <link rel="stylesheet" href="../../styles/loader.css" />
    <link rel="stylesheet" href="../../styles/modal.css" />
    <!-- <link rel="stylesheet" href="loader.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#loader").hide();
        
        var isFreezed=<?php if( isset($result['freezed_to']) && $result['freezed_to']==1) echo "true"; else echo "false"; ?>;
        $("#print").click(function() {
          //alert("HEllo");
          if(isFreezed)
          window.location.href =
          "../report_generation/to_college.php?u_id=" + $("#unique_no").val();
            else{
              $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Please freeze and submit to Print");
      return false;
            }
        });

        $("#submit").click(function() {
          if ($("#freeze").is(":checked")) {
            if (
              !confirm(
                "Once You Freeze You can not able to edit this data, Do you really want to Freeze?"
              )
            ) {
              return;
            }
          }
          $.post(
            "vacancy_info_update.php",
            {
              reg_no: $("#unique_no").val(),
              tcollege_sanctioned_intake: $("#sac_intake").val(),
              tcollege_total_students: $("#total_stu").val(),
              tcollege_total_after: $("#tcollege_total_after").val(),
              freezed_to: $("#freeze").is(":checked") ? 1 : 0
            },
            function(data, status) {
              if (data == "success") {
                isFreezed=$("#freeze").is(":checked");
                $("#submit").prop("disabled", $("#freeze").is(":checked"));
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "#baf1a1");
                $("#message").text("Success Updated");
              } else {
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "red");
                $("#message").text(data);
              }
            }
          );
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
      });
    </script>
  </head>
  <body>
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content" style="width:50%;background-color: #f08585;">
        <span class="close" style="margin-left:80%;">&times;</span>
        <h5 id="message" style="color:white;"></h5>
      </div>
    </div>
    <div id="loader"></div>

    <div
      style="margin: 0px auto;width: 40%; border: 1px solid gainsboro; padding: 1%;"
    >
      <h3 style="margin: 0px auto;text-align: center;">Student Details</h3>
      <p style="margin: 0px auto;text-align: center;">
        (The Details of student be filled up below)
      </p>
      <hr />
      <div class="box-body">
        <div>
          <label>Endorsement No</label>
          <input
            autocomplete="off"
            class="form-control"
            readonly
            id="unique_no"
            type="text"
            value="<?php echo $result['reg_no']; ?>"
            style="text-transform:uppercase"
          />
        </div>
        <div>
          <label>Name of the Student</label>
          <input
            autocomplete="off"
            class="form-control"
            readonly
            id="name"
            type="text"
            value="<?php echo $result['name_of_student']; ?>"
            style="text-transform:uppercase"
          />
        </div>

        <div>
          <label>College Name</label>
          <input
            autocomplete="off"
            class="form-control"
            readonly
            id="college"
            type="text"
            value="<?php echo $result['tcollege']; ?>"
            style="text-transform:uppercase"
          />
        </div>

        <div>
          <label>Branch Name</label>
          <input
            autocomplete="off"
            class="form-control"
            readonly
            id="b_name"
            type="text"
            value="<?php echo $result['b_name']; ?>"
            style="text-transform:uppercase"
          />
        </div>

        <div>
          <label>Semester in which transfer is requested</label>
          <input
            autocomplete="off"
            class="form-control"
            id="semester"
            readonly
            type="text"
            value="<?php echo $result['sem_to']; ?>"
            style="text-transform:uppercase"
          />
        </div>

        <div>
          <label
            >Sanctioned intake in the branch in this respective academic
            year</label
          >
          <input
            autocomplete="off"
            class="form-control"
            id="sac_intake"
            type="text"
            value="<?php echo $result['tcollege_sanctioned_intake']; ?>"
            style="text-transform:uppercase"
          />
        </div>

        <div>
          <label
            >Total No. of students on Roll in this branch and semester as on
            date</label
          >
          <input
            autocomplete="off"
            class="form-control"
            id="total_stu"
            type="text"
            value="<?php echo $result['tcollege_total_students']; ?>"
            style="text-transform:uppercase"
          />
        </div>
        <div>
          <label
            >Total No. of students in this branch and semester including the
            transfer</label
          >
          <input
            autocomplete="off"
            class="form-control"
            id="tcollege_total_after"
            type="text"
            value="<?php echo $result['tcollege_total_after']; ?>"
            style="text-transform:uppercase"
          />
        </div>
        <div style="margin: 0px auto;text-align: center;">
          <h3>Do You want to freeze?</h3>
          <label class="switch">
            <input type="checkbox" id="freeze"
            <?php if($result['freezed_to']=='1') echo "checked"; ?>/>
            <span class="slider round"></span>
          </label>
        </div>
      </div>
    </div>

    <div style="margin: 2px auto; text-align: center;">
      <button  class="btn btn-success" id="submit" <?php if($result['freezed_to']=='1') echo "disabled";?>>Submit</button>
      <button class="btn btn-primary" id="print">Print</button>
      <a href="../user/" class="btn btn-warning">Home</a>
      <a href="../user/#to" class="btn btn-info">Back</a>
    </div>
  </body>
</html>
