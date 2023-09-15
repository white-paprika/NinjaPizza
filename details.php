<?php 
    include 'config/db_connect.php';
    
    // удаление пиццы
    if(isset($_POST['delete'])){
        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM `pizzas` WHERE `pizzas`.`id` = $id_to_delete";
        if(mysqli_query($conn, $sql)){
            header('Location: index.php');
        } else {
            echo 'Query error: ' . mysqli_error($conn);
        }
    }


    // Получение информации о пицце
    // check GET request 'id' parameter
    if(isset($_GET['id'])){
        
        // we take id param from the link "MORE INFO" in cards 
        //mysqli_real_escape_string - защита от SQL инъекции
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        // make sql // GETTING A SINGLE RECORD BY ID 
        $sql = "SELECT * FROM pizzas WHERE id = $id";

        $result = mysqli_query($conn, $sql);

        // Getting a single record - associated array: id => '', 'title' => '' ...
        $pizza = mysqli_fetch_assoc($result);

        // Free result from memory (Хорошей практикой считается освобождение $result после получения нужных данных)
        mysqli_free_result($result);

        // Close connection
        mysqli_close($conn);
        
        // print_r($pizza);
        
    }
?>

<!DOCTYPE html>
<html>

    <?php include 'templates/header.php'; ?>

    <div class="container center">
        <?php if ($pizza):?>
            <h4><?php echo htmlspecialchars($pizza['title']);?></h4>
            <p>Created by: <?php echo htmlspecialchars($pizza['email'])?></p>
            <p><?php echo htmlspecialchars($pizza['created_at'])?></p>
            <p><?php echo htmlspecialchars($pizza['ingredients'])?></p>
            
            <!-- DELETE FORM (используем форму, чтобы отправлять данные методом POST.
            Генерация URL с параметрами (как при переходе на детали о пицце) - это GET ) -->
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']?>">
                <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
            </form>
        <?php else:?>
            <h5>No such pizza exists</h5>
        <?php endif;?>
    </div>

    <?php include 'templates/footer.php'; ?>

</html>