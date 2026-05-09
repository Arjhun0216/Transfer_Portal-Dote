<?php
session_start();
if(!isset($_SESSION['admin_login']))
{
  die("INVALID");
}
include '../../user/database.php';
$sql="select c_code,name_of_college_with_address from college_details";
if($stmt=$conn->query($sql))
{

}
else
{
  die("Something went wrong");
}
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
<html lang="en">
  <head>
    <title>Transfer/Transfer Cum Readmission</title>
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
      
      input:checked + .slider {
        background-color: #2196F3;
      }
      
      input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
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
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="transfer.css" />
    <link rel="stylesheet" href="../../../styles/loader.css">
    <link rel="stylesheet" href="../../../styles/modal.css">
    <!-- <link rel="stylesheet" href="loader.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
  $(document).ready(function(){
    var isUploadSuccessful = 0;
    var value1 = "";
    $("#loader").hide();
    
    // Board selection handling
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

    $("input[type='radio'][name='request_for']").change(function(){
      if($("input[type='radio'][name='request_for']:checked").val()=="TRANSFER CUM READMISSION") {
        $("#tcr").css("display","block");
      } else {
        $("#tcr").css("display","none");
      }
    });

    $("#uploadBtn").click(function() {
      var formData = new FormData();
      var files = $('#pdf_upload')[0].files[0];
      if (files) {
        showLoading();
        formData.append('file', files);
        formData.append('c_code', getC_code($("#fcollege").val()));
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
              $("#myModal").css("display", "block");
              $(".modal-content").css("background-color", "#33ff33");
              $("#message").text("File uploaded successfully");
              var linkHtml = ' <div><label>Click here to view the PDF File</label></div><a href="../../request_transfer/last_semester_marksheet/' + value1 + '.pdf" target="_blank" style="color: #007bff; text-decoration: none; font-weight: bold; border: 1px solid #007bff; padding: 5px 10px; border-radius: 5px; background-color: #f2f2f2;">' + value1 + '.pdf</a>';
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

    $("#b_name").change(function(){
      $("#to_b_name").val($("#b_name").val());
    });
    
    $("#sem_from").change(function(){
      $("#sem_to").val(parseInt($("#sem_from").val())+1);
    });
    
    $("#tcollege").change(function(){
      $("#tcollege_forwarded").val($("#tcollege").val());
    });
    
    function getC_code(strs) {
      var newStr="";
      for(var i=0;i<strs.length && strs[i]!='-';i++) {
        newStr+=strs[i];
      }
      return newStr;
    }

    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    function validation() {
      if($("#reg_no").val()=="" || $("#reg_no").val()==null) {
        $("#myModal").css("display","block");
        $(".modal-content").css("background-color","#ff6666");
        $("#message").text("Enter Register Number");
        return false;
      }
      
      if($("#name_of_student").val()=="" || $("#name_of_student").val()==null) {
        $("#myModal").css("display","block");
        $(".modal-content").css("background-color","#ff6666");
        $("#message").text("Enter Name of Student");
        return false;
      }

      // Add board validation
      if($("#board").val()=="" || $("#board").val()==null) {
        $("#myModal").css("display","block");
        $(".modal-content").css("background-color","#ff6666");
        $("#message").text("Select Board (XII/DIPLOMA)");
        return false;
      }

      if($("#board").val() == 'XII') {
        if($("#mark1").val()=="" || $("#mark1").val()==null) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text("Enter Maths Mark");
          return false;
        }
        if($("#mark2").val()=="" || $("#mark2").val()==null) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text("Enter Physics Mark");
          return false;
        }
        if($("#mark3").val()=="" || $("#mark3").val()==null) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text("Enter Chemistry Mark");
          return false;
        }
        if($("#cut_off").val()=="" || $("#cut_off").val()==null) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text("Enter Cut Off Mark");
          return false;
        }
      } else {
        if($("#mark1dip").val()=="" || $("#mark1dip").val()==null) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text("Enter 5th Sem Mark");
          return false;
        }
        if($("#mark2dip").val()=="" || $("#mark2dip").val()==null) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text("Enter 6th Sem Mark");
          return false;
        }
        if($("#cut_offdip").val()=="" || $("#cut_offdip").val()==null) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text("Enter Percentage");
          return false;
        }
      }

      // Rest of your existing validation checks...
      return true;
    }

    $("#submit").click(function(){
      if(!validation()) {
        return;
      }
      
      if($("#freeze").is(":checked")) {
        var one=confirm("Once You Freeze You can not able to edit this data, Do you really want to Freeze?");
        if(one==false) {
          return;
        }
      }

      // Get mark values based on board selection
      var mark1Value, mark2Value, mark3Value, cutOffValue;
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

      $.post("add_request_transfer.php",{
        add_transfer:null,
        reg_no:$("#reg_no").val(),
        name_of_student:$("#name_of_student").val().toUpperCase(),
        mobile:$("#mobile").val(),
        dob:$("#dob").val(),
        admission_type:$("#admission_type").val(),
        admission_year:$("#admission_year").val(),
        admission_month:$("#admission_month").val(),
        request_for:$("input[name=request_for]:checked").val(),
        fcollege_c_code:getC_code($("#fcollege").val()),
        fcollege:$("#fcollege").val(),
        fcollege_autonomous:$("#fcollege_autonomous").val(),
        arrears: $("#arrears").val(),
        no_arrears: $("#no_arrears").val(),
        b_name:$("#b_name").val(),
        sem_from:$("#sem_from").val(),
        tcollege_c_code:getC_code($("#tcollege").val()),
        tcollege:$("#tcollege").val(),
        tcollege_autonomous:$("#tcollege_autonomous").val(),
        sem_to:$("#sem_to").val(),
        last_appeared_month:$("#last_appeared_month").val(),
        last_appeared_year:$("#last_appeared_year").val(),
        last_appeared_reg_no:$("#last_appeared_reg_no").val(),
        last_appeared_semester:$("#last_appeared_semester").val(),
        tcr_last_appeared_semester:$("#tcr_last_appeared_semester").val(),
        reason:$("#reason").val().toUpperCase(),
        total_periods:$("#total_periods").val(),
        attended_periods:$("#attended_periods").val(),
        attendence_percentage:$("#attendence_percentage").val(),
        community:$("#community").val(),
        quota:$("#quota").val(),
        board:$("#board").val().toUpperCase(),
        mark1: mark1Value,
        mark2: mark2Value,
        mark3: mark3Value,
        cut_off: cutOffValue,
        freezed:$("#freeze").is(':checked')==true?1:0,
        freezed_to:2,
        tcollege_sanctioned_intake:$("#tcollege_sanctioned_intake").val(),
        tcollege_total_students:$("#tcollege_total_students").val(),
        tcollege_total_after:$("#tcollege_total_after").val(),
        status:$("#status").val(),
        status_reason:$("#status_reason").val(),
        sanctioned_intake:$("#sanctioned_intake").val(),
        admitted:$("#admitted").val(),
        vacancy:$("#vacancy").val()
      },function(data,status){
        if(status==404) {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text('Cannot Access web');
        }
        if(data=="success"){
          isFreezed=$("#freeze").is(':checked');
          $("#uploadBtn").prop("disabled", $("#freeze").is(':checked'));
          $("#submit").prop("disabled",$("#freeze").is(':checked'));
          $("#clear").prop("disabled",$("#freeze").is(':checked'));
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#baf1a1");
          $("#message").text("Submitted Successfully");
        } else {
          $("#myModal").css("display","block");
          $(".modal-content").css("background-color","#ff6666");
          $("#message").text(data);
        }
      });
    });
    
    $("#mainDiv").css("display", "block");
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
          <div
            style="width: 35%;
            float: left;"
          >
            <label for="reg_no">Register no</label>
            <input
              autocomplete="off"
              class="form-control"
              id="reg_no"
              name="reg_no"
              type="text"
              value=""
            />
          </div>

          <div
            style=" width: 60%;
            float: right;"
          >
            <label for="name_of_student">Name of the Student (as per semester marksheet)</label>
            <input
              autocomplete="off"
              class="form-control"
              data-val="true"
              data-val-="The collegename field is ."
              id="name_of_student"
              name="name_of_student"
              type="text"
              value=""
              style="text-transform:uppercase"
            />
          </div>
