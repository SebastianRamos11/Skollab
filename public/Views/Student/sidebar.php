<?php
  $user_name = "SELECT nombres  FROM persona WHERE ID_Persona =".$_SESSION['id'];
  $name_result = mysqli_query($dbConnection, $user_name) or die(mysqli_error($dbConnection));
  $result_array = mysqli_fetch_all($name_result, MYSQLI_NUM);
  $user_name = $result_array[0][0];
  $id_user = $_SESSION['id'];

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
        <a href="activities-center.php?group=<?php echo $group ?>" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-book"></i>
            <span>Actividades</span>
          </li>
        </a>
        <a href="briefcase.php?group=<?php echo $group ?>" class="nav-y-menu__link">
          <li class="nav-y-menu__item">
            <i class="fa-solid fa-briefcase"></i>
            <span>Portafolio</span>
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><g data-name="Man Graduation"><path d="M45 11.39v11.88a1.995 1.995 0 0 0-1-.27h-3v-3s-10 0-12-4c0 0-1 4-6 4v3h-3a1.995 1.995 0 0 0-1 .27V11.39a47.276 47.276 0 0 1 26 0z" style="fill:#343544"/><path d="M38 31.71V39a6 6 0 0 1-12 0v-7.3a8.99 8.99 0 0 0 12 .01z" style="fill:#eac2b9"/><path d="M58 53.47V62a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-8.53a9.992 9.992 0 0 1 5.9-9.12L26 38a6 6 0 0 0 12 0l14.1 6.35a9.992 9.992 0 0 1 5.9 9.12z" style="fill:#494a59"/><path d="M50.28 43.53C47.09 49.27 39.87 53 32 53s-15.09-3.73-18.28-9.47L26 38a6 6 0 0 0 12 0z" style="fill:#ea972a"/><path d="M47.53 42.29C44.88 46.83 38.93 50 32 50s-12.88-3.17-15.53-7.71L26 38a6 6 0 0 0 12 0z" style="fill:#fcd354"/><path d="M44 22h-4l-.223 6H44a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zM24 22h-4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4.223z" style="fill:#eac2b9"/><path d="M29 15s-1 4-6 4v7a9 9 0 0 0 18 0v-7s-10 0-12-4z" style="fill:#ffddd4"/><path d="M17 1v10.642a.996.996 0 0 0 1.295.947 47.435 47.435 0 0 1 27.41 0A.996.996 0 0 0 47 11.642V1z" style="fill:#494a59"/><path d="M52.514 43.435 39 37.353V33.13A10.011 10.011 0 0 0 41.539 29H44a3.003 3.003 0 0 0 3-3v-2a2.982 2.982 0 0 0-1-2.22v-8.044c.228.072.457.137.684.213A1 1 0 0 0 48 13V2h4v14a1 1 0 0 0 2 0V1a1 1 0 0 0-1-1H11a1 1 0 0 0 0 2h5v11a1 1 0 0 0 1.316.949c.227-.076.457-.14.684-.213v8.044A2.982 2.982 0 0 0 17 24v2a3.003 3.003 0 0 0 3 3h2.461A10.011 10.011 0 0 0 25 33.13v4.223l-13.514 6.082A11.017 11.017 0 0 0 5 53.465V63a1 1 0 0 0 2 0v-9.534a9.013 9.013 0 0 1 5.307-8.207l1.021-.46C16.89 50.414 24.097 54 32 54s15.11-3.586 18.672-9.2l1.021.46A9.013 9.013 0 0 1 57 53.465V63a1 1 0 0 0 2 0v-9.534a11.017 11.017 0 0 0-6.486-10.031zM32 45a7.01 7.01 0 0 0 6.84-5.525l7.21 3.244C43.259 46.565 37.888 49 32 49s-11.258-2.435-14.05-6.28l7.21-3.245A7.01 7.01 0 0 0 32 45zm13-19a1 1 0 0 1-1 1h-2.05c.032-.329.05-.662.05-1v-3h2a1 1 0 0 1 1 1zm1-24v9.634a48.789 48.789 0 0 0-28 0V2zM20 13.155a46.812 46.812 0 0 1 24 0V21h-2v-2a1 1 0 0 0-1-1c-2.61-.002-9.694-.625-11.105-3.447a1 1 0 0 0-1.865.204C28.021 14.79 27.17 18 23 18a1 1 0 0 0-1 1v2h-2zM20 27a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h2v3c0 .338.018.671.05 1zm4-1v-6.052a6.93 6.93 0 0 0 5.22-3.061c2.756 2.503 8.398 2.995 10.78 3.09V26a8 8 0 0 1-16 0zm8 10a9.925 9.925 0 0 0 5-1.353V38a5 5 0 0 1-10 0v-3.353A9.925 9.925 0 0 0 32 36zm0 16c-7.112 0-13.583-3.12-16.835-8.027l.93-.419C19.192 48.102 25.317 51 32 51s12.807-2.898 15.906-7.446l.93.419C45.582 48.88 39.111 52 32 52z" style="fill:#231e23"/><path d="M48 54a1 1 0 0 0-1 1v8a1 1 0 0 0 2 0v-8a1 1 0 0 0-1-1zM16 54a1 1 0 0 0-1 1v8a1 1 0 0 0 2 0v-8a1 1 0 0 0-1-1z" style="fill:#231e23"/></g></svg>
        <div>Estudiante</div>
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