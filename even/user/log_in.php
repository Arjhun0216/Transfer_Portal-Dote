<?php
    session_start();
    if(isset($_POST['login'])) 
    {
        include 'database.php';
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $username = stripcslashes($username);
        $password = stripcslashes($password);
        $sql="SELECT * FROM college_details WHERE c_code =? LIMIT 1";
        if($stmt=$conn->prepare($sql))
        {
              $stmt->bind_param("s",$username);
              $stmt->execute();
              $result=$stmt->get_result();
              $x=mysqli_num_rows($result);
              $resultSet=$result->fetch_assoc();
              if($x==1)
              {
                 if($password == $resultSet['pass'])
                  {
                      $_SESSION['c_code'] = $username;
                     
                      $_SESSION['college_name'] = $resultSet['name_of_college_with_address'];
                    // echo "password correct";
                      if(!isset($_SESSION['redirect_url']))
                      {
                       header("Location:/transfer/even/user/");
                      }
                      else{

                        // echo $_SESSION['redirect_url'];
                        // header("Location:".$_SESSION['redirect']);
                  } 
                }
                  else {
                  echo "<div  class='alert alert-warning alert-dismissible fade show message' role='alert'>
                  <strong>Incorrect password!</strong> Enter the correct values below.
                  </div>";
              }
            }
            else {
              echo "<div  class='alert alert-warning alert-dismissible fade show message' role='alert'>
              <strong>Incorrect Counselling Code!</strong> Enter the correct values below.
              </div>";
                }
            }
        }
            
?>
 
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sample_header.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
  <div>
      <!-- <label class="title bg-light" style="width:100%">  -->
      <label class="title"  style="width:100%;background-color:#FDC11C"> 
        <h2 style="margin-top:5px;font-size:36px;">DIRECTORATE OF TECHNICAL EDUCATION<h2>
        <h6 style="margin-top:5px;font-size:22px;">( GOVERNMENT OF TAMILNADU )<h6>
      </label>
          </div>
          <div>
  <h5 style="text-align:center;margin-top:0px;color:green;font-size:26px;">Online Readmission Even Semester 2025-2026 (User Portal) <h5>
  <!-- <h2  style="text-align:center;color:red;"><u>Web Portel is closed  </u></h2> -->
  <!-- <h5 id="demo" style="text-align:center;color:red;"></h5> -->
  <h6 style="text-align:center;color:red;">***Students are not allowed to enter details themselves. Only College authority is allowed to Login and enter details.***<h6>
  <h6 style="text-align:center;color:blue;">KINDLY ENSURE THAT THE READMISSION APPLICATIONS ARE FILLED WITH CORRECT DETAILS.<h6>
  <h6 style="text-align:center;color:black;">Login to the web portal with your previously used password.<h6>
      <!-- <marquee><h5 style="color:red;">Readmission web portal is in under maintanance</h5></marquee> -->
  <!-- <marquee><h5 style="color:red;">Readmission web portal will be closed by 10 am on February 6,2024</h6></marquee> -->
  <!-- <h2 style="text-align:center;color:green;">For ODD semester transfer and readmission click below link :</h2>
   <H4 style="text-align:center;"> <a  href="http://gcebargurdotesoftware.in/transfer/user/log_in.php">http://gcebargurdotesoftware.in/transfer/user/log_in.php</a></H4> -->
  </div>
  <script>
var deadline = new Date("Jul 29, 2024 17:00:00").getTime(); 
var x = setInterval(function() { 
var now = new Date().getTime(); 
var t = deadline - now; 
 var days = Math.floor(t /(1000 * 60 * 60 * 24)); 
var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)); 
var seconds = Math.floor((t % (1000 * 60)) / 1000); 
document.getElementById("demo").innerHTML =  hours + "h " + minutes + "m " + seconds + "s "; 
    if (t < 0) { 
        clearInterval(x); 
        document.getElementById("demo").innerHTML = "EXPIRED"; 
    } 
}, 1000); 
</script>
<section class="container-fluid">
        <section class="row justify-content-center">
            <section style="margin-top:-120px;" class="col-12 col-sm-6 col-md-3">
            
             <div class="container">   
              <img src="images/use.png" class="bg">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-container">
                <h4 class="text-center font-eight-bold">Login Form</h4>
                <div class="form-group">
                    <input class="form-control" id="exampleInputEmail1" placeholder="Counselling Code" name="username" required>
                </div>
                <div class="form-group">
                     <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                  <!-- <button name="login" type="submit"  class="btn btn-primary btn-block">Log in</button> -->
                  <button  name="login" type="submit"  class="btn btn-primary btn-block">Log in</button>
              </form>
              <div>
            </section>
        </section>
    </section>

    <div class="footer1" style="position: fixed;left: 0;bottom: 0;width: 100%;background-color: #fdc11c;color: #000000;text-align: center;">
            <h5>For any queries - contact us</h5>
            <h7> E-mail   : <b>onlinetrans2020@gmail.com &nbsp;</b><h7>
            <!-- <i class="fa fa-mobile-phone" style="font-size:15px"> - <b>9043768687 / 6382745697</b></i><br> -->
   </div> 
   
  </body>
</html>