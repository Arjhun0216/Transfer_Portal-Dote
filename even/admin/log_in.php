<?php

    session_start();

    if(isset($_POST['login'])) 
    {
        include '../user/database.php';
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $username = stripcslashes($username);
        $password = stripcslashes($password);
        $sql="SELECT * FROM admin_login WHERE uname =? LIMIT 1";
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
                      $_SESSION['admin_login'] = true;
                     // echo "password correct";
                     //if(!isset($_SESSION['redirect_url']))
                      //{
                       header("Location:index.php");
                      //}
                      //else{
                         //echo $_SESSION['redirect_url'];
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
  </head>
  <body>
  <div>
      <!-- <label class="title bg-light" style="width:100%">  -->
      <label class="title"  style="width:100%;background-color:#FDC11C"> 
        <h2 style="margin-top:5px;font-size:46px;">DIRECTORATE OF TECHNICAL EDUCATION<h2>
        <h6 style="margin-top:5px;font-size:26px;">( GOVERNMENT OF TAMILNADU )<h6>
      </label>
          </div>
          <div>
  <h5 style="text-align:center;margin-top:5px;color:green;font-size:30px;">Online Readmission (Admin Portal)<h5>
  </div>
<section class="container-fluid">
        <section class="row justify-content-center">
            <section style="margin-top:-65px;" class="col-12 col-sm-6 col-md-3">
            
             <div class="container">   
              <img src="/transfer/admin/images/use.png" class="bg">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-container">
                <h4 class="text-center font-eight-bold">Login Form</h4>
                <div class="form-group">
                    <input class="form-control" id="exampleInputEmail1" placeholder="Counselling Code" name="username" required>
                </div>
                <div class="form-group">
                     <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                  <button  name="login" type="submit"  class="btn btn-primary btn-block">Log in</button>
              </form>
              <div>
            </section>
        </section>
    </section>
   
  </body>
</html>