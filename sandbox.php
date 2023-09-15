<?php 

    //############################# ternary operators
    echo '<br>';

    $score = 30;
    echo $score > 40 ? 'high score' : 'low score';
    

    //############################# superglobals
    echo '<br>';

    /*
    $_GET['name'];
    $_POST['name'];
    */

    echo $_SERVER['SERVER_NAME'] . '<br>'; // имя сервера (например, localhost)
    echo $_SERVER['REQUEST_METHOD'] . '<br>'; // Тип запроса, которым была звгружена эта страница
    echo $_SERVER['SCRIPT_FILENAME'] . '<br>'; // Абсолютный путь к странице
    echo $_SERVER['QUERY_STRING'] . '<br>'; // То, что идет после ? в URL при GET запросе (параметры)
    echo $_SERVER['PHP_SELF'] . '<br>'; // Относительный путь к странице (отностительно сервера). Можно использовать в action формы, когда обработчик находится на той же странице.
    echo time();
    //############################# sessions
    echo '<br>';
    // Сессии хранят данные на сервере, что позволяет не терять их при переходе между страницами 
    // Сессия начинается, когда мы ее открываем и действует, пока не закроется вкладка сайта 

    if(isset($_POST['submit'])) {

        session_start(); // starting a session

        // Данные в сессию записаны, теперь мы можем получить к ним доступ в любом месте сайта
        $_SESSION['name'] = $_POST['name'];

        header('Location: index.php'); 
        // работа с сессиями продолжается в файле templates/header.php
    }

    //############################# cookies
    //Куки хранятся в памяти ПК. Используются, например, чтобы узнать, посещал ли пользователь какую-либо страницу ранее,
    // или добавлял ли пользователь тот или иной товар в корзину. 
    echo '<br>';

    if(isset($_POST['submit'])) {
        setcookie('sex', $_POST['sex'], time() + 86400); // создаение куки.
        // sex - имя куки,
        // $_POST['sex'] - присваиваемое значение, 
        //time() + 86400 - время, в которое куки автоматически удалится. 
        //time() в PHP возвращает количество секунд, прошедших с 1 января 1970 года 00:00:00 UTC. 
        //Мы к этому времени прибавляем еще 86400 секунды, т.е еще сутки. Выходит, что эти куки будут храниться 24 часа.
    
        // работа с куки продолжается в файле templates/header.php
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sandbox</title>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <input type="text" name="name">
        <select name="sex">
            <option value="male">male</option>
            <option value="female">female</option>
        </select>
        <input type="submit" name="submit" value="Submit">
    </form>
</head>
<body>
    
</body>
</html>


