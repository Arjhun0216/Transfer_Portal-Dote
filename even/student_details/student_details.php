<?php
session_start();
include '../user/head.php';
include '../user/database.php';
if(!isset($_SESSION['c_code']))
{
    $_SESSION['redirect']=$_SERVER['REQUEST_URI'];
    header("Location:/user/log_in.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="google" content="notranslate">
        <title>Student_Registration</title>
        <link rel="stylesheet" href="../styles/modal.css">
        <link rel="stylesheet" href="student_details.css">
        <link rel="stylesheet" href="jQuery-ui\jquery-ui.css">
        <link rel="stylesheet" type="text/javascript"  href="jQuery-ui\jquery-ui.min.js">
        <link rel="stylesheet"  href="css\bootstrap.min.css">
        <link rel="stylesheet" type="text/javascript" href="js\bootstrap.min.js">
        <link rel="stylesheet" type="text/javascript" href="js\bootstrap.bundle.min.js">
        <link rel="stylesheet" href="loader.css">
        <link href="tabulator-master\dist\css\tabulator.css" rel="stylesheet">
        <script type="text/javascript" src="tabulator-master\dist\js\tabulator.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
  $(document).ready(function(){
      //Executes after loading
      
       
      $("#mainDiv").css("display","block");
      $("#mainDiv").hide();
      $("#loader").hide();
      $("#branch_name").hide();
      $("#category").on('change',function(){
          var category=$("#category").val();
          //$("#clear").trigger('change');
            if(category=="GOVERNMENT")
            {
                $("#mainDiv :input").prop("disabled", true);
                $("input[name=aicte_tfw]").prop("disabled",false);
                $("input[name=pms]").prop("disabled",false);
                $("input[name=fg]").prop("disabled",false);
                $("#fg_no").prop("disabled",false);
                $("#annual_income").prop("disabled",false);
                $("#fg_district").prop("disabled",false);
                $("input[name=availed_fg]").prop("disabled",false);
                $("#update").prop("disabled",false);
                $("#delete").prop("disabled",false);
                
                return;
            }
            else if(category=="MANAGEMENT" || category=="MIN" || category=="LAP" || category=="GOI" || category=="NRI" || category=="FOR")
            {       
                $("#mainDiv :input").prop("disabled", false);
                $("input[name=aicte_tfw]").prop("disabled",true);
                $("input[name=aicte_tfw][value=0]").prop("checked",true);
                $("input[name=fg]").prop("disabled",true);
                $("input[name=fg][value=0]").prop("checked",true);
                $("#fg_district").prop("disabled",true);
                $("#annual_income").prop("disabled",true);
                $("input[name=availed_fg]").prop("disabled",true);
                $("input[name=availed_fg][value=0]").prop("checked",true);
                $("input[name=fg_no]").prop("disabled",true);
            }
            else
            {
            
            }
           
      });
      $("#delete").click(function(){
          //alert("HEllo");
          if(!confirm("If you click 'OK' student record will be removed"))
          {
                return;
          }
          showLoading();
          $.post("delete_records.php",{
                a_no:$("#a_no").val(),
                b_code:$("#b_code").val()
          },function(data,status){
                //alert(data);
                if(data=="success")
                {
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#33ff33");
                    $("#message").text("Deleted Successfully");
                    $("#"+$("#a_no").val()).css("background-color","#ffcccc");
                    $("#mainDiv").hide();
                    
                }
                else
                {
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("Failed to delete");
                }
                hideLoading();
          });
      });
      
      $("#update").click(function(){
        if(!validateForm())
            {
                return ;
            }
           // $("html, body").animate({ scrollTop: 0 }, "slow");
            showLoading();
            // var fg_number=null;
            // if($("#fg").val()=="0")
            // {
            //     //alert("in");
            //     var fg_number=null;
            // }
            // else
            // {
            //    // alert("out");
            //     fg_number=$("#fg").val();

            // }
        $.post("update_records.php",{
            category:$("#category").val(),
             a_no:$("#a_no").val(),
             b_code:$("#b_code").val(),
             name:$("#name").val().toUpperCase(),
             dob:$("#dob").val(),
             gender:$("input[name='gender']:checked").val(),
             mobile:$("#mobile").val(),
             email:$("#email").val(),
             nationality:$("input[name='nationality']:checked").val(),
             nativity:$("input[name='nativity']:checked").val(),
             religion:$("#input").val(),
             community:$("#output").val(),
             caste_name:$("#casteop").val(),
             parent_occupation:$("#parent_occupation").val(),
             state:$("#state").val(),
             district:$("#district").val(),
             hsc_tn:$("input[name='hsc_tn']:checked").val(),
             qualifying_exam:$("#qualifying_exam").val(),
             name_of_board:$("#name_of_board").val(),
             year_of_passing:$("#year_of_passing").val(),
             hsc_reg_no:$("#hsc_reg_no").val(),
             hsc_group:$("input[name='hsc_group']:checked").val(),
             eleventh_pass:$("input[name='eleventh_pass']:checked").val(),
             physics_m:$("#physics_m").val(),
             physics_t:$("#physics_t").val(),
             chemistry_m:$("#chemistry_m").val(),
             chemistry_t:$("#chemistry_t").val(),
             maths_m:$("#maths_m").val(),
             maths_t:$("#maths_t").val(),
             optional_m:$("#optional_m").val(),
             optional_t:$("#optional_t").val(),
             annual_income:$("#annual_income").val(),
            aicte_tfw:$("input[name='aicte_tfw']:checked").val(),
            pms:$("input[name='pms']:checked").val(),
            fg:$("input[name='fg']:checked").val(),
            fg_district:$("#fg_district").val(),
            fg_no:$("#fg_no").val(),
            availed_fg:$("input[name='availed_fg']:checked").val()
         },function(data,status){
            //alert(data);
                hideLoading();
                if(data=="success")
                {
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#33ff33");
                    $("#message").text("Updated Successfully");
                    $("#mainDiv").hide();
                    $("#a_no").val(null);
                    $("#b_code").trigger('change');
                }
                else{
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("Failed to update");
                }
         });
     });

     $("input[type=radio][name=hsc_group]").change(function(){
        if($("input[name=hsc_group]:checked").val()=="VOCATIONAL")
            {
                changeTOSubject();
            }
            else
            {
            changeFROMSubject();
            }
            if($("#b_code").val()=='AR' || $("#b_code").val()=='BA')
        {
            changeTOArch();
        }
        $("#category").trigger('change');
     });
     function changeTOArch(){
        //alert("JJ");
            $("#s1").text("HSC Total");
            $("#s2").text("Diplomo Total")
            $("#s3").text("Maths");
            $("#s4").text("NATA");
          //  $("#hsc_reg_no").val()
     }
     function changeFROMSubject(){
        //alert("JJ");
            $("#s1").text("Physics");
            $("#s2").text("Chemistry")
            $("#s3").text("Maths");
            $("#s4").text("Optional");
          //  $("#hsc_reg_no").val()
     }
     function changeTOSubject(){
        //alert("JJ");
            $("#s1").text("Practical I");
            $("#s2").text("Practical II")
            $("#s3").text("Maths/Physics/Chemistry");
            $("#s4").text("Theory");
          //  $("#hsc_reg_no").val()
     }
     $("#clear").click(function(){
        $("#mainDiv :input").prop("disabled", false);
            clearme(true);
     });
      function clearme(isTrue=false){
            if(isTrue)
            $("#a_no").val(null);
            $("input[type=number][name=a_no]").prop("disabled",false);
            $("input:radio").prop("checked", false);
            $("input:radio").prop("disabled", false);
            $("#branch_name").hide();
             $("#category").val(1);
            $("#name").val(null);
            $("#dob").val(null);
            //$("#gender").removeAttr("checked");
            $("#mobile").val(null);
            $("#email").val(null);
            //$("#nationality").removeAttr("checked");
            //$("#nativity").removeAttr("checked");
            $("#input").val(1);
            $("#output").val(1);
            $("#casteop").val(null);
            $("#parent_occupation").val(1);
            $("#state").val(1);
            $("#district").val(1);
            //$("#hsc_tn").removeAttr("checked");
            $("#qualifying_exam").val(1);
            $("#name_of_board").val("");
            $("#year_of_passing").val(1);
            $("#hsc_reg_no").val(null);
            //$("#hsc_group").removeAttr("checked");
            //$("#eleventh_pass").removeAttr("checked");
            $("#physics_m").val(null);
            $("#physics_t").val(null);
            $("#chemistry_m").val(null);
            $("#chemistry_t").val(null);
            $("#maths_m").val(null);
            $("#maths_t").val(null);
            $("#optional_m").val(null);
            $("#optional_t").val(null);
            $("#annual_income").val(null);
            //$("#aicte_tfw").removeAttr("checked");
            //$("#pms").removeAttr("checked");
            //$("#fg").removeAttr("checked");
            $("#fg_district").val(1);
            $("#fg_no").val(null);
            //$("#availed_fg").removeAttr("checked");
            $("#mainDiv").hide();
      }
     //Executes when changed
     $("#b_code").change(function(){
        showLoading();
        $("#mainDiv").hide();
        $.post("get_records.php",{
          b_code:$("#b_code").val()
     },function(data,status)
     {
        hideLoading();
         $("#table_details").html(data);
     });
     });
     $("#table_details").on('click','button',function(){
         //alert("hhhh");
         clearme(false);
         $("#a_no").val($(this).val());
         $("#editBtn").click();
     });
     $("#editBtn").click(function(){
         
        if($("#a_no").val()!=="")
         {
            showLoading();
            clearme(false);
            $("#branch_name").show();
            $("#delete").show();
            $("#submit").hide();
            $("#update").show();
            $("#category").prop("disabled",true);
            $.post("get_records_ano.php",{
                a_no:$("#a_no").val(),
                b_code:$("#b_code").val()
            },function(data,status){
                hideLoading();
                if(data=="no_data")
                {
                    
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("Enter a valid application number");
                    return;
                }
               // alert(data);
              //$("#b_code").prop("disabled",true);
                 $("input[type=number][name=a_no]").prop("disabled",true);
                var result= $.parseJSON(data);
                $("#mainDiv").show();
                $("#submit").hide();
                $("#update").show();
               
                $.each( result, function( key, value ) { 
                    //$("#b_code").val(value['']),
                        //$("#a_no").val(value['']),
                        //console.log(value['annual_income']);
                        $("#category").val(value['catogory']).change(),
                        $("#name").val(value['name']),
                        $("#dob").val(value['dob']),
                        $("input[name='gender'][value="+value['gender']+"]").prop("checked",true),
                        $("#mobile").val(value['mobile']),
                        $("#email").val(value['email']),
                        $("input[name='nationality'][value="+value['nationality']+"]").prop("checked",true).change(),
                        $("input[name='nativity'][value="+value['nativity']+"]").prop("checked",true).change(),
                        $("#input").val(value['religion']),
                        $("#output").val(value['community']),
                        $("#casteop").val(value['caste_name']),
                        $("#parent_occupation").val(value['parent_occupation']),
                        $("#state").val(value['state']),
                        $("#district").val(value['district']),
                        $("input[name='hsc_tn'][value="+value['hsc_tn']+"]").prop("checked",true),
                        $("#qualifying_exam").val(value['qualifying_exam']).change(),
                        $("#name_of_board").val(value['name_of_board']=="TN-Tamil nadu Board of Higher Secondary Education"?"TN-Tamil nadu Board of Higher Secondary Education":"Others").change(),
                        $("#year_of_passing").val(value['year_of_passing']),
                        $("#hsc_reg_no").val(value['hsc_reg_no']),
                        $("input[name='hsc_group'][value="+value['hsc_group']+"]").prop("checked",true).change(),
                        $("input[name='eleventh_pass'][value="+value['eleventh_pass']+"]").prop("checked",true),
                        $("#physics_m").val(value['physics_m']),
                        $("#physics_t").val(value['physics_t']),
                        $("#chemistry_m").val(value['chemistry_m']),
                        $("#chemistry_t").val(value['chemistry_t']),
                        $("#maths_m").val(value['maths_m']),
                        $("#maths_t").val(value['maths_t']),
                        $("#optional_m").val(value['optional_m']),
                        $("#optional_t").val(value['optional_t']),
                        $("#annual_income").val(value['annual_income']),
                        $("input[name='aicte_tfw'][value="+value['aicte_tfw']+"]").prop("checked",true),
                        $("input[name='pms'][value="+value['pms']+"]").prop("checked",true).change(),
                        $("input[name='fg'][value="+value['fg']+"]").prop("checked",true).change(),
                        $("#fg_district").val(value['fg_district']),
                        $("#fg_no").val(value['fg_no']),
                        $("input[name='availed_fg'][value="+value['Availed_fg']+"]").prop("checked",true).change()
                 }); 
            });
           
         }
         else
         {
            $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("Fill Application Number");
         }
     });
     $("#addBtn").click(function(){
        //if(!validateForm())
        //return;
        $("#mainDiv :input").prop("disabled", false);
        if($("#a_no").val()=="")
        {
            $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("Fill the Application number");
             return;
        }
        //console.log($("#b_code").val());
        if($("#b_code").val()=="")
        {
            $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("Select the Branch");
             return;
        }
        clearme(false);
        $("#category").prop("disabled",false);
        $("#mainDiv").show();
        $("#submit").show();
        $("#delete").hide();
        $("#update").hide();
        //$("#branch_name").hide();
     });
     function validateForm()
      {
        if($("#category").val()!="GOVERNMENT")
          {
          if($("#b_code").val()=="" || $("#b_code").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Select Branch");
             return false;
          }
          if($("#a_no").val()=="")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Fill Application number");
             return false;
          }
          if($("#a_no").val().length>7)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Application Number must be 6 or 7 digits");
             return false;
          }
          if($("#category").val()=="" || $("#category").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Category is required");
             return false;
          }
          if($("#name").val()=="")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Canditate's Name is required");
             return false;
          }
          if(!Date.parse($("#dob").val()))
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Date of Birth is required");
             return false;
          }
          if($('input[name=gender]:checked').length <=0)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Gender is required");
             return false;
          }
          if($("#mobile").val()=="" || ($("#mobile").val().length!=10))
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Mobile Number is required");
             return false;
          }
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if($("#email").val()=="" || !regex.test($("#email").val()))
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Enter a valid mail id");
             return false;
          }
          if($('input[name=nationality]:checked').length <=0)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Nationality is required");
             return false;
          }
          if($('input[name=nativity]:checked').length <=0)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Nativity is required");
             return false;
          }
          if($("#input").val()=="" || $("#input").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Religion is required");
             return false;
          }
          if($("#output").val()=="" ||  $("#output").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Community is required");
             return false;
          } 
          if($("#parent_occupation").val()=="" ||  $("#parent_occupation").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Parent's Occupation is required");
             return false;
          }
          if($("#state").val()=="" ||  $("#state").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("State is required");
             return false;
          }
          if($("#district").val()=="" ||  $("#district").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("District is required");
             return false;
          }
          if($('input[name=hsc_tn]:checked').length <=0)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Student's Education in TN is required");
             return false;
          }
          if($("#qualifying_exam").val()=="" ||  $("#qualifying_exam").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Qualifying Exam is required");
             return false;
          }
          if($("#name_of_board").val()=="" ||  $("#name_of_board").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Name of Board is required");
             return false;
          }
          if($("#year_of_passing").val()=="" ||  $("#year_of_passing").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Year of Passing is required");
             return false;
          }
          if($("#hsc_reg_no").val()=="")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("HSC Reg Number is required");
             return false;
          }
        
          if($('input[name=hsc_group]:checked').length <=0)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("HSC Group is required");
             return false;
          }
          if($('input[name=eleventh_pass]:checked').length <=0)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("+1 passed is required");
             return false;
          }
          if($('input[name=eleventh_pass]:checked').val()=="0")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Canditate is should passed +1 for eligiblity");
             return false;
          }
          if($("#physics_m").val()=="")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if($("#physics_t").val()=="" ||  $("#physics_t").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if($("#chemistry_m").val()=="")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if($("#chemistry_t").val()=="" ||  $("#chemistry_t").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if($("#maths_m").val()=="")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if($("#maths_t").val()==""||  $("#maths_t").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if($("#optional_m").val()=="")
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if($("#optional_t").val()=="" ||  $("#optional_t").val()==null)
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks are required");
             return false;
          }
          if(parseInt($("#physics_m").val())>parseInt($("#physics_t").val()))
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks and total is Wrong");
             return false;
          }
          if(parseInt($("#chemistry_m").val())>parseInt($("#chemistry_t").val()))
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks and total is Wrong");
             return false;
          }
          if(parseInt($("#maths_m").val())>parseInt($("#maths_t").val()))
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks and total is Wrong");
             return false;
          }
          if(parseInt($("#optional_m").val())>parseInt($("#optional_t").val()))
          {
            $("#myModal").css("display","block");
            $(".modal-content").css("background-color","#ff6666");
            $("#message").text("Marks and total is Wrong");
             return false;
          }
      }
          if($("#category").val()=="GOVERNMENT")
          {
            if($("#annual_income").val()=="")
            {
                $("#myModal").css("display","block");
                $(".modal-content").css("background-color","#ff6666");
                $("#message").text("Annual Income is Required");
                return false;
            }
            if( $('input[name=aicte_tfw]:checked').length <=0)
            {
                $("#myModal").css("display","block");
                $(".modal-content").css("background-color","#ff6666");
                $("#message").text("AICTE TFW is Required");
                return false;
            }
            if($('input[name=pms]:checked').length <=0)
            {
                $("#myModal").css("display","block");
                $(".modal-content").css("background-color","#ff6666");
                $("#message").text("Post Metric scholarship field is Required");
                return false;
            }
            if($('input[name=fg]:checked').length <=0)
            {
                $("#myModal").css("display","block");
                $(".modal-content").css("background-color","#ff6666");
                $("#message").text("First Graduate Field is Required");
                return false;
            }
            if($('input[name=availed_fg]:checked').length <=0)
            {
                $("#myModal").css("display","block");
                $(".modal-content").css("background-color","#ff6666");
                $("#message").text("Availed Fg field is Required");
                return false;
            }
            if(document.getElementById("fg1").checked)
            {
                if($("#fg_district").val()=="")
                {
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("FG District is Required");
                    return false;
                }
                if($("#fg_no").val()=="")
                {
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text("FG Certificate Number is Required");
                    return false;
                }
            }
          }
          return true;
      }
      //validate form ends

      //loader showing
      function showLoading()
      {
          $("#loader").show();
          $("input").prop("disabled",true);
          $("button").prop("disabled",true);
      }

      //loader hide function
      function hideLoading()
      {
          $("#loader").hide();
          $("input").prop("disabled",false);
          $("button").prop("disabled",false);
      }

     $("#submit").click(function(){
            if(!validateForm())
            {
                return ;
            }
            // var fg_number=null;

            // if($("#fg").val()=="0")
            // {
            //     //alert("in");
            //     var fg_number=null;
            // }
            // else
            // {
            //    // alert("out");
            //     fg_number=$("#fg").val();

            // }
            showLoading();
             $.post("put_records.php",{
                b_code:$("#b_code").val(),
                a_no:$("#a_no").val(),
                category:$("#category").val(),
                name:$("#name").val().toUpperCase(),
                dob:$("#dob").val(),
                gender:$("input[name='gender']:checked").val(),
                mobile:$("#mobile").val(),
                email:$("#email").val(),
                nationality:$("input[name='nationality']:checked").val(),
                nativity:$("input[name='nativity']:checked").val(),
                religion:$("#input").val(),
                community:$("#output").val(),
                caste_name:$("#casteop").val(),
                parent_occupation:$("#parent_occupation").val(),
                state:$("#state").val(),
                district:$("#district").val(),
                hsc_tn:$("input[name='hsc_tn']:checked").val(),
                qualifying_exam:$("#qualifying_exam").val(),
                name_of_board:$("#name_of_board").val(),
                year_of_passing:$("#year_of_passing").val(),
                hsc_reg_no:$("#hsc_reg_no").val(),
                hsc_group:$("input[name='hsc_group']:checked").val(),
                eleventh_pass:$("input[name='eleventh_pass']:checked").val(),
                physics_m:$("#physics_m").val(),
                physics_t:$("#physics_t").val(),
                chemistry_m:$("#chemistry_m").val(),
                chemistry_t:$("#chemistry_t").val(),
                maths_m:$("#maths_m").val(),
                maths_t:$("#maths_t").val(),
                optional_m:$("#optional_m").val(),
                optional_t:$("#optional_t").val(),
                annual_income:$("#annual_income").val(),
                aicte_tfw:$("input[name='aicte_tfw']:checked").val(),
                pms:$("input[name='pms']:checked").val(),
                fg:$("input[name='fg']:checked").val(),
                fg_district:$("#fg_district").val(),
                fg_no:$("#fg_no").val(),
                availed_fg:$("input[name='availed_fg']:checked").val()
         },function(data,status){
                hideLoading();
                console.log(data);
                if(data=="success")
                {
                    if($(".tabulator-table").length==0)
                    {
                        $("#table_details").empty();
                    }
                    
                    var html="";                 
                    html+="<div  class='tabulator-table' style='min-width: 480px; min-height: 1px; '>";
                    html+="<div id='"+$("#a_no").val()+"' class='tabulator-row tabulator-selectable tabular-row-even' role='row' style='padding-left:0px;'>";
                    html+="<div class='tabulator-cell' role='gridcell' tabulator-field='SNO' title style='width:70px;text-align:center;height:32px;'>"+($(".tabulator-table").length+1)+"</div>";
                    html+="<div class='tabulator-cell' role='gridcell' tabulator-field='APP_NO' title style='width:84px;text-align:center;height:32px;'>"+$("#a_no").val()+"</div>";
                    html+="<div class='tabulator-cell' role='gridcell' tabulator-field='NAME' title style='width:174px;text-align:center;height:32px;'>"+$("#name").val().toUpperCase()+"</div>";
                    html+="<div class='tabulator-cell' role='gridcell' tabulator-field='Status' title style='width:94px;text-align:center;height:32px;'>";
                    html+="<button class='btn btn-success' value='"+$("#a_no").val()+"' style='font-size:12px;padding:15px;height:24px;padding:0px;width:70px'>View/Edit</button></div></div></div><br>";
                    $("#table_details").append(html);
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#33ff33");
                    $("#message").text("Saved Successfully");
                    $("#mainDiv").hide();
                    $("#a_no").val(null);
                }
                else
                {
                    $("#myModal").css("display","block");
                    $(".modal-content").css("background-color","#ff6666");
                    $("#message").text(data);
                }
         });
     });

    $("input[name='nationality']").change(function(){
        if($("input[name='nationality']:checked").val()=="SRILANKAN" || $("input[name='nationality']:checked").val()=="OTHERS")
        {    
            $("input[name='nativity'][value=OTHERS]").prop("checked",true).trigger('change');
            $("input[name='nativity']").prop("disabled",true);
        }
        else
        {
            $("input[name='nativity']").prop("disabled",false).trigger('change');
            $("#category").trigger('change');
        }
     });

     $("input[name='nativity']").change(function(){
        if($("input[name='nativity']:checked").val()=="OTHERS" )
        {
            $("#output").val("OC");
            $("#output").prop("disabled",true);
        }
        else
        {
            $("#output").prop("disabled",false);
            $("#category").trigger('change');
        }
     });

     $("#qualifying_exam").change(function(){
         if($("#qualifying_exam").val()!="HSC")
         {
             //alert("HEllo");
             $("input[name=hsc_group][value=GENERAL]").prop("checked",true).trigger('change');
             $("input[name=hsc_group]").prop("disabled",true);
             $("#category").trigger('change');
         }
         else
         {
            $("input[name=hsc_group]").prop("disabled",false);
         }
     });

     /*$("#name_of_board").change(function(){
        if($("#name_of_board").val()!="TN-Tamilnadu-Tamilnadu Board of Higher Secondary Education" || $("#qualifying_exam").val()!="HSC")
        {
            $("input[name=hsc_group][value=GENERAL]").prop("checked",true).trigger('change');
             $("input[name=hsc_group]").prop("disabled",true);
            $("#category").trigger('change');
        } 
        else
         {
            $("input[name=hsc_group]").prop("disabled",false);
         }
     });*/

     var modal = document.getElementById("myModal");
     var span = document.getElementsByClassName("close")[0];
     span.onclick = function() 
     {
     modal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }

