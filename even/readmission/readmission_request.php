<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Re-Admission</title>
    <link rel="stylesheet" href="../css/adminlte.min.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
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
    <link rel="stylesheet" href="../../styles/modal.css" />
    <link rel="stylesheet" href="../../styles/loader.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
      $(document).ready(function () {
        var isUploadSuccessful = 0;
      var value1 = "";
        $("#loader").hide();
        $("#print").click(function () {
          
          if($("#freeze").is(":checked"))
          {
          window.location.href =
            "../report_generation/readmission.php?u_id=" + $("#reg_no").val();
        }
           else{
              $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Please freeze and submit to Print");
      return false;
            }

          window.location.href =
            "../report_generation/readmission.php?u_id=" + $("#reg_no").val();
        });
        $.urlParam = function (name) {
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
              u_id: $.urlParam("u_id"),
            },
            function (data, status) {
              $("#loader").hide();
              //var objectN = {}.constructor;
              if (data == "no_record") {
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "#ff6666");
                $("#message").text("No data exists");
              } else {
                try {
                  //console.log(data);
                  var result = $.parseJSON(data);
                  $.each(result, function (key, value) {
                    $("#reg_no").val(value['reg_no']);
                  var c_code = "<?php echo $_SESSION['c_code']; ?>";
                  var link = 'all_previous_marksheet/' + c_code + '_' + $("#reg_no").val() + '.pdf';
                  async function checkFileExists(url) {
                    try {
                      const response = await fetch(url, {
                        method: 'HEAD'
                      });
                      if (response.ok) {
                        isUploadSuccessful = 1;
                        // alert(link);
                        var linkHtml = ' <div><label>Click here to view the PDF File</label></div><a href="' + link + '" target="_blank" style="color: #007bff;text-decoration: none; font-weight: bold; border: 1px solid #007bff; padding: 5px 10px;margin-left:20px; border-radius: 5px; background-color: #f2f2f2;">' + c_code + "_" + $("#reg_no").val() + '.pdf</a>';
                        $("#displaypdf").html(linkHtml);
                        // console.log('File exists');
                      }
                      // else {
                      //     // console.log('File does not exist');
                      // }
                    } catch (error) {
                      // console.log('File does not exist');
                    }
                  }

                  // Replace with the URL of the file you want to check
                  const fileUrl = link;
                  checkFileExists(fileUrl);
                    $("#reg_no").val(value["reg_no"]),
                      $("#name_of_student").val(value["name_of_student"]),
                      $("#dob").val(value["dob"]),
                      // $("#address1").val(value["address1"]),
                      // $("#address2").val(value["address2"]),
                      // $("#district").val(value["district"]),
                      // $("#pincode").val(value["pincode"]),
                      $("#mobile").val(value["mobile"]),
                      // $("#email").val(value["email"]),
                      $("#b_name").val(value["b_name"]),
                      $("#lack_attendence_sem").val(value["lack_attendence_sem"]),
                      // $("#month_of_admission").val(value["month_of_admission"]),
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
                      // $("#tnea_reg_no").val(value["tnea_reg_no"]),
                      $("#college_autonomous").val(value["college_autonomous"]),
                      $("#autonomous_year").val(value["autonomous_year"]),
                      $("#college_autonomous").val(value["college_autonomous"]),
                    $("#autonomous_year").val(value["autonomous_year"]),
                      $("#community").val(value["community"]),
                      $("#quota").val(value["quota"]),
                      // $("#fg").val(value["fg"]),
                      // $("#pms").val(value["pms"]),
                      $("#freeze").prop(
                        "checked",
                        value["freezed"] == "1" ? true : false
                      );
                  });
                  $("#uploadBtn").prop("disabled", $("#freeze").is(':checked'));
                  $("#submit").prop("disabled", $("#freeze").is(":checked"));
                } catch (error) {
                 // alert(data);
                  $("#myModal").css("display", "block");
                  $(".modal-content").css("background-color", "#ff6666");
                  $("#message").text(error);
                }
              }
            }
          );
        }

