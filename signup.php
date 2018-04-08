<?php
    
    session_start();
    include "checkError.php";
    $user="root";
    $pass="";
    $db="hunter";
    $nameErr=$usnErr=$emailErr=$passwordErr=$phoneErr=$cgpaErr=$semErr=$branchErr=$imgError="";
    $err=false;
    $link="";
    $name="";
    if(isset($_POST['insert'])){
        insert();
    }elseif(isset($_POST['select'])){
        select();
    }
    

    function select()
    {
       
    }
    function insert()
    {
        $i=4;
         echo '<div class= "form-group" >';
            echo'<input type="text" class="form-control" name="achievement[]" placeholder="Achievement 4">';
                echo'</div>';
               echo'<input type="submit" class="button" name="insert" value="+" onclick="insert()" /> ';          
                echo"<br>";
    }
    if(array_key_exists("submit",$_POST)){
        if(test_input($nameErr,$usnErr,$emailErr,$passwordErr,$phoneErr,$cgpaErr,$semErr,$branchErr)==-1){
            $err=true;
            $globalErr="*Some fields are still empty or have invalid inputs";
        }
        else{
            $link=mysqli_connect("localhost",$user,$pass,$db) or die;
            $query="Select * from students";
            $result=mysqli_query($link,$query);
        
            while($row=mysqli_fetch_array($result)){
                if($row["usn"]==$_POST["usn"]){
                    $usnErr="USN already exists";
                    $err=true;
                    break;
                }else if($row["email"]==$_POST["email"]){
                    $emailErr="Email already exists";
                    $err=true;
                    break;
                }
            }
        }
        if(!$err){
            $img_name="";
            $Name=$_POST['name'];// or $Name=$_POST['name']
            $usn=$_POST['usn'];//----similar---
            $j=uploadImg();
            echo $img_name;
            if($j==1) {     
            $query="Insert into `students`(`name`,`email`,`usn`,`password`,`phone`,`cgpa`,`sem`,`branch`,`longgoal`,`shortgoal`,`image`,`points`) values('".$_POST['name']."','".$_POST['email']."','".$_POST['usn']."','".$_POST['password']."','".$_POST['phone']."','".$_POST['cgpa']."','".$_POST['sem']."','".$_POST['branch']."','".$_POST['longgoal']."','".$_POST['shortgoal']."','".$img_name."',0)";
           // if($j==1)
           // {
           //     $query1="Insert into `students`(`image`) values('".$_POST['$img_name']."')";
            }
           // echo $query;
            mysqli_query($link,$query);
                
            $result=mysqli_query($link,"Select id from students where email='".$_POST['email']."'");
            $row=mysqli_fetch_array($result);
            $_SESSION['id']=$row['id'];
            
            foreach($_POST['favLang'] as $lang)
               mysqli_query($link,"Insert into `languages` values(".$row['id'].",'".$lang."')");
            
             foreach($_POST['achievement'] as $a)
               if($a!=""){
                mysqli_query($link,"Insert into `achievement` values(".$row['id'].",'".$a."')");
               }
            
           foreach($_POST['project'] as $s)
               if($s!=""){
                mysqli_query($link,"Insert into `projects` values(".$row['id'].",'".$s."')");
               }
           
            
            header('Location: feed.php');
        
        }
    
            
        
    }
    function uploadImg()
{
		global $Name;
		global $usn;
		global $imgError;
		global $img_name;
		@$name = $_FILES['img']['name'];
					@$size = $_FILES['img']['size'];
					@$type = $_FILES['img']['type'];
					@$temp_name = $_FILES['img']['tmp_name'];
					@$error = $_FILES['img']['error'];
					$extention = strtolower(substr($name, strpos($name,'.')+1));
					$file_name = $Name.'_'.$usn.'.'.$extention;
                    echo $file_name;
					$img_name = $file_name;
					$location = 'images/'; 
					$i=0;
					if(isset($name))
					{
						if(!empty($name))
						{
							if(($extention=='jpg'||$extention=='jpeg')&&$type=='image/jpeg')
							{
								if(move_uploaded_file($temp_name,$location.$file_name))
									$i=1;
							}
							else
							{
								$imgError = '*File must be jpeg/jpg';
								$i=0;
							}
						}
						else
						{
							$imgError= '*Please choose a file';
							$i=0;
						}
					}
					return $i;
}
        


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login-Form</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>     
        <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
    
        
        <div class="signup">
            <header class="text-center">
            <h1>Sign Up</h1></header>
            <div class="signup-form">
            <form method="post" enctype='multipart/form-data'>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Full Name"><span style="color:red;" ><?php echo $nameErr?></span>
                    
                </div>
                <div class="form-group">
                    <input type="text" name="usn" class="form-control" placeholder="USN">
                    <span  style="color:red;"><?php echo $usnErr ?></span>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <span  style="color:red;"><?php echo $emailErr ?></span>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <span  style="color:red;"><?php echo $passwordErr ?></span>
                </div>
                <div class="form-group">
                    <input type="sem" name="sem" class="form-control" placeholder="sem">
                    <span  style="color:red;"><?php echo $semErr ?></span>
                </div>
                <div class="form-group">
                    <input type="branch" name="branch" class="form-control" placeholder="branch">
                    <span  style="color:red;"><?php echo $branchErr ?></span>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" maxlength="10"  class="form-control" placeholder="Phone">
                    <span  style="color:red;"><?php echo $phoneErr ?></span>
                </div>
                 <div class="form-group">
                    <input type="number" step=0.01 name="cgpa" class="form-control" placeholder="CGPA">
                     <span  style="color:red;"><?php echo $cgpaErr ?></span>
                </div>
                <div class="form-group">
                    <input type="longgoal" name="longgoal" class="form-control" placeholder="long Term goal">
                </div>
                 <div class="form-group">
                    <input type="shortgoal" name="shortgoal" class="form-control" placeholder="short Term goal">
                </div>
        
                <div class="form-group">
                    <label class="labelClass"><b>Languages Known</b></label><br>
                    <input type="checkbox" name="favLang[]" value="Core Java" class="checkboxClass"><b><span style="color:white;">Java</span>&nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="Python" class="checkboxClass"><b><span style="color:white;">Python</span>&nbsp;&nbsp; </b>
                    <input type="checkbox" name="favLang[]" value="C" class="checkboxClass"><b><span style="color:white;">C</span> &nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="C++" class="checkboxClass"><b><span style="color:white;">C++</span> &nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="R" class="checkboxClass"><b><span style="color:white;">R</span> &nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="PHP" class="checkboxClass"><b><span style="color:white;">PHP</span> &nbsp;&nbsp;</b><br>
                     <input type="checkbox" name="favLang[]" value="Swift" class="checkboxClass"><b><span style="color:white;">Swift</span>&nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="Java Script" class="checkboxClass"><b><span style="color:white;">Java Script</span>&nbsp;&nbsp; </b>
                    <input type="checkbox" name="favLang[]" value="C#" class="checkboxClass"><b><span style="color:white;">C#</span> &nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="SQL" class="checkboxClass"><b><span style="color:white;">SQL</span> &nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="Lisp" class="checkboxClass"><b><span style="color:white;">Lisp</span> &nbsp;&nbsp;</b>
                    <input type="checkbox" name="favLang[]" value="ADA" class="checkboxClass"><b><span style="color:white;">ADA</span> &nbsp;&nbsp;</b>   
                </div>
                 <!--Third row-->
        <!-- <label class="labelClass"><b>Certificates</b></label><br>
        <div class="row">
       

        <!--First column-->
       <!-- <div class="col-md-8">
            <div class="md-form">
                <input type="text" id="form41" class="form-control" name="certificate[]" placeholder="Certificate 1">
                
            </div>
        </div>
         <div class="col-md-4">
            <div class="md-form">
                    <input type="submit" name="c1" value="Certificate" class=" form-control btn btn-white">
            </div>
        </div>
          <!--Second column-->
     <!--   <div class="col-md-8">
            <div class="md-form">
                <input type="text" id="form51" class="form-control" name="certificate[]" placeholder="Certificate 2">
                
            </div>
        </div>
         <div class="col-md-4">
            <div class="md-form">
                    <input type="submit" name="c2" value="Certificate" class=" form-control btn btn-white">
            </div>
        </div>

        <!--Third column-->
       
         <!--<div class="col-md-8">
            <div class="md-form">
                <input type="text" id="form61" class="form-control" name="certificate[]" placeholder="Certificate 3">
                
            </div>
        </div>
         <div class="col-md-4">
            <div class="md-form">
                    <input type="submit" name="c3" value="Certificate" class=" form-control btn btn-white">
            </div>
        </div>
     </div>
                                            

    <!--Third row-->
                   <label class="labelClass"><b>Achievements</b></label><br>
        <!--First column-->
        <div class="form-group">
                    <input type="text" name="achievement[]"  class="form-control" placeholder="Achievement 1">
                </div>
                
        <!--Second column-->
            <div class="form-group">
                <input type="text" class="form-control" name="achievement[]" placeholder="Achievement 2">
                
            </div>

        <!--Third column-->
            <div class="form-group" >
                <input type="text" class="form-control" name="achievement[]" placeholder="Achievement 3">
        </div>
                <input type="submit" class="button" name="insert" value="+" onclick="insert()" />               
                <br>
                
         <!--/.Fourth row--> 
                
         <label class="labelClass"><b>Projects Undertaken</b></label><br>
        <!--First column-->
        <div class="form-group">
                    <input type="text" name="project[]"  class="form-control" placeholder="Project 1">
                </div>
                
        <!--Second column-->
            <div class="form-group">
                <input type="text" class="form-control" name="project[]" placeholder="Project 2">
                
            </div>

        <!--Third column-->
            <div class="form-group" >
                <input type="text" class="form-control" name="project[]" placeholder="Project 3">
        </div>
                
                <br>
    <!--/.Fifth row-->
            <!--   <div class="form-group">
                     <label for="image">Upload Profile</label>
                    <input class="form-control" type="file" name="image">
                </div>
                    
                <br>-->
                 <div class="form-group">
                    <input type="file" id="img_id" name="img">
                    <span  style="color:red;"><?php echo $imgError ?></span>
                </div> <br>
                
                <input type="submit" name="submit" value="Register" class="form-control btn btn-white">
        <br><br>
                        <label class="labelClass"><b>Already Registered : </b></label><a href="studentLogin.php" ><b>&nbsp;&nbsp;Login</b></a>
                <a href="index.html">Home</a>

                </form>
            </div>
       </div>
      
    </body>
</html>