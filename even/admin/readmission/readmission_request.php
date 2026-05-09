<?php
session_start();
if(!isset($_SESSION['admin_login']))
{
    die("INVALID REQUEST");
}
include '../../user/database.php';
$sql1="select c_code,name_of_college_with_address from college_details";
if($stmt1=$conn->query($sql1))
{

}
else
{
  die("Something went wrong");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Re-Admission</title>
    <link rel="stylesheet" href="../../css/adminlte.min.css" />
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="style1.css" />
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
     <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#loader").hide();
        $("#print").click(function() {
          window.location.href =
            "../index.php";
        });
        $.urlParam = function(name) {
          var results = new RegExp("[\?&]" + name + "=([^&#]*)").exec(
            window.location.href
          );
          if (results == null) {
            return null;
          }
          return decodeURI(results[1]) || 0;
        };
        if ($.urlParam("u_id") != null) {
          $("#loader").show();
          $.post(
            "fetch_data.php",
            {
              u_id: $.urlParam("u_id")
            },
            function(data, status) {
              $("#loader").hide();

              //var objectN = {}.constructor;
              if (data == "no_record") {
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "#ff6666");
                $("#message").text("No data exists");
              } else {
                try {
                  var result = $.parseJSON(data);
                  $.each(result, function(key, value) {
                    $("#college_name").val(value["c_code"]),
                    $("#reg_no").val(value["reg_no"]),
                      $("#name_of_student").val(value["name_of_student"]),
                      $("#address1").val(value["address1"]),
                      $("#address2").val(value["address2"]),
                      $("#district").val(value["district"]),
                      $("#pincode").val(value["pincode"]),
                      $("#mobile").val(value["mobile"]),
                      $("#email").val(value["email"]),
                      $("#b_name").val(value["b_name"]),
                      $("#lack_attendence_sem").val(
                        value["lack_attendence_sem"]
                      ),
                      $("#month_of_admission").val(value["month_of_admission"]),
                      //$("#month_of_admission_autonomous").val(value['month_of_admission_autonomous']),
                      $("#year_of_admission").val(value["year_of_admission"]),
                      $("#mode_of_admission").val(value["mode_of_admission"]),
                      $("#discontinued_sem").val(value["discontinued_sem"]),
                      $("#discontinued_year").val(value["discontinued_year"]),
                      $("#readmission_sougth_sem").val(
                        value["readmission_sougth_sem"]
                      ),
                      $("#readmission_sougth_year").val(
                        value["readmission_sougth_year"]
                      ),
                      $("#reason").val(value["reason"]),
                      $("#total_periods").val(value["total_periods"]),
                      $("#total_attended").val(value["total_attended"]),
                      $("#percentage").val(value["percentage"]),
                      $("#tnea_reg_no").val(value["tnea_reg_no"]),
                      $("#community").val(value["community"]),
                      $("#quota").val(value["quota"]),
                      $("#fg").val(value["fg"]),
                      $("#pms").val(value["pms"]),
                      $("#admin_reason").val(value["admin_reason"]),
                      $("#approved").val(value["approved"]),
                      $("#freeze").prop(
                        "checked",
                        value["freezed"] == "1" ? true : false
                      );
                  });
                  //$("#submit").prop("disabled", $("#freeze").is(":checked"));
                } catch (error) {
                  alert(data);
                  $("#myModal").css("display", "block");
                  $(".modal-content").css("background-color", "#ff6666");
                  $("#message").text(error);
                }
              }
            }
          );
        }
        $("#submit").click(function() {
          $("#loader").show();
          $.post(
            "status_update.php",
            {
              approved: $("#approved").val(),
              admin_reason: $("#admin_reason").val(),
              reg_no: $("#reg_no").val(),
              college_name:$("#college_name").val(),
              name_of_student: $("#name_of_student").val(),
              address1: $("#address1").val(),
              address2: $("#address2").val(),
              district: $("#district").val(),
              pincode: $("#pincode").val(),
              mobile: $("#mobile").val(),
              email: $("#email").val(),
              tnea_reg_no: $("#tnea_reg_no").val(),
              community: $("#community").val(),
              quota: $("#quota").val(),
              fg: $("#fg").val(),
              pms: $("#pms").val(),
              month_of_admission: $("#month_of_admission").val(),
              year_of_admission: $("#year_of_admission").val(),
              mode_of_admission: $("#mode_of_admission").val(),
              b_name: $("#b_name").val(),
              discontinued_sem: $("#discontinued_sem").val(),
              discontinued_year: $("#discontinued_year").val(),
              readmission_sougth_sem: $("#readmission_sougth_sem").val(),
              readmission_sougth_year: $("#readmission_sougth_year").val(),
              reason: $("#reason").val(),
              lack_attendence_sem: $("#lack_attendence_sem").val(),
              total_periods: $("#total_periods").val(),
              total_attended: $("#total_attended").val(),
              percentage: $("#percentage").val(),
              freezed: $("#freeze").is(":checked") == true ? 1 : 0
            },
            function(data, status) {
              //console.log(data);
              $("#loader").hide();
              if (data == "success") {
                //$("#submit").prop("disabled", $("#freeze").is(":checked"));
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "green");
                $("#message").text("Successfully Submitted and status Updated");
              } else {
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "#ff6666");
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
    <div class="container">
      <div class="row" style="margin-top: 3%;">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">
              Application Form For Re-Admission to UG/PG
            </h3>
          </div>
        </div>

        <div class="box-body col-md-6">
        <div class="form-group">
            <div >
              <label for="college_name" class="control-label">College Name</label>
            </div>
            <div class="col-sm-6">
              <select name="college_name" id="college_name" class="form-control">
               <option value=""></option>
              <?php
                while($row1=$stmt1->fetch_assoc()):
              ?>
              <option value="<?php echo $row1['c_code']; ?>"><?php echo $row1['c_code']."-".$row1['name_of_college_with_address']; ?></option>
              <?php endwhile?>
             </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="anna_reg_no" class="control-label"
                >Anna University Register No.</label
              >
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="reg_no"
                name="anna_reg_no"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="name_of_stu" class="control-label"
                >Name of the Student</label
              >
            </div>
            <div class="col-sm-8">
              <input
                autocomplete="off"
                class="form-control"
                id="name_of_student"
                name="name_of_stu"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="address1" class="control-label">Address 1</label>
            </div>
            <div class="col-sm-10">
              <input
                autocomplete="off"
                class="form-control"
                id="address1"
                name="address1"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="address2" class="control-label">Address 2</label>
            </div>
            <div class="col-sm-10">
              <input
                autocomplete="off"
                class="form-control"
                id="address2"
                name="address2"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="district" class="control-label">District</label>
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="district"
                name="district"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="pincode" class="control-label">Pincode</label>
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="pincode"
                name="pincode"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="mobile" class="control-label">Mobile</label>
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="mobile"
                name="mobile"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="email-id" class="control-label">Email-Id</label>
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="email"
                name="email-id"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="tnea_reg_no" class="control-label"
                >TNEA Reg.No.</label
              >
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="tnea_reg_no"
                name="tnea_reg_no"
                type="text"
                value=""
              />
            </div>
          </div>
        </div>

        <div class="box-body col-md-6">
          <div class="form-group">
            <div class="col-sm-6">
              <label for="community" class="control-label">Community</label>
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="community">
                <option></option>
                <option value="BC">BC</option>
                <option value="OC">OC</option>
                <option value="BCM">BCM</option>
                <option value="MBC">MBC/DNC</option>
                <option value="SC">SC</option>
                <option value="SCA">SCA</option>
                <option value="ST">ST</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="quota" class="control-label">Quota</label>
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="quota">
                <option></option>
                <option value="GOVERNMENT">GOVERNMENT</option>
                <option value="MANAGEMENT">MANAGEMENT</option>
                <option value="MIN">MIN</option>
                <option value="LAP">LAP</option>
                <option value="NRI">NRI</option>
                <option value="GOI">GOI</option>
                <option value="FOR">FOR</option>
                      </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-10">
              <label for="fg" class="control-label"
                >Whether First graduate amount claimed for 2024-2024</label
              >
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="fg">
                <option></option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-10">
              <label for="pms" class="control-label"
                >Whether Post Matric Scholarship claimed for 2024-2024</label
              >
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="pms">
                <option></option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="month_admission" class="control-label"
                >Month of Admission</label
              >
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="month_of_admission">
                <option></option>
                <option value="JAN">January</option>
                <option value="FEB">Feburary</option>
                <option value="MAR">March</option>
                <option value="APR">April</option>
                <option value="MAY">May</option>
                <option value="JUN">June</option>
                <option value="JUL">July</option>
                <option value="AUG">August</option>
                <option value="SEP">September</option>
                <option value="OCT">October</option>
                <option value="NOV">November</option>
                <option value="DEC">December</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="year_admission" class="control-label"
                >Year of Admission</label
              >
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="year_of_admission"
                name="year_of_admission"
                type="number"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-10">
              <label for="stu_admit_mode" class="control-label"
                >Through Which mode the student was originally admitted</label
              >
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="mode_of_admission">
              <option value="UG-DIRECT SECOND YEAR">UG-DIRECT SECOND YEAR</option>
              
              <option value="PG-FIRST YEAR">PG-FIRST YEAR </option>
                <option value="UG-FIRST YEAR">UG-FIRST YEAR</option>
                <option value="UG-PART TIME">UG-PART TIME</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="branch_study" class="control-label"
                >Branch of Study</label
              >
            </div>
            <div class="col-sm-10">
            <input
                autocomplete="off"
                class="form-control"
                id="b_name"
                name="b_name"
                type="text"
                value=""
              />
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="table-box">
            <div
              class="table-row table-head"
              style="padding-bottom: 0px;line-height: 5px;"
            >
              <div
                class="table-cell first-cell"
                style="padding-top:5px;padding-bottom:0px;"
              >
                <p>Description</p>
              </div>
              <div class="table-cell">
                <p>Semester</p>
              </div>
              <div class="table-cell last-cell">
                <p>Year</p>
              </div>
            </div>

            <div class="table-row">
              <div class="table-cell first-cell">
                <p>Semester/Year during which the course was Discontinued</p>
              </div>
              <div class="table-cell">
                <select
                  class="form-control"
                  id="discontinued_sem"
                  style="margin:5px auto;width:50%"
                >
                  <option></option>
                  <option value="2">II</option>
                  <option value="4">IV</option>
                  <option value="6">VI</option>
                  <option value="8">VIII</option>
                  <option value="10">X</option>
                </select>
              </div>
              <div class="table-cell last-cell">
                <input
                  class="form-control"
                  id="discontinued_year"
                  style="margin:5px auto;width:50%"
                />
              </div>
            </div>

            <div class="table-row">
              <div class="table-cell first-cell">
                <p>Semester/Year during which Readmission is Sought</p>
              </div>
              <div class="table-cell">
                <input
                  id="readmission_sougth_sem"
                  name="readd_semester"
                  type="text"
                  class="form-control"
                  style="margin:5px auto;width:50%"
                />
              </div>
              <div class="table-cell last-cell">
                <input
                  type="text"
                  class="form-control"
                  id="readmission_sougth_year"
                  name="readd_year"
                  style="margin:5px auto;width:50%"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row" style="margin-top: 2%;">
        <div class="col-md-6">
          <div class="form-group">
            <div class="col-sm-8">
              <label for="reason_discontinuance" class="control-label"
                >Reason for Discontinuance of study</label
              >
            </div>
            <div class="col-sm-10">
              <textarea
                autocomplete="off"
                class="form-control"
                id="reason"
                name="reason_discontinuance"
                rows="2"
                columns="100"
              ></textarea>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-10">
              <label for="lack_attendance" class="control-label"
                >Mention the Even Semester in which the student was put into lack
                of attendance(II, IV, VI, VIII,X)
              </label>
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="lack_attendence_sem">
                <option></option>
                <option value="2">II</option>
                  <option value="4">IV</option>
                  <option value="6">VI</option>
                  <option value="8">VIII</option>
                  <option value="10">X</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-10">
              <label for="sem_attendance" class="control-label"
                >Total No. of Periods taken into account for calculation of
                attendance for the above Semester</label
              >
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="total_periods"
                name="sem_attendance"
                type="text"
                value=""
              />
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <div class="col-sm-6">
              <label for="att_periods" class="control-label"
                >No. of Periods attended by the student</label
              >
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="total_attended"
                name="att_periods"
                type="text"
                value=""
              />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-6">
              <label for="att_per" class="control-label"
                >Percentage of the Attendance</label
              >
            </div>
            <div class="col-sm-6">
              <input
                autocomplete="off"
                class="form-control"
                id="percentage"
                name="att_per"
                type="text"
                value=""
              />
            </div>
            <div class="col-sm-6">
              <h4>Do you want to Freeze?</h4>
              <label class="switch">
                <input type="checkbox" id="freeze" />
                <span class="slider round"></span>
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
        <div class="box-body">
          <table>
            <col width="200">
            <col width="600">
            <tr>
              <td>Approval Status</td>
              <td>
                <select type="number" class="form-control" id="approved">
                  <option value="0"></option>
                  <option value="1">Approved</option>
                  <option value="3">Not Approved</option>
                  <option value="2">Pending</option>
                  <option value="4" disabled>Order Generated</option>
    </select>
              </td>
            </tr>
            <br>
            <tr>
              <td>Reason</td>
              <td>
                <input type="text" class="form-control" id="admin_reason">
              </td>
            </tr>
    </table>
    </div>
    <br>
          <div class="box box-primary">
            <div class="box-header with-border text-center">
              <button
                id="submit"
                class="btn btn-primary waves-effect waves-light"
                type="submit"
                value="Submit"
                name="actionType"
              >
                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                Submit
              </button>
              <button
                class="btn btn-inverse waves-effect waves-light"
                id="print"
              >
                Home
              </button>
           
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
