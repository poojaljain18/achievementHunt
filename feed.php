<?php
    session_start();

    $user="root";
    $pass="";
    $db="hunter";
    $link=mysqli_connect("localhost",$user,$pass,$db) or die;
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Students Details</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
   <link href="css/styles_2.css" rel="stylesheet">
   
    <!-- Your custom styles (optional) -->

</head>
    
        <body>
        <nav class="navbar navbar-expand-lg navbar-dark blue">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">AchivementHunter</a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Links -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="homepage.php">MyProfile</a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="feed.php">Feed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="signup.php">Log Out</a>
            </li>


        </ul>

        <!-- Search form -->
        <form class="form-inline" method="post">
            <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" aria-label="Search">
        </form>
    </div>
    <!-- Collapsible content -->

</nav>
    <!--Panel-->
    <?php
       
        $query1="Select * from students";
        $query2="Select * from languages";
        $query3="Select * from projects";
         $query4="Select * from achievement";
        if(isset($_POST['search']))
            $query1="Select * from students where name like '".$_POST['search']."%' or usn like '%".$_POST['search']."%'" ;
       // echo $query1;
        $resultStudents=mysqli_query($link,$query1);
        
         while($row=mysqli_fetch_array($resultStudents)){
             if($_SESSION['id']==$row['id'])
                 continue;
             $id=$row['id'];
             
            
    ?>
      
        <div class="card card-body">
            
            
            <h4 class="card-title"><?php echo '<span class="badge green">'.$row['name'].'</span>' ?></h4>
              <div class=one>
            <p class="card-text"><b>USN:</b><?php echo " ".$row['usn']; ?></p>
            <p class="card-text"><b>EmailId:</b><?php echo " ".$row['email']; ?></p>
             <p class="card-text"><b>semester:</b><?php echo " ".$row['sem']; ?></p>
             <p class="card-text"><b>Branch:</b><?php echo " ".$row['branch']; ?></p>
            <p class="card-text"><b>CGPA:</b><?php echo " ".$row['cgpa']." cgpa"; ?></p>
            <p class="card-text"><b>Contact:</b><?php echo " ".$row['phone']; ?></p>
             <p class="card-text"><b>LongTerm Goal:</b><?php echo " ".$row['longgoal']; ?></p>
             <p class="card-text"><b>ShortTerm Goal:</b><?php echo " ".$row['shortgoal']; ?></p>                    
            <p class="card-text"><b>Languages Known:</b>
                <?php
                    $resultLanguages=mysqli_query($link,$query2);
                    while($row1=mysqli_fetch_array($resultLanguages))
                            {
                                if($id==$row1['sId'])
                                    echo '<span class="badge badge-default">'.$row1['lang'].'</span> ';
                                else
                                    continue;
                            }
                    
                ?>
             <p class="card-text"><b>Achievements:</b>
                <?php
                    $resultAchievements=mysqli_query($link,$query4);
                    while($row1=mysqli_fetch_array($resultAchievements))
                            {
                                if($id==$row1['sId'])
                                    echo '<span class="badge badge-blue">'.$row1['achieveName'].'</span>  ';
                                else
                                    continue;
                            }
                    
                ?></p>
            <p class="card-text"><b>Projects Undertaken:</b>
            </p>
                <?php
                    $resultProjects=mysqli_query($link,$query3);
                    while($row1=mysqli_fetch_array($resultProjects))
                            {
                                if($id==$row1['sId'])
                                    echo '<span class="badge badge-danger">'.$row1['projectName'].'</span>  ';
                                else
                                    continue;
                            }
                    
                ?>                   
        </div>
        </div>     
         <?php
             
            }
        ?>
        



<!--/.Panel-->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    
    </body>
</html>