$("#annual_income").change(function(){
    if($("#annual_income").val()==4 || $("#annual_income").val()==5 )
    {
        $("input[name=pms]").prop("disabled",true);
        $("input[name=pms][value=0]").prop("checked",true);
        $("input[name=aicte_tfw]").prop("disabled",true);
        $("input[name=aicte_tfw][value=0]").prop("checked",true);
    }
    else if($("#annual_income").val()==3 )
    {       
            $("input[name=pms]").prop("disabled",true);
            $("input[name=pms][value=0]").prop("checked",true);
            $("input[name=aicte_tfw]").prop("disabled",false);
    }
    else
    {
        $("input[name=aicte_tfw]").prop("disabled",false);
        $("input[name=pms]").prop("disabled",false);
    }
});

    $("#pms").change(function(){
        if($("#pms").val()=="1")
        {
            $("input[name=aicte_tfw][value=0]").prop("checked",true);
            $("input[name=fg][value=0]").prop("checked",true);
       }
    });

    $("#aicte_tfw").change(function(){
        if($("#aicte_tfw").val()=="1")
        {
            $("input[name=pms][value=0]").prop("checked",true);
            $("input[name=fg][value=0]").prop("checked",true);
        }
    });

    $("#availed_fg").change(function(){
        
        if($("#availed_fg").val()=="1")
        {
            $("input[name=fg][value=0]").prop("checked",true);
        }
    });
    
    $("#state").on('change',function()
    {
        if($("#state").val()=="TAMILNADU")
        {
            $("#district").val(1); 
            $("#district").prop("disabled",false); 
        }
        else
        {
            $("#district").val("OTHERS"); 
            $("#district").prop("disabled",true);
        }
    });
    
  });
