<?php

    include 'config/db_connect.php';

    // write query for all pizzas
    $sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

    // make query and get result
    $result = mysqli_query($conn, $sql);

    //fetch the resulting rows as an array (idexed array of records - associated arrays)
    $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Free result from memory (Хорошей практикой считается освобождение $result после получения нужных данных)
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);

    // print_r($pizzas);

?>

<!DOCTYPE html>
<html lang="en">

    <?php include 'templates/header.php'; ?>

    <h4 class="center grey-text">Pizzas</h4>
    
    <div class="container">
        <div class="row">

        <!-- Выводим для каждой пиццы, полученной из БД -->
            <?php foreach($pizzas as $pizza): ?>

                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($pizza['title']) ?></h6>
                            <ul>
                                <!-- explode использется для расчленения строки на массив. 
                                Принимает подстроку - разделитель и саму разделяемую строку  -->
                                <?php $ingredients = explode(',', $pizza['ingredients']); ?>
                                <?php foreach ($ingredients as $ingredient): ?>
                                    <li><?php echo htmlspecialchars($ingredient)?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="card-action right-align">
                            <!-- Передаем ID пиццы GET запросом при переходе на подробную информацию -->
                            <a href="details.php?id=<?php echo $pizza['id']?>" class="brand-text">more info</a>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>

</html>