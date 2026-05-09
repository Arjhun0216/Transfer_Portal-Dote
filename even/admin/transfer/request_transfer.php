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
      
        $("#loader").hide();
        $("input[type='radio'][name='request_for']").change(function(){
          //alert("Hello world");
            if($("input[type='radio'][name='request_for']:checked").val()=="TRANSFER CUM READMISSION")
            {
             $("#tcr").css("display","block");
            }
            else
            {
              //alert($("input[name='request_for']").val());
              $("#tcr").css("display","none");
              
              
            }
        });
        $("#b_name").change(function(){
            $("#to_b_name").val($("#b_name").val());
        });
        $("#sem_from").change(function(){
            $("#sem_to").val(parseInt($("#sem_from").val())+1);
            //console.log($("#sem_from").val()+1);
        });
        $("#tcollege").change(function(){
            $("#tcollege_forwarded").val($("#tcollege").val());
        });
        function getC_code(strs)
        {
          var newStr="";
           for(var i=0;i<strs.length && strs[i]!='-';i++)
           {
              newStr+=strs[i];
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
  if($("#address").val()=="" || $("#address").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Address");
      return false;
  }
  if($("#address2").val()=="" || $("#address2").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Address2");
      return false;
  }
  
  if($("#district").val()=="" || $("#district").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter District");
      return false;
  }
  if($("#pincode").val()=="" || $("#pincode").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Pincode");
      return false;
  }
  if($("#mobile").val()=="" || $("#mobile").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Mobile");
      return false;
  }
  if($("#email").val()=="" || $("#email").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Email");
      return false;
  }
  if($("#admission_type").val()=="" || $("#admission_type").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Student Adn=mitted Mode");
      return false;
  }
  if($("#admission_month").val()=="" || $("#admission_month").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Admission Month");
      return false;
  }
  
  if($("#admission_year").val()=="" || $("#admission_year").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Admission Year");
      return false;
  }
  if($('input[name=request_for]:checked').length <=0)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Transfer Type Required (Transfer/ Transfer cum Readmission");
      return false;
  }
  
  if($("#tnea_reg_no").val()=="" || $("#tnea_reg_no").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter TNEA Register Number");
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
  if($("#fg").val()=="" || $("#fg").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Whether First Graduate or Not");
      return false;
  }if($("#pms").val()=="" || $("#pms").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("whether Post Metric Scholarship");
      return false;
  }
  if($("#fcollege").val()=="" || $("#fcollege").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter From College Name");
      return false;
  }
  if($("#fcollege_autonomous").val()=="" || $("#fcollege_autonomous").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select From College Autonomous");
      return false;
  }
  if($("#sem_from").val()=="" || $("#sem_from").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("select From Semester");
      return false;
  }
  if($("#b_name").val()=="" || $("#b_name").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select Branch Name");
      return false;
  }
  if($("#tcollege").val()=="" || $("#tcollege").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter To College Name");
      return false;
  }
  if($("#tcollege_autonomous").val()=="" || $("#tcollege_autonomous").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select To College Autonomous");
      return false;
  }
  if($("#sem_to").val()=="" || $("#sem_to").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("select From Semester");
      return false;
  }
  if($("#to_b_name").val()=="" || $("#to_b_name").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Select Branch Name");
      return false;
  }
  if($("#last_appeared_month").val()=="" || $("#last_appeared_month").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Last Appeared Month");
      return false;
  }
  if($("#last_appeared_year").val()=="" || $("#last_appeared_year").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Last Appeared Year");
      return false;
  }
  if($("#last_appeared_semester").val()=="" || $("#last_appeared_semester").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Last Appeared Semester");
      return false;
  }
  if($("#last_appeared_reg_no").val()=="" || $("#last_appeared_reg_no").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Last Appeared Register Number");
      return false;
  }
  if($("#reason").val()=="" || $("#reason").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Reason for Transfer");
      return false;
  }
  if($("#tcollege_forwarded").val()=="" || $("#tcollege_forwarded").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter To College Forwaded (Fill by Principal)");
      return false;
  }
  if($("#total_periods").val()=="" || $("#total_periods").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Total No. of Periods");
      return false;
  }
  if($("#attended_periods").val()=="" || $("#attended_periods").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter No. of Periods Attended");
      return false;
  }
  if($("#attendence_percentage").val()=="" || $("#attendence_percentage").val()==null)
  {
    $("#myModal").css("display","block");
    $(".modal-content").css("background-color","#ff6666");
    $("#message").text("Enter Attendance Percentage");
      return false;
  }
  return true;
          
}
        $("#submit").click(function(){
          if(!validation())
          {
            return;
          }
              if($("#freeze").is(":checked"))
              {
                  var one=confirm("Once You Freeze You can not able to edit this data, Do you really want to Freeze?");
                  if(one==false)
                  {
                    return;
                  }
              }
            $.post("add_request_transfer.php",{
              add_transfer:null,
              reg_no:$("#reg_no").val(),
              name_of_student:$("#name_of_student").val().toUpperCase(),
              address:$("#address").val().toUpperCase(),
              address2:$("#address2").val().toUpperCase(),
              district:$("#district").val().toUpperCase(),
              pincode:$("#pincode").val(),
              mobile:$("#mobile").val(),
              email:$("#email").val(),
              admission_type:$("#admission_type").val(),
              admission_year:$("#admission_year").val(),
              admission_month:$("#admission_month").val(),
              request_for:$("input[name=request_for]:checked").val(),
              fcollege_c_code:getC_code($("#fcollege").val()),
              fcollege:$("#fcollege").val(),
              fcollege_autonomous:$("#fcollege_autonomous").val(),
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

              tnea_reg_no:$("#tnea_reg_no").val(),
              community:$("#community").val(),
              quota:$("#quota").val(),
              fg:$("#fg").val(),
              pms:$("#pms").val(),
              board:$("#board").val().toUpperCase(),
              mark1:$("#mark1").val(),
              mark2:$("#mark2").val(),
              mark3:$("#mark3").val(),
              cut_off:$("#cut_off").val(),
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
              if(status==404)
              {
                $("#myModal").css("display","block");
                  $(".modal-content").css("background-color","#ff6666");
                  $("#message").text('Cannot Access web');
              }
              if(data=="success"){
                isFreezed=$("#freeze").is(':checked');
                $("#submit").prop("disabled",$("#freeze").is(':checked'));
                $("#clear").prop("disabled",$("#freeze").is(':checked'));
              $("#myModal").css("display","block");
              $(".modal-content").css("background-color","#baf1a1");
              $("#message").text("Submitted Successfully");
              }
              else
              {
                  $("#myModal").css("display","block");
                  $(".modal-content").css("background-color","#ff6666");
                  $("#message").text(data);
              }
            });
        });
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
            <label for="name_of_student">Name of the Student</label>
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
          </div>

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

          <div style="float: right;width: 55%;">
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
          </div>
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
            <label for="tranfer">TRANSFER</label>
            <input id="t cum readmission" type="radio" name="request_for" value="TRANSFER CUM READMISSION" />
            <label for="t cum readmission">TRANSFER CUM READMISSION</label>
          </div>
        </div>
      </div>
      <div class="single-div">
        <div class="box-body" >
          <fieldset style="display: inline-block;">
          <table>
            <col width="200">
             <col width="150">
            <tr>
              <td>TNEA Reg.No</td>
              <td><input type="number" id="tnea_reg_no" style="width:150%;" /></td>
            </tr>
            <tr>
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
            <tr>
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
            <tr>
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
            </tr>
          </table>
        </fieldset>
          <fieldset style="float: right;">
            <legend >Only for Govt and Aided Colleges</legend>
          <table>
            <col width="200">
            <col width="100">
            <tr>
              <td>Qualify Exam</td>
              <td>
                <input type="text" id="board" style="text-transform:uppercase" >
              </td>
            </tr>
            <tr>
              <td>Maths/Semester V</td>
              <td>
                <input type="number" id="mark1">
              </td>
            </tr>
            <tr>
              <td>Physics/Semester VI</td>
              <td>
                <input type="number" id="mark2">
              </td>
            </tr>
            <tr>
              <td>Chemistry</td>
              <td>
                <input type="number" id="mark3">
              </td>
            </tr>
            <tr>
              <td>Cut off Out of 200</td>
              <td>
                <input type="number" id="cut_off">
              </td>
            </tr>
          </table>
        </fieldset>
        </div>
      </div>
        <div class="single-div">
          <h3 style="margin: 0px auto;text-align: center;">Name of the Institution and branch in which student studied Even Sem(II,IV,VI,VIII)</h3>
         
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
                <option value="" selected disabled></option>
                <option value="2">II</option>
                <option value="4">IV</option>
                <option value="6">VI</option>
                <option value="8">VIII</option>
              </select>
            </div>
            <div style="width:40%;float:right;display: inline-block;margin-right: 5%;">
              <label>Branch Name</label>
              <input type="text" name="b_name" id="b_name" class="form-control">
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
              <input type="number" class="form-control" id="last_appeared_year">
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
            <div id="tcr" style="display: none;width: 30%;margin-top: .5%;">
              <label>Mention the Even semester in which student was put into lack of attendence</label>
              <select type="text" class="form-control" id="tcr_last_appeared_semester">
                <option value=""></option>
                <option value="3">III</option>
                <option value="5">V</option>
                <option value="7">VII</option>
                <option value="9">IX</option>
                </select>
            </div>
            <div >
              <label>Reason for transfer</label>
              <input type="text" class="form-control" id="reason">
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
