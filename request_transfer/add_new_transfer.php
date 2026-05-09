<?php
session_start();
if (!isset($_SESSION['c_code'])) {
  die("INVALID");
}
include '../user/database.php';
// $sql = "select c_code,name_of_college_with_address from college_details";

$a=array('1013', '1014', '1015', '1026', '2025', '3011', '3016', '3018', '3019', '3021', '4020', '4023', '4024', '5010', '5017', '5022', '1516' , '2005', '2006', '2007', '2369', '2603', '2615', '2709', '3464', '3465', '4974', '5008', '5009', '5901');
if(in_array($_SESSION['c_code'],$a))
{
$sql = "select c_code,name_of_college_with_address from college_details where c_code in ('1013', '1014', '1015', '1026', '2025', '3011', '3016', '3018', '3019', '3021', '4020', '4023', '4024', '5010', '5017', '5022', '1516' , '2005', '2006', '2007', '2369', '2603', '2615', '2709', '3464', '3465', '4974', '5008', '5009', '5901')";
}
else{
$sql = "select c_code,name_of_college_with_address from college_details where c_code not in ('0001', '0002', '0003', '0004', '0005', '1013', '1014', '1015', '1026', '2025', '3011', '3016', '3018', '3019', '3021', '4020', '4023', '4024', '5010', '5017', '5022', '1516' , '2005', '2006', '2007', '2369', '2603', '2615', '2709', '3464', '3465', '4974', '5008', '5009', '5901')";

}

