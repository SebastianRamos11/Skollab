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
        <a href="../main.php" class="nav-y-menu__link nav-y-menu__link--active">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-house"></i>
            <span>Inicio</span>
          </li>
        </a>
        <a href="./activities.php" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-book"></i>
            <span>Actividades</span>
          </li>
        </a>
        <a href="./groups.php" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-users"></i>
            <span>Fichas</span>
          </li>
        </a>
        <a href="../../Models/logout.php" class="logout-mobile">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Cerrar Sesión</span> 
          </li>
        </a>
      </ul>
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
    