</script>

<style type="text/css">
            #secCheckList .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 2px !important;
         }
    
         #secCheckList > .modal-header, .modal-body, .modal-footer {
            padding: 5px !important;
         }
         </style>
    </head>
    <body style="background-color: #f2f2f2e0;">
    <div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content" style="width:50%;background-color: #f08585;">
<span class="close" style="margin-left:80%;">&times;</span>
  <h5 id="message" style="color:white;"></h5>
  
</div>

</div>
        
        <div>
            <div style="min-height: 500px; margin-top: 10px;">
                <div style="margin-top: 10px;">

        
         
<div id="loader"></div>
    <div class="row" style="margin-top:4px;">
       
       <div class="col-md-12" style="background-color:palegreen;color:white;margin-top:-10px;">
           <div class="row">

               
               <div class="col-md-2 text-right" style="margin-left: 18%;">
                   <div class="gap15">
                       <span size="4"><strong>BRANCH NAME</strong></span>
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="gap5">
                   <?php 
                                if($stmt=$conn->prepare("select b_code,branch_name,save from branch_info where c_code=?"))
                                {
                                    
                                    $stmt->bind_param("s",$_SESSION['c_code']);
                                    if($stmt->execute())
                                    {
                                        $result=$stmt->get_result();
                                    }
                                    else
                                      die("something went wrong");    
                                }
                               else
                                {
                                    die("Something went wrong");
                                }
                          ?>
                            

                       <select class="form-control" id="b_code" name="b_code" >
                            <option value="" disabled selected>------Select Branch------</option>
                          <?php while($row=$result->fetch_assoc()):?>
                          <?php if($row['save']===1):?>
                                <option value="<?php echo $row['b_code'] ;?>"><?php echo $row['branch_name'];?></option>
                            <?php endif?>
                            <?php endwhile ?>
                       </select>
                   </div>
               </div>
           </div>
       </div>
       
       <div class="col-md-4 md-whiteframe-24dp" style="border:1px solid #bababa; min-height:600px;">
           <div id="tblStud" class="tabulator" role="grid" tabulator-layout="fitColumns">
               <div class="tabulator-header" style="padding-right: 0px;">
                   <div class="tabulator-headers" style="margin-left: 0px;">
                       <div class="tabulator-col tabulator-sortable" role="columnheader" aria-sort="none" tabulator-field="SNO" title="" style="min-width: 40px; width: 70px; height: 28px;">
                           <div class="tabulator-col-content">
                               <div class="tabulator-col-title">
                               S.NO
                           </div>
                          
                       </div>
                   </div>
                   <div class="tabulator-col tabulator-sortable" role="columnheader" aria-sort="none" tabulator-field="APP_NO" title="" style="min-width: 40px; width: 80px; height: 28px;">
                       <div class="tabulator-col-content">
                           <div class="tabulator-col-title">A.No</div>
               
                       </div>
                   </div>
                   <div class="tabulator-col tabulator-sortable" role="columnheader" aria-sort="none" tabulator-field="NAME" title="" style="min-width: 40px; width: 170px; height: 28px;">
                       <div class="tabulator-col-content">
                           <div class="tabulator-col-title">NAME</div>
                          
                       </div>
                   </div>
                   <div class="tabulator-col tabulator-sortable" role="columnheader" aria-sort="none" tabulator-field="Status" title="" style="min-width: 40px; width: 90px; height: 28px;">
                       <div class="tabulator-col-content">
                           <div class="tabulator-col-title">
                               Action
                            </div>
                   </div>
               </div>
           </div>
                </div>

                   <div id="table_details" class="tabulator-tableHolder" tabindex="0">
                       <!-- Table Contents Goes Here -->
                </div>
                
       </div>
 </div>


       <div class="col-md-8 md-whiteframe-24dp" style="border: 1px solid rgb(186, 186, 186); min-height: 100px;">

           <div class="row top5">
               <div class="col-md-1">
                   &nbsp;
                </div>
               <div class="col-md-3 text-right" style="margin-left:-8%;">
                   <div class="gap15">
                       <span size="4"><strong>APPLICATION NUMBER</strong></span>
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="gap5">
                       <input id="a_no" name="a_no"  type="number" class="text-center form-control" >
                   </div>
               </div>

               <div style="margin-left:5%;margin-top:1%;">
               <button id="editBtn" class="btn btn-primary">
                       Search/Edit
                  </button>
                   <button id="addBtn" class="btn btn-primary">
                    New
                  </button>
                  
                  <button id="clear" class="btn btn-danger">
                       Clear
                  </button>
                  
               </div>    

         </div>



           <div id="mainDiv" style="display:none;" >

           <div class="row studHdrBg top10">
                   <div class="col-md-12">
                       <div class="gap2">
                           <span size="2"><strong style="color:white;font-size: 14px;">CATEGORY DETAILS</strong></span>
                       </div>
                   </div>
               </div>

           <div class="row top5">
           <div class="col-md-2 text-right" style="margin-left: 7%;">
                   <div class="gap15">
                       <span size="4"><strong>CATEGORY</strong></span>
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="gap5">
                       <select id="category" class="form-control" name="ddBranch"   style="margin-left:-9%" >
                           <option value="" selected disabled ></option>
                           <option readonly value="GOVERNMENT">
                               GOVERNMENT
                           </option>
                           <option   value="MANAGEMENT">
                               MANAGEMENT
                           </option>
                           <option   value="MIN">
                               MIN
                           </option>
                           <option   value="LAP">
                               LAP
                           </option>
                           <option   value="NRI">
                               NRI
                           </option>
                           <option   value="GOI">
                               GOI
                           </option>
                           <option   value="FOR">
                               FOR
                           </option>
                       </select>
                   </div>
               </div>
               <div class="gap15">
                       <span size="4"><strong>QUOTA</strong></span>
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="gap5">
                       <select id="quota" class="form-control" name="ddBranch"   style="margin-left:-9%" >
                           <option value="" selected  ></option>
                           <option value="SPORTS GOV">
                               SPORTS GOVERNMENT
                           </option>
                           <option   value="MANAGEMENT">
                               MANAGEMENT
                           </option>
                           <option   value="MIN">
                               MIN
                           </option>
                           <option   value="LAP">
                               LAP
                           </option>
                           <option   value="NRI">
                               NRI
                           </option>
                           <option   value="GOI">
                               GOI
                           </option>
                           <option   value="FOR">
                               FOR
                           </option>
                       </select>
                   </div>
               </div>
            </div>
            
               <div class="row studHdrBg top10">
                   <div class="col-md-12">
                       <div class="gap2">
                           <span size="2"><strong style="color:white;font-size: 14px;">PERSONAL DETAILS</strong></span>
                       </div>
                   </div>
               </div>
               <div class="row top15">
                   <div class="row">
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>Candidate's Name</label>
                               <input id="name" name="txtName"  type="text" class="form-control" style="text-transform:uppercase;">           
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>Date of Birth</label>
                               <input id="dob"  name="txtDOB" id="txtDOB" type="date" placeholder="dd-mm-yyyy" class="form-control" >
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>Gender</label><br>
                               <label><input id="gender"  name="gender"  type="radio" value="MALE"   >Male</label>
                               <label><input id="gender" name="gender"  type="radio" value="FEMALE"   >Female</label>
                               <label><input id="gender" name="gender"  type="radio" value="TRANSGENDER"  >Others</label>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4">
                           <div class="form-group">
                               <label >Mobile </label><br>
                               <input id="mobile" style="width:123%" class="form-control" name="txtMobile" type="number">
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label style="margin-left:60px">Email</label><br>
                               <input id="email"  style="margin-left:56px;width:150%" class="form-control"  name="txtEmail" type="email">
                           </div>
                       </div>
                   </div>
               </div>
               <div class="row studHdrBg">
                   <div class="col-md-12">
                       <div class="gap2">
                           <span size="2"><strong style="color:white;font-size: 14px;">ELIGIBILITY DETAILS</strong></span>
                       </div>
                   </div>
               </div>
               <div class="row top15">
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>Nationality</label> <span color="red">*</span><br>
                           <label><input  id="nationality" type="radio" name="nationality" value="INDIAN"   >Indian</label>
                           <label><input  id="nationality" type="radio" name="nationality" value="SRILANKAN"  >Srilankan</label>
                           <label><input  id="nationality" type="radio" name="nationality"  value="OTHERS" >Others</label>     
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label for="nativity">Nativity</label> <br>
                           <label><input id="nativity" type="radio" name="nativity" value="TN" >Tamil Nadu</label>
                           <label><input id="nativity" type="radio" name="nativity" value="OTH" >Others</label>                         
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>Religion</label> <span color="red">*</span>
                           <select class="form-control" name="religion" id="input"  >
                               <option value=""></option>
                               <option value="HINDHU">Hindhu</option>
                               <option value="CHRISTIAN">Christian</option>
                               <option value="MUSLIM">Muslim</option>
                               <option value="JAINISM">Jainism</option>
                               <option value="BUDDHISM">Buddhism</option>
                               <option value="SIKHISM">Sikhism</option>
                               <option value="OTHERS">Others</option>
                           </select>
                       </div>
                   </div>
               </div>
               <div class="row top15">
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>Community</label> <span color="red">*</span>
                           <select  id="output" class="form-control"  name="community">
                               
                               <option value=""></option>
                               <option value="OC">OC</option>
                               <option value="BC">BC</option>
                               <option value="BCM" >BCM</option>
                               <option value="MBC/DNC">MBC/DNC</option>
                               <option value="MBC/DNC">MBC-V</option>
                               <option value="SC">SC</option>
                               <option value="SCA">SCA</option>
                               <option value="ST">ST</option>
                               
                            </select>
                       
                       </div>
                   </div>

                   <div class="col-md-4">
                       <div class="form-group">
                           <label>Caste Name</label>
                           <input id="casteop" class="form-control"   name="caste"  >
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>Parent Occupation</label>
                           <select id="parent_occupation" class="form-control" name="ddParentOccup">
                               <option value="" selected></option>
                               <option value="STATE GOVT EMPLOYEE">State Govt.</option>
                               <option value="CENTRAL GOVT EMPLOYEE">Central Govt.</option>
                               <option value="PROFESSIONALS">Professional</option>
                               <option value="INDUSTRY">Industry</option>
                               <option value="BUSINESS">Business</option>
                               <option value="AGRICULTURE">Agriculture</option>
                               <option value="SELF EMPLOYED">Self Employee</option>
                               <option value="PRIVATE">Private Organization</option>
                               <option value="SMALL TRADE">Small Trade</option>
                               <option value="OTHERS">Others</option>
                           </select>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>State</label> <span color="red">*</span>
                           <select id="state"  class="form-control" name="ddState">
                               <option value="" selected></option>
                               <option value="Others">Others</option>
                            
                               <option    value="ANDAMAN NICOBAR">
                                   ANDAMAN AND NICOBAR ISLANDS
                               </option>
                               <option    value="ANDHRA PRADESH">
                                   ANDHRA PRADESH
                               </option>
                               <option    value="ARUNACHAL PRADESH">
                                   ARUNACHAL PRADESH
                               </option>
                               <option    value="ASSAM">
                                   ASSAM
                               </option>
                               <option    value="BIHAR">
                                   BIHAR
                               </option>
                               <option    value="CHANDIGARH">
                                   CHANDIGARH
                               </option>
                               <option    value="CHHATTISGARH">
                                   CHHATTISGARH
                               </option>
                               <option    value="DADRA AND NAGAR HAVELI">
                                   DADRA AND NAGAR HAVELI
                               </option>
                               <option    value="DAMAN AND DIU">
                                   DAMAN AND DIU
                               </option>
                               <option    value="DELHI">
                                   DELHI
                               </option>
                               <option    value="GOA">
                                   GOA
                               </option>
                               <option    value="GUJARAT">
                                   GUJARAT
                               </option>
                               <option    value="HARYANA">
                                   HARYANA
                               </option>
                               <option    value="HIMACHAL PRADESH">
                                   HIMACHAL PRADESH
                               </option>
                               <option    value="JAMMU AND KASHMIR">
                                   JAMMU AND KASHMIR
                               </option>
                               <option    value="JHARKHAND">
                                   JHARKHAND
                               </option>
                               <option    value="KARNATAKA">
                                   KARNATAKA
                               </option>
                               <option    value="KERALA">
                                   KERALA
                               </option>
                               <option    value="LAKSHADWEEP">
                                   LAKSHADWEEP
                               </option>
                               <option    value="MADHYA PRADESH">
                                   MADHYA PRADESH
                               </option>
                               <option    value="MAHARASHTRA">
                                   MAHARASHTRA
                               </option>
                               <option    value="MANIPUR">
                                   MANIPUR
                               </option>
                               <option    value="MEGHALAYA">
                                   MEGHALAYA
                               </option>
                                   <option    value="MIZORAM">
                                   MIZORAM
                               </option>
                               <option    value="NAGALAND">
                                   NAGALAND
                               </option>
                               <option    value="ODISHA">
                                   ODISHA
                               </option>
                               <option    value="PUDUCHERRY">
                                   PUDUCHERRY
                               </option>
                               <option    value="PUNJAB">
                                   PUNJAB
                               </option>
                               <option    value="RAJASTHAN">
                                   RAJASTHAN
                               </option>
                               <option    value="SIKKIM">
                                   SIKKIM
                               </option>
                               <option    value="TAMILNADU">
                                   TAMIL NADU
                               </option>
                               <option    value="TELANGANA">
                                   Telangana
                               </option>
                               <option    value="TRIPURA">
                                   TRIPURA
                               </option>
                               <option    value="UTTAR PRADESH">
                                   UTTAR PRADESH
                               </option>
                               <option    value="UTTARAKHAND">
                                   UTTARAKHAND
                               </option>
                               <option    value="WEST BENGAL">
                                   WEST BENGAL
                               </option>
                           </select>
                          
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>District</label>
                           <select id="district" class="form-control" name="ddDistrict">
                               <option value="" selected="selected">

                               </option>
                              <option    value="ARIYALUR">
                                   ARIYALUR
                               </option>
                               <option    value="CHENGALPATTU">
                                   CHENGALPATTU
                               </option><option    value="CHENNAI">
                                   CHENNAI
                               </option><option    value="COIMBATORE">
                                   COIMBATORE
                               </option><option    value="CUDDALORE">
                                   CUDDALORE
                               </option><option    value="DHARMAPURI">
                                   DHARMAPURI
                               </option><option    value="DINDIGUL">
                                   DINDIGUL
                               </option><option    value="ERODE">
                                   ERODE
                               </option>
                               <option    value="KALLAKURICHI">
                                   KALLAKURICHI
                               </option><option    value="KANCHIPURAM">
                                   KANCHIPURAM
                               </option><option    value="KANYAKUMARI">
                                   KANYAKUMARI
                               </option><option    value="KARUR">
                                   KARUR
                               </option><option    value="KRISHNAGIRI">
                                   KRISHNAGIRI
                               </option><option    value="MADURAI">
                                   MADURAI
                               </option>
                               <option    value="MAYILADUTHURAI">
                                   MAYILADUTHURAI
                               </option><option    value="NAGAPATTINAM">
                                   NAGAPATTINAM
                               </option><option    value="NAMAKKAL">
                                   NAMAKKAL
                               </option><option    value="PERAMBALUR">
                                   PERAMBALUR
                               </option><option    value="PUDUKOTTAI">
                                   PUDUKOTTAI
                               </option><option    value="RAMANATHAPURAM">
                                   RAMANATHAPURAM
                               </option>
                               <option    value="RANIPET">
                                   RANIPET
                               </option><option    value="SALEM">
                                   SALEM
                               </option><option    value="SIVAGANGAI">
                                   SIVAGANGAI
                               </option>
                               <option    value="TENKASI">
                                   TENKASI
                               </option><option    value="THANJAVUR">
                                   THANJAVUR
                               </option><option    value="THENI">
                                   THENI
                               </option><option    value="THE NILGIRIS">
                                   THE NILGIRIS
                               </option><option    value="TIRUNELVELI">
                                   TIRUNELVELI
                               </option><option    value="TIRUVALLUR">
                                   TIRUVALLUR
                               </option><option    value="THIRUVANNAMALAI">
                                   THIRUVANNAMALAI
                               </option><option    value="THIRUVARUR">
                                   THIRUVARUR
                               </option>
                               <option    value="THIRUPATTUR">
                                   THIRUPATTUR
                               </option><option    value="THOOTHUKUDI">
                                   THOOTHUKUDI
                               </option><option    value="TIRUCHIRAPPALLI">
                                   TIRUCHIRAPPALLI
                               </option><option    value="TIRUPPUR">
                                   TIRUPPUR
                               </option><option    value="VELLORE">
                                   VELLORE
                               </option><option    value="VILUPPURAM">
                                   VILLUPPURAM
                               </option><option    value="VIRUDHUNAGAR">
                                   VIRUDHUNAGAR
                               </option><option    value="OTHERS">
                                   OTHERS
                               </option>
                           </select>
                         
                       </div>
                   </div>
               </div>
               <div class="row ">
                   <div class="col-md-8">
                       <div class="form-group">
                           <label>Studied VIII, IX, X, XI &amp; XII Std. in Tamil Nadu ?</label><br>
                           <label><input id="hsc_tn" name="hsc_tn"  type="radio" value="1"  >Yes</label>
                           <label><input id="hsc_tn"  name="hsc_tn"  type="radio" value="0"  >No</label>
        
                       </div>
                   </div>


                   <div class="col-md-4">
                       &nbsp;
                   </div>
               </div>
           
               <div class="row studHdrBg">
                   <div class="col-md-12">
                       <div class="gap2">
                           <span size="2"><strong style="color:white;font-size: 14px;">ACADEMIC DETAILS</strong></span>
                       </div>
                   </div>
               </div>
            
               <div class="row top15">
                   <div class="col-md-3">
                       <div class="form-group">
                           <label>Qualifying Examination</label>
                           <select id="qualifying_exam" class="form-control" name="rbQE">
                           <option value="" selected></option>
                               <option value="HSC">HSC</option>
                               <option value="CBSE">CBSE</option>
                               <option value="SSCE">SSCE</option>
                               <option value="ICSE">ICSE</option>
                               <option value="ISCE">ISCE</option>
                               <option value="OTHERS">OTHERS</option>
                               <option value="Diplomo">Diplomo</option>
                           </select>
                        
                       </div>
                   </div>
                   <div class="col-md-5">
                       <div class="form-group">
                           <label>Name of the Board of Examination</label>
                           <select class='form-control' name="name_of_board" id="name_of_board">
                           <option value="TN-Tamil nadu Board of Higher Secondary Education">TN-Tamil nadu Board of Higher Secondary Education</option>
                           <option value="Others">Other States</option>
                          
                           </select>
                         
                         
                       </div>
                   </div>
                  
                   <div class="col-md-2">
                       <div class="form-group">
                           <label>Year of Passing</label><br>
                           <select id="year_of_passing" class="form-control">
                               <option value=""></option>
                               <option value="2020">2020</option>
                               <option  value="2019">
                                   2019
                               </option><option  value="2018">
                                   2018
                               </option><option  value="2017">
                                   2017
                               </option><option  value="2016">
                                   2016
                               </option><option  value="2015">
                                   2015
                               </option><option  value="2014">
                                   2014
                               </option><option  value="2013">
                                   2013
                               </option><option  value="2012">
                                   2012
                               </option><option  value="2011">
                                   2011
                               </option><option  value="2010">
                                   2010
                               </option><option  value="2009">
                                   2009
                               </option><option  value="2008">
                                   2008
                               </option><option  value="2007">
                                   2007
                               </option><option  value="2006">
                                   2006
                               </option><option  value="2005">
                                   2005
                               </option><option  value="2004">
                                   2004
                               </option><option  value="2003">
                                   2003
                               </option><option  value="2002">
                                   2002
                               </option><option  value="2001">
                                   2001
                               </option><option  value="2000">
                                   2000
                               </option><option  value="1999">
                                   1999
                               </option><option  value="1998">
                                   1998
                               </option><option  value="1997">
                                   1997
                               </option><option  value="1996">
                                   1996
                               </option><option  value="1995">
                                   1995
                               </option><option  value="1994">
                                   1994
                               </option><option  value="1993">
                                   1993
                               </option><option  value="1992">
                                   1992
                               </option><option  value="1991">
                                   1991
                               </option><option  value="1990">
                                   1990
                               </option><option  value="1989">
                                   1989
                               </option><option  value="1988">
                                   1988
                               </option><option  value="1987">
                                   1987
                               </option><option  value="1986">
                                   1986
                               </option><option  value="1985">
                                   1985
                               </option><option  value="1984">
                                   1984
                               </option><option  value="1983">
                                   1983
                               </option><option  value="1982">
                                   1982
                               </option><option  value="1981">
                                   1981
                               </option><option  value="1980">
                                   1980
                               </option>
                           </select>
                         
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-4">
                       <div class="form-group">
                      
                           <label>HSC Register Number</label>
                         
                           <input id="hsc_reg_no" class="form-control"  type="number">
                           
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>HSC Group</label><br>
                           <label>
                               <input id="hsc_group" type="radio" name="hsc_group"  value="GENERAL"  >
                               HSC Academic
                           </label>
                           <label>
                               
                               <input id="hsc_group" type="radio" name="hsc_group"  value="VOCATIONAL"  >
                               <label >HSC Vocational</label>
                           
                           </label>
                        
                       </div>
                   </div>
                   <div class="col-md-4">
                       <div class="form-group">
                           <label>Whether +1 Passed</label><br>
                           <label><input id="eleventh_pass" type="radio" name="eleventh_pass"  value="1"  >Yes</label>
                           <label><input id="eleventh_pass" type="radio" name="eleventh_pass"  value="0"  >No</label>

                         
                       </div>
                   </div>
               </div>

               <table class="w100p" border="1" cellpadding="0" cellspacing="0">
              
                   <tbody>
                   <tr>
                       
                       
                       <td class="w25p">
                           <div class="form-group text-center">
                               <table class="w100p" cellspacing="0">
                                   <tbody><tr>
                                       <td colspan="3">
                                           <div style="text-align: center;">
                                               <label  id="s1"></label>
                                             
                        
                                           </div>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td class="w50p">
                                           <div style="text-align: center;">
                                               <input id="physics_m"  type="number" style="width:90px;"   maxlength="3" name="txtSubj1"   class="form-control text-center txtMarkSize">
                                              
                                             
                                           </div>
                                       </td>
                                       <td>
                                         /  
                                       </td>
                                       <td class="w50p">
                                           <div style="text-align: center;">
                                            
                                               <input id="physics_t" type="number" name="ddSubj1MaxMark" class="form-control text-center txtMarkSize "  >
                                                  

                                            

                                           </div>
                                       </td>
                                   </tr>
                               </tbody></table>

                           </div>

                       </td>
                       <td class="w25p">
                           <div class="form-group text-center">
                               <table cellspacing="0" class="w100p">
                                   <tbody><tr>
                                       <td colspan="3">
                                           <span>
                                               <label  id="s2"></label>
            
                                           </span>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td class="w50p ">
                                           <div style="text-align: center;">
                                               <input id="chemistry_m" type="number" maxlength="3" name="chemistry_m"   class="form-control text-center txtMarkSize" style="width:90px;">
                                          
                                           </div>
                                       </td>
                                       <td>/</td>
                                       <td class="w50p">
                                           <div style="text-align: center;">
                                              
                                               <input type="number"  id="chemistry_t" name="chemistry_t" class="form-control text-center txtMarkSize">
                                                
                                                   
                                              
                                           </div>
                                       </td>
                                   </tr>

                               </tbody></table>



                           </div>
                       </td>
                       <td class="w25p">
                           <div class="form-group">
                               <table class="w100p">
                                   <tbody><tr>
                                       <td colspan="3">
                                           <div style="text-align: center;">
                                               <label  id="s3"></label>
                                           
                                           </div>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td class="w50p">
                                           <div style="text-align: center;">
                                               <input id="maths_m" style="width:90px;" type="number"  maxlength="3" name="maths_m"   class="form-control text-center txtMarkSize ">
                                        
                                           </div>
                                       </td>
                                       <td>/</td>
                                       <td class="w50p">
                                           <div style="text-align: center;">
                                             
                                               <input id="maths_t" type="number" name="maths_t" class="form-control text-center txtMarkSize "   >
                                        
                                                
                                             
                                           </div>
                                       </td>
                                   </tr>
                               </tbody></table>


                           </div>
                       </td>
                       <td class="w25p">
                           <div class="form-group text-center">

                               <table class="w100p" cellspacing="0">
                                   <tbody><tr>
                                       <td colspan="3">
                                           <div style="text-align: center;">
                                               <label id="s4" ></label>
                                        
                                           </div>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td class="w50p">
                                           <div style="text-align: center;">
                                               
                                               <input id="optional_m" style="width:90px;" type="number" maxlength="3" name="optional_m"  class="form-control text-center txtMarkSize">
                                              
                                           </div>
                                       </td>
                                       <td>/</td>
                                       <td class="w50p">
                                           <div style="text-align: center;">

                                               <input id="optional_t" type="number" name="optional_t" class="form-control text-center txtMarkSize">
                                           </div>
                                       </td>
                                   </tr>
                               </tbody></table>




                           </div>
                       </td>
                   </tr>
               </tbody>
            </table>


               <div id="scholarship"  aria-hidden="true">
                   <div class="row studHdrBg top10">
                       <div class="col-md-12">
                           <div class="gap2">
                               <span size="2" color="white"><strong>SCHOLARSHIP DETAILS</strong></span>
                           </div>
                       </div>
                   </div>
                   <div class="row top15">
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>Annual Income</label>
                               <select id="annual_income" class="form-control" name="ddIncome"   >
                                   <option value="" selected></option>
                                   <option value="1">Below Rs. 1,00,000</option>
                                   <option value="2">Rs. 1,00,001 - 2,50,000</option>
                                   <option value="3">Rs. 2,50,001 - 4,50,000</option>
                                   <option value="4">Rs. 4,50,001 - 6,00,000</option>
                                   <option value="5">Above Rs. 6,00,000</option>
                               </select>
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>AICTE Tuition Fee Waiver (TFW) Scheme</label> <br>
                               <label><input id="aicte_tfw" type="radio"  name="aicte_tfw"  value="1">Yes</label>
                               <label><input id="aicte_tfw" type="radio"  name="aicte_tfw"  value="0">No</label>
                               
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>Post Matric Scholarship (SC/ST/SCA/Converted Christians)</label><br>
                               <label><input id="pms" type="radio"  name="pms"  value="1" >Yes</label>
                               <label><input id="pms" type="radio"  name="pms"  value="0">No</label>
                             
                           </div>

                       </div>
                   </div>
                   <script>
                   function FG()
    {
        if(document.getElementById("fg1").checked)
        {
            $("input[name=availed_fg][value=0]").prop("checked",true);
            $("#fg_district").prop("disabled",false);
            $("#fg_no").prop("disabled",false);
            $("input[name=aicte_tfw][value=0]").prop("checked",true);
            $("input[name=pms][value=0]").prop("checked",true);
     
        }
        if(document.getElementById("fg2").checked)
        {
            $("#fg_district").prop("disabled",true);
            $("#fg_district").val(1);
            $("#fg_no").prop("disabled",true);
            $("#fg_no").val(null);
            
        }
    }

                   </script>
                   <div class="row">
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>First Graduate</label>
                               <label><input id="fg1" type="radio" name="fg"  value="1" onclick="FG()">Yes</label>
                               <label><input id="fg2" type="radio" name="fg"  value="0" onclick="FG()">No</label> 
                           </div>
                           <div class="form-group">
                               <label>Availed First Graduate</label>
                               <label><input id="availed_fg"  type="radio" name="availed_fg"  value="1">Yes</label>
                               <label><input id="availed_fg" type="radio" name="availed_fg"  value="0">No</label>
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>FG Cert Issued District</label>
                               <select id="fg_district" class="form-control" name="fg_district"  >
                                   <option value="" selected></option>
                             <option    value="ARIYALUR">
                                       ARIYALUR
                                   </option><option    value="CHENNAI">
                                       CHENNAI
                                   </option><option    value="COIMBATORE">
                                       COIMBATORE
                                   </option><option    value="CUDDALORE">
                                       CUDDALORE
                                   </option><option    value="DHARMAPURI">
                                       DHARMAPURI
                                   </option><option    value="DINDIGUL">
                                       DINDIGUL
                                   </option><option    value="ERODE">
                                       ERODE
                                   </option><option    value="KALLAKURICHI">
                                       KALLAKURICHI
                                   </option><option    value="KANCHIPURAM">
                                       KANCHIPURAM
                                   </option><option    value="KANNIYAKUMARI">
                                       KANNIYAKUMARI
                                   </option><option    value="KARUR">
                                       KARUR
                                   </option><option    value="KRISHNAGIRI">
                                       KRISHNAGIRI
                                   </option><option    value="MADURAI">
                                       MADURAI
                                   </option><option    value="NAGAPATTINAM">
                                       NAGAPATTINAM
                                   </option><option    value="NAMAKKAL">
                                       NAMAKKAL
                                   </option><option    value="PERAMBALUR">
                                       PERAMBALUR
                                   </option><option    value="PUDUKOTTAI">
                                       PUDUKOTTAI
                                   </option><option    value="RAMANATHAPURAM">
                                       RAMANATHAPURAM
                                   </option><option    value="SALEM">
                                       SALEM
                                   </option><option    value="SIVAGANGAI">
                                       SIVAGANGAI
                                   </option><option    value="TENKASI">
                                       TENKASI
                                   </option><option    value="THANJAVUR">
                                       THANJAVUR
                                   </option><option    value="THENI">
                                       THENI
                                   </option><option    value="THE NILGIRIS">
                                       THE NILGIRIS
                                   </option><option    value="THIRUNELVELI">
                                       THIRUNELVELI
                                   </option><option    value="THIRUVALLUR">
                                       THIRUVALLUR
                                   </option><option    value="THIRUVANNAMALAI">
                                       THIRUVANNAMALAI
                                   </option><option    value="THIRUVARUR">
                                       THIRUVARUR
                                   </option><option    value="THOOTHUKUDI">
                                       THOOTHUKUDI
                                   </option><option    value="TIRUCHIRAPALLI">
                                       TIRUCHIRAPALLI
                                   </option><option    value="TIRUPPUR">
                                       TIRUPPUR
                                   </option><option    value="VELLORE">
                                       VELLORE
                                   </option><option    value="VILLUPURAM">
                                       VILLUPURAM
                                   </option><option    value="VIRUDHUNAGAR">
                                       VIRUDHUNAGAR
                                   </option><option    value="OTHERS">
                                       OTHERS
                                   </option>
                               </select>
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label>FG Certificate Number</label>
                               <input id="fg_no" name="fg_no"  type="text" class="form-control" value=" ">           
                           </div>
                       </div>
                   </div>
               </div>
               <md-divider></md-divider>
             
               <div class="row top15">
                   <div class="col-md-2">&nbsp;</div>
                  
