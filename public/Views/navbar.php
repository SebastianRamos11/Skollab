<?php
  $user = "SELECT ID_Rol, nombres FROM persona WHERE ID_Persona =".$_SESSION['id'];
  $user_result = mysqli_query($dbConnection, $user) or die(mysqli_error($dbConnection));
  $user = mysqli_fetch_all($user_result, MYSQLI_NUM); 
?>
<nav class="nav nav--session">
  <div class="nav__logo">
    <a href="index.php" class="logo">
      <img src="img/main/Logo.png" alt="logo" class="logo__img" />
    </a>
  </div>
  <ul class="nav-menu nav-menu--loged">
    <li class="nav-menu__item"><a href="main.php" class="nav-menu__link"><i class="fa-solid fa-house"></i> Inicio</a></li>
    <li class="nav-menu__item"><a href="profile.php" class="nav-menu__link"><i class="fa-solid fa-user"></i> Perfil</a></li>
    <li class="nav-menu__item"><a href="../Models/logout.php" class="nav-menu__link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a></li>
  </ul>
  <div class="nav-profile">
    <img src="./img/default.jpeg" alt="avatar" class="nav-profile__img">
    <div class="nav-profile__name"><?php if (isset($_SESSION['id'])) {echo $user[0][1];} else {include('../Models/logout.php'); $location = header('Location: ../index.php');}; ?></div>
  </div>
</nav>