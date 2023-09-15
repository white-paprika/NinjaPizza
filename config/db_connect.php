<?php

    // connect to database
    $conn = mysqli_connect('localhost', 'egor', 'password', 'pizzaDB');

    // check connection
    // В видео работает, тк там кидает warning, но фактически при ошибке подключения сразу вылезет фатальная ошибка, потэтому до проверки не дойдет
    if(!$conn){
        echo 'connection error:' . mysqli_connect_error();
    }

?>