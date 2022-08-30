<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/643b0ccc65.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/instructor.css" />
    <title>Centro de revisión</title>
  </head>
  <body>
    <?php
      include_once "../../Models/connection.php";
      include_once "../../Models/session.php";
      $read_query = "SELECT *  FROM persona WHERE ID_Persona = '$session'";
      $query_result = mysqli_query($dbConnection, $read_query) or die(mysqli_error($dbConnection));
      $result_array = mysqli_fetch_all($query_result, MYSQLI_NUM);
    ?>
    <?php include './sidebar.php' ?>

    <div class="main-content__header">Welcome! Have a nice day.</div>
        <div class="main-content__info">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis molestiae porro quidem voluptatum pariatur quos accusamus eius
          doloremque, ab similique ratione ea! Harum nisi, eveniet ad impedit numquam dolores sapiente debitis odit perferendis exercitationem.
          Reprehenderit qui architecto, quasi provident tempora assumenda porro natus ipsam, quo rerum laborum fuga ab at aspernatur, quam ipsa enim.
          Suscipit adipisci corrupti veritatis rem aperiam ipsum, vero perferendis sunt placeat eveniet alias possimus similique debitis iste, quidem
          dolores necessitatibus ut, libero corporis voluptates atque qui voluptate maxime. Iure voluptas atque ab cupiditate similique, incidunt
          eveniet expedita corporis corrupti ut praesentium dolorem distinctio nihil. Sapiente nam at, dolores quae esse, sunt sit, veritatis
          provident suscipit tempore voluptatibus fugiat facere mollitia minima harum magni vitae eveniet modi cum enim? Beatae, eum minus. Expedita,
          odit quam optio repellat sapiente sint ratione, totam cupiditate, nulla ipsam est corporis at eius et hic. Cum, quisquam. Inventore saepe
          aliquam animi sequi earum distinctio. Iste eaque consequuntur dignissimos doloribus repudiandae deserunt quos veniam vel tempora. Corporis
          placeat eveniet autem, fugiat non veniam mollitia perspiciatis reiciendis nulla ducimus cumque hic voluptas soluta itaque debitis quo
          repellendus rerum quisquam ea! Exercitationem fugiat temporibus fuga, doloremque cum nemo et cupiditate impedit voluptates vero? Enim,
          nostrum!
        </div>
      </main>
    </div>
    <script src="../../Controllers/instructor-control.js"></script>
  </body>
</html>