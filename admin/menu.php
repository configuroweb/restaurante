<?php
	include("../functions.php");
	include("addmenu.php");
	include("additem.php");
	include("deletemenu.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Menu - ConfiguroWeb Admin</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="index.php">Restaurante | ConfiguroWeb</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!------------------ Sidebar ------------------->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Panel de Control</span>
          </a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link" href="menu.php">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Menú</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sales.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Ventas</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="staff.php">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Empleados</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-power-off"></i>
            <span>Cerrar Sesión</span>
          </a>
        </li>

      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.php">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">Menú</li>
          </ol>

          <!-- Page Content -->
          <h1>Administración del Menú</h1>
          <hr>
          <p>Acá puedes Administrar los menús de tu restaurante, puedes Agregar, Modificar o Eliminar listas de Menús.</p>

          <div class="card mb-3 border-primary">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Lista de Menús
              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addMenuModal">Agregar Categoría</button>

          </div>
            <div class="card-body">

            	<?php 
					$menuQuery = "SELECT * FROM tbl_menu";

					if ($menuResult = $sqlconnection->query($menuQuery)) {

						if ($menuResult->num_rows == 0) {
							echo "<center><label>Sin menús agregados por el momento.</label></center>";
						}

						while($menuRow = $menuResult->fetch_array(MYSQLI_ASSOC)) {?>

							<div class="card mb-3 border-primary">
					            <div class="card-header">

					              <i class="fas fa-chart-area"></i>
					              <?php echo $menuRow["menuName"]; ?>
  					              <button class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#deleteModal" data-category="<?php echo $menuRow["menuName"];?>" data-menuid="<?php echo $menuRow["menuID"];?>">Eliminar</button>

  					              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addItemModal" data-category="<?php echo $menuRow["menuName"];?>" data-menuid="<?php echo $menuRow["menuID"];?>">Agregar</button>

					          	</div>
					            <div class="card-body">

                			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<tr>
									<td>#</td>
									<td>Nombre de Item</td>
									<td>Precio (COP)</td>
									<td>Opciones</td>
								</tr>
							<?php
								$menuItemQuery = "SELECT * FROM tbl_menuitem WHERE menuID = " . $menuRow["menuID"];

								//No item in menu
								if ($menuItemResult = $sqlconnection->query($menuItemQuery)) {

									if ($menuItemResult->num_rows == 0) {
											echo "<td colspan='4' class='text-center'>Sin productos agregados en este Menú.</td>";
										}

									$itemno = 1;
									//Fetch and display all item based on their category 
									while($menuItemRow = $menuItemResult->fetch_array(MYSQLI_ASSOC)) {	?>

										<tr>
											<td><?php echo $itemno++; ?></td>
			        						<td><?php echo $menuItemRow["menuItemName"] ?></td>
			        						<td><?php echo $menuItemRow["price"] ?></td>
			        						<td>
			        							<a href="#editItemModal" data-toggle="modal" data-itemname="<?php echo $menuItemRow["menuItemName"] ?>" data-itemprice="<?php echo $menuItemRow["price"] ?>" data-menuid="<?php echo $menuRow["menuID"] ?>" data-itemid="<?php echo $menuItemRow["itemID"] ?>">Editar </a>
			        							<a href="deleteitem.php?itemID=<?php echo $menuItemRow["itemID"] ?>&menuID=<?php echo $menuRow["menuID"] ?>"> Eliminar</a></td>
										</tr>

									<?php
									}
								}

								else {
									die("Algo malo paso");
								}
							?>
							</table>
							</div>
					    </div>

						<?php
						}
					}

					else {
						die("Algo malo paso");
					}
				 ?>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Sistema de Restaurante ConfiguroWeb 2020</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">0 to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="logout.php">Cerrar Sesión</a>
          </div>
        </div>
      </div>
    </div>

	<!-- Add Menu Modal -->
	<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="addMenuModalLabel">Agregar Categoría</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="addmenuform" method="POST">
	        	<div class="form-group">
		            <label class="col-form-label">Categoría:</label>
		            <input type="text" required="required" class="form-control" name="menuname" placeholder="Puedes poner algo como postres, bebidas, etc...." >
		        </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="addmenuform" class="btn btn-success" name="addmenu">Agregar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Add Item Modal -->
	<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="addItemModalLabel">Agregar Menú</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="additemform" method="POST">
	        	<div class="form-group">
		            <label class="col-form-label">Nombre:</label>
		            <input type="text" required="required" class="form-control" name="itemName" placeholder="Puedes poner algo como Sopa, Pepsi o algo así" >
		        </div>
		        <div class="form-group">
		            <label class="col-form-label">Precio (COP):</label>
		            <input type="text" required="required" class="form-control" name="itemPrice"  >
		            <input type="hidden" name="menuID" id="menuid">
		        </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="additemform" class="btn btn-success" name="addItem">Agregar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Edit Item Modal -->
	<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="addItemModalLabel">Editar Menú</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="edititemform" action="edititem.php" method="POST">
	        	<div class="form-group">
		            <label class="col-form-label">Nombre:</label>
		            <input type="text" required="required" id="itemname" class="form-control" name="itemName" placeholder="Sopa,Pepsi,etc" >
		        </div>
		        <div class="form-group">
		            <label class="col-form-label">Precio (COP):</label>
		            <input type="text" required="required" id="itemprice" class="form-control" name="itemPrice" placeholder="" >
		            <input type="hidden" name="menuID" id="menuid">
		            <input type="hidden" name="itemID" id="itemid">
		        </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="edititemform" class="btn btn-primary" name="btnedit">Editar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Estás seguro de eliminar este menú?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Seleccione "Eliminar" a continuación se eliminará <strong>todos</strong> su artículo o menú en esta categoría.</div>
          <div class="modal-footer">
          	<form id="deletemenuform" method="POST">
          		<input type="hidden" name="menuID" id="menuid">
          	</form>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
	        <button type="submit" form="deletemenuform" class="btn btn-danger" name="deletemenu">Eliminar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <script>
    	//passing menuId to modal
    	$('#addItemModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget); // Button that triggered the modal
			  var id = button.data('menuid'); // Extract info from data-* attributes
			  var category = button.data('category');

			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			  var modal = $(this);
			  modal.find('.modal-title').text('Agregar Nuevo Menú -- ' + category );
			  modal.find('.modal-body #menuid').val(id);
		});

		$('#editItemModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget); // Button that triggered the modal

			  var menuid = button.data('menuid'); // Extract info from data-* attributes
			  var itemid = button.data('itemid');
			  var itemname = button.data('itemname');
			  var itemprice = button.data('itemprice');

			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			  var modal = $(this);
			  modal.find('.modal-body #menuid').val(menuid);
			  modal.find('.modal-body #itemid').val(itemid);
			  modal.find('.modal-body #itemname').val(itemname);
			  modal.find('.modal-body #itemprice').val(itemprice);
		});


		$('#deleteModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget); // Button that triggered the modal
			  var id = button.data('menuid'); // Extract info from data-* attributes
			  var category = button.data('category');

			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			  var modal = $(this);
			  modal.find('.modal-body').html('Selecciona "Eliminar" y a continuación se borrará esta lista completa');
			  modal.find('.modal-footer #menuid').val(id);
		});
    </script>

    <script type="text/javascript">
	    window.setTimeout(function() {
	        $(".alert").fadeTo(500, 0).slideUp(500, function() {
	            $(this).hide();
	        });
	    }, 1000);
	</script> 

  </body>

</html>