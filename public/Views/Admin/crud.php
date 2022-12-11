<?php
  include_once "../../Models/connection.php";
  session_start();

  if (isset($_SESSION['id'])) {
    $read_admin = "SELECT num_documento, ID_Tipo_Documento, nombres, apellidos, correo_electronico, telefono, ID_Persona FROM persona WHERE ID_Rol = 1;";
    $read_admin_result = mysqli_query($dbConnection, $read_admin) or die(mysqli_error($dbConnection));
    $admin = mysqli_fetch_all($read_admin_result, MYSQLI_NUM);

    $read_instructor = "SELECT num_documento, ID_Tipo_Documento, nombres, apellidos, correo_electronico, telefono, ID_Persona FROM persona WHERE ID_Rol = 2;";
    $read_instructor_result = mysqli_query($dbConnection, $read_instructor) or die(mysqli_error($dbConnection));
    $instructor = mysqli_fetch_all($read_instructor_result, MYSQLI_NUM);

    $read_aprendiz = "SELECT num_documento, ID_Tipo_Documento, nombres, apellidos, correo_electronico, telefono, ID_Persona FROM persona WHERE ID_Rol = 3;";
    $read_aprendiz_result = mysqli_query($dbConnection, $read_aprendiz) or die(mysqli_error($dbConnection));
    $aprendiz = mysqli_fetch_all($read_aprendiz_result, MYSQLI_NUM);

    // GET DOCUMENT TYPES
    $type_doc = "SELECT tipo FROM tipo_documento";
    $type_doc_result = mysqli_query($dbConnection, $type_doc) or die(mysqli_error($dbConnection));
    $type_doc_array = mysqli_fetch_all($type_doc_result, MYSQLI_NUM);

    // GET ROLES
    $role = "SELECT tipo FROM rol";
    $role_result = mysqli_query($dbConnection, $role) or die(mysqli_error($dbConnection));
    $role_array = mysqli_fetch_all($role_result, MYSQLI_NUM);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/admin.css" />
    <title>CRUD Usuarios</title>
  </head>
  <body id="body">
    <?php include './sidebar.php' ?>
    
      <h1 class="main-content__header">👪 CRUD de Usuarios</h1>
    
      <?php
        $aux = 0;
        $num_crud = 0;

        function crudOption($role, $figure, $num, &$aux){
          echo '
          <div class="crud-option">
            <div class="crud-option__label">'.$role.'</div>
            '.$figure.'
            <div class="crud-option__num">'.$num.' Inscritos</div>
            <a href="#crud-'.$aux.'" class="crud-'.$aux.' crud-option__btn">Consultar</a>
          </div>';
          $aux++;
        }
        
        function generateCrud($arr, $role, &$num_crud){
          global $type_doc_array;
          echo '
          <div id="crud-'.$num_crud.'" class="crud card mb-50 hidden">
            <div class="card-header">'.$role.'</div>
            <div class="p-4">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">Documento</th>
                    <th scope="col">Tipo Documento</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col" colspan="3"></th>
                  </tr>
                </thead>
                <tbody>';
                  for($i = 0; $i < sizeof($arr); $i++){
                    echo '
                    <tr>
                      <td scope="row">'.$arr[$i][0].'</td>
                      <td scope="row">'.$type_doc_array[$arr[$i][1] - 1][0].'</td>
                      <td>'.$arr[$i][2].'</td>
                      <td>'.$arr[$i][3].'</td>
                      <td>'.$arr[$i][4].'</td>
                      <td>'.$arr[$i][5].'</td>
                      <td><a href="form-edit.php?id='.$arr[$i][6].'" class="edit-button"><i class="fa-solid fa-pen-to-square"></i></a></td>
                      <td><a href="delete.php?delete_user&id='.$arr[$i][6].'" class="delete-button"><i class="fa-solid fa-trash-can"></i></a></td>
                      <td><a href="view-user.php?user='.$arr[$i][6].'" class="see-button"><i class="fa-regular fa-eye"></i></a></td>
                    </tr>
                    ';
                  }
                  echo '
                </tbody>
              </table>
            </div>
          </div>
          ';
          $num_crud++;
        }
      ?>

      <div class="crud-choise">
        <?php 
          crudOption(
            'Administradores',
            '<svg class="crud-option__figure" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><g data-name="Business Man"><path d="M55.26 42.26 39 35l-5 7h-4l-5-7-16.3 7.37A8.012 8.012 0 0 0 4 49.66v12.59a.75.75 0 0 0 .75.75h54.5a.75.75 0 0 0 .75-.75V49.57a8.012 8.012 0 0 0-4.74-7.31z" style="fill:#494a59"/><path d="M39 28.14V36l-5 7h-4l-5-7v-7.86a10 10 0 0 0 14 0z" style="fill:#eac2b9"/><path d="M18 19.542V8a4 4 0 0 1 4-4 3 3 0 0 1 3-3h8.81a16.817 16.817 0 0 1 9.77 2.98c2.43 1.75 4.6 4.31 4.41 7.88-.125 2.3-.939 3.681-3.091 7.556z" style="fill:#494a59"/><path style="fill:#343544" d="M29 63h-6l-6-11 3-3-4-2-3.48-6.36 7.59-3.43 7.21 20.91L29 63z"/><path style="fill:#494a59" d="M36.68 58.12 35 63h-6l-1.68-4.88L29 49h6l1.68 9.12z"/><path style="fill:#343544" d="M37 43.8 35 49h-6l-2-5.2 3-1.8h4l3 1.8z"/><path style="fill:#d0dbf7" d="M43.9 37.19 39 45l-2-1.2-3-1.8 5-7 4.9 2.19zM30 42l-3 1.8-2 1.2-4.89-7.79L25 35l5 7z"/><path style="fill:#e6ecff" d="m29 49-1.68 9.12-7.21-20.91L25 45l2-1.2 2 5.2zM43.9 37.19l-7.22 20.93L35 49l2-5.2 2 1.2 4.9-7.81z"/><path d="M47 20v2a2 2 0 0 1-2 2h-4.2a10.048 10.048 0 0 0 .2-2v-4h4a2.006 2.006 0 0 1 2 2zM23.2 24H19a2 2 0 0 1-2-2v-2a2.006 2.006 0 0 1 2-2h4v4a10.048 10.048 0 0 0 .2 2z" style="fill:#eac2b9"/><path d="M42 15v7a10 10 0 0 1-10 10 10 10 0 0 1-10-10v-9s2.222.143 6-3c0 0 4 5 14 5z" style="fill:#ffddd4"/><path style="fill:#343544" d="m48 47-4 2 3 3-6 11h-6l1.68-4.88 7.22-20.93 7.61 3.4L48 47zM53.75 52v11h-1.5V52a.75.75 0 0 1 1.5 0z"/><path d="m20.11 37.21-.01-.02M20.11 37.21l-.01-.02"/><path d="M11.75 52v11h-1.5V52a.75.75 0 0 1 1.5 0z" style="fill:#343544"/></g></svg>',
            sizeof($admin),
            $aux
          );
          crudOption(
            'Instructores',
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><g data-name="Business Man"><path d="M45 8v9.27a2 2 0 0 0-1-.27h-3v-4s-2 0-5.4-3c0 0-3.6 4-12.6 4v3h-3a2 2 0 0 0-1 .27V8a7 7 0 0 1 7-7h12a3 3 0 0 1 3 3 4 4 0 0 1 4 4z" style="fill:#494a59"/><path d="M38 26.7V34l-4 5h-4l-4-5v-7.3a8.976 8.976 0 0 0 12 0z" style="fill:#eac2b9"/><path d="M58 47.17v15.08a.755.755 0 0 1-.75.75H6.75a.755.755 0 0 1-.75-.75V47.17a7.992 7.992 0 0 1 4.72-7.29C21.846 34.869 18.429 36.407 26 33l4 5h4l4-5c7.4 3.329 4.11 1.849 15.28 6.88A7.992 7.992 0 0 1 58 47.17z" style="fill:#b28362"/><path d="M53.28 39.88 44 35.7v.08a17.992 17.992 0 0 1-12 16.97 66.3 66.3 0 0 1-6.69 1.7A3 3 0 0 0 23 57.37V63h34.25a.75.75 0 0 0 .75-.75V47.17a7.992 7.992 0 0 0-4.72-7.29z" style="fill:#dbaa89"/><path d="M37.64 41.64 34 38h-4l-3.64 3.64L29 46l-.86 4.84A18.027 18.027 0 0 0 32 52.75a18.027 18.027 0 0 0 3.86-1.91L35 46z" style="fill:#343544"/><path d="M35.86 50.84A18.027 18.027 0 0 1 32 52.75a18.027 18.027 0 0 1-3.86-1.91L29 46h6z" style="fill:#494a59"/><path style="fill:#d0dbf7" d="m30 38-5 5-5-7.3 6-2.7 4 5z"/><path d="m29 46-.86 4.84A18 18 0 0 1 20 35.78v-.08l5 7.3 1.36-1.36z" style="fill:#e6ecff"/><path style="fill:#d0dbf7" d="M44 35.7 39 43l-5-5 4-5 6 2.7z"/><path d="M44 35.7v.08a18 18 0 0 1-8.14 15.06L35 46l2.64-4.36L39 43z" style="fill:#e6ecff"/><path d="M49.75 51v12h-1.5V51a.75.75 0 0 1 1.5 0z" style="fill:#b28362"/><path d="M15.75 51v12h-1.5V51a.75.75 0 0 1 1.5 0z" style="fill:#896146"/><path d="M45 16.27a2 2 0 0 0-1-.27h-4l-.23 7H44a2.006 2.006 0 0 0 2-2v-3a2 2 0 0 0-1-1.73zM24 16h-4a2 2 0 0 0-2 2v3a2.006 2.006 0 0 0 2 2h4.23z" style="fill:#eac2b9"/><circle cx="27" cy="59" r="1" style="fill:#b28362"/><path d="M41 12v9a9 9 0 0 1-18 0v-8c9 0 12.6-4 12.6-4 3.4 3 5.4 3 5.4 3z" style="fill:#ffddd4"/></g></svg>',
            sizeof($instructor),
            $aux
          );
          crudOption(
            'Aprendices',
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><g data-name="Wisuda Man"><path d="M41 23h2a2 2 0 0 1 1 .27v-9.06L32 18l-12-3.79v9.06a2 2 0 0 1 1-.27h20z" style="fill:#343544"/><path d="M45 24v2a2.006 2.006 0 0 1-2 2h-3.22a9.356 9.356 0 0 0 .22-2v-4h3a2.006 2.006 0 0 1 2 2zM24.22 28H21a2.006 2.006 0 0 1-2-2v-2a2.006 2.006 0 0 1 2-2h3v4a9.356 9.356 0 0 0 .22 2zM38 31.71V39l-6 5-6-5v-7.3a8.991 8.991 0 0 0 12 .01z" style="fill:#eac2b9"/><path d="M52.1 44.35C40.775 39.247 43.793 40.606 38 38l-6 5-6-5c-5.775 2.6-2.823 1.268-14.1 6.35A9.992 9.992 0 0 0 6 53.47v8.78a.75.75 0 0 0 .75.75h50.5a.75.75 0 0 0 .75-.75v-8.78a9.992 9.992 0 0 0-5.9-9.12z" style="fill:#494a59"/><path d="M51.16 43.93C47.89 49.86 40.53 54 32 54s-15.89-4.14-19.16-10.07C23.13 39.288 20.231 40.6 26 38l6 5 6-5c5.8 2.608 2.884 1.3 13.16 5.93z" style="fill:#ffb64d"/><path d="M47.53 42.29C44.88 46.83 38.93 50 32 50s-12.88-3.17-15.53-7.71c6.07-2.735 3.9-1.757 9.53-4.29l6 5 6-5c5.631 2.533 3.46 1.555 9.53 4.29z" style="fill:#ea972a"/><path d="M25 16.789v1.093a1.808 1.808 0 0 1-1 1.618 1.808 1.808 0 0 0-1 1.618V26a9 9 0 0 0 9 9 9 9 0 0 0 9-9v-4.882a1.808 1.808 0 0 0-1-1.618 1.808 1.808 0 0 1-1-1.618v-1.093z" style="fill:#ffddd4"/><path style="fill:#e6ecff" d="M42.58 40.06 37 46l-5-3 6-5 4.58 2.06zM32 43l-5 3-5.58-5.94L26 38l6 5z"/><path d="M44 8.21v7L32 19l-12-3.79v-7L32 12c11.158-3.523 8.765-2.768 12-3.79zM51 7v10a.75.75 0 0 1-1.5 0V7.47z" style="fill:#494a59"/><path d="M48.75 55v8h-1.5v-8a.75.75 0 0 1 1.5 0zM16.75 55v8h-1.5v-8a.75.75 0 0 1 1.5 0zM13 7l19 6 19-6-19-6-19 6z" style="fill:#343544"/></g></svg>',
            sizeof($aprendiz),
            $aux
          );
        ?>
        
        <!-- CREATE BUTTON -->
        <a href="#body" class="crud-option create-button open-modal-btn">
          <div class="crud-option__label">Crear Usuario</div>
          <i class="fa-solid fa-plus"></i>
        </a>
      </div>


      <!-- CRUD -->
      <div class="crud-modal">
        <div class="row">
          <div class="col-md-12">
            <?php generateCrud($admin, 'Administradores', $num_crud) ?>
            <?php generateCrud($instructor, 'Instructores', $num_crud) ?>
            <?php generateCrud($aprendiz, 'Aprendices', $num_crud) ?>
          </div>
        </div>
      </div>
      
      <!-- Form modal to CREATE an user -->
      <div class="modal-form hidden modal card">
        <button class="close-modal close-button">&times;</button>
        <div class="modal__header">
          <h2>Crear usuario</h2>
          <hr />
        </div>
        <form action="create.php" class="form" id="form" method="POST">
          <!-- DOCUMENT TYPE -->
          <div class="doc-type form__field">
            <label for="doc-type">Tipo de documento</label>
            <select name="doc-type" id="doc-type" class="upload-form__field-input">
              <option value="">Seleccione el tipo</option>
              <?php 
                for($i = 1; $i <= sizeof($type_doc_array); $i++){
                ?>
                  <option value="<?php echo $i ?>"><?php echo $type_doc_array[$i - 1][0]; ?></option>
                <?php
                }
              ?>
            </select>
          </div>

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

          <!-- PHONE -->
          <div class="form__field">
            <label for="phone">Celular</label>
            <input type="text" name="phone" id="phone" maxlength="10" placeholder="Celular" class="register-input" />
          </div>

          <!-- ROL -->
          <div class="rol">
            <div class="rol__title">Rol</div>
            <div class="rol__options">
              <?php 
                for($i = 1; $i <= sizeof($role_array); $i++){
                  ?>
                  <div class="rol__option">
                    <input type="radio" name="rol" id="rol-<?php echo $i?>" value="<?php echo $i?>"/>
                    <label for="rol-<?php echo $i?>"><?php print_r($role_array[$i - 1][0]) ?></label>
                  </div>
                  <?php 
                }
              ?>
            </div>
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
          <div class="form__field submit__field" style="grid-column: 1 span;">
            <input type="submit" name="recover-submited" value="Crear Usuario" class="submit-btn" />
          </div>
        </form>
      </div>
      <div class="overlay hidden"></div>
    </main>
    <script src="../../Controllers/confirm-deletion.js"></script>
    <script>confirmDeletion('¿Seguro que quieres eliminar este usuario?')</script>
    <?php
      if(isset($_GET['message'])){
        if($_GET['message'] === 'empty') {
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: '¡No puedes enviar datos vacíos!'});</script><?php
        } else if($_GET['message'] === 'already-registered'){
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: 'Un usuario con estos datos ya se encuentra registrado.'});</script><?php
        } else if($_GET['message'] === 'created'){
          ?><script>Swal.fire({icon: 'success',title: '¡Usuario creado!',text: '¡Gracias por alimentar la base de datos!'});</script><?php
        } else if($_GET['message'] === 'modified'){
          ?><script>Swal.fire({icon: 'success',title: 'El usuario ha sido modificado',});</script><?php
        } else if($_GET['message'] === 'deleted'){
          ?><script>Swal.fire({icon: 'success',title: 'El usuario ha sido eliminado'});</script><?php
        } else if($_GET['message'] === 'error'){
          ?><script>Swal.fire({icon: 'error',title: 'Error',text: 'El usuario no fue encontrado'});</script><?php
        }
      }
    ?>
    <script src="../../Controllers/modal-form.js"></script>
    <script src="../../Controllers/show-crud.js"></script>
  </body>
  </html>
  <?php 
  } else {
    include('../../Models/logout.php');
    $location = header('Location: ../index.php');
  }
?>