<?php $res= $conn->query("select last_date from time_limit where name='first_year_submission'"); $result=$res->fetch_assoc();?>
<?php $freez=$conn->query("select freezed from college_info where c_code=".$_SESSION['c_code']); $freezed=$freez->fetch_assoc();?>
<?php if(strtotime($result['last_date'])>=strtotime(date("Y/m/d")) && $freezed['freezed']=="0"): ?>
       <button id="submit" type="submit" value="submit" style="background-color:seagreen;color:white;border-radius: 6px;
       margin-bottom: 24px;margin-top: 14px;width: 12%;padding: 5px;margin-left: 5%;">Save</button>

      <button id="update" style="background-color:rgba(6, 228, 6, 0.925);color:white;border-radius: 6px;
      margin-bottom: 24px;margin-top: 14px;width: 12%;padding: 5px;margin-left: 10%;">Update</button>

       <button id="delete" style="background-color:rgb(185, 12, 12);color:white;border-radius: 6px;
       margin-bottom: 24px;margin-top: 14px;width: 12%;padding: 5px;margin-left: 10%;">Delete</button>
       <?php endif ?>
    </div>
</div>
    
<!-- <script src="AppScripts/Student.js?v=null"></script>
</script>> -->

        </div>  
    </div>
    </div>
    </body>
</html>