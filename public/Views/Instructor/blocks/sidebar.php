<div class="wrapper">
  <header class="header">
    <nav class="nav">
      <a href="../index.html">
        <img src="../img/main/Logo.png" alt="logo" class="logo full-logo" />
        <img src="../img/skollab.png" alt="logo" class="logo short-logo" />
      </a>
      <ul class="nav-menu">
        <li class="nav-menu__item">
          <a href="./instructor.php?id=<?php echo $id; ?>" class="nav-menu__link nav-menu__link--active">
            <i class="fa-solid fa-house"></i>
            <span>Inicio</span>
          </a>
        </li>
        <li class="nav-menu__item">
          <a href="./review-center.php?id=<?php echo $id; ?>" class="nav-menu__link">
            <i class="fa-solid fa-briefcase"></i>
            <span>Centro de revisión</span>
          </a>
        </li>
        <li class="nav-menu__item">
          <a href="./groups.php?id=<?php echo $id; ?>" class="nav-menu__link">
            <i class="fa-solid fa-users"></i>
            <span>Fichas</span>
          </a>
        </li>
        <li class="nav-menu__item">
          <a href="./publications.php?id=<?php echo $id; ?>" class="nav-menu__link">
            <i class="fa-solid fa-book"></i>
            <span>Publicaciones</span>
          </a>
        </li>
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
      <div class="profile">
        <img src="../img/default.jpeg" alt="avatar" class="profile__img">
        <div class="profile__name"><?php echo $result_array[0][1];?></div>
      </div>
    </nav>
  </header>
  <main class="main-content">
    