function validation()
{
  if($("#reg_no").val()=="" || $("#reg_no").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Register Number");
    return false;
  }
  if($("#name_of_student").val()=="" || $("#name_of_student").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Name of Student");
      return false;
  }
  if($("#dob").val()=="" || $("#dob").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter the date of birth");
      return false;
  }
  // if($("#address1").val()=="" || $("#address1").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Enter Address");
  //     return false;
  // }
  // if($("#address2").val()=="" || $("#address2").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Enter Address2");
  //     return false;
  // }
  
  // if($("#district").val()=="" || $("#district").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Enter District");
  //     return false;
  // }
  // if($("#pincode").val()=="" || $("#pincode").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Enter Pincode");
  //     return false;
  // }
  if($("#mobile").val()=="" || $("#mobile").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Mobile");
      return false;
  }
  // if($("#email").val()=="" || $("#email").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Enter Email");
  //     return false;
  // }  
  // if($("#tnea_reg_no").val()=="" || $("#tnea_reg_no").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Enter TNEA Register Number");
  //     return false;
  // }
  if ($("#college_autonomous").val() == "" || $("#college_autonomous").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Select College autonomous");
          return false;
        }
        if (($("#autonomous_year").val() == "" || $("#autonomous_year").val() == null) && ($("#college_autonomous").val() == '1')) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Select College autonomous year");
          return false;
        }
  if($("#community").val()=="" || $("#community").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Community");
      return false;
  }
  if($("#quota").val()=="" || $("#quota").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Quota");
      return false;
  }
  // if($("#fg").val()=="" || $("#fg").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Whether First Graduate or Not");
  //     return false;
  // }if($("#pms").val()=="" || $("#pms").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("whether Post Metric Scholarship");
  //     return false;
  // }

  if($("#year_of_admission").val()=="" || $("#year_of_admission").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Year of Admission ");
      return false;
  }
  // if($("#month_of_admission").val()=="" || $("#month_of_admission").val()==null)
  // {
  //   $("#myModal").css("display","block");
  //   $(".modal-content").css("background-color","#ff6666");
  //   $("#message").text("Enter Month of Admission");
  //     return false;
  // }
  if($("#mode_of_admission").val()=="" || $("#mode_of_admission").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Mode of Admission");
      return false;
  }
  if($("#b_name").val()=="" || $("#b_name").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select Branch Name");
      return false;
  }
  if($("#discontinued_sem").val()=="" || $("#discontinued_sem").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select Discontinude Sem");
      return false;
  }
  if($("#discontinued_year").val()=="" || $("#discontinued_year").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select Discontinude Year");
      return false;
  }
  if($("#readmission_sougth_sem").val()=="" || $("#readmission_sougth_sem").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select Readmission Sought Sem");
      return false;
  }
  if($("#readmission_sougth_year").val()=="" || $("#readmission_sougth_year").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select Readmission Sought Year");
      return false;
  }
  if($("#reason").val()=="" || $("#reason").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Reason ");
      return false;
  }
  if($("#lack_attendence_sem").val()=="" || $("#lack_attendence_sem").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Lack Attendance Sem");
      return false;
  }
  if($("#total_periods").val()=="" || $("#total_periods").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Total No. of Periods");
      return false;
  }
  if($("#total_attended").val()=="" || $("#total_attended").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter  Attended Periods");
      return false;
  }
  if($("#percentage").val()=="" || $("#percentage").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Percentage");
      return false;
  }
  if (isUploadSuccessful == 0) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Upload PDF File!!");
          return false;
        }
  return true;
          
}
$("#discontinued_sem").change(function() {
        $("#readmission_sougth_sem").val($("#discontinued_sem").val());
      });
      $("#discontinued_sem").change(function() {
        $("#lack_attendence_sem").val($("#discontinued_sem").val());
      });

      $("#uploadBtn").click(function() {
        var formData = new FormData();
        var files = $('#pdf_upload')[0].files[0];
        if (files) {
          showLoading();
          formData.append('file', files);
          formData.append('reg_no', $("#reg_no").val());
          $.ajax({
            url: 'pdfUpload.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              hideLoading();
              if (response != 0) {
                isUploadSuccessful = 1;
                value1 = response;
                // var baseURL = window.location.protocol + "//" + window.location.host;
                // var fullURL = baseURL + '/' + pdfLocation;
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "#33ff33");
                $("#message").text("File uploaded successfully");
                var linkHtml = ' <div><label>Click here to view the PDF File</label></div><a href="all_previous_marksheet/' + value1 + '.pdf" target="_blank" style="color: #007bff; text-decoration: none; font-weight: bold; border: 1px solid #007bff; padding: 5px 10px; border-radius: 5px; background-color: #f2f2f2;">' + value1 + '.pdf</a>';
                $("#displaypdf").html(linkHtml);

              } else {
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "#ff6666");
                $("#message").text("File not Uploaded!!");
                return;
              }
            },
          });
        } else {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Upload PDF first!!");
          return;
        }
      });

        $("#submit").click(function () {
          if(!validation())
          {
            return;
          }
          $("#loader").show();
          if ($("#freeze").is(":checked")) {
            if (!confirm("Once You freeze You may not allowed to edit data")) {
              return;
            }
          }
          $.post(
            "readmission_update.php",
            {
              reg_no: $("#reg_no").val(),
              name_of_student: $("#name_of_student").val().toUpperCase(),
              dob: $("#dob").val(),
              //address1: $("#address1").val(),
              //address2: $("#address2").val(),
              //district: $("#district").val(),
              //pincode: $("#pincode").val(),
              college_autonomous: $("#college_autonomous").val(),
            autonomous_year: $("#autonomous_year").val(),
              mobile: $("#mobile").val(),
              //email: $("#email").val(),
              //tnea_reg_no: $("#tnea_reg_no").val(),
              community: $("#community").val(),
              quota: $("#quota").val(),
              //fg: $("#fg").val(),
              //pms: $("#pms").val(),
              //month_of_admission: $("#month_of_admission").val(),
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
              freezed: $("#freeze").is(":checked") == true ? 1 : 0,
            },
            function (data, status) {
              $("#loader").hide();
              if (data == "success") {
                $("#uploadBtn").prop("disabled", $("#freeze").is(':checked'));
                $("#submit").prop("disabled", $("#freeze").is(":checked"));
                $("#myModal").css("display", "block");
                $(".modal-content").css("background-color", "green");
                $("#message").text("Successfully Submitted");
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
        span.onclick = function () {
          modal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        };

        $("#loader").hide();

function clearme(isTrue = false) {
  if (isTrue)
    $("#displaypdf").html(null);
  $("#pdf_upload").val(null);
}

function showLoading() {
  $("#loader").show();
  $("input").prop("disabled", true);
  $("button").prop("disabled", true);
}

function hideLoading() {
  $("#loader").hide();
  $("input").prop("disabled", false);
  $("button").prop("disabled", false);
}
      });
    </script>
  </head>
   <body>
   <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content" style="width: 50%; background-color: #f08585;">
      <span class="close" style="margin-left: 80%;">&times;</span>
      <h5 id="message" style="color: white;"></h5>
    </div>
  </div>
  <div id="loader"></div>
  <div class="container">
    <div class="row" style="margin-top: 3%;">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">
            Application Form For EVEN Sem Re-Admission to UG/PG
          </h3>
        </div>
      </div>

      <div class="box-body col-md-6">
        <div class="form-group">
          <div class="col-sm-6">
            <label for="college" class="control-label">Name of the College</label>
          </div>
          <div>
            <input autocomplete="off" class="form-control" id="college" name="college" readonly value="<?php echo $_SESSION['c_code'] . "-" . $_SESSION['college_name']; ?>" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-6">
            <label for="anna_reg_no" class="control-label">Anna University Register No.</label>
          </div>
          <div class="col-sm-6">
            <input autocomplete="off" class="form-control" id="reg_no" name="reg_no" type="text" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-6">
            <label for="name_of_stu" class="control-label">Name of the Student</label>
          </div>
          <div class="col-sm-8">
            <input autocomplete="off" class="form-control" id="name_of_student" name="name_of_stu" type="text" style="text-transform:uppercase;" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-6">
            <label for="dob" class="control-label">Date of birth</label>
          </div>
          <div class="col-sm-8">
            <input autocomplete="off" class="form-control" id="dob" name="dob" type="date" />
          </div>
        </div>

        <!-- <div class="form-group">
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
              />
            </div>
          </div> -->

        <div class="form-group">
          <div class="col-sm-6">
            <label for="mobile" class="control-label">Mobile</label>
          </div>
          <div class="col-sm-6">
            <input autocomplete="off" class="form-control" id="mobile" name="mobile" type="text" />
          </div>
        </div>

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

        <!-- <div class="form-group">
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
              />
            </div>
          </div> -->

        <!-- <div class="form-group">
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
              />
            </div>
          </div> -->
      </div>

      <div class="box-body col-md-6">
        <div class="form-group">
          <div class="col-sm-6">
            <label for="college_autonomous" class="control-label">Autonomous</label>
          </div>
          <div class="col-sm-6">
            <select class="form-control" name="college_autonomous" id="college_autonomous">
              <option value=""></option>
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
        </div>
        <!-- <div class="form-group" id="autonomous_years"> -->
        <div class="form-group">
          <div class="col-sm-6">
            <label for="autonomous_year" class="control-label">Autonomous Year (if autonomous, then fill it)</label>
          </div>
          <div class="col-sm-6">
            <input autocomplete="off" class="form-control" id="autonomous_year" name="autonomous_year" val="" />
          </div>
        </div>


        <!-- <div class="form-group">
            <div class="col-sm-10">
              <label for="fg" class="control-label"
                >Whether First graduate amount claimed for 2021-2023</label
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
                >Whether Post Matric Scholarship claimed for 2021-2023</label
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
          </div> -->

        <div class="form-group">
          <div class="col-sm-6">
            <label for="year_admission" class="control-label">Year of Admission</label>
          </div>
          <div class="col-sm-6">
            <input autocomplete="off" class="form-control" id="year_of_admission" name="year_of_admission" type="number" value="" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-10">
            <label for="stu_admit_mode" class="control-label">Through Which mode the student was originally admitted</label>
          </div>
          <div class="col-sm-6">
            <select class="form-control" id="mode_of_admission">
              <option></option>
              <option value="UG-DIRECT SECOND YEAR">UG-DIRECT SECOND YEAR</option>

              <option value="PG-FIRST YEAR">PG-FIRST YEAR </option>
              <option value="UG-FIRST YEAR">UG-FIRST YEAR</option>
              <option value="UG-PART TIME">UG-PART TIME</option>
              <option value="PG-PART TIME">PG-PART TIME</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-6">
            <label for="branch_study" class="control-label">Branch of Study</label>
          </div>
          <div class="col-sm-10">
            <!-- <input
                autocomplete="off"
                class="form-control"
                id="b_name"
                name="b_name"
                type="text"
                value=""
              /> -->
            <select name="b_name" id="b_name" class="form-control">
              <option value=""></option>
              <option value="M.E APPLIED ELECTRONICS">M.E APPLIED ELECTRONICS</option>
              <option value="ARTIFICIAL INTELLIGENCE AND DATA SCIENCE">ARTIFICIAL INTELLIGENCE AND DATA SCIENCE</option>
              <option value="AERONAUTICAL ENGINEERING">AERONAUTICAL ENGINEERING</option>
              <option value="AGRICULTURE ENGINEERING">AGRICULTURE ENGINEERING</option>
              <option value="ARTIFICIAL INTELLIGENCE AND MACHINE LEARNING">ARTIFICIAL INTELLIGENCE AND MACHINE LEARNING</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING (AI AND MACHINE LEARNING)">COMPUTER SCIENCE AND ENGINEERING (AI AND MACHINE LEARNING)</option>
              <option value="AEROSPACE ENGINEERING"> AEROSPACE ENGINEERING</option>
              <option value="APPAREL TECHNOLOGY (SS)">APPAREL TECHNOLOGY (SS)</option>
              <option value="ARCHITECTURE">ARCHITECTURE</option>
              <option value="AUTOMOBILE ENGINEERING (SS)">AUTOMOBILE ENGINEERING (SS)</option>
              <option value="AUTOMOBILE ENGINEERING">AUTOMOBILE ENGINEERING</option>
              <option value="ARCHITECTURE (SS)">ARCHITECTURE (SS)</option>
              <option value="BIO TECHNOLOGY AND BIO CHEMICAL ENGINEERING">BIO TECHNOLOGY AND BIO CHEMICAL ENGINEERING</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING (BIG DATA ANALYTICS)">COMPUTER SCIENCE AND ENGINEERING (BIG DATA ANALYTICS)</option>
              <option value="BIO MEDICAL ENGINEERING ">BIO MEDICAL ENGINEERING </option>
              <option value="BIO TECHNOLOGY (SS)">BIO TECHNOLOGY (SS)</option>
              <option value="BIO TECHNOLOGY">BIO TECHNOLOGY</option>
              <option value="BIO MEDICAL ENGINEERING  (SS)">BIO MEDICAL ENGINEERING (SS)</option>
              <option value="COMPUTER SCIENCE AND BUSSINESS SYSTEM">COMPUTER SCIENCE AND BUSSINESS SYSTEM</option>
              <option value="COMPUTER SCIENCE AND DESIGN">COMPUTER SCIENCE AND DESIGN</option>
              <option value="CHEMICAL AND ELECTRO CHEMICAL  ENGINEERING (SS)">CHEMICAL AND ELECTRO CHEMICAL ENGINEERING (SS)</option>
              <option value="CIVIL  ENGINEERING ">CIVIL ENGINEERING </option>
              <option value="CHEMICAL  ENGINEERING ">CHEMICAL ENGINEERING </option>
              <option value="M.TECH. COMPUTER SCIENCE AND ENGINEERING (INTEGRATED 5 YEARS)">M.TECH. COMPUTER SCIENCE AND ENGINEERING (INTEGRATED 5 YEARS)</option>
              <option value="CHEMICAL  ENGINEERING (SS)">CHEMICAL ENGINEERING (SS)</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING (SS)">COMPUTER SCIENCE AND ENGINEERING (SS)</option>
              <option value="CIVIL  ENGINEERING (SS)">CIVIL ENGINEERING (SS)</option>
              <option value="COMPUTER AND  COMMUNICATION ENGINEERING">COMPUTER AND COMMUNICATION ENGINEERING</option>
              <option value="CERAMIC TECHNOLOGY (SS)">CERAMIC TECHNOLOGY (SS)</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING">COMPUTER SCIENCE AND ENGINEERING</option>
              <option value="COMPUTER TECHNOLOGY">COMPUTER TECHNOLOGY</option>
              <option value="COMPUTER SCIENCE AND BUSINESS SYSTEM (SS)">COMPUTER SCIENCE AND BUSINESS SYSTEM (SS)</option>
              <option value="CYBER SECURITY">CYBER SECURITY</option>
              <option value="CIVIL AND STRUCTUTURAL ENGINEERING">CIVIL AND STRUCTUTURAL ENGINEERING</option>
              <option value="ELECTRONICS AND COMMUNICATION ENGINEERING">ELECTRONICS AND COMMUNICATION ENGINEERING</option>
              <option value="ELECTRICAL AND ELECTRONICS ENGINEERING">ELECTRICAL AND ELECTRONICS ENGINEERING</option>
              <option value="ELECTRONICS AND INSTRUMENTATION ENGINEERING">ELECTRONICS AND INSTRUMENTATION ENGINEERING</option>
              <option value="ELECTRONICS AND COMMUNICATION ENGINEERING (SS)">ELECTRONICS AND COMMUNICATION ENGINEERING (SS)</option>
              <option value="ELECTRICAL AND ELECTRONICS (SANDWICH) (SS)">ELECTRICAL AND ELECTRONICS (SANDWICH) (SS)</option>
              <option value="ELECTRONICS AND  TELECOMMUNICATION ENGINEERING">ELECTRONICS AND TELECOMMUNICATION ENGINEERING</option>
              <option value="ELECTRICAL AND ELECTRONICS ENGINEERING (SS)">ELECTRICAL AND ELECTRONICS ENGINEERING (SS)</option>
              <option value="FOOD TECHNOLOGY ">FOOD TECHNOLOGY </option>
              <option value="FOOD TECHNOLOGY (SS)">FOOD TECHNOLOGY (SS)</option>
              <option value="FASHION TECHNOLOGY">FASHION TECHNOLOGY</option>
              <option value="FASHION TECHNOLOGY (SS)">FASHION TECHNOLOGY (SS)</option>
              <option value="GEO INFORMATICS">GEO INFORMATICS</option>
              <option value="HANDLOOM AND TEXTILE TECHNOLOGY">HANDLOOM AND TEXTILE TECHNOLOGY</option>
              <option value="INDUSTRIAL BIO TECHNOLOGY">INDUSTRIAL BIO TECHNOLOGY</option>
              <option value="INSTRUMENTATION AND CONTROL ENGINEERING">INSTRUMENTATION AND CONTROL ENGINEERING</option>
              <option value="INDUSTRIAL ENGINEERING">INDUSTRIAL ENGINEERING</option>
              <option value="INFORMATION TECHNOLOGY (SS)">INFORMATION TECHNOLOGY (SS)</option>
              <option value="INDUSTRIAL ENGINEERING AND MANAGEMENT">INDUSTRIAL ENGINEERING AND MANAGEMENT</option>
              <option value="INDUSTRIAL BIO TECHNOLOGY (SS)">INDUSTRIAL BIO TECHNOLOGY (SS)</option>
              <option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
              <option value="INSTRUMENTATION AND CONTROL ENGINEERING (SS)">INSTRUMENTATION AND CONTROL ENGINEERING (SS)</option>
              <option value="LEATHER TECHNOLOGY">LEATHER TECHNOLOGY</option>
              <option value="MATERIAL SCIENCE AND ENGINEERING (SS)">MATERIAL SCIENCE AND ENGINEERING (SS)</option>
              <option value="MECHATRONICS">MECHATRONICS</option>
              <option value="MEDICAL ELECTRONICS ENGINEERING">MEDICAL ELECTRONICS ENGINEERING</option>
              <option value="MECHANICAL ENGINEERING">MECHANICAL ENGINEERING</option>
              <option value="MECHANICAL ENGINEERING (SS)">MECHANICAL ENGINEERING (SS)</option>
              <option value="MECHATRONICS (SS)">MECHATRONICS (SS)</option>
              <option value="MECHANICAL ENGINEERING (SANDWICH)">MECHANICAL ENGINEERING (SANDWICH)</option>
              <option value="MINING ENGINEERING">MINING ENGINEERING</option>
              <option value="MECHANICAL ENGINEERING (MANUFACTURING)">MECHANICAL ENGINEERING (MANUFACTURING)</option>
              <option value="MANUFACTURING ENGINEERING">MANUFACTURING ENGINEERING</option>
              <option value="MECHANICAL AND MECHATRONICS ENGINEERING (ADDITIVE MANUFACTURING)">MECHANICAL AND MECHATRONICS ENGINEERING (ADDITIVE MANUFACTURING)</option>
              <option value="MARINE ENGINEERING">MARINE ENGINEERING</option>
              <option value="MECHANICAL ENGINEERING (SANDWICH) (SS)">MECHANICAL ENGINEERING (SANDWICH) (SS)</option>
              <option value="METALLURGICAL ENGINEERING">METALLURGICAL ENGINEERING</option>
              <option value="MECHANICAL AND AUTOMATION ENGINEERING">MECHANICAL AND AUTOMATION ENGINEERING</option>
              <option value="METALLURGICAL ENGINEERING (SS)">METALLURGICAL ENGINEERING (SS)</option>
              <option value="MECHATRONICS ENGINEERING">MECHATRONICS ENGINEERING</option>
              <option value="NANO SCIENCE AND TECHNOLOGY">NANO SCIENCE AND TECHNOLOGY</option>
              <option value="PLASTIC TECHNOLOGY">PLASTIC TECHNOLOGY</option>
              <option value="PETRO CHEMICAL TECHNOLOGY">PETRO CHEMICAL TECHNOLOGY</option>
              <option value="PETRO CHEMICAL ENGINEERING">PETRO CHEMICAL ENGINEERING</option>
              <option value="PETROLEUM ENGINEERING">PETROLEUM ENGINEERING</option>
              <option value="PHARMACEUTICAL TECHNOLOGY">PHARMACEUTICAL TECHNOLOGY</option>
              <option value="POLYMER TECHNOLOGY">POLYMER TECHNOLOGY</option>
              <option value="PHARMACEUTICAL TECHNOLOGY (SS)">PHARMACEUTICAL TECHNOLOGY (SS)</option>
              <option value="PRODUCTION ENGINEERING (SS)">PRODUCTION ENGINEERING (SS)</option>
              <option value="PETROLEUM ENGINEERING AND TECHNOLOGY (SS)">PETROLEUM ENGINEERING AND TECHNOLOGY (SS)</option>
              <option value="PRODUCTION ENGINEERING">PRODUCTION ENGINEERING</option>
              <option value="PRODUCTION ENGINEERING (SANDWICH) (SS)">PRODUCTION ENGINEERING (SANDWICH) (SS)</option>
              <option value="PRINTING TECHNOLOGY">PRINTING TECHNOLOGY</option>
              <option value="ROBOTICS AND AUTOMATION (SS)">ROBOTICS AND AUTOMATION (SS)</option>
              <option value="ROBOTICS AND AUTOMATION">ROBOTICS AND AUTOMATION</option>
              <option value="RUBBER AND PLASTIC TECHNOLOGY">RUBBER AND PLASTIC TECHNOLOGY</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING (INTERNET OF THINGS AND CYBER SECURITY INCLUDING BLOCK CHAIN TECHNOLOGY)">COMPUTER SCIENCE AND ENGINEERING (INTERNET OF THINGS AND CYBER SECURITY INCLUDING BLOCK CHAIN TECHNOLOGY)</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING (CYBER SECURITY)">COMPUTER SCIENCE AND ENGINEERING (CYBER SECURITY)</option>
              <option value="INFORMATION SCIENCE AND ENGINEERING">INFORMATION SCIENCE AND ENGINEERING</option>
              <option value="SAFETY AND FIRE ENGINEERING">SAFETY AND FIRE ENGINEERING</option>
              <option value="TEXTILE CHEMISTRY">TEXTILE CHEMISTRY</option>
              <option value="COMPUTER SCIENCE AND TECHNOLOGY">COMPUTER SCIENCE AND TECHNOLOGY</option>
              <option value="TEXTILE TECHNOLOGY (SS)">TEXTILE TECHNOLOGY (SS)</option>
              <option value="TEXTILE TECHNOLOGY">TEXTILE TECHNOLOGY</option>
              <option value="CIVIL ENGINEERING (TAMIL MEDIUM)">CIVIL ENGINEERING (TAMIL MEDIUM)</option>
              <option value="MECHANICAL ENGINEERING (TAMIL MEDIUM)">MECHANICAL ENGINEERING (TAMIL MEDIUM)</option>
              <option value="MBA">MBA</option>
              <option value="MBA (TOURISM MANAGEMENT) (SS)">MBA (TOURISM MANAGEMENT) (SS)</option>
              <option value="MBA (PART TIME) (SS)">MBA (PART TIME) (SS)</option>
              <option value="MBA (SS)">MBA (SS)</option>
              <option value="MBA (DUAL SPECIALIZATION)">MBA (DUAL SPECIALIZATION)</option>
              <option value="MBA (INFRASTRUCTURE MANAGEMENT)">MBA (INFRASTRUCTURE MANAGEMENT)</option>
              <option value="MBA (BUSINESS ANALYTICS)">MBA (BUSINESS ANALYTICS)</option>
              <option value="MCA">MCA</option>
              <option value="MCA (EVENING)(SS)">MCA (EVENING)(SS)</option>
              <option value="MCA (LATERAL)">MCA (LATERAL)</option>
              <option value="MCA (LATERAL) (SS)">MCA (LATERAL) (SS)</option>
              <option value="AVIONICS">AVIONICS</option>
              <option value="BIO-MEDICAL ENGINEERING">BIO-MEDICAL ENGINEERING</option>
              <option value="BIO-METRICS & CYBER SECURITY">BIO-METRICS & CYBER SECURITY</option>
              <option value="CAD / CAM">CAD / CAM</option>
              <option value="COMMUNICATION & NETWORKING">COMMUNICATION & NETWORKING</option>
              <option value="COMMUNICATION ENGINEERING">COMMUNICATION ENGINEERING</option>
              <option value="COMMUNICATION SYSTEMS">COMMUNICATION SYSTEMS</option>
              <option value="COMMUNICATION SYSTEMS (SS)">COMMUNICATION SYSTEMS (SS)</option>
              <option value="COMPUTER AIDED DESIGN">COMPUTER AIDED DESIGN</option>
              <option value="COMPUTER INTEGRATED MANUFACTURING">COMPUTER INTEGRATED MANUFACTURING</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING">COMPUTER SCIENCE AND ENGINEERING</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING (NETWORKS)">COMPUTER SCIENCE AND ENGINEERING (NETWORKS)</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING (SS)">COMPUTER SCIENCE AND ENGINEERING (SS)</option>
              <option value="CONSTRUCTION ENGINEERING AND MANAGEMENT">CONSTRUCTION ENGINEERING AND MANAGEMENT</option>
              <option value="CONSTRUCTION ENGINEERING AND MANAGEMENT (SS)">CONSTRUCTION ENGINEERING AND MANAGEMENT (SS)</option>
              <option value="CONTROL AND  INSTRUMENTATION ENGINEERING">CONTROL AND  INSTRUMENTATION ENGINEERING</option>
              <option value="CONTROL AND  INSTRUMENTATION ENGINEERING (SS)">CONTROL AND  INSTRUMENTATION ENGINEERING (SS)</option>
              <option value="CONTROL SYSTEMS">CONTROL SYSTEMS</option>
              <option value="CRYOGENIC ENGINEERING">CRYOGENIC ENGINEERING</option>
              <option value="EMBEDDED SYSTEM TECHNOLOGIES">EMBEDDED SYSTEM TECHNOLOGIES</option>
              <option value="EMBEDDED SYSTEMS">EMBEDDED SYSTEMS</option>
              <option value="ENERGY ENGINEERING">ENERGY ENGINEERING</option>
              <option value="ENERGY ENGINEERING (SS)">ENERGY ENGINEERING (SS)</option>
              <option value="ENGINEERING DESIGN">ENGINEERING DESIGN</option>
              <option value="ENVIRONMENTAL ENGG. AND MANAGEMENT (SS)">ENVIRONMENTAL ENGG. AND MANAGEMENT (SS)</option>
              <option value="ENVIRONMENTAL ENGINEERING">ENVIRONMENTAL ENGINEERING</option>
              <option value="ENVIRONMENTAL ENGINEERING (SS)">ENVIRONMENTAL ENGINEERING (SS)</option>
              <option value="GEOTECHNICAL ENGINEERING">GEOTECHNICAL ENGINEERING</option>
              <option value="HIGH VOLTAGE ENGINEERING">HIGH VOLTAGE ENGINEERING</option>
              <option value="INDUSTRIAL ENGINEERING">INDUSTRIAL ENGINEERING</option>
              <option value="INDUSTRIAL ENGINEERING (SS)">INDUSTRIAL ENGINEERING (SS)</option>
              <option value="INDUSTRIAL METALLURGY (SS)">INDUSTRIAL METALLURGY (SS)</option>
              <option value="INDUSTRIAL SAFETY ENGINEERING">INDUSTRIAL SAFETY ENGINEERING</option>
              <option value="INFRASTRUCTURAL ENGINEERING (SS)">INFRASTRUCTURAL ENGINEERING (SS)</option>
              <option value="INFRASTRUCTURE ENGINEERING & MANAGEMENT">INFRASTRUCTURE ENGINEERING & MANAGEMENT</option>
              <option value="INSTRUMENTATION ENGINEERING">INSTRUMENTATION ENGINEERING</option>
              <option value="INTERNAL COMBUSTION ENGINEERING">INTERNAL COMBUSTION ENGINEERING</option>
              <option value="MANUFACTURING ENGINEERING">MANUFACTURING ENGINEERING</option>
              <option value="MECHATRONICS">MECHATRONICS</option>
              <option value="MECHATRONICS ENGINEERING">MECHATRONICS ENGINEERING</option>
              <option value="MEDICAL ELECTRONICS">MEDICAL ELECTRONICS</option>
              <option value="OPTICAL COMMUNICATION">OPTICAL COMMUNICATION</option>
              <option value="POWER ELECTRONICS AND DRIVES">POWER ELECTRONICS AND DRIVES</option>
              <option value="POWER ELECTRONICS AND DRIVES (SS)">POWER ELECTRONICS AND DRIVES (SS)</option>
              <option value="POWER SYSTEMS ENGINEERING">POWER SYSTEMS ENGINEERING</option>
              <option value="POWER SYSTEMS ENGINEERING (SS)">POWER SYSTEMS ENGINEERING (SS)</option>
              <option value="SOFTWARE ENGINEERING">SOFTWARE ENGINEERING</option>
              <option value="SOFTWARE ENGINEERING (SS)">SOFTWARE ENGINEERING (SS)</option>
              <option value="SOIL MECHANICS AND FOUNDATION ENGINEERING">SOIL MECHANICS AND FOUNDATION ENGINEERING</option>
              <option value="STRUCTURAL ENGINEERING">STRUCTURAL ENGINEERING</option>
              <option value="STRUCTURAL ENGINEERING (SS)">STRUCTURAL ENGINEERING (SS)</option>
              <option value="THERMAL ENGINEERING">THERMAL ENGINEERING</option>
              <option value="VLSI DESIGN">VLSI DESIGN</option>
              <option value="VLSI DESIGN (SS)">VLSI DESIGN (SS)</option>
              <option value="WELDING TECHNOLOGY">WELDING TECHNOLOGY</option>
              <option value="WIRELESS TECHNOLOGIES (SS)">WIRELESS TECHNOLOGIES (SS)</option>
              <option value="APPAREL TECHNOLOGY">APPAREL TECHNOLOGY</option>
              <option value="BIO-TECHNOLOGY">BIO-TECHNOLOGY</option>
              <option value="BIO-TECHNOLOGY (SS)">BIO-TECHNOLOGY (SS)</option>
              <option value="CHEMICAL ENGINEERING">CHEMICAL ENGINEERING</option>
              <option value="FOOD TECHNOLOGY">FOOD TECHNOLOGY</option>
              <option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
              <option value="INFORMATION TECHNOLOGY (INFORMATION AND CYBER WAREFARE)">INFORMATION TECHNOLOGY (INFORMATION AND CYBER WAREFARE)</option>
              <option value="INFORMATION TECHNOLOGY (SS)">INFORMATION TECHNOLOGY (SS)</option>
              <option value="NANO SCIENCE AND TECHNOLOGY">NANO SCIENCE AND TECHNOLOGY</option>
              <option value="PETROLEUM REFINING & PETRO CHEMICALS">PETROLEUM REFINING & PETRO CHEMICALS</option>
              <option value="PLASTICS TECHNOLOGY">PLASTICS TECHNOLOGY</option>
              <option value="REMOTE SENSING">REMOTE SENSING</option>
              <option value="TEXTILE TECHNOLOGY">TEXTILE TECHNOLOGY</option>
              <option value="TEXTILE TECHNOLOGY (SS)">TEXTILE TECHNOLOGY (SS)</option>
              <option value="APPLIED MATHEMATICS (2 YEARS) (SS)">APPLIED MATHEMATICS (2 YEARS) (SS)</option>
              <option value="THEORETICAL COMPUTER SCIENCE ( 5 YEARS) (SS)">THEORETICAL COMPUTER SCIENCE ( 5 YEARS) (SS)</option>
              <option value="APPLIED SCIENCE">APPLIED SCIENCE</option>
              <option value="ENVIRONMENTAL SCIENCE AND TECHNOLOGY">ENVIRONMENTAL SCIENCE AND TECHNOLOGY</option>
              <option value="COMPUTER SYSTEMS AND DESIGN (SS)">COMPUTER SYSTEMS AND DESIGN (SS)</option>
              <option value="INFORMATION SYSTEMS (SS)">INFORMATION SYSTEMS (SS)</option>
              <option value="SOFTWARE SYSTEMS (SS)(5 YEARS)">SOFTWARE SYSTEMS (SS)(5 YEARS)</option>
              <option value="SOFTWARE SYSTEMS (5 YEARS)">SOFTWARE SYSTEMS (5 YEARS)</option>
              <option value="AUTOMOBILE ENGINEERING">AUTOMOBILE ENGINEERING</option>
              <option value="HYDROLOGY WATER RESOURSES ENGINEERING">HYDROLOGY WATER RESOURSES ENGINEERING</option>
              <option value="IRRIGATION WATER MANAGEMENT">IRRIGATION WATER MANAGEMENT</option>
              <option value="LASER & ELECTRO OPTICAL ENGG">LASER & ELECTRO OPTICAL ENGG</option>
              <option value="MATERIAL SCIENCE  (2 YEARS)">MATERIAL SCIENCE  (2 YEARS)</option>
              <option value="APPLIED CHEMISTRY (2 YRS)">APPLIED CHEMISTRY (2 YRS)</option>
              <option value="MEDICAL PHYSICS  (2 YEARS)">MEDICAL PHYSICS  (2 YEARS)</option>
              <option value="APPLIED GEOLOGY  (2 YEARS)">APPLIED GEOLOGY  (2 YEARS)</option>
              <option value="MATHEMATICS">MATHEMATICS</option>
              <option value="PHYSICS">PHYSICS</option>
              <option value="ENGLISH">ENGLISH</option>
              <option value="TRANSPORTATION. ENGG.(FT -REGULAR)">TRANSPORTATION. ENGG.(FT -REGULAR)</option>
              <option value="ENVIRONMENTAL MANAGEMENT (FT SS)">ENVIRONMENTAL MANAGEMENT (FT SS)</option>
              <option value="EMBEDDED SYSTEM TECHNOLOGY (FT SS)">EMBEDDED SYSTEM TECHNOLOGY (FT SS)</option>
              <option value="MANUFACTURING AND SYSTEM  MANAGEMENT (FT SS)">MANUFACTURING AND SYSTEM  MANAGEMENT (FT SS)</option>
              <option value="SOLAR ENERGY (FT SS)">SOLAR ENERGY (FT SS)</option>
              <option value="PRINTING AND PACKAGING TECHNOLOGY (SS)">PRINTING AND PACKAGING TECHNOLOGY (SS)</option>
              <option value="(5 YRS INTEGRATED) COMPUTER SCIENCE (SS)">(5 YRS INTEGRATED) COMPUTER SCIENCE (SS)</option>
              <option value="(5 YRS INTEGRATED) INFORMATION TECHNOLOPGY (SS)">(5 YRS INTEGRATED) INFORMATION TECHNOLOPGY (SS)</option>
              <option value="POLYMER SCIENCE AND ENGINEERING (FT SS)">POLYMER SCIENCE AND ENGINEERING (FT SS)</option>
              <option value="(2 YRS) ELECTRONIC MEDIA (SS)">(2 YRS) ELECTRONIC MEDIA (SS)</option>
              <option value="(5 YRS INTEGRATED) ELECTRONIC MEDIA (SS)">(5 YRS INTEGRATED) ELECTRONIC MEDIA (SS)</option>
              <option value="TEXTILE TECHNOLOGY(WITH SPECIALIZATION IN TEXTILE CHEMISTRY)">TEXTILE TECHNOLOGY(WITH SPECIALIZATION IN TEXTILE CHEMISTRY)</option>
              <option value="POWER ENGINEERING AND MANAGEMENT (FT SS)">POWER ENGINEERING AND MANAGEMENT (FT SS)</option>
              <option value="CERAMIC TECHNOLOGY">CERAMIC TECHNOLOGY</option>
              <option value="BIO PHARMACEUTICAL TECHNOLOGY(SS-FT)">BIO PHARMACEUTICAL TECHNOLOGY(SS-FT)</option>
              <option value="INDUSTRIAL SAFETY AND HAZARD MGMT.(SS-FT)">INDUSTRIAL SAFETY AND HAZARD MGMT.(SS-FT)</option>
              <option value="AEROSPACE TECHNOLOGY(SS-FT)">AEROSPACE TECHNOLOGY(SS-FT)</option>
              <option value="RUBBER AND PLASTIC TECHNOLOGY(SS-FT)">RUBBER AND PLASTIC TECHNOLOGY(SS-FT)</option>
              <option value="SOFTWARE SYSTEMS">SOFTWARE SYSTEMS</option>
              <option value="INDUSTRIAL AUTOMATION & ROBOTICS">INDUSTRIAL AUTOMATION & ROBOTICS</option>
              <option value="FASHION DESIGN AND MERCHANDISING (5 YEARS) (SS)">FASHION DESIGN AND MERCHANDISING (5 YEARS) (SS)</option>
              <option value="POLYMER SCIENCE & ENGINEERING">POLYMER SCIENCE & ENGINEERING</option>
              <option value="NANO SCIENCE AND TECHNOLOGY (SS)">NANO SCIENCE AND TECHNOLOGY (SS)</option>
              <option value="DATA SCIENCE (5 YEARS) (SS)">DATA SCIENCE (5 YEARS) (SS)</option>
              <option value="APPLIED ELECTRONICS (PT) (SS)">APPLIED ELECTRONICS (PT) (SS)</option>
              <option value="EMBEDDED AND REAL TIME SYSTEMS (SS)">EMBEDDED AND REAL TIME SYSTEMS (SS)</option>
              <option value="WIRELESS COMMUNICATION (SS)">WIRELESS COMMUNICATION (SS)</option>
              <option value="CONSTRUCTION MANAGEMENT (SS)">CONSTRUCTION MANAGEMENT (SS)</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING WITH SPECIALISATION IN BIG DATA ANALYTICS (SS-FT)">COMPUTER SCIENCE AND ENGINEERING WITH SPECIALISATION IN BIG DATA ANALYTICS (SS-FT)</option>
              <option value="REMOTE SENSING AND GEOMATICS (REGULAR)">REMOTE SENSING AND GEOMATICS (REGULAR)</option>
              <option value="ENGINEERING DESIGN (SS)">ENGINEERING DESIGN (SS)</option>
              <option value="QUALITY ENGINEERING AND MANAGEMENT (SS-FT)">QUALITY ENGINEERING AND MANAGEMENT (SS-FT)</option>
              <option value="DECISION AND COMPUTING SCIENCE (5 YEARS INTEGRATED)">DECISION AND COMPUTING SCIENCE (5 YEARS INTEGRATED)</option>
              <option value="DATA SCIENCE">DATA SCIENCE</option>
              <option value="MASTER OF TECHNOLOGY MANAGEMENT}">MASTER OF TECHNOLOGY MANAGEMENT}</option>
              <option value="EMBEDDED SYSTEM TECHNOLOGIES(SS-PT)">EMBEDDED SYSTEM TECHNOLOGIES(SS-PT)</option>
              <option value="PRODUCT DESIGN AND DEVELOPMENT(SS-PT)">PRODUCT DESIGN AND DEVELOPMENT(SS-PT)</option>
              <option value="COMPUTER SCIENCE AND ENGINEERING SPL IN OPERATIONS RESEARCH [SS] ">COMPUTER SCIENCE AND ENGINEERING SPL IN OPERATIONS RESEARCH [SS] </option>
              <option value="M.TECH. INFORMATION TECHNOLOGY WITH SPL IN MULTIMEDIA TECHNOLOGY (SS)">M.TECH. INFORMATION TECHNOLOGY WITH SPL IN MULTIMEDIA TECHNOLOGY (SS)</option>
              <option value="MBA (5 YEARS INTEGRATED)">MBA (5 YEARS INTEGRATED)</option>
              <option value="ARTIFICIAL INTELLIGENCE AND MACHINE LEARNING (INTEGRATED)">ARTIFICIAL INTELLIGENCE AND MACHINE LEARNING (INTEGRATED)</option>
              <option value="M.ARCH (ENVIRONMENTAL ARCHITECTURE)">M.ARCH (ENVIRONMENTAL ARCHITECTURE)</option>
              <option value="LEATHER TECHNOLOGY">LEATHER TECHNOLOGY</option>
              <option value="'ENVIRONMENT SCIENCE & TECHNOLOGY(SS)'}">'ENVIRONMENT SCIENCE & TECHNOLOGY(SS)'}</option>
              <option value="FOOTWEAR ENGINEERING & MANAGEMENT">FOOTWEAR ENGINEERING & MANAGEMENT</option>
              <option value="FOOD TECHNOLOGY(SS)">FOOD TECHNOLOGY(SS)</option>
              <option value="COMPUTATIONAL BIOLOGY(SS)];">COMPUTATIONAL BIOLOGY(SS)];</option>
              <option value="M.ARCH (REAL ESTATE DEVELOPMENT)];">M.ARCH (REAL ESTATE DEVELOPMENT)];</option>
              <option value="VLSI DESIGN AND EMBEDDED SYSTEM(SS)">VLSI DESIGN AND EMBEDDED SYSTEM(SS)</option>
              <option value="INDUSTRIAL ENGINEERING (PT) (SS)">INDUSTRIAL ENGINEERING (PT) (SS)</option>
              <option value="STRUCTURAL ENGINEERING (PT) (SS)">STRUCTURAL ENGINEERING (PT) (SS)</option>
              <option value="MANUFACTURING ENGINEERING (PT) (SS)">MANUFACTURING ENGINEERING (PT) (SS)</option>
              <option value="ELECTRICAL MACHINES (PT) (SS)">ELECTRICAL MACHINES (PT) (SS)</option>
              <option value="INDUSTRIAL METALLURGY (PT) (SS)">INDUSTRIAL METALLURGY (PT) (SS)</option>
              <option value="TEXTILE TECHNOLOGY (PT) (SS)">TEXTILE TECHNOLOGY (PT) (SS)</option>
              <option value="MCA (SS)">MCA (SS)</option>
              <option value="CYBER SECURITY (5 YEARS) (SS)">CYBER SECURITY (5 YEARS) (SS)</option>
              <option value="MBA (WASTE MANAGEMENT & SOCIAL ENTREPRENEURSHIP) (SS)">MBA (WASTE MANAGEMENT & SOCIAL ENTREPRENEURSHIP) (SS)</option>
              <option value="BIG DATA ANALYTICS">BIG DATA ANALYTICS</option>
              <option value="ELECTRONICS AND COMMUNICATION ENGINEERING INDUSTRY INTEGRATED">ELECTRONICS AND COMMUNICATION ENGINEERING INDUSTRY INTEGRATED</option>
              <option value="M.ARCH (GENERAL)">M.ARCH (GENERAL)</option>
              <option value="M.PLAN">M.PLAN</option>
              <option value="M.ARCH(LANDSCAPE) (SS-FT)">M.ARCH(LANDSCAPE) (SS-FT)</option>
              <option value="M.ARCH (SS-FT)">M.ARCH (SS-FT)</option>
            </select>

            <!-- <select class="form-control" id="b_name">
                <option value="CS">Computer Science and Engineering</option>
                <option value="MECH">Mechanical Engineering</option>
                <option value="ELE"
                  >Electrical and Electronics Engineering</option
                >
                <option value="ECE"
                  >Electronics and Communication Engineering</option
                >
              </select> -->
          </div>
        </div>
      </div>
    </div>

       <div class="row">
        <div class="col-md-12">
          <div class="table-box">
            <div
              class="table-row table-head"
              style="padding-bottom: 0px; line-height: 5px;"
            >
              <div
                class="table-cell first-cell"
                style="padding-top: 5px; padding-bottom: 0px;"
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
                  style="margin: 5px auto; width: 50%;"
                >
                  <option></option>
      <!-- <option value="1">I</option>  -->
                  <option value="2">II</option>
                  <option value="4">IV</option>
                  <option value="6">VI</option>
                  <option value="8">VIII</option>
                  <option value="10">X</option>
                </select>
              </div>
              <div class="table-cell last-cell">
              <select class="form-control" id="discontinued_year" style="margin: 5px auto; width: 50%;">
                <option></option>

                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
              </select>
                <!-- <input
                  class="form-control"
                  id="discontinued_year"
                  style="margin: 5px auto; width: 50%;"
                /> -->
              </div>
            </div>

            <div class="table-row">
              <div class="table-cell first-cell">
                <p>Semester/Year during which Readmission is Sought</p>
              </div>
              <div class="table-cell">
              <select class="form-control" id="readmission_sougth_sem" style="margin: 5px auto; width: 50%;" disabled>
                <option></option>
                <option value="2">II</option>
                  <option value="4">IV</option>
                  <option value="6">VI</option>
                  <option value="8">VIII</option>
                  <option value="10">X</option>
              </select>
                <!-- <input
                  id="readmission_sougth_sem"
                  name="readd_semester"
                  type="number"
                  class="form-control"
                  style="margin: 5px auto; width: 50%;"
                /> -->
              </div>
              <div class="table-cell last-cell">
              <input type="text" class="form-control" id="readmission_sougth_year" value="2025" name="readd_year" style="margin: 5px auto; width: 50%;" readonly />
                <!-- <input
                  type="text"
                  class="form-control"
                  id="readmission_sougth_year"
                  name="readd_year"
                  style="margin: 5px auto; width: 50%;"
                /> -->
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
                of attendance(II, IV, VI, VIII, X)
              </label>
            </div>
            <div class="col-sm-6">
              <select class="form-control" id="lack_attendence_sem" disabled>
                <option></option>
                <option value="2">II</option>
                <option value="4">IV</option>
                <option value="6">VI</option>
                <option value="8">VIII</option>
                <option value="10">X</option>
              </select>
            </div>
          </div>
          <div>
          <div class="form-group">
            <label><b>Upload All previous Semester Marksheet(Only pdf file Allowed.)</b></label>
            <form method="post" action="" enctype="multipart/form-data" id="uploadForm">
              <div>
                <input required="" id="pdf_upload" name="pdfFile" type="file" accept=".pdf"><br>
                <button id="uploadBtn" type="button" style="background-color: dodgerblue; color: white; border-radius: 6px; padding: 5px; margin-top: 10px;margin-left: 10px;">Upload</button>
              </div>
            </form>
          </div>
          <div class="form-group">
            <div id="displaypdf">

            </div>
          </div>
        </div>
        </div>

        <div class="col-md-6">
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
                Print
              </button>
              <button
              class="btn btn-success"
              id="home" 
            ><a style="text-decoration:none;color:white;" href="../user/#from">Home</a>
            </button>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
  </body>
</html>
