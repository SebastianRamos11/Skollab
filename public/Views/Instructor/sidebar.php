<?php
  $user_name = "SELECT nombres  FROM persona WHERE ID_Persona =".$_SESSION['id'];
  $name_result = mysqli_query($dbConnection, $user_name) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($name_result, MYSQLI_NUM);
  $user_name = $result_array[0][0];

  $group_num = "SELECT numero FROM ficha WHERE ID_Ficha = $group";
  $group_num_result = mysqli_query($dbConnection, $group_num) or die(mysqli_error($dbConnection));
  $group_num = mysqli_fetch_all($group_num_result, MYSQLI_NUM)[0][0];
?>
<div class="wrapper">
  <header class="header">
    <nav-y class="nav-y">
      <a href="../index.php" class="nav-y__logo">
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
        <a href="./activities.php?group=<?php echo $group ?>" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-book"></i>
            <span>Actividades</span>
          </li>
        </a>
        <a href="./groups.php?group=<?php echo $group ?>" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-users"></i>
            <span>Ficha</span>
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><g data-name="Business Man"><path d="M45 8v9.27a2 2 0 0 0-1-.27h-3v-4s-2 0-5.4-3c0 0-3.6 4-12.6 4v3h-3a2 2 0 0 0-1 .27V8a7 7 0 0 1 7-7h12a3 3 0 0 1 3 3 4 4 0 0 1 4 4z" style="fill:#494a59"/><path d="M38 26.7V34l-4 5h-4l-4-5v-7.3a8.976 8.976 0 0 0 12 0z" style="fill:#eac2b9"/><path d="M58 47.17v15.08a.755.755 0 0 1-.75.75H6.75a.755.755 0 0 1-.75-.75V47.17a7.992 7.992 0 0 1 4.72-7.29C21.846 34.869 18.429 36.407 26 33l4 5h4l4-5c7.4 3.329 4.11 1.849 15.28 6.88A7.992 7.992 0 0 1 58 47.17z" style="fill:#b28362"/><path d="M53.28 39.88 44 35.7v.08a17.992 17.992 0 0 1-12 16.97 66.3 66.3 0 0 1-6.69 1.7A3 3 0 0 0 23 57.37V63h34.25a.75.75 0 0 0 .75-.75V47.17a7.992 7.992 0 0 0-4.72-7.29z" style="fill:#dbaa89"/><path d="M37.64 41.64 34 38h-4l-3.64 3.64L29 46l-.86 4.84A18.027 18.027 0 0 0 32 52.75a18.027 18.027 0 0 0 3.86-1.91L35 46z" style="fill:#343544"/><path d="M35.86 50.84A18.027 18.027 0 0 1 32 52.75a18.027 18.027 0 0 1-3.86-1.91L29 46h6z" style="fill:#494a59"/><path style="fill:#d0dbf7" d="m30 38-5 5-5-7.3 6-2.7 4 5z"/><path d="m29 46-.86 4.84A18 18 0 0 1 20 35.78v-.08l5 7.3 1.36-1.36z" style="fill:#e6ecff"/><path style="fill:#d0dbf7" d="M44 35.7 39 43l-5-5 4-5 6 2.7z"/><path d="M44 35.7v.08a18 18 0 0 1-8.14 15.06L35 46l2.64-4.36L39 43z" style="fill:#e6ecff"/><path d="M49.75 51v12h-1.5V51a.75.75 0 0 1 1.5 0z" style="fill:#b28362"/><path d="M15.75 51v12h-1.5V51a.75.75 0 0 1 1.5 0z" style="fill:#896146"/><path d="M45 16.27a2 2 0 0 0-1-.27h-4l-.23 7H44a2.006 2.006 0 0 0 2-2v-3a2 2 0 0 0-1-1.73zM24 16h-4a2 2 0 0 0-2 2v3a2.006 2.006 0 0 0 2 2h4.23z" style="fill:#eac2b9"/><circle cx="27" cy="59" r="1" style="fill:#b28362"/><path d="M41 12v9a9 9 0 0 1-18 0v-8c9 0 12.6-4 12.6-4 3.4 3 5.4 3 5.4 3z" style="fill:#ffddd4"/></g></svg>
        <div>Profesor</div>
      </div>
      <div class="nav-y__course">
        <img src="../img/courses/school_logo.png" alt="course">
        <div><?php echo $group_num; ?></div>
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
    
