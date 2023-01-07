<!-- PHP Connection-->
<?php
    ob_start();

    // Create connection
    $sname= "localhost";
    $unmae= "root";
    $password = "";

    $db_name = "porto";

    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    // Check connection
    if (!$conn) {
        die ("Connection failed!");
    }
?>
<!-- End PHP Connection-->

<!-- PHP Function -->
<?php
    $date           = "";
    //$no_lpb       = "";
    //$part_number  = "";
    $part_name      = "";
    //$supplier     = "";
    //$category     = "";
    $problem        = "";
    $note           = "";
    $location       = "";
    $qty            = "";
    $date_to_whs    = "";
    $from           = "";
    $to             = "";
    $supfil         = "";
    $data           = "";
    $error          = "";
    $succeed        = "";

    
    if (isset($_GET['op'])) {
        $op = $_GET['op'];
    } else {
        $op = "";
    }
    
    // DELETE FUNCTION
    if($op == 'delete'){
        $id         = $_GET['id'];
        $sql1       = "DELETE FROM raw_data_reject where id = '$id'";
        $q1         = mysqli_query($conn,$sql1);
        if($q1){
            $succeed = "Delete Success";
        }else{
            $error  = "Delete error";
        }
    }                                       

    // EDIT FUNCTION
    if ($op == 'edit') {
        $id             = $_GET['id'];
        $sql1           = "SELECT * FROM raw_data_reject where id = '$id'";
        $q1             = mysqli_query($conn, $sql1);
        $r1             = mysqli_fetch_array($q1);
        $date           = $r1['date'];
        $no_lpb         = $r1['no_lpb'];
        $part_number    = $r1['part_number'];
        $part_name      = $r1['part_name'];
        $supplier       = $r1['supplier'];
        $category       = $r1['category'];
        $problem        = $r1['problem'];
        $note           = $r1['note'];
        $location       = $r1['location'];
        $qty            = $r1['qty'];
        $date_to_whs    = $r1['date_to_whs'];

        if ($id == '') {
            $error = "Data tidak ditemukan";
        }
    }


    // SUBMIT FUNCTION
    if (isset($_POST['submit'])) {
        $date           = $_POST['date'];
        //$no_lpb       = $_POST['no_lpb'];
        //$part_number  = $_POST['part_number'];
        $part_name      = $_POST['part_name'];
        //$supplier     = $_POST['supplier'];
        //$category     = $_POST['category'];
        $problem        = $_POST['problem'];
        $note           = $_POST['note'];
        $location       = $_POST['location'];
        $qty            = $_POST['qty'];
        $date_to_whs    = $_POST['date_to_whs'];

        if ($date && $part_name && $problem && $location && $qty && $date_to_whs) {
            //Update Data
            if ($op == 'edit') { 
                $sql1       = "UPDATE raw_data_reject SET date='$date', part_name='$part_name', problem = '$problem', note='$note', location='$location', qty='$qty', date_to_whs='$date_to_whs' where id = '$id'";
                $q1         = mysqli_query($conn, $sql1);

                $sql4           = "SELECT * FROM master_part where part_name = '$part_name'";
                $q4             = mysqli_query($conn, $sql4);
                $r4             = mysqli_fetch_array($q4);
                $part_number    = $r4['part_number'];
                $supplier       = $r4['supplier_code'];

                $sql5       = "UPDATE raw_data_reject SET part_number='$part_number', supplier ='$supplier' where part_name = '$part_name'";
                $q5         = mysqli_query($conn, $sql5);

                $sql8           = "SELECT * FROM master_problem where problem = '$problem'";
                $q8             = mysqli_query($conn, $sql8);
                $r8             = mysqli_fetch_array($q8);
                $category       = $r8['category'];

                $sql9       = "UPDATE raw_data_reject SET category='$category' where part_name = '$part_name'";
                $q9         = mysqli_query($conn, $sql9);

                if ($q1) {
                    $succeed = "Update success";
                    header("refresh:4;url=qc-reject-material.php");
                } else {
                    $error  = "Update error";
                }
            }
            //Insert Data
            else { 
                $sql1   = "INSERT INTO raw_data_reject values
                            ('', '$date', '', '', '$part_name', '', '', '$problem', '$note',
                            '$location', '$qty', '$date_to_whs')";
                $q1     = mysqli_query($conn, $sql1);

                $sql4           = "SELECT * FROM master_part where part_name = '$part_name'";
                $q4             = mysqli_query($conn, $sql4);
                $r4             = mysqli_fetch_array($q4);
                $part_number    = $r4['part_number'];
                $supplier       = $r4['supplier_code'];

                $sql5       = "UPDATE raw_data_reject SET part_number='$part_number', supplier ='$supplier' where part_name = '$part_name'";
                $q5         = mysqli_query($conn, $sql5);

                $sql8           = "SELECT * FROM master_problem where problem = '$problem'";
                $q8             = mysqli_query($conn, $sql8);
                $r8             = mysqli_fetch_array($q8);
                $category       = $r8['category'];

                $sql9       = "UPDATE raw_data_reject SET category='$category' where part_name = '$part_name'";
                $q9         = mysqli_query($conn, $sql9);

                if ($q1) {
                    $succeed      = "Submission success";
                    
                    $date           = "";
                    //$no_lpb       = "";
                    //$part_number  = "";
                    $part_name      = "";
                    //$supplier     = "";
                    //$category     = "";
                    $problem        = "";
                    $note           = "";
                    $location       = "";
                    $qty            = "";
                    $date_to_whs    = "";
                } else {
                    $error      = "Submission error";
                }
            }
        } else {
            $error = "Please fill all the data";
            
        }
    }