if ($stmt = $conn->query($sql)) {
} else {
  die("Something went wrong");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add Transfer</title>
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
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 33px;
      width: 33px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked+.slider {
      background-color: #2196F3;
    }

    input:focus+.slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
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
  <link rel="stylesheet" href="../../styles/loader.css">
  <link rel="stylesheet" href="../../styles/modal.css">
  <!-- <link rel="stylesheet" href="loader.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var isUploadSuccessful = 0;
      var value1 = "";
      $("#clear").click(function() {
        $college = $("#fcollege").val();
        $("input").val('');
        $("select").val('');
        $("#freeze").prop("checked", false);
        $("#submit").prop("disabled", false);
        $("#displaypdf").html(null);
        $("#pdf_upload").val(null);
        $("#fcollege").val($college);

      });
      var isFreezed = false;
      $("#print").click(function() {
        //alert("HEllo");

        // $("#myModal").css("display", "block");
        // $(".modal-content").css("background-color", "#ff6666");
        // $("#message").text("Report Generation is not available now !!");
        
        if (isFreezed)
          window.location.href =
          "../report_generation/transfer.php?u_id=" + $("#reg_no").val();
        else {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Please freeze and submit to Print");
          return false;
        }
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
                var linkHtml = ' <div><label>Click here to view the PDF File</label></div><a href="last_semester_marksheet/' + value1 + '.pdf" target="_blank" style="color: #007bff; text-decoration: none; font-weight: bold; border: 1px solid #007bff; padding: 5px 10px; border-radius: 5px; background-color: #f2f2f2;">' + value1 + '.pdf</a>';
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

      $("#submit").click(function() {
        if (!validation()) {
          return;
        }
        if ($("#freeze").is(":checked")) {
          var one = confirm("Once You Freeze You can not able to edit this data, Do you really want to Freeze?");
          if (one == false) {
            return;
          }
        }

        if ($("#board").val() == 'DIPLOMA') {
          mark1Value = $("#mark1dip").val();
          mark2Value = $("#mark2dip").val();
          mark3Value = 0;
          cutOffValue = $("#cut_offdip").val();
        } else {
          mark1Value = $("#mark1").val();
          mark2Value = $("#mark2").val();
          mark3Value = $("#mark3").val();
          cutOffValue = $("#cut_off").val();
        }
        $.post("add_transfer.php", {
          add_transfer: null,
          reg_no: $("#reg_no").val(),
          name_of_student: $("#name_of_student").val().toUpperCase(),
          // address:$("#address").val().toUpperCase(),
          // address2:$("#address2").val().toUpperCase(),
          // district:$("#district").val().toUpperCase(),
          // pincode:$("#pincode").val(),
          mobile: $("#mobile").val(),
          dob: $("#dob").val(),
          // email:$("#email").val(),
          admission_type: $("#admission_type").val(),
          admission_year: $("#admission_year").val(),
          admission_month: $("#admission_month").val(),
          request_for: $("input[name=request_for]:checked").val(),
          fcollege_c_code: getC_code($("#fcollege").val()),
          fcollege: $("#fcollege").val(),
          fcollege_autonomous: $("#fcollege_autonomous").val(),
          arrears: $("#arrears").val(),
          no_arrears: $("#no_arrears").val(),
          // sem_arrears: $("#sem_arrears").val(),
          b_name: $("#b_name").val(),
          sem_from: $("#sem_from").val(),
          tcollege_c_code: getC_code($("#tcollege").val()),
          tcollege: $("#tcollege").val(),
          tcollege_autonomous: $("#tcollege_autonomous").val(),
          sem_to: $("#sem_to").val(),
          last_appeared_month: $("#last_appeared_month").val(),
          last_appeared_year: $("#last_appeared_year").val(),
          last_appeared_reg_no: $("#last_appeared_reg_no").val(),
          last_appeared_semester: $("#last_appeared_semester").val(),
          tcr_last_appeared_semester: $("#tcr_last_appeared_semester").val(),
          reason: $("#reason").val().toUpperCase(),
          total_periods: $("#total_periods").val(),
          attended_periods: $("#attended_periods").val(),
          attendence_percentage: $("#attendence_percentage").val(),

          // tnea_reg_no: $("#tnea_reg_no").val(),
          community: $("#community").val(),
          quota: $("#quota").val(),
          // fg:$("#fg").val(),
          // pms:$("#pms").val(),
          board: $("#board").val().toUpperCase(),
          mark1: mark1Value,
          mark2: mark2Value,
          mark3: mark3Value,
          cut_off: cutOffValue,
          freezed: $("#freeze").is(':checked') == true ? 1 : 0
        }, function(data, status) {
          if (status == 404) {
            $("#myModal").css("display", "block");
            $(".modal-content").css("background-color", "#ff6666");
            $("#message").text('Cannot Access web');
          }
          if (data == "success") {
            isFreezed = $("#freeze").is(':checked');
            $("#uploadBtn").prop("disabled", $("#freeze").is(':checked'));
            $("#submit").prop("disabled", $("#freeze").is(':checked'));
            $("#clear").prop("disabled", $("#freeze").is(':checked'));
            $("#myModal").css("display", "block");
            $(".modal-content").css("background-color", "#baf1a1");
            $("#message").text("Submitted Successfully");
          } else {
            $("#myModal").css("display", "block");
            $(".modal-content").css("background-color", "#ff6666");
            $("#message").text(data);
            console.log(data);
            alert(data);
          }
        });
      });
      
      $.urlParam = function(name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
          return null;
        }
        return decodeURI(results[1]) || 0;
      }
      if ($.urlParam("u_id") != null) {
        $("#loader").show();
        $.post("fetch_data.php", {
          u_id: $.urlParam("u_id")
        }, function(data, status) {

          if (status == 404) {
            $("#myModal").css("display", "block");
            $(".modal-content").css("background-color", "#ff6666");
            $("#message").text('Cannot Access web');
          }
          var objectN = ({}).constructor;
          if (data == "no_record") {
            $("#myModal").css("display", "block");
            $(".modal-content").css("background-color", "#ff6666");
            $("#message").text("No data exists");
          } else {

            try {
              var result = $.parseJSON(data);
              $.each(result, function(key, value) {
                $("#reg_no").val(value['reg_no']);
                var c_code = "<?php echo $_SESSION['c_code']; ?>";
                var link = 'last_semester_marksheet/' + c_code + '_' + $("#reg_no").val() + '.pdf';
                async function checkFileExists(url) {
            try {
                const response = await fetch(url, { method: 'HEAD' });
                if (response.ok) {
                  isUploadSuccessful = 1;
                  // alert(link);
                  var linkHtml = ' <div><label>Click here to view the PDF File</label></div><a href="' + link + '" target="_blank" style="color: #007bff;text-decoration: none; font-weight: bold; border: 1px solid #007bff; padding: 5px 10px;margin-left:20px; border-radius: 5px; background-color: #f2f2f2;">' + c_code +"_" + $("#reg_no").val() + '.pdf</a>';
                  $("#displaypdf").html(linkHtml);
                    // console.log('File exists');
                } 
                // else {
                //     // console.log('File does not exist');
                // }
            } 
            catch (error) {
                // console.log('File does not exist');
            }
        }

        // Replace with the URL of the file you want to check
        const fileUrl = link;
        checkFileExists(fileUrl);

                $("#reg_no").val(value['reg_no']),
                  $("#name_of_student").val(value['name_of_student']),
                  // $("#address").val(value['address']),
                  // $("#address2").val(value['address2']),
                  // $("#district").val(value['district']),
                  // $("#pincode").val(value['pincode']),
                  $("#mobile").val(value['mobile']),
                  $("#dob").val(value['dob']),
                  // $("#email").val(value['email']),
                  $("#admission_type").val(value['admission_type']),
                  $("#admission_year").val(value['admission_year']),
                  $("#admission_month").val(value['admission_month']),
                  $("input[name='request_for'][value='" + value['request_for'] + "']").prop("checked", true).change(),

                  $("#fcollege").val(value['fcollege']),
                  $("#fcollege_autonomous").val(value['fcollege_autonomous']),
                  $("#arrears").val(value['arrears']),
                  $("#no_arrears").val(value['no_arrears']),
                  // $("#sem_arrears").val(value['sem_arrears']),
                  $("#b_name").val(value['b_name']).change(),
                  $("#sem_from").val(value['sem_from']).change(),

                  $("#tcollege").val(value['tcollege']).change(),
                  $("#tcollege_autonomous").val(value['tcollege_autonomous']),
                  $("#sem_to").val(value['sem_to']),
                  $("#last_appeared_month").val(value['last_appeared_month']),
                  $("#last_appeared_year").val(value['last_appeared_year']),
                  $("#last_appeared_reg_no").val(value['last_appeared_reg_no']),
                  $("#last_appeared_semester").val(value['last_appeared_semester']),
                  $("#tcr_last_appeared_semester").val(value['tcr_last_appeared_semester']),
                  $("#reason").val(value['reason']),
                  $("#total_periods").val(value['total_periods']),
                  $("#attended_periods").val(value['attended_periods']),
                  $("#attendence_percentage").val(value['attendence_percentage']),

                  // $("#tnea_reg_no").val(value['tnea_reg_no']),
                  $("#community").val(value['community']),
                  $("#quota").val(value['quota']),
                  // $("#fg").val(value['fg']),
                  // $("#pms").val(value['pms']),
                  $("#board").val(value['board']);

                if (value['board'] === 'XII') {
                  $("#mark1_row").show();
                  $("#mark2_row").show();
                  $("#mark3_row").show();
                  $("#cutoff_row").show();
                  $("#mark1_dip").hide();
                  $("#mark2_dip").hide();
                  $("#cutoff_dip").hide();
                  $("#mark1").val(value['mark1']);
                  $("#mark2").val(value['mark2']);
                  $("#mark3").val(value['mark3']);
                  $("#cut_off").val(value['cut_off']);
                } else {
                  $("#mark1_row").hide();
                  $("#mark2_row").hide();
                  $("#mark3_row").hide();
                  $("#cutoff_row").hide();
                  $("#mark1_dip").show();
                  $("#mark2_dip").show();
                  $("#cutoff_dip").show();
                  $("#mark1dip").val(value['mark1']);
                  $("#mark2dip").val(value['mark2']);
                  $("#cut_offdip").val(value['cut_off']);
                }
                isFreezed = value['freezed'] == '1',
                  $("#freeze").prop("checked", value['freezed'] == '1')
              });

              $("#uploadBtn").prop("disabled", $("#freeze").is(':checked'));
              $("#submit").prop("disabled", $("#freeze").is(':checked'));
              $("#clear").prop("disabled", $("#freeze").is(':checked'));
            } catch (error) {
              $("#myModal").css("display", "block");
              $(".modal-content").css("background-color", "#ff6666");
              $("#message").text(error);
            }
            $("#loader").hide();

          }

        });
      }

      $("#loader").hide();
      $("input[type='radio'][name='request_for']").change(function() {
        //alert("Hello world");
        if ($("input[type='radio'][name='request_for']:checked").val() == "READMISSION CUM TRANSFER") {
          $("#tcr").css("display", "block");
        } else {
          //alert($("input[name='request_for']").val());
          $("#tcr").css("display", "none");


        }
      });

      $("#mark1_dip").hide();
      $("#mark2_dip").hide();
      $("#cutoff_dip").hide();


      $("#board").change(function() {
        if ($("#board").val() == 'XII') {
          $("#mark1_row").show();
          $("#mark2_row").show();
          $("#mark3_row").show();
          $("#cutoff_row").show();
          $("#mark1_dip").hide();
          $("#mark2_dip").hide();
          $("#cutoff_dip").hide();

        } else if ($("#board").val() == 'DIPLOMA') {
          $("#mark1_row").hide();
          $("#mark2_row").hide();
          $("#mark3_row").hide();
          $("#cutoff_row").hide();
          $("#mark1_dip").show();
          $("#mark2_dip").show();
          $("#cutoff_dip").show();

        }
      });

      $("#b_name").change(function() {
        $("#to_b_name").val($("#b_name").val());
      });
      $("#arrears").change(function() {
        if ($("#arrears").val() == 0) {
          $("#no_arrears").prop("disabled", true);
          // $("#sem_arrears").prop("disabled", true);
        } else {
          $("#no_arrears").prop("disabled", false);
          // $("#sem_arrears").prop("disabled", false);

        }
      });
      $("#sem_from").change(function() {
        $("#sem_to").val(parseInt($("#sem_from").val())+1);
        //console.log($("#sem_from").val()+1);
      });
      $("#tcollege").change(function() {
        $("#tcollege_forwarded").val($("#tcollege").val());
      });

      function getC_code(strs) {
        var newStr = "";
        for (var i = 0; i < strs.length && strs[i] != '-'; i++) {
          newStr += strs[i];
        }
        //console.log(newStr);
        return newStr;
      }
      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];
      span.onclick = function() {
        modal.style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }

      function validation() {
        if ($("#reg_no").val() == "" || $("#reg_no").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Register Number");
          return false;
        }
        if ($("#name_of_student").val() == "" || $("#name_of_student").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Name of Student");
          return false;
        }
        // if($("#address").val()=="" || $("#address").val()==null)
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
        if ($("#mobile").val() == "" || $("#mobile").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Mobile");
          return false;
        }
        if ($("#dob").val() == "" || $("#dob").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter dob");
          return false;
        }
        // if($("#email").val()=="" || $("#email").val()==null)
        // {
        //   $("#myModal").css("display","block");
        //   $(".modal-content").css("background-color","#ff6666");
        //   $("#message").text("Enter Email");
        //     return false;
        // }
        if ($("#admission_type").val() == "" || $("#admission_type").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Student Admitted Mode");
          return false;
        }
        if ($("#admission_month").val() == "" || $("#admission_month").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Admission Month");
          return false;
        }

        if ($("#admission_year").val() == "" || $("#admission_year").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Admission Year");
          return false;
        }
        if ($('input[name=request_for]:checked').length <= 0) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Transfer Type Required (Transfer/ Readmission cum Transfer)");
          return false;
        }

        // if ($("#tnea_reg_no").val() == "" || $("#tnea_reg_no").val() == null) {
        //   $("#myModal").css("display", "block");
        //   $(".modal-content").css("background-color", "#ff6666");
        //   $("#message").text("Enter TNEA Register Number");
        //   return false;
        // }
        if ($("#community").val() == "" || $("#community").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Community");
          return false;
        }
        if ($("#quota").val() == "" || $("#quota").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
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
        if ($("#fcollege").val() == "" || $("#fcollege").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter From College Name");
          return false;
        }
        if ($("#fcollege_autonomous").val() == "" || $("#fcollege_autonomous").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Select From College Autonomous");
          return false;
        }
        if ($("#arrears").val() == "" || $("#arrears").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Select Having Arrears or Not");
          return false;
        }
        if ($("#arrears").val() == 1) {
          if ($("#no_arrears").val() == "" || $("#no_arrears").val() == null) {
            $("#myModal").css("display", "block");
            $(".modal-content").css("background-color", "#ff6666");
            $("#message").text("Enter No of Arrears");
            return false;
          }
          // if ($("#sem_arrears").val() == "" || $("#sem_arrears").val() == null) {
          //   $("#myModal").css("display", "block");
          //   $(".modal-content").css("background-color", "#ff6666");
          //   $("#message").text("Enter Semester which you have Arrears");
          //   return false;
          // }
        }
        if ($("#sem_from").val() == "" || $("#sem_from").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("select From Semester");
          return false;
        }
        if ($("#b_name").val() == "" || $("#b_name").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Select Branch Name");
          return false;
        }
        if ($("#tcollege").val() == "" || $("#tcollege").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter To College Name");
          return false;
        }
        if ($("#tcollege_autonomous").val() == "" || $("#tcollege_autonomous").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Select To College Autonomous");
          return false;
        }
        if ($("#sem_to").val() == "" || $("#sem_to").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("select From Semester");
          return false;
        }
        if ($("#to_b_name").val() == "" || $("#to_b_name").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Select Branch Name");
          return false;
        }
        if ($("#last_appeared_month").val() == "" || $("#last_appeared_month").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Last Appeared Month");
          return false;
        }
        if ($("#last_appeared_year").val() == "" || $("#last_appeared_year").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Last Appeared Year");
          return false;
        }
        if ($("#last_appeared_semester").val() == "" || $("#last_appeared_semester").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Last Appeared Semester");
          return false;
        }
        if ($("#last_appeared_reg_no").val() == "" || $("#last_appeared_reg_no").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Last Appeared Register Number");
          return false;
        }
        if ($("#reason").val() == "" || $("#reason").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Reason for Transfer");
          return false;
        }
        if ($("#tcollege_forwarded").val() == "" || $("#tcollege_forwarded").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter To College Forwaded (Fill by Principal)");
          return false;
        }
        if ($("#total_periods").val() == "" || $("#total_periods").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Total No. of Periods");
          return false;
        }
        if ($("#attended_periods").val() == "" || $("#attended_periods").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter No. of Periods Attended");
          return false;
        }
        if ($("#attendence_percentage").val() == "" || $("#attendence_percentage").val() == null) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Enter Attendance Percentage");
          return false;
        }

        if (isUploadSuccessful == 0) {
          $("#myModal").css("display", "block");
          $(".modal-content").css("background-color", "#ff6666");
          $("#message").text("Upload PDF File!!");
          return;
        }

        //alert($("#fcollege_autonomous").val());
        // if($("#fcollege_autonomous").val()==1 || $("#tcollege_autonomous").val()==1)
        // {
        //   if($("#arrears").val()==1)
        //   {
        //     $("#myModal").css("display","block");
        //     $(".modal-content").css("background-color","#ff6666");
        //     $("#message").text("Arrear Students are not eligible to apply transfer");
        //     return false;
        //   }
        // }
        // end of the validation function
        return true;

      }

      $("#mainDiv").css("display", "block");

      $("#loader").hide();

      function clearme(isTrue = false) {
        if (isTrue)
          $("#displaypdf").html(null);
        $("#pdf_upload").val(null);
      }

      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];
      span.onclick = function() {
        modal.style.display = "none";
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
    <div class="modal-content" style="width:50%;background-color: #f08585;">
      <span class="close" style="margin-left:80%;">&times;</span>
      <h5 id="message" style="color:white;"></h5>

    </div>

  </div>
  <div id="loader"></div>
  <div class="mainDiv">
    <div class="single-div">
      <h3 style="margin: 0px auto;text-align: center;">Student Details</h3>
      <p style="margin: 0px auto;text-align: center;">
        (The Details of student be filled up below)
      </p>
      <hr />
      <div class="box-body">
        <div style="width: 35%;
            float: left;">
          <label for="reg_no">Register no</label>
          <input autocomplete="off" class="form-control" id="reg_no" name="reg_no" type="text" value="" />
        </div>

        <div style=" width: 60%;
            float: right;">
          <label for="name_of_student">Name of the Student (as per semester marksheet)</label>
          <input autocomplete="off" class="form-control" data-val="true" data-val-="The collegename field is ." id="name_of_student" name="name_of_student" type="text" value="" style="text-transform:uppercase" />
        </div>

        <!-- <div style="display: inline-block;width:100%;">
            <label for="address">Address 1 </label>
            <input
              autocomplete="off"
              class="form-control"
              data-val="true"
              data-val-="The collegename field is ."
              id="address"
              name="address"
              type="text"
              value=""
              style="text-transform:uppercase"
            />
          </div> -->

        <!-- <div>
            <label for="taluk">Address 2</label>
            <input
              autocomplete="off"
              class="form-control"
              data-val="true"
              data-val-="The collegename field is ."
              id="address2"
              name="addredd2"
              type="text"
              value=""
              style="text-transform:uppercase"
            />
          </div> -->

        <!-- <div style="display: inline-block;width: 40%;">
            <label for="district">District</label>
            <input
              autocomplete="off"
              class="form-control"
              data-val="true"
              data-val-="The collegename field is ."
              id="district"
              name="district"
              type="text"
              value=""
              style="text-transform:uppercase"
            />
          </div> -->

        <!-- <div style="float: right;width: 55%;">
            <label for="pincode">Pincode</label>
            <input
              autocomplete="off"
              class="form-control"
              data-val="true"
              data-val-="The collegename field is ."
              id="pincode"
              name="pincode"
              type="text"
              value=""
            />
          </div> -->

        <div style="display: inline-block;width: 40%;">
          <label for="mobile">Mobile</label>
          <input autocomplete="off" class="form-control" data-val="true" data-val-="The collegename field is ." id="mobile" name="mobile" type="text" value="" />
        </div>

        <div style="display: inline-block;width: 40%;">
          <label for="dob">Date of Birth</label>
          <input autocomplete="off" class="form-control" data-val="true" data-val-="The collegename field is ." id="dob" name="dob" type="date" value="" />
        </div>

        <!-- <div style="float: right;width: 55%;">
            <label for="email">Email ID</label>
            <input
              autocomplete="off"
              class="form-control"
              data-val="true"
              data-val-="The collegename field is ."
              id="email"
              name="email"
              type="text"
              value=""
              style="text-transform:uppercase"
            />
          </div> -->
      </div>
    </div>
    <div class="single-div">
      <h3 style="margin: 0px auto;text-align: center;">
        Month and Year of admission in First Year/Direct Second Year/PG
      </h3>
      <p style="margin: 0px auto;text-align: center;">
        (The Details of student be filled up below)
      </p>
      <hr />
      <div class="box-body">
        <div style="display: inline-block;width: 40%;">
          <label>Through which mode student<br />
            was originally admitted</label>
          <select class="form-control" id="admission_type" name="admission_type">
            <option value=""></option>
            <option value="UG DIRECT SECOND YEAR">UG-Direct Second Year</option>
            <option value="PG FIRST YEAR">PG-First Year</option>
            <option value="UG FIRST YEAR">UG-First Year</option>
            <!-- <option value="UG FIRST YEAR">UG-First Year</option> -->
            <option value="UG PART TIME">UG Part Time</option>
            <!-- <option value="PG PART TIME">PG Part Time</option> -->
          </select>
        </div>

        <div style="float: right;width: 25%;">
          <label>Month</label>
          <select class="form-control" id="admission_month">
            <option value=""></option>
            <option value=""></option>
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
        <div style="float: right;width: 30%;">
          <label>Year</label>
          <input class="form-control" type="text" id="admission_year" />
        </div>
        <div style="margin-top: 3%;">
          <input id="tranfer" type="radio" name="request_for" value="TRANSFER" />
          <label for="tranfer"><b>TRANSFER</b></label>
          <input id="t cum readmission" type="radio" name="request_for" value="READMISSION CUM TRANSFER" />
          <label for="t cum readmission"><b>READMISSION CUM TRANSFER</b></label>
        </div>
      </div>
    </div>
    <div class="single-div">
      <div class="box-body">
        <fieldset style="display: inline-block;">
          <table>
            <col width="200">
            <col width="100">
            <!-- <tr style="height: 60px;">
              <td>TNEA Reg.No</td>
              <td><input type="text" id="tnea_reg_no" style="width:150%;" /></td>
            </tr> -->
            <tr style="height: 85px;">
              <td>Community</td>
              <td>
                <select id="community" style="width:150%;">
                  <option value=""></option>
                  <option value="OC">OC</option>
                  <option value="BC">BC</option>
                  <option value="BCM">BCM</option>
                  <option value="MBC">MBC/DNC</option>
                  <option value="SC">SC</option>
                  <option value="SCA">SCA</option>
                  <option value="ST">ST</option>
                </select>
              </td>
            </tr>
            <tr style="height: 85px;">
              <td>Quota</td>
              <td>
                <select id="quota" style="width:150%;">
                  <option value=""></option>
                  <option value="GOVERNMENT">GOVERNMENT</option>
                  <option value="MANAGEMENT">MANAGEMENT</option>
                  <option value="LAP">LAP</option>
                  <option value="MIN">MIN</option>
                  <option value="NRI">NRI</option>
                  <option value="GOI">GOI</option>
                </select>
              </td>
            </tr>
            <!-- <tr>
              <td>
                Whether first graduate claimed for 2021-2023
              </td>
              <td>
                <select name="" id="fg">
                  <option value=""></option>
                  <option value="1">YES</option>
                  <option value="0">NO</option>
                </select>
              </td>
            </tr>

            <tr>
              <td>Whether post matric scholarship claimed for 2021-2023</td>
              <td>
                <select name="" id="pms">
                  <option value=""></option>
                  <option value="1">YES</option>
                  <option value="0">NO</option>
                </select>
              </td>
            </tr> -->
          </table>
        </fieldset>
        <fieldset style="float: right;">
          <legend>Only for Govt/Govt Aided/University Colleges</legend>
          <table>
            <col width="200">
            <col width="100">
            <tr>
              <td>Qualify Exam</td>
              <td>
                <!-- <input type="text" id="board" style="text-transform:uppercase" value="XII" > -->
                <select name="board" id="board" style="width:100%;">
                  <option value=""></option>
                  <option value="XII">XII</option>
                  <option value="DIPLOMA">DIPLOMA</option>
                </select>
              </td>
            </tr>
            <tr id="mark1_row">
              <td>Maths</td>
              <td>
                <input type="text" id="mark1">
              </td>
            </tr>
            <tr id="mark2_row">
              <td>Physics</td>
              <td>
                <input type="text" id="mark2">
              </td>
            </tr>
            <tr id="mark3_row">
              <td>Chemistry</td>
              <td>
                <input type="text" id="mark3">
              </td>
            </tr>
            <tr id="cutoff_row">
              <td>Cut off Out of 200</td>
              <td>
                <input type="text" id="cut_off">
              </td>
            </tr>
            <tr id="mark1_dip">
              <td>5th SEM MARK</td>
              <td>
                <input type="text" id="mark1dip">
              </td>
            </tr>
            <tr id="mark2_dip">
              <td>6th SEM MARK</td>
              <td>
                <input type="text" id="mark2dip">
              </td>
            </tr>
            <tr id="cutoff_dip">
              <td>Percentage</td>
              <td>
                <input type="text" id="cut_offdip">
              </td>
            </tr>
          </table>
        </fieldset>
      </div>
    </div>
    <!-- from college info -->
    <div class="single-div">
      <h3 style="margin: 0px auto;text-align: center;">Name of the Institution and branch in which student studied Even Sem(II,IV,VI,VIII,X)</h3>
      <hr />
      <div class="box-body">
        <div>
          <label>College Name</label>
          <input class="form-control" id="fcollege" readonly value="<?php echo $_SESSION['c_code'] . "-" . $_SESSION['college_name']; ?>">

        </div>
        <div style="width:30%;display: inline-block;">
          <label>Autonomous</label>
          <select name="" id="fcollege_autonomous" class="form-control">
            <option value=""></option>
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>

        <div style="width:20%;float:right;display:inline-block;">
          <label>Semester</label>
          <select name="" id="sem_from" class="form-control">
            <!-- <option value="" selected disabled></option> -->
            <option value=""></option>
            <option value="2">II</option>
            <option value="4">IV</option>
            <option value="6">VI</option>
            <option value="8">VIII</option>
            <option value="10">X</option>
          </select>
        </div>
        <div style="width:40%;float:right;display: inline-block;margin-right: 5%;">
          <label>Branch Name</label>
          <!--<input type="text" name="" id="b_name" class="form-control" >-->
          <select name="b_name" id="b_name" class="form-control">
            <option value=""></option>
            <option value="M.E APPLIED ELECTRONICS">M.E APPLIED ELECTRONICS</option>
            <option value="COMPUTER SCIENCE AND ENGINEERING (INTERNET OF THINGS)">COMPUTER SCIENCE AND ENGINEERING (INTERNET OF THINGS)</option>
            <option value="ARTIFICIAL INTELLIGENCE AND DATA SCIENCE">ARTIFICIAL INTELLIGENCE AND DATA SCIENCE</option>
            <option value="AERONAUTICAL ENGINEERING">AERONAUTICAL ENGINEERING</option>
            <option value="B.TECH AGRICULTURAL ENGINEERING">B.TECH AGRICULTURAL ENGINEERING</option>
            <option value="AGRICULTURE ENGINEERING">AGRICULTURE ENGINEERING</option>
            <option value="AGRICULTURAL ENGINEERING">AGRICULTURAL ENGINEERING</option>
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
        </div>
      </div>
      <div class="d-flex">
        <div class="mt-2" style="width:34%">
          <label>Have Arrears?</label>
          <select name="arrears" id="arrears" class="form-control">
            <option value=""></option>
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>
        <div class="p-2" style="width:30%;">
          <label>No. of Arrears</label>
          <input class="form-control" id="no_arrears" name="no_arrears" type="text">
        </div>
        <!-- <div class="p-2" style="width:30%;">
          <label>In Which Semester you have Arrears?</label>
          <select name="" id="sem_arrears" class="form-control">
            <option value=""></option>
            <option value="1">I</option>
            <option value="2">II</option>
            <option value="3">III</option>
            <option value="4">IV</option>
            <option value="5">V</option>
            <option value="6">VI</option>
            <option value="7">VII</option>
            <option value="8">VIII</option>
            <option value="9">IX</option>
          </select>
        </div> -->
      </div>
    </div>
    <div class="single-div">
      <h3 style="margin: 0px auto;text-align: center;">Name of the Institution and branch to which transfer is requested (III,V,VII,IX)</h3>

      <hr />
      <div class="box-body">
        <div>
          <label>College Name</label>
          <select name="" id="tcollege" class="form-control">
            <option value=""></option>
            <?php
            while ($row = $stmt->fetch_assoc()) :
            ?>
              <option value="<?php echo $row['c_code'] . "-" . $row['name_of_college_with_address']; ?>"><?php echo $row['c_code'] . "-" . $row['name_of_college_with_address']; ?></option>
            <?php endwhile ?>
          </select>
        </div>
        <div style="width:30%;display: inline-block;">
          <label>Autonomous</label>
          <select name="" id="tcollege_autonomous" class="form-control">
            <option value=""></option>
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>

        <div style="width:20%;float:right;display: inline-block;">
          <label>Semester</label>
          <!-- <select name="" id="sem_to" class="form-control" disabled>
                <option value=""></option>
                <option value="3">III</option>
                <option value="5">V</option>
                <option value="7">VII</option>
                <option value="9">IX</option>
              </select> -->
          <!-- <input type="text" name="" id="sem_to" class="form-control" readonly> -->
          <select name="" id="sem_to" class="form-control" disabled>
            <option value=""></option>
            <option value="3">III</option>
            <option value="5">V</option>
            <option value="7">VII</option>
            <option value="9">IX</option>
          </select>
        </div>
        <div style="width:40%;float:right;display: inline-block;margin-right: 5%;">
          <label>Branch Name</label>
          <input type="text" name="" id="to_b_name" class="form-control" readonly>


        </div>
      </div>
    </div>
    <div class="single-div">

      <div class="box-body">
        <div style="display: inline-block;">
          <label>Last Appeared Month</label>
          <select class="form-control" id="last_appeared_month">
            <option value=""></option>
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
        <div style="float: right;display: inline;">
          <label>Last Appeared Reg.No</label>
          <input type="text" class="form-control" id="last_appeared_reg_no">
        </div>
        <div style="display: inline-block;margin-left: 2%;">
          <label>Last Appeared Year</label>
          <input type="text" class="form-control" id="last_appeared_year">
        </div>
        <div style="float: right;margin-right: 2%;">
          <label>Last Appeared Semester</label>
          <select type="text" class="form-control" id="last_appeared_semester">
            <option value=""></option>
            <option value="2">II</option>
            <option value="4">IV</option>
            <option value="6">VI</option>
            <option value="8">VIII</option>
          </select>

        </div>

        <div style="float: right;margin-right: 2%;">
          <div>
            <div class="form-group">
              <label><b>Upload Last Semester Hallticket/Marksheet(Only pdf file Allowed.)</b></label>
              <form method="post" action="" enctype="multipart/form-data" id="uploadForm">
                <div>
                  <input required="" id="pdf_upload" name="pdfFile" type="file" accept=".pdf"><br>
                  <button id="uploadBtn" type="button" style="background-color: dodgerblue; color: white; border-radius: 6px; padding: 5px; margin-top: 10px;margin-left: 10px;">Upload</button>
                </div>
              </form>
            </div>
          </div>
          <div>
            <div class="form-group">
              <div id="displaypdf">

              </div>
            </div>

          </div>



        </div>


        <div id="tcr" style="display: none;width: 30%;margin-top: .5%;">
          <label>Mention the Odd semester in which student was put into lack of attendence</label>
          <select type="text" class="form-control" id="tcr_last_appeared_semester">
            <option value=""></option>
            <option value="3">III</option>
            <option value="5">V</option>
            <option value="7">VII</option>
            <option value="9">IX</option>
          </select>
        </div>
        <div>
          <label>Reason for transfer</label>
          <div style="width: 40%; height:150px">
            <input type="text" class="form-control" id="reason" maxlength="120">
          </div>
        </div>


      </div>
    </div>
    <div class="single-div">
      <h3 style="margin: 0px auto;text-align: center;">To be Filled by the Principal of institution in which student at present studying</h3>
      <hr>
      <div class="box-body">
        <div>
          <label>Forwarded to the principal</label>
          <input type="text" class="form-control" id="tcollege_forwarded">
        </div>
        <table>
          <col width="300">
          <col width="150">
          <tr>
            <td>Total No.of Periods taken into account for calculation of attendence for the above semester </td>
            <td>
              <input type="text" class="form-control" id="total_periods">
            </td>
          </tr>
          <tr>
            <td>No.of Periods attended by the student </td>
            <td>
              <input type="text" class="form-control" id="attended_periods">
            </td>
          </tr>
          <tr>
            <td>Percentage of attendence in Even semester(II,IV,VI,VIII)2024-2025</td>
            <td>
              <input type="text" class="form-control" id="attendence_percentage">
            </td>
          </tr>
        </table>


      </div>
    </div>
    <div class="single-div" style="margin: 0px auto; text-align: center;width:98%">
      <div class="box-body">
        <h3>Do you Want to freeze?</h3>
        <label class="switch">
          <input type="checkbox" id="freeze">
          <span class="slider round"></span>
        </label>
      </div>
    </div>
  </div>

  </div>st

  <div style="margin: 2px auto; text-align: center;">
    <button class="btn btn-success" id="submit">Submit</button>
    <!-- <button onclick="demo()"  style="background-color:red;min-height:45px;min-width:80px;color:white">print</button>
    <script>
      function demo()
      {
            alert("The print option is under maintenance and it will be enabled as soon as possible");
      }
      </script> -->
    <button class="btn btn-primary" id="print">Print</button>
    <button class="btn btn-warning" id="clear">Clear</button>
    <a style="text-decoration:none;color:white;" href="../user/#from"><button class="btn btn-success" id="home">Home</button></a>

  </div>
</body>

</html>