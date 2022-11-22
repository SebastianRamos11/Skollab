<?php
    $read_query = "SELECT ID_Rol, nombres FROM persona WHERE ID_Persona =".$_SESSION['id'];
    $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
    $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM); 
?>
<nav class="nav nav--session">
  <div class="nav__logo">
    <a href="index.php" class="logo">
      <img src="img/main/Logo.png" alt="logo" class="logo__img" />
    </a>
  </div>
  <ul class="nav-menu nav-menu--loged">
    <li class="nav-menu__item"><a href="
    <?php
      if ($result_array[0][0] == 1) {
        echo './Admin/admin.php';
      } elseif ($result_array[0][0] == 2) {
        echo './Instructor/instructor.php';
      } elseif ($result_array[0][0] == 3) {
        echo './Aprendiz/aprendiz.php';
      }
    ?>
    " class="nav-menu__link"><i class="fa-solid fa-house"></i> Inicio</a></li>
    <li class="nav-menu__item"><a href="../Models/logout.php" class="nav-menu__link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a></li>
  </ul>
  <div class="nav-profile">
    <img src="./img/default.jpeg" alt="avatar" class="nav-profile__img">
    <div class="nav-profile__name"><?php if (isset($_SESSION['id'])) {echo $result_array[0][1];} else {include('../Models/logout.php'); $location = header('Location: ../index.php');}; ?></div>
  </div>
</nav>
<script>
  const navArrow = document.querySelector('.btn-menu');
  const navMenuLinks = document.querySelector('.nav-menu__links');
  navArrow.addEventListener('click', () => {
    navArrow.classList.toggle('btn-menu--rotate');
    navMenuLinks.classList.toggle('hidden');
  })
</script>