<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Inicio</title>
  </head>
  <body>
    <div class="container df">
      <!-- NAV -->
      <nav class="nav nav-y">
        <div class="nav__logo">
          <a href="../index.html" class="logo">
            <img src="../img/main/Logo.png" alt="logo" class="logo__img" />
          </a>
        </div>
        <ul class="nav-menu">
          <li class="nav-menu__item">
            <a href="./instructor.php" class="nav-menu__link nav-menu__link--active">
              <i class="fa-solid fa-house"></i>
              <span>Inicio</span>
            </a>
          </li>
          <li class="nav-menu__item">
            <a href="./review-center.php" class="nav-menu__link">
              <i class="fa-solid fa-briefcase"></i>
              <span>Centro de revisión</span>
            </a>
          </li>
          <li class="nav-menu__item">
            <a href="./groups.php" class="nav-menu__link">
              <i class="fa-solid fa-users"></i>
              <span>Fichas</span>
            </a>
          </li>
          <li class="nav-menu__item">
            <a href="./publications.php" class="nav-menu__link">
              <i class="fa-solid fa-book"></i>
              <span>Publicaciones</span>
            </a>
          </li>
        </ul>
        <div class="nav-ad">
          <div class="nav-ad__figure">Libros</div>
          <div class="nav-ad__paragraph">Crea una evidencia para tus aprendices</div>
          <a href="#"><input type="button" value="Crear evidencia" /></a>
        </div>
      </nav>

      <!-- MAIN -->
      <div class="main ml300">
        <header class="header">
          <!-- TITLE -->
          <h1 class="title">Buenos días, Instructor 👋</h1>
          <!-- PROFILE -->
          <div class="profile">
            <div class="profile__img">Foto de perfil</div>
            <div class="profile__notifications">Notificaciones</div>
          </div>
        </header>
        <section class="task-counter">
          <div class="task-counter__message">El 67% de tus aprendices han completado la evidencia.</div>
          <div class="task-counter__figure">Imagen rompecabezas</div>
        </section>
        <section class="tasks">Tabla evidencias</section>
        <section class="best-students">Estudiantes, foto, puntos</section>
        <section class="groups">Fichas</section>
      </div>
    </div>
  </body>
</html>