<!-- 
          <div style="display: inline-block;width:100%;">
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
          </div>

          <div>
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
          </div>

          <div style="display: inline-block;width: 40%;">
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
          </div>

          <div style="float: right;width: 55%;">
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
            <input
              autocomplete="off"
              class="form-control"
              data-val="true"
              data-val-="The collegename field is ."
              id="mobile"
              name="mobile"
              type="text"
              value=""
            />
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
            <label 
              >Through which mode student<br />
              was originally admitted</label
            >
            <select class="form-control" id="admission_type" name="admission_type">
              <option value=""></option>
              <option value="UG DIRECT SECOND YEAR"
                >UG-Direct Second Year</option>
              <option value="PG FIRST YEAR">PG-First Year</option>
              <option value="UG FIRST YEAR">UG-First Year</option>
            </select>
          </div>

          <div style="float: right;width: 25%;">
            <label >Month</label>
            <select class="form-control" id="admission_month" >
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
            <label >Year</label>
            <input class="form-control" type="number" id="admission_year"/>
          </div>
          <div style="margin-top: 3%;">
            <input id="tranfer" type="radio" name="request_for" value="TRANSFER"/>
            <label for="tranfer"><b>TRANSFER</b></label>
            <input id="t cum readmission" type="radio" name="request_for" value="TRANSFER CUM READMISSION" />
            <label for="t cum readmission"><b>TRANSFER CUM READMISSION</b></label>
          </div>
        </div>
      </div>
      <div class="single-div">
        <div class="box-body" >
          <fieldset style="display: inline-block;">
          <table>
            <col width="200">
             <col width="100">
            <!-- <tr>
              <td>TNEA Reg.No</td>
              <td><input type="number" id="tnea_reg_no" style="width:150%;" /></td>
            </tr> -->
            <tr style="height: 90px;">
              <td>Community</td>
              <td>
                <select id="community" style="width:150%;">
                  <option value=""></option>
                  <option value="OC">OC</option>
                  <option value="BC">BC</option>
                  <option value="MBC">MBC/DNC</option>
                  <option value="SC">SC</option>
                  <option value="SCA">SCA</option>
                  <option value="ST">ST</option>
                </select>
              </td>
            </tr>
            <tr style="height: 90px;">
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
              <td>Whether first graduate claimed for 2020-2024</td>
              <td>
                <select name="" id="fg">
                  <option value=""></option>
                  <option value="1">YES</option>
                  <option value="0">NO</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Whether post matric scholarship claimed for 2020-2024</td>
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
</fieldset>        </fieldset>
        </div>
      </div>
        <div class="single-div">
          <h3 style="margin: 0px auto;text-align: center;">Name of the Institution and branch in which student studied Even Sem(II,IV,VI,VIII,X)</h3>
         
          <hr />
          <div class="box-body">
            <div>
              <label>College Name</label>
              <select name="fcollege" id="fcollege" class="form-control">
               <option value=""></option>
              <?php
                while($row=$stmt->fetch_assoc()):
              ?>
              <option value="<?php echo $row['c_code']."-".$row['name_of_college_with_address']; ?>"><?php echo $row['c_code']."-".$row['name_of_college_with_address']; ?></option>
              <?php endwhile?>
             </select>
              
              </div>
            <div style="width:30%;display: inline-block;">
              <label>Autonomous</label>
              <select name="" id="fcollege_autonomous" class="form-control">
                <option value=""></option>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            
            <div style="width:20%;float:right;display: inline-block;">
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
              <!-- <input type="text" name="b_name" id="b_name" class="form-control"> -->
              <select name="b_name" id="b_name" class="form-control">
            <option value=""></option>
            <option value="M.E APPLIED ELECTRONICS">M.E APPLIED ELECTRONICS</option>
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
          <!-- <option value=""></option>
                <option value="AE-Aeronautical Engineering">Aeronautical Engineering</option>
                <option value="AR-Architecture">Architecture</option>
                <option value="AI-Agriculture & Irrigation Engineering">Agriculture & Irrigation Engineering</option>
                <option value="AP-Apparel Technology">Apparel Technology</option>
                <option value="AU-Automobile Engineering">Automobile Engineering</option>
                <option value="BM-Bio-Medical Engineering">Bio-Medical Engineering</option>
                <option value="CR-Ceramic Technology">Ceramic Technology</option>
                <option value="CH-Chemical Engineering">Chemical Engineering</option>
                <option value="CE-Civil Engineering">Civil Engineering</option>
                <option value="CS-Computer Science and Engg.">Computer Science and Engg.</option>
                <option value="EE-Electrical and Electronics">Electrical and Electronics</option>
                <option value="EC-Electronics & Communication">Electronics & Communication</option>
                <option value="EI-Electronics & Instrumentation">Electronics & Instrumentation</option>
                <option value="FT-Food Technology">Food Technology</option>
                <option value="GI-Geo-Informatics">Geo-Informatics</option>
                <option value="IB-Industrial Bio-Technology">Industrial Bio-Technology</option>
                <option value="IE-Industrial Engineering">Industrial Engineering</option>
                <option value="IT-Information Technology">Information Technology</option>
                <option value="LE-Leather Technology">Leather Technology</option>
                <option value="MN-Manufacturing Engineering">Manufacturing Engineering</option>
                <option value="MS-Material Science & Engineering">Material Science & Engineering</option>
                <option value="ME-Mechanical Engineering">Mechanical Engineering</option>
                <option value="MI-Mining Engineering">Mining Engineering</option>
                <option value="PH-Pharmaceutical Technology">Pharmaceutical Technology</option>
                <option value="PT-Printing Technology">Printing Technology</option>
                <option value="PET-Petroleum Engineering & Technology">Petroleum Engineering & Technology</option>
                <option value="PE-Production Engineering">Production Engineering</option>
                <option value="RP-Rubber and Plastics Technology">Rubber and Plastics Technology</option>
                <option value="TX-Textile Technology">Textile Technology</option>
     
              </select> -->
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
              <select name="tcollege" id="tcollege" class="form-control">
               <option value=""></option>
              <?php
                while($row1=$stmt1->fetch_assoc()):
              ?>
              <option value="<?php echo $row1['c_code']."-".$row1['name_of_college_with_address']; ?>"><?php echo $row1['c_code']."-".$row1['name_of_college_with_address']; ?></option>
              <?php endwhile?>
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
              <input type="text" name="" id="to_b_name" class="form-control"  readonly>
                
              
            </div>
        </div>
        </div>
        <div class="single-div">
          
          <div class="box-body">
            <div style="display: inline-block;">
              <label >Last Appeared Month</label>
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
          <div >
            <label >Forwarded to the principal</label>
          <input  type="text" class="form-control"  id="tcollege_forwarded" >
          </div>
          <table>
            <col width="300">
            <col width="150">
            <tr>
              <td>Total No.of Periods taken into account for calculation of attendence for the above semester </td>
              <td>
                <input type="number" class="form-control" id="total_periods">
              </td>
            </tr>
            <tr>
              <td>No.of Periods attended by the student </td>
              <td>
                <input type="number" class="form-control" id="attended_periods">
              </td>
            </tr>
            <tr>
              <td>Percentage of attendence in Even semester(II,IV,VI,VIII)2020-2024</td>
              <td>
                <input type="number" class="form-control" id="attendence_percentage">
              </td>
            </tr>
          </table>
         
          
      </div>
    </div>
    <div class="single-div">
        
        <div class="box-body">
          <table>
            <col width="300">
            <col width="150">
            <tr>
              <td>Sactioned Intake in this branch in the respective academic year</td>
              <td>
                <input type="number" class="form-control" id="tcollege_sanctioned_intake">
              </td>
            </tr>
            <tr>
              <td>Total No. of students on roll in this branch and semester as on date</td>
              <td>
                <input type="number" class="form-control" id="tcollege_total_students">
              </td>
            </tr>
            <tr>
              <td>Total No. of students in this branch and semester including transferee</td>
              <td>
                <input type="number" class="form-control" id="tcollege_total_after">
              </td>
            </tr>
          </table>
         
          
      </div>
    </div>
    <div class="single-div">
        
        <div class="box-body">
          <!-- <table>
            <col width="200">
            <col width="600">
            <tr>
              <td>Approval Status</td>
              <td>
                <select type="number" class="form-control" id="status">
                  <option value=""></option>
                  <option value="O" disabled>Order Generated</option>
                  <option value="A">Approved</option>
                  <option value="R">Not Approved</option>
                  <option value="P">Pending</option>
    </select>
              </td>
            </tr>
            <tr>
              <td>Reason</td>
              <td>
                <input type="text" class="form-control" id="status_reason">
              </td>
            </tr>

            <tr>
              <td>Sanctioned Intake</td>
              <td>
                <input type="text" class="form-control" id="sanctioned_intake">
              </td>
            </tr>

            <tr>
              <td>Admitted</td>
              <td>
                <input type="text" class="form-control" id="admitted">
              </td>
            </tr>

            <tr>
              <td>Vacancy</td>
              <td>
                <input type="text" class="form-control" id="vacancy">
              </td>
            </tr>

            
            
          </table>
          -->
          
      </div>
    </div>

    <!-- sanctioned intake, admitted, vacancy -->


    <div class="single-div" style="margin: 0px auto; text-align: center;width:98%">
    <div class="box-body">
      <h3>Freezed?</h3>
    <label class="switch">
      <input type="checkbox" id="freeze">
      <span class="slider round"></span>
    </label>
  </div>
  </div>
      </div>
      
    </div>
    
    <div style="margin: 2px auto; text-align: center;">

    <button class="btn btn-success" id="submit">Save</button>
    <button class="btn btn-warning" id="home"><a href="../index.php">Home</a></button>
    
    </div>
  </body>
</html>
