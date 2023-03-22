<?php
  $user_name = "SELECT nombres  FROM persona WHERE ID_Persona =".$_SESSION['id'];
  $name_result = mysqli_query($dbConnection, $user_name) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($name_result, MYSQLI_NUM);
  $user_name = $result_array[0][0];
?>

<div class="wrapper">
  <header class="header">
    <nav-y class="nav-y">
      <a href="../index.php">
        <img src="../img/main/Logo.png" alt="logo" class="logo full-logo" />
        <img src="../img/skollab.png" alt="logo" class="logo short-logo" />
      </a>
      <ul class="nav-y-menu">
        <a href="./admin.php" class="nav-y-menu__link nav-y-menu__link--active">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-house"></i>
            <span>Inicio</span>
          </li>
        </a>
        <a href="crud.php" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-user-group"></i>
            <span>CRUD</span>
          </li>
        </a>
        <a href="courses.php" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Cursos</span>
          </li>
        </a>
        <a href="../../Models/logout.php" class="logout-mobile">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Cerrar Sesión</span> 
          </li>
        </a>
      </ul>
      <div class="nav-y__role">
        <svg class="crud-option__figure" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><g data-name="Business Man"><path d="M55.26 42.26 39 35l-5 7h-4l-5-7-16.3 7.37A8.012 8.012 0 0 0 4 49.66v12.59a.75.75 0 0 0 .75.75h54.5a.75.75 0 0 0 .75-.75V49.57a8.012 8.012 0 0 0-4.74-7.31z" style="fill:#494a59"/><path d="M39 28.14V36l-5 7h-4l-5-7v-7.86a10 10 0 0 0 14 0z" style="fill:#eac2b9"/><path d="M18 19.542V8a4 4 0 0 1 4-4 3 3 0 0 1 3-3h8.81a16.817 16.817 0 0 1 9.77 2.98c2.43 1.75 4.6 4.31 4.41 7.88-.125 2.3-.939 3.681-3.091 7.556z" style="fill:#494a59"/><path style="fill:#343544" d="M29 63h-6l-6-11 3-3-4-2-3.48-6.36 7.59-3.43 7.21 20.91L29 63z"/><path style="fill:#494a59" d="M36.68 58.12 35 63h-6l-1.68-4.88L29 49h6l1.68 9.12z"/><path style="fill:#343544" d="M37 43.8 35 49h-6l-2-5.2 3-1.8h4l3 1.8z"/><path style="fill:#d0dbf7" d="M43.9 37.19 39 45l-2-1.2-3-1.8 5-7 4.9 2.19zM30 42l-3 1.8-2 1.2-4.89-7.79L25 35l5 7z"/><path style="fill:#e6ecff" d="m29 49-1.68 9.12-7.21-20.91L25 45l2-1.2 2 5.2zM43.9 37.19l-7.22 20.93L35 49l2-5.2 2 1.2 4.9-7.81z"/><path d="M47 20v2a2 2 0 0 1-2 2h-4.2a10.048 10.048 0 0 0 .2-2v-4h4a2.006 2.006 0 0 1 2 2zM23.2 24H19a2 2 0 0 1-2-2v-2a2.006 2.006 0 0 1 2-2h4v4a10.048 10.048 0 0 0 .2 2z" style="fill:#eac2b9"/><path d="M42 15v7a10 10 0 0 1-10 10 10 10 0 0 1-10-10v-9s2.222.143 6-3c0 0 4 5 14 5z" style="fill:#ffddd4"/><path style="fill:#343544" d="m48 47-4 2 3 3-6 11h-6l1.68-4.88 7.22-20.93 7.61 3.4L48 47zM53.75 52v11h-1.5V52a.75.75 0 0 1 1.5 0z"/><path d="m20.11 37.21-.01-.02M20.11 37.21l-.01-.02"/><path d="M11.75 52v11h-1.5V52a.75.75 0 0 1 1.5 0z" style="fill:#343544"/></g></svg>
        <div>Administrador</div>
      </div>
      <button class="ham" type="button" aria-label="Main Menu">
        <svg width="60" height="50" viewBox="0 0 100 100">
          <path
            class="br br-1"
            d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058"
          />
          <path class="br br-2" d="M 20,50 H 80" />
          <path
            class="br br-3"
            d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942"
          />
        </svg>
      </button>
      <a href="../profile.php" class="nav-profile nav-profile--y">
        <img src="../img/default.jpeg" alt="avatar" class="nav-profile__img">
        <div class="nav-profile__name"><?php if (isset($_SESSION['id'])) {echo $user_name;} else {include('../../Models/logout.php'); $location = header('Location: ../index.php');}; ?></div>
      </a>
      <a href="../../Models/logout.php" class="logout-desktop">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
        <span>Cerrar Sesión</span>
      </a>  
    </nav-y>
  </header>
  <main class="main-content">