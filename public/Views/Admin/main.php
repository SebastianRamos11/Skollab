<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css" />
    <link rel="stylesheet" href="../css/admin.css" />

      <!-- Header -->
      <?php include '../components/header.php' ?>
      <h1 class="header__title" id="header">Bienvenido, Administrador 👋</h1>
          <!-- <div class="banner">
            <h2 class="banner__title">Skollab, el mejor sistema de gestión aprendizaje dedicado al SENA.</h2>
            <img class="banner__figure" src="../img/figures/puzzle.png" alt="puzzle">
          </div> -->
      </header>
      <?php 
        include_once "../../Models/new-connection.php";
        $read_query = $bd -> query("SELECT * FROM persona");
        $persona = $read_query->fetchAll(PDO::FETCH_OBJ);

        $read_admin = $bd -> query("SELECT * FROM persona WHERE rol = 'ADMINISTRADOR';");
        $read_aprendiz = $bd -> query("SELECT * FROM persona WHERE rol = 'APRENDIZ';");
        $read_instructor = $bd -> query("SELECT * FROM persona WHERE rol = 'INSTRUCTOR';");
        
        $admin = $read_admin->fetchAll(PDO::FETCH_OBJ);
        $aprendiz = $read_aprendiz->fetchAll(PDO::FETCH_OBJ);
        $instructor = $read_instructor->fetchAll(PDO::FETCH_OBJ);



      ?>


      <div class="container">
        <div class="row">
          <div class="col-md-11">
            <!-- ALERTS -->

            <!-- Empty data -->
            <?php 
              if(isset($_GET['message']) and $_GET['message'] == 'empty'){
            ?>
              <script>
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: '¡No puedes enviar datos vacíos!'
                  });
              </script>
            <?php 
              }
            ?>
            <!-- Create successfully -->
            <?php 
              if(isset($_GET['message']) and $_GET['message'] == 'created'){
            ?>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: '¡Usuario creado!',
                      text: '¡Gracias por alimentar la base de datos!'
                  });
              </script>
            <?php 
              }
            ?>
            <!-- Modified successfully -->
            <?php 
              if(isset($_GET['message']) and $_GET['message'] == 'modified'){
            ?>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'El usuario ha sido modificado',
                  });
              </script>
            <?php 
              }
            ?>
            <!-- Delete successfully -->
            <?php 
              if(isset($_GET['message']) and $_GET['message'] == 'deleted'){
            ?>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'El usuario ha sido eliminado'
                  });
              </script>
            <?php 
              }
            ?>
            
            <!-- Error -->
            <?php 
              if(isset($_GET['message']) and $_GET['message'] == 'error'){
            ?>
              <script>
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'El usuario no fue encontrado'
                  });
              </script>
            <?php 
              }
            ?>


            <!-- /ALERTS -->

            <!-- CRUD: Administradores -->
            <div class="card mb-50">
              <div class="card-header">Administradores</div>
              <div class="p-4">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Nombres</th>
                      <th scope="col">Apellidos</th>
                      <th scope="col">Rol</th>
                      <th scope="col">Correo</th>
                      <th scope="col">Teléfono</th>
                      <th scope="col" colspan="2"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      foreach($admin as $dato){
                        
                    ?>

                    <tr>
                      <td scope="row"><?php echo $dato -> ID_Persona; ?></td>
                      <td><?php echo $dato -> nombres; ?></td>
                      <td><?php echo $dato -> apellidos; ?></td>
                      <td><?php echo $dato -> rol; ?></td>
                      <td><?php echo $dato -> correo_electronico; ?></td>
                      <td><?php echo $dato -> telefono; ?></td>
                      <td><a href="form-edit.php?id=<?php echo $dato -> ID_Persona; ?>" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a></td>
                      <td><a href="delete.php?id=<?php echo $dato -> ID_Persona; ?>" class="delete-button"><i class="fa-solid fa-trash-can"></i></a></td>
                    </tr>

                    <?php 
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- CRUD: Instructores -->
            <div class="card mb-50">
              <div class="card-header">Instructores</div>
              <div class="p-4">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Nombres</th>
                      <th scope="col">Apellidos</th>
                      <th scope="col">Rol</th>
                      <th scope="col">Correo</th>
                      <th scope="col">Teléfono</th>
                      <th scope="col" colspan="2"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      foreach($instructor as $dato){
                        
                    ?>

                    <tr>
                      <td scope="row"><?php echo $dato -> ID_Persona; ?></td>
                      <td><?php echo $dato -> nombres; ?></td>
                      <td><?php echo $dato -> apellidos; ?></td>
                      <td><?php echo $dato -> rol; ?></td>
                      <td><?php echo $dato -> correo_electronico; ?></td>
                      <td><?php echo $dato -> telefono; ?></td>
                      <td><a href="form-edit.php?id=<?php echo $dato -> ID_Persona; ?>" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a></td>
                      <td><a href="delete.php?id=<?php echo $dato -> ID_Persona; ?>" class="delete-button"><i class="fa-solid fa-trash-can"></i></a></td>
                    </tr>

                    <?php 
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- CRUD: Aprendices -->
            <div class="card mb-50">
              <div class="card-header">Aprendices</div>
              <div class="p-4">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Nombres</th>
                      <th scope="col">Apellidos</th>
                      <th scope="col">Rol</th>
                      <th scope="col">Correo</th>
                      <th scope="col">Teléfono</th>
                      <th scope="col" colspan="2"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      foreach($aprendiz as $dato){
                        
                    ?>

                    <tr>
                      <td scope="row"><?php echo $dato -> ID_Persona; ?></td>
                      <td><?php echo $dato -> nombres; ?></td>
                      <td><?php echo $dato -> apellidos; ?></td>
                      <td><?php echo $dato -> rol; ?></td>
                      <td><?php echo $dato -> correo_electronico; ?></td>
                      <td><?php echo $dato -> telefono; ?></td>
                      <td><a href="form-edit.php?id=<?php echo $dato -> ID_Persona; ?>"><i class="fa-solid fa-pen-to-square edit-button"></i></a></td>
                      <td><a href="delete.php?id=<?php echo $dato -> ID_Persona; ?>" class="delete-button"><i class="fa-solid fa-trash-can"></i></a></td>
                    </tr>

                    <?php 
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
          <!-- Create button -->
          <div class="col-md-1 btn-create">
            <a href="#header"><i class="fa-solid fa-plus create-button"></i></a>
          </div>
        </div>
      </div>
      
      
      <!-- Form modal to CREATE an user -->
      <div class="modal card hidden">
        <button class="close-modal">&times;</button>
        <div class="modal__header">
          <h2>Crear usuario</h2>
          <hr />
        </div>
        <form action="create.php" class="form" id="form" method="POST">
          <!-- ID -->
          <div class="form__field">
            <label for="id">Identificación</label>
            <input type="text" id="id" name="id" maxlength="10" placeholder="Número de identificación" class="register-input" />
          </div>

          <!-- FIRST NAME -->
          <div class="form__field">
            <label for="firstName">Nombres</label>
            <input type="text" id="firstName" name="firstName" placeholder="Nombres" onkeyup="upper(this);" maxlength="20" class="register-input" />
          </div>

          <!-- LAST NAME -->
          <div class="form__field">
            <label for="lastName">Apellidos</label>
            <input type="text" id="firstName" name="lastName" placeholder="Apellidos" onkeyup="upper(this);" maxlength="20" class="register-input" />
          </div>

          <!-- BIRTH YEAR -->
          <div class="form__field">
            <label for="birthYear">Fecha de nacimiento</label>
            <input type="date" id="birthYear" name="birthYear" value="2000-02-02" class="register-input" />
          </div>

          <!-- ROL -->
          <div class="rol">
            <div class="rol__title">Rol</div>
            <div class="rol__options">
              <div class="rol__option">
                <input type="radio" name="rol" id="administrador" value="ADMINISTRADOR" class="administrador" />
                <label for="administrador">Administrador</label>
              </div>
              <div class="rol-option">
                <input type="radio" name="rol" id="aprendiz" value="APRENDIZ" class="aprendiz" />
                <label for="aprendiz">Aprendiz</label>
              </div>
              <div class="rol-option">
                <input type="radio" name="rol" id="instructor" value="INSTRUCTOR" class="instructor" />
                <label for="instructor">Instructor</label>
              </div> 
            </div>
          </div>

          <!-- PHONE -->
          <div class="form__field">
            <label for="phone">Celular</label>
            <input type="text" name="phone" id="phone" maxlength="10" placeholder="Celular" class="register-input" />
          </div>

          <!-- MAIL -->
          <div class="form__field">
            <label for="email">Correo electrónico</label>
            <input type="text" name="email" id="email" placeholder="Correo electrónico" class="register-input" />
          </div>

          <!-- PASSWORD -->
          <div class="form__field">
            <label for="pass">Contraseña</label>
            <input type="text" name="pass" id="pass" placeholder="Contraseña" class="register-input" />
          </div>

          <!-- SUBMIT -->
          <div class="form__field submit__field">
            <input type="submit" name="recover-submited" value="Crear Usuario" class="submit-btn" />
          </div>
        </form>
      </div>
      
      <div class="overlay hidden"></div>
      
      <?php include '../components/footer.php' ?>
      <script src="../../Controllers/admin-control.js"></script>
    </body>
</html>