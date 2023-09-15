<?php 
    session_start();

    if($_SERVER['QUERY_STRING'] == 'noname'){ // если дописать в url парамер noname
        unset($_SESSION['name']); // удаляем name из массива сессии 
        unset($_COOKIE['sex']);
    }

    // ?? - Null coalescing operator
    $name = $_SESSION['name'] ?? 'Guest'; // Присваиваем значение переменной name. 
    // Если $_SESSION['name'] возвращает не true (напимер мы ансетнули с помощью ?noname или
    // просто не отправляли POST запрос из сандбокса), то $name присваивается 'запасное' значение 'Guest'
    
    
    
    // get cookie

    $sex = $_COOKIE['sex'] ?? 'Unknown';

    ?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Ninja Pizza</title>
    <style>
        .brand{
            background-color: #cbb09c !important;
        }
        .brand-text{
            color: #cbb09c !important;
        }
        form{
            max-width: 460px;
            margin: 20px auto;
            padding: 20px;
        }
    </style>
</head>
<body class="grey lighten-4">
    <nav class="white z-depth-0">
        <div class="container">
            <a href="index.php" class="brand-logo brand-text">Ninja Pizza</a>
            <ul id="nav-mobile" class="right hide-on-small-and-down">
            <li class="grey-text">Hello <?php echo htmlspecialchars($name) ?> </li>
            <li class="grey-text"> (<?php echo htmlspecialchars($sex) ?>)</li>    
            <li><a href="add.php" class="btn brand brand z-depth-0">Add a pizza</a></li>
            </ul>
        </div>
    </nav>