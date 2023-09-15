<?php

    include 'config/db_connect.php';

    /*
    При отправке формы ее обрабатывает эта же страница
    Поэтому делается проверка на наличие данных, отправленных методом GET (POST),
    ведь при первом посешении страницы никаких данных с формы не отправляется
    
    Встроенная ф-ция isset проверяет, инициализирована ли переменная.
    *Инициализация - объявление с присваиванием значения или присваивание переменной значения
    до первого ее использования в программе.

    $_GET и $_POST - глобальные переменные, содержащие ассоциативные массивы,
    где парой ключ-значение являются атрибут name тега input и значение, записанное в него пользователем.

    $_GET или $_POST - зависит от метода (атрибут method) отправки данных с формы.
    
    $_GET и $_POST - глобальные переменные и они объявлены в любом случае,
    а при отсутствии данных хранят пустые массивы

    Поэтому проверяем if(isset($_GET['submit'])). 
    $_GET['submit'] (кнопка отправки формы) инициализируется только при отправке формы.

    */

    // POST check

    /* чтоб не словить ошибок в полях формы, при первом запуске страницы (у инпутов
     автозаполнение через value, а если убрать этот код, то переменные, которыми они
      заполняются будут объявлены только после выполнения условия отправки данных
      с формы if(isset($_POST['submit'])). Поэтому мы инициализируем эти переменные до 
      проверки отправки формы.*/
    $email = $title = $ingredients = "";
    
    // Объявляем ассоциативный массив, в который будем вписывать сообщения об ошибках валидации инпутов для пользователей
    $errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');


    if(isset($_POST['submit'])){

        // ВАЛИДАЦИЯ

        // check email
        if(empty($_POST['email'])){
            $errors['email'] = 'An email is required';
        } else {
            $email = $_POST['email'];
            // Используем встроенный в php фильтр на email (есть еще ip, url и тд.)
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'invalid email';
            }
        }

        // check title
        if(empty($_POST['title'])){
            $errors['title'] = 'A title is required <br>';
        } else {
           $title = $_POST['title'];
           // Используем регулярное выражение.
           if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] = 'Title must be letters and spaces only';
           }
        }

        // check ingredients
        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'At least one ingredient is required <br>';
        } else {
            $ingredients = $_POST['ingredients'];
            // Используем регулярное выражение.
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
                $errors['ingredients'] = 'Ingredients must be a comma separated list';
            }
        }

        /* array_filter проходит массив и выполняет для каждого его элемента функцию
        Принимает массив и коллбэк функцию 
        Может принимать только массив. Тогда при проходе массива, в котором все строки
        пустые, он вернет false, чем мы и воспользуемся 
        */
        if(!array_filter($errors)){ // если !есть непустые строки в массиве $errors (другими словами, если форма заполнена правильно)
            
            // ДОБАВЛЕНИЕ ЗАПИСИ

            // mysqli_real_escape_string защита от SQL инъекции. Используется тогда, когда мы хотим внести в ЮД данные, полученные от пользователя
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

            $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES ('$title', '$email', '$ingredients')";

            //sending a query to DB and check for errors at the same time 
            if(mysqli_query($conn, $sql)){
                //success
                header('Location: index.php');
            } else {
                //error
                echo 'query error: ' . mysqli_error($conn);
            }

        }

    }; // end of POST check

?>

<!DOCTYPE html>
<html lang="en">

    <?php include 'templates/header.php'; ?>

    <section class="container grey-text">
        <h4 class="center">Add a Pizza</h4>

        <form action="add.php" method="POST" class="white">
            
            <div class="red-text"><?php echo $errors['email']?></div>
            <!--echo htmlspecialchars($email); // htmlspecialchars - защита от XSS (cross site scripting) Оборачивай в него все, что вводил пользователь и что должно быть обработано браузером. В данном случае это вывод данных в инпут-->
            <input type="text" name="email" value="<?php echo htmlspecialchars($email)?>">
            <label for="">Your Email:</label>

            <div class="red-text"><?php echo $errors['title']?></div>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title)?>">
            <label for="">Pizza Title:</label>

            <div class="red-text"><?php echo $errors['ingredients']?></div>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients)?>">
            <label for="">Ingredients (comma separated):</label>

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
            
        </form>

    </section>

    <?php include 'templates/footer.php'; ?>

</html>