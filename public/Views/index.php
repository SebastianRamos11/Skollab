<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/main.css" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <title>Skollab</title>
  </head>
  <body>
    <header class="header">
      <?php 
        include_once "../Models/connection.php";
        session_start();

        if (isset($_SESSION['id'])) {
          include_once "navbar.php";
        } else {
          ?>
          <nav class="nav">
            <div class="nav__logo">
              <a href="index.php" class="logo">
                <img src="img/main/Logo.png" alt="logo" class="logo__img" />
              </a>
            </div>
            <ul class="nav-menu">
              <li class="nav-menu__item">
                <a href="./login.php" class="nav-menu__link">Iniciar Sesión</a>
              </li>
              <li class="nav-menu__item">
                <a href="./signup.php" class="nav-menu__link nav-menu__link--outline">Registrarse</a>
              </li>
            </ul>
          </nav>
          <?php
        }
      ?>
    </header>

    <main class="main">
      <section class="home">
        <div class="home__figure">
          <img src="img/main/books-illustration.png" alt="books" />
        </div>
        <div class="home__start">
          <h1 class="home__title">Donde la gestión del aprendizaje dígital es más intuitiva y eficaz.</h1>
          <p class="home__paragraph">Digitaliza tu gestión académica, ¡Skollab LMS te permitirá esto y mucho más!</p>
          <a href="signup.php" class="home__btn">Comenzar</a>
        </div>
      </section>
    </main>

    <article class="info">
      <h2 class="info__title">¿Qué ofrecemos?</h2>
      <p class="info__paragraph">Skollab es LMS que te permitirá gestionar todo tu proceso formativo, ofrenciendo interfaces intuitivas e interactivas que mejorarán tu experiencia educativa.</p>
    </article>

    <section class="card-container">
      <section class="card">
        <div class="card__figure">
          <img src="img/main/hero.png" alt="student" class="card__img" />
        </div>
        <div class="card-content">
          <div class="card__info">
            <h2 class="card__title">Formación fluida</h2>
            <p class="card__paragraph"> Forma tu curso de la mejor manera, fluye en tu aprendizaje sin interrupciones ni complicaciones.</p>
          </div>
          <div class="card-steps">
            <ul class="card-steps__list">
              <li class="card-steps__li"><span>1</span> Regístrate</li>
              <li class="card-steps__li"><span>2</span> Elige tu rol</li>
              <li class="card-steps__li"><span>3</span> Únete a tu curso</li>
              <li class="card-steps__li"><span>4</span> ¡Gestiona tu aprendizaje!</li>
            </ul>
          </div>
        </div>
      </section>
    </section>

    <section class="design">
      <div class="design__title">Con un diseño moderno para el fácil entendimiento y uso de la aplicación.<hr/></div>
      <div class="design__figure">
        <img src="img/main/painter.png" alt="painter" class="design__img" />
      </div>
    </section>

    <section class="skills">
      <div class="skills__head">
        <h2 class="skills__title">Beneficios</h2>
        <hr />
        <p class="skills__paragraph">Con nosotros tendras beneficios, que te serán de gran utilidad a lo largo de tu formación.</p>
      </div>
      <div class="skills__icons">
        <div class="skills__item">
          <img src="img/skills/target.png" alt="target" class="skills__img" />
          <h3>Productividad</h3>
        </div>
        <div class="skills__item">
          <img src="img/skills/organized.png" alt="calendar" class="skills__img" />
          <h3>Organización</h3>
        </div>
        <div class="skills__item">
          <img src="img/skills/flexibility.png" alt="open-book" class="skills__img" />
          <h3>Flexibilidad</h3>
        </div>
        <div class="skills__item">
          <img src="img/skills/portfolio.png" alt="briefcase" class="skills__img" />
          <h3>Portafolio</h3>
        </div>
        <div class="skills__item">
          <img src="img/skills/reports.png" alt="support" class="skills__img" />
          <h3>Reportes</h3>
        </div>
      </div>
    </section>

    <section class="start">
      <div class="start__content">
        <div class="start__title">
          <h2>La mejor opción para gestionar tu aprendizaje</h2>
          <hr />
        </div>
        <p class="start__paragraph">Comienza ahora a gestionar tu formación académica de forma dígital, accede a tus actividades y recursos en cualquier lugar con acceso a internet.</p>
        <a href="signup.php" value="Comenzar" class="start__btn">Comenzar</a>
      </div>
      <div class="start__figure">
        <img src="img/main/start.png" alt="start" />
      </div>
    </section>

    <footer class="footer">
      <div class="footer-wave">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" >
          <path
            d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
            class="shape-fill"
          ></path>
        </svg>
      </div>
      <div class="footer__content">
        <div class="footer__general">
          <div class="footer__brand">Skollab</div>
          <div class="footer__info">
            <div>Skollab Education</div>
            <div>Av 1 de Mayo #33-98</div>
            <div>Bogotá D.C</div>
          </div>
          <div class="footer__media">
            <a href="https://web.facebook.com/profile.php?id=100068938852709" target="_blank"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-instagram" target="_blank"></i></a>
            <a href="#"><i class="fa-brands fa-linkedin" target="_blank"></i></a>
          </div>
        </div>
        <div class="footer__us">
          <h4 class="footer__title">Nosotros</h4>
          <div class="footer__info">
            <div>Inicio</div>
            <div>Personalizar</div>
            <div>Soporte</div>
            <div>Contacto</div>
          </div>
        </div>
        <div class="footer__business">
          <h4 class="footer__title">Empresa</h4>
          <div class="footer__info">
            <div>NIT</div>
            <div>Contrato</div>
            <div>Licencia</div>
            <div>Miembros</div>
          </div>
        </div>
        <div class="footer__contact">
          <h4 class="footer__title">Contáctanos</h4>
          <div class="footer__info">
            Ingresa tu email y nos contactaremos contigo en unos minutos.
          </div>
          <form class="footer__contact-form">
            <input type="email" name="email" class="footer__contact-email" placeholder="Correo electrónico"/>
            <input type="button" value="Enviar" class="footer__contact-button"/>
          </form>
        </div>
      </div>
      <hr />
      <div class="footer__copyright">
        <div>2022 @Skollab</div>
        <div>Todos los derechos reservados</div>
      </div>
    </footer>
  </body>
</html>
