<?php
    try
    {
        $db=mysqli_connect('localhost','root','','dozrobienialista'); //connect to DB
        $tasks=mysqli_query($db, "SELECT * FROM zadania"); // query to DB
        $row=mysqli_fetch_array($tasks); //make it as assoc tab
    }
    catch(Exception $e)
    {
        exit('<div style="color:red">Error</div>');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <title>To do list</title>
</head>
<body>
    <div class="container">
       <div class="add">
            <form action="index.php" method="POST">
                Add new task<br/><br/>
                <input type="text" name="text" maxlength="255" autocomplete="off" required/><br/>
                <input type="submit" name="submit" value="Add task"/>
            </form>
            <?php
                if(isset($_POST['text']))
                {
                    $text=$_POST['text'];
                    $add=mysqli_query($db,"INSERT INTO zadania (zadanie) VALUES('$text')");
                    header("Location: index.php");
                }
            ?>
       </div>
       <div class="remove">
            <form action="index.php" method="post">
                Type ID number to delete<br/>
                <input type="text" name="textDel" autocomplete="off" required/>
                <input type="submit" name="submitDel" value="Delete task"/>
            </form>
            <?php 
                if((isset($_POST['textDel'])))
                {
                    $nr=$_POST['textDel'];
                    $del=mysqli_query($db,"DELETE FROM zadania WHERE id=$nr");
                    header("Location: index.php");
                }
            ?>
       </div>
       <div class="update">
            <form action="index.php" method="post">
                Type ID number to update<br/>
                <input type="text" name="idUpd" autocomplete="off" required/><br/>
                Type new task<br/>
                <input type="text" name="textUpd" autocomplete="off" required/>
                <input type="submit" name="submitUpd" value="Update task"/>
            </form>
            <?php 
                if(isset($_POST['idUpd']) && (isset($_POST['submitUpd'])))
                {
                    $idedit=$_POST['idUpd'];
                    $textEdit=$_POST['textUpd'];
                    $upd=mysqli_query($db,"UPDATE zadania set zadanie='$textEdit'where id='$idedit'");
                    header("Location: index.php");
                }
            ?>
       </div>
       <div style="clear:both;"></div>
       <div class="showList">
       <?php
            while($row=mysqli_fetch_array($tasks))
            {
                echo " | ".$row['id'].' | '.$row['zadanie'];
                echo "<br/>";
            }
        ?>
       </div>
    </div>
</body>
</html>