?>
<!-- End PHP Function -->

<!DOCTYPE html>
<html lang="en">

<!-- Head Section-->
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Home</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  
  <!-- Datepicker -->
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/css/datepicker.min.css'>  

  <!-- Table -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">  
  
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>
<!-- End Head Section-->

<!-- Body Section-->
<body class="bg-light bg-light" >
    <!-- Header Section-->
	<section>

        <!-- Topbar -->
        <header>
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container-xxl">

                    <!-- Sidebar Toggler-->
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#sidebar"
                        aria-controls="sidebar"
                        aria-expanded="true"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- End Sidebar Toggler-->

                    <!-- Topbar Title-->
                    <a class="navbar-brand me-auto ms-lg-3 ms-2 text-uppercase fw-bold"
                        href="#">
                        SWI
                    </a>
                    <!-- End Topbar Title-->
                
                    <!-- Topbar Toggler-->
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#topbar"
                        aria-controls="topbar"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- End Topbar Toggler-->

                    <!-- Topbar Content -->
                    <div class="collapse navbar-collapse" id="topbar">
                        <ul class="navbar-nav d-flex ms-auto"> 
                            <!-- Topbar Item -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle"
                                href="#" id="navbarDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="bi bi-person-fill"></span>Profile
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2"></i>Setting</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="index.html"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a></li>
                                </ul>
                            </li>
                            <!-- End Topbar Item -->
                        </ul>
                    </div>
                    <!-- End Topbar Content -->
                </div>
            </nav>
        </header>
        <!-- End Topbar -->

    </section>
    <!-- End Header Section-->
    
    <!-- Main -->
    <section class="container-xxl">
		<div class="row flex-nowrap">
			<div class="col-auto px-0 max-vh-100">
				<!-- Sidebar Section-->
				<div id="sidebar" class="navbar-nav navbar-expand-md bg-light">
					<div id="sidebar" class="collapse navbar-collapse collapse-horizontal min-vh-100 border-end border-0 rounded-0">
						
						<!-- Sidebar Content -->                        
						<ul class="px-2 pt-2 min-vh-100">
							<li class="px-2 pt-2">
								<div class="accordion" id="accordionExample">

									<!-- Sidebar Item -->  
									<div class="px-2 pt-2">
										<a href="#" class="btn btn-nav w-100 text-start rounded text-black" role="button"> <span class="bi bi-house me-2"></span>Home</a>
									</div>
									<!-- End Sidebar Item -->  

									<!-- Sidebar Item -->  
									<div class="px-2 pt-2">
										<a href="#"
										class="btn btn-nav collapsed w-100 text-start rounded text-black active"
										data-bs-toggle="collapse"
										data-bs-target="#QC"
										role="button"
										aria-expanded="false"
										aria-controls="QC">
										<span class="bi bi-shield-check me-2"></span>
										Quality Control</a>
										  
										<div id="QC" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
											<ul>
												<li class="dropdown-item">
													<a href="#" role="button" class="btn btn-nav-item w-100 text-start rounded text-black btn-sm">Dashboard</a>
												</li>
												<li class="dropdown-item">
													<a href="qc-reject-material.php" role="button" class="btn btn-nav-item w-100 text-start rounded text-black btn-sm active">Reject Material</a>
												</li>
												<li class="dropdown-item">
													<a href="#" role="button" class="btn btn-nav-item w-100 text-start rounded text-black btn-sm">Reject Rate</a>
												</li>
                                                <li class="dropdown-item">
													<a href="qc-master-part.php" role="button" class="btn btn-nav-item w-100 text-start rounded text-black btn-sm">Master Part</a>
												</li>
                                                <li class="dropdown-item">
													<a href="qc-master-problem.php" role="button" class="btn btn-nav-item w-100 text-start rounded text-black btn-sm">Master Problem</a>
												</li>
                                                <li class="dropdown-item">
													<a href="qc-master-location.php" role="button" class="btn btn-nav-item w-100 text-start rounded text-black btn-sm">Master Location</a>
												</li>
											</ul>
										 </div>
									</div>
									<!-- End Sidebar Item -->   					
								
									<!-- Divider -->
									<div class="px-2 pt-2">
									<hr>
									</div>
									<!-- End Divider -->
									
									<!-- Sidebar Item -->
									<li class="list-group-item px-2 pt-2">
										<a href="users.php" class="btn btn-nav w-100 text-start rounded text-black" role="button"> Users</a>
									</li>	
									<!-- End Sidebar Item -->
								</div>
							</li>						
						</ul>
						<!-- End Sidebar Content -->

					</div>
				</div>
				<!-- End Sidebar Section -->


                <!-- Main Section-->
                <div class="col ps-md-3 max-vh-100" data-aos="fade" data-aos-delay="100">
                    <!-- Header-->  
                    <div class="page-header pt-3">
                        <h2>Reject Material</h2>
                    </div>
                    <hr class="mb-3">
                    <!-- End Header-->
                    
                    <!-- Main Content --> 
                    <div class="row justify-content-md-center">

                        <!-- Card Input -->
                        <div class="col-lg-9 col-md-12 mb-3">
                            <div class="container shadow px-3 pt-3 pb-3">

                                <!-- Card Header
                                <div class="card-header">
                                    Create / Edit Data
                                </div>
                                End Card Header -->

                                <!-- Card Body -->
                                <div class="card-body">

                                    <?php
                                    if ($error) {
                                    ?>

                                        <div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                            <?php echo $error ?>
                                        </div>

                                    <?php
                                        //echo "<meta http-equiv=\"refresh\" content=\"0;URL=qc-reject-material.php\">";
                                        //"<script> document.location.href ='qc-reject-material.php'</script>";
                                        //header("refresh:2;url=qc-reject-material.php");
                                        //5 : detik
                                    }
                                    ?>

                                    <?php
                                    if ($succeed) {
                                    ?>

                                        <div class="alert alert-success  d-flex align-items-center mb-0" role="alert">
                                            <?php echo $succeed ?>
                                        </div>

                                    <?php
                                        //header("refresh:3;url=qc-reject-material.php");
                                    }
                                    ?>

                                    <!-- Input Form -->
                                    <form action="" method="POST">
                                        <div class="row">

                                            <!-- Input Group -->
                                            <div class="col-md-6">

                                                <!-- Input Item -->
                                                <div class="mb-1 row">
                                                    <label for="date" class="col-sm-12 col-form-label">Date</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm datepicker_input" id="date" name="date" value="<?php echo $date ?>">
                                                    </div>
                                                </div>
                                                <!-- End Input Item -->
                                                
                                                <!-- Input Item -->
                                                <div class="mb-1 row">
                                                    <label for="part_name" class="col-sm-12 col-form-label">Part Name</label>
                                                    <div class="col-sm-12">
                                                        <input id="part_name" name="part_name"
                                                                type="text" class="form-control form-control-sm" 
                                                                value="<?php echo $part_name ?>">
                                                        
                                                        <?php
                                                        $sql3 = "SELECT part_name FROM master_part ORDER BY part_name ASC";
                                                        $q3 = $conn->query($sql3);
                                                        
                                                        $data1 = array();
                                                        
                                                        foreach($q3 as $row)
                                                        {
                                                            $data1[] = array(
                                                                'label'     =>  $row['part_name'],
                                                                'value'     =>  $row['part_name']
                                                            );
                                                        }
                                                        ?>    

                                                    </div>
                                                </div>
                                                <!-- End Input Item -->

                                                <!-- Input Item -->
                                                <div class="mb-1 row">
                                                    <label for="problem" class="col-sm-12 col-form-label">Problem</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm" id="problem" name="problem" value="<?php echo $problem ?>">
                                                        
                                                        <?php
                                                        $sql6 = "SELECT problem FROM master_problem ORDER BY problem ASC";
                                                        $q6 = $conn->query($sql6);
                                                        
                                                        $data2 = array();
                                                        
                                                        foreach($q6 as $row)
                                                        {
                                                            $data2[] = array(
                                                                'label'     =>  $row['problem'],
                                                                'value'     =>  $row['problem']
                                                            );
                                                        }
                                                        ?>                                                     
                                                    
                                                    </div>
                                                </div>
                                                <!-- End Input Item -->

                                                <!-- Input Item -->
                                                <div class="mb-1 row">
                                                    <label for="note" class="col-sm-12 col-form-label">Note</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm" id="note" name="note" value="<?php echo $note ?>">
                                                    </div>
                                                </div>
                                                <!-- End Input Item -->

                                            </div>
                                            <!-- End Input Group -->

                                            <!-- Input Group -->
                                            <div class="col-md-6">

                                                <!-- Input Item -->
                                                <div class="mb-1 row">
                                                    <label for="location" class="col-sm-12  col-form-label">Location</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm" id="location" name="location" value="<?php echo $location ?>">

                                                        <?php
                                                        $sql7 = "SELECT location FROM master_location ORDER BY location ASC";
                                                        $q7 = $conn->query($sql7);
                                                        
                                                        $data3 = array();
                                                        
                                                        foreach($q7 as $row)
                                                        {
                                                            $data3[] = array(
                                                                'label'     =>  $row['location'],
                                                                'value'     =>  $row['location']
                                                            );
                                                        }
                                                        ?> 

                                                    </div>
                                                </div>
                                                <!-- End Input Item -->
                                                
                                                <!-- Input Item -->
                                                <div class="mb-1 row">
                                                    <label for="qty" class="col-sm-12  col-form-label">Quantity</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm" id="qty" name="qty" value="<?php echo $qty ?>">
                                                    </div>
                                                </div>
                                                <!-- End Input Item -->

                                                <!-- Input Item -->
                                                <div class="mb-4 row">
                                                    <label for="date_to_whs" class="col-sm-12 col-form-label">Date to WHS</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm datepicker_input" id="date_to_whs" name="date_to_whs" value="<?php echo $date_to_whs ?>">
                                                    </div>
                                                </div>
                                                <!-- End Input Item -->


                                            </div>
                                            <!-- End Input Group -->

                                            <!-- Submit Button -->
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <input type="submit" id="submit" name="submit" value="Submit" class="btn btn-submit col-md-3 col-lg-2" />
                                            </div>
                                            <!-- End Submit Button -->
                                        </div>

                                    </form>
                                    <!-- End Input Form -->

                                </div>
                                <!-- End Card Body -->

                            </div>
                        </div>
                        <!-- End Card Input -->


                        <!-- Table -->
                        <div class="col-lg-12 col-md-12">
                            <div class="container shadow px-4 py-4">

                                <!-- Input Form -->
                                <form id="form" action="" method="POST" class="mb-3">
                                    <div class="row">
                                        <!-- Input Group -->
                                        <div class="col-md-3 col-lg-2">        
                                            <!-- Input Item -->
                                            <div class="mb-1 row">
                                                <label for="part_name" class="col-sm-12 col-form-label">From</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm datepicker_input" id="from" name="from" value="<?php echo $from ?>">
                                                    </div>
                                            </div>
                                            <!-- End Input Item -->
                                        </div>
                                        <!-- End Input Group -->

                                        <!-- Input Group -->
                                        <div class="col-md-3 col-lg-2">        
                                            <!-- Input Item -->
                                            <div class="mb-1 row">
                                                <label for="part_name" class="col-sm-12 col-form-label">To</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm datepicker_input" id="to" name="to" value="<?php echo $to ?>">
                                                    </div>
                                            </div>
                                            <!-- End Input Item -->
                                        </div>
                                        <!-- End Input Group -->

                                        <!-- Input Group -->
                                        <div class="col-md-2 col-lg-2">        
                                            <!-- Input Item -->
                                            <div class="mb-1 row">
                                                <label for="part_name" class="col-sm-12 col-form-label">Supplier</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-sm" id="supfil" name="supfil" value="<?php echo $supfil ?>">
                                                    </div>
                                            </div>
                                            <!-- End Input Item -->
                                        </div>
                                        <!-- End Input Group -->

                                        <!-- Filter Button -->
                                        <div class="col-md-2 col-lg-2 col-xl-1 d-flex align-items-end">        
                                            <input type="submit" id="filter" name="filter" value="Filter" class=" mb-1 btn btn-sm btn-primary col-3 col-md-12 col-lg-12" />
                                        </div>
                                        <!-- Filter Button -->

                                        <!-- Clear Button -->
                                        <div class="col-md-2 col-lg-2 col-xl-1 d-flex flex-row align-items-end">        
                                            <input type="submit" id="filter" name="clear" value="Clear" class=" mb-1 btn btn-sm btn-danger col-3 col-md-12 col-lg-12" />
                                        </div>
                                        <!-- Clear Button -->                                     

           
                                    </div>
                                </form>
                                <!-- End Input Form -->

                                <!-- Table Content -->
                                <div class="table-responsive-lg">                                
                                    <table id="reject_table" class="table table-sm display nowrap table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">No LPB</th>
                                                <th scope="col">Part Number</th>
                                                <th scope="col">Part Name</th>
                                                <th scope="col">Supplier</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Problem</th>
                                                <th scope="col">Note</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">QTY</th>
                                                <th scope="col">Date to WHS</th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $sql2   = "SELECT * FROM raw_data_reject ORDER BY id DESC";

                                            if (isset($_POST['filter'])) {
                                                $from           = $_POST['from'];
                                                $to             = $_POST['to'];
                                                $supfil         = $_POST['supfil'];

                                                if (empty($from && $to)){
                                                    $sql2   = "SELECT * FROM raw_data_reject where supplier = '".$supfil."' ORDER BY date ASC";                                                    
                                                }

                                                elseif (empty($supfil)){
                                                    $sql2   = "SELECT * FROM raw_data_reject where date BETWEEN '".$from."' AND '".$to."' ORDER BY date ASC";
                                                }

                                                else{
                                                    $sql2   = "SELECT * FROM raw_data_reject where supplier = '".$supfil."' AND date BETWEEN '".$from."' AND '".$to."' ORDER BY id DESC";
                                                }
                                                                                        
                                            }

                                            if (isset($_POST['clear'])) {
                                                $sql2   = "SELECT * FROM raw_data_reject ORDER BY id DESC";                                    
                                            }


                                            $q2     = mysqli_query($conn, $sql2);
                                            $order   = 1;
                                            while ($r2 = mysqli_fetch_array($q2)) {
                                                $id             = $r2['id'];
                                                $date           = $r2['date'];
                                                $no_lpb         = $r2['no_lpb'];
                                                $part_number    = $r2['part_number'];
                                                $part_name      = $r2['part_name'];
                                                $supplier       = $r2['supplier'];
                                                $category       = $r2['category'];
                                                $problem        = $r2['problem'];
                                                $note           = $r2['note'];
                                                $location       = $r2['location'];
                                                $qty            = $r2['qty'];
                                                $date_to_whs    = $r2['date_to_whs'];

                                            ?>
                                                <tr>
                                                    <td scope="row">
                                                        <a href="qc-reject-material.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-sm btn-warning">Edit</button></a>
                                                        <a href="qc-reject-material.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Are you sure you want to delete the data?')"><button type="button" class="btn btn-sm btn-danger">Delete</button></a>            
                                                    </td>
                                                    <th scope="row"><?php echo $order++ ?></th>
                                                    <td scope="row"><?php echo $date  ?></td>
                                                    <td scope="row"><?php echo $no_lpb ?></td>
                                                    <td scope="row"><?php echo $part_number ?></td>
                                                    <td scope="row"><?php echo $part_name  ?></td>
                                                    <td scope="row"><?php echo $supplier ?></td>
                                                    <td scope="row"><?php echo $category ?></td>
                                                    <td scope="row"><?php echo $problem ?></td>
                                                    <td scope="row"><?php echo $note ?></td>
                                                    <td scope="row"><?php echo $location ?></td>
                                                    <td scope="row"><?php echo $qty ?></td>
                                                    <td scope="row"><?php echo $date_to_whs ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>                                           
                                    </table>
                                </div>
                                <!-- End Table Content -->
                            </div>
                        </div>
                        <!-- End Table -->                        

                    </div>
                    <!-- End Main Content --> 

                </div>
                <!-- End Main Section-->

            </div>
        </div>
    </section>
    <!-- End Main -->   



    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Datepicker -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker-full.min.js"></script>

    <script>
    const elems = document.querySelectorAll('.datepicker_input');
    for (const elem of elems) {
    const datepicker = new Datepicker(elem, {
        'format': 'yyyy/mm/dd',
        
    });
    }      
    </script>

    <!--Table -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    
    <script>
    $(document).ready(function () {
    $('#reject_table').DataTable({
        dom: 'Blfrtip',
        buttons: [      
                {
                    extend: 'excelHtml5',
                    className: 'btn_excel',
                    title: 'Raw Data Reject Material',
                    text:'Export to Excel' 
                },
                {
                    extend: 'csvHtml5', 
                    className: 'btn_csv', 
                    title: 'Raw Data Reject Material',               
                    text: 'Export to CSV' 
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn_pdf',
                    title: 'Raw Data Reject Material',
                    text: 'Export to PDF' 
                },
	    ],
        scrollY: 430,
        scrollX: true,
    });
        $('.btn_excel').attr("class","btn btn-success btn-sm mb-3");
        $('.btn_pdf').attr("class","btn btn-primary btn-sm mb-3");
        $('.btn_csv').attr("class","btn btn-primary btn-sm mb-3");
    });    
    </script>

    <!--Searchable Dropdown -->
    <script src="assets/js/autocomplete.js"></script>

    <script>
    var auto_complete = new Autocomplete(document.getElementById('part_name'), {
        data:<?php echo json_encode($data1); ?>,
        maximumItems:10,
        highlightTyped:true,
        highlightClass : 'fw-bold text-primary',

    }); 
    $('.btn_excel').attr("class","w-50");
    </script>

    <script>
    var auto_complete = new Autocomplete(document.getElementById('problem'), {
        data:<?php echo json_encode($data2); ?>,
        maximumItems:10,
        highlightTyped:true,
        highlightClass : 'fw-bold text-primary'
    }); 
    </script>

    <script>
    var auto_complete = new Autocomplete(document.getElementById('location'), {
        data:<?php echo json_encode($data3); ?>,
        maximumItems:10,
        highlightTyped:true,
        highlightClass : 'fw-bold text-primary'
    }); 
    </script>

    <!-- <script>
    // var tableHTML = document.getElementById("reject_table").innerHTML;
    // window.localStorage["sharedTable"] = tableHTML;

    var tableContent = document.getElementById("reject_table").innerHTML;
    localStorage.setItem('tableContent', tableContent);

    </script>    -->


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>
<!-- End Body Section-->

</html>
