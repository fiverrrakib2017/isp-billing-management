<?php
if (!isset($_SESSION)) {
    session_start();
}
$rootPath = $_SERVER['DOCUMENT_ROOT'];  

$db_connect_path = $rootPath . '/include/db_connect.php';  
$users_right_path = $rootPath . '/include/users_right.php';

if (file_exists($db_connect_path)) {
    require($db_connect_path);
}

if (file_exists($users_right_path)) {
    require($users_right_path);
}

if(isset($_GET["id"]))
{
    $areaId = $_GET["id"];
    if ($areaname = $con -> query("SELECT * FROM area_list WHERE id='$areaId'")) 
        {
            while($rowname = $areaname->fetch_array()){
                
                $areaName = $rowname["name"];

            }

        } 
    
}
if ($pop_list = $con -> query("SELECT * FROM add_pop WHERE id='$auth_usr_POP_id'")) {
    while($rows= $pop_list->fetch_array())
    {
      $lstid=$rows["id"];
      $pop_name=$rows["pop"];
      $fullname= $rows['fullname'];
   $username= $rows['username'];
   $password= $rows['password'];
   $opening_bal= $rows['opening_bal'];
   $mobile_num1= $rows['mobile_num1'];
   $mobile_num2= $rows['mobile_num2'];
   $email_address= $rows['email_address'];
   $note= $rows['note'];
      
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
    
        <meta charset="utf-8">
        <title>FAST-ISP-BILLING-SOFTWARE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
    
        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . '/style.php';
        
        echo file_get_contents($url);
        
        ?>
    
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
        
            <?php $page_title="POP/Branch Area"; include '../Header.php';?>
        
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <?php include 'Sidebar_menu.php'; ?>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
        
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-purple me-0 float-end"><i class=" fas fa-globe"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-purple">
                                                   <?php
                                                   $sql = "SELECT radacct.username FROM radacct
                                                   INNER JOIN customers
                                                   ON customers.username=radacct.username
                                                   
                                                   WHERE customers.area='$areaId' AND radacct.acctstoptime IS NULL";
                                                   $countareaonlnusr = mysqli_query($con, $sql);

                                                   echo $countareaonlnusr->num_rows; 
                                        
                                        
                                                    ?>
                                                </span>
                                                Online
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--End col -->
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-brown me-0 float-end"><i class="fas fa-exclamation-triangle"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-brown">
                                                    <?php 
                                                    if ($ttlareusr = $con -> query("SELECT * FROM customers WHERE area='$areaId'")) 
                                                    {
                                                        echo  $ttlareusr ->num_rows; 
                                            
                                                    } 
                                                    ?>
                                                </span>
                                                Total
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End col -->
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i class=" fas fa-danger"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                     
                                                    <?php if ($ttlareusr = $con -> query("SELECT * FROM customers WHERE status='0'")) 
                                                    {
                                                        echo  $ttlareusr ->num_rows; 
                                            
                                                    } 
                                                    ?>
                                                </span>
                                                Disabled User
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col -->
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mini-stat">
                                            <span class="mini-stat-icon bg-teal me-0 float-end"><i class=" fas fa-plus"></i></span>
                                            <div class="mini-stat-info">
                                                <span class="counter text-teal">
                                                <?php  
                                                    if ($dsblcstmr = $con -> query("SELECT * FROM customers WHERE area='$areaId' AND status='2'")) 
                                                                {
                                                                    echo  $dsblcstmr ->num_rows; 

                                                                } 
                                                    ?>
                                                </span>
                                                Expired 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col -->
                        </div> <!-- end row-->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow h-100 py-2" style="border-left:3px solid #2A0FF1;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Customers Since</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php 
                                $createdate = new DateTime($createdate);
                                $createdate = $createdate->format('d-M-Y');
                                echo $createdate; 
                            ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="payment_history.php">
                      <div class="card shadow h-100 py-2" style="border-left:3px solid #27F10F;">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Paid</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                  <?php 
                                  $totalPaid='';
                                    if ($pop_payment=$con->query(" SELECT `amount` FROM `pop_transaction` WHERE pop_id='$auth_usr_POP_id' ")) {
                                             while ($rows=$pop_payment->fetch_array()) {
                                                 $totalPaid +=$rows["amount"];
                                             }
                                             //echo $stotalpaid;
                                         }
                                         echo  $totalPaid;
                                    ?>
                              </div>
                            </div>
                            <div class="col-auto">
                              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                  </a>
            </div>
            

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow h-100 py-2" style="border-left:3px solid #0FADF1;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow h-100 py-2" style="border-left:3px solid red;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Due</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php 
                            echo 0;
                            ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-6">
           <div class="card">
               <div class="card-body">
                   <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-marker-check"></i> Incharge Fullname:</p> <a href="#"><?php echo $fullname; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-account-circle"></i>  Incharge Username:</p> <a href="#"><?php echo $username; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class=" fas fa-dollar-sign"></i>   Opening Balance:</p> <a href="#"><?php echo $opening_bal; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class="mdi mdi-phone"></i> Mobile:</p> <a href="#"><?php echo $mobile_num1; ?></a>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2 px-3">
                        <p><i class=" fas fa-envelope"></i> Email Address:</p> <a href="#"><?php echo $email_address; ?></a>
                    </div>
                </div>
               </div>
           </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <h5 class="text-center mt-3">Cutomers Statistics</h5>
                <div class="card-body">
                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                </div>
            </div>
         </div>
    </div>
                    <div class="row">
                      
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p >Tickets</p>
                                        </div>
                                        <div class="col-md-4">
                                           <button style="float: right;">
                                        <a href="">+</a>
                                            </button>  
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Complain Type</th>
                                            <th>Ticket Type</th>
                                            <th>Form Date</th>
                                        </tr>
                                    </thead>
<tbody id="ticket-list">
    <?php 

    if ($ticket=$con->query("SELECT * FROM ticket WHERE pop='$pop_name' LIMIT 5")) {
        while ($rows=$ticket->fetch_array()) {
            $ticket_id=$rows["id"];
            $ticket_type=$rows["ticket_type"];
            $asignto=$rows["asignto"];
            $ticketfor=$rows["ticketfor"];
            $complain_type=$rows["complain_type"];
            $pop=$rows["pop"];
            $startdate=$rows["startdate"];
            $enddate=$rows["enddate"];


 if($ticket_type=="Active"){

                $tcktyp = '<label class="badge badge-danger">'.$ticket_type.'</label>';

                }
                if($ticket_type=="Open"){

                $tcktyp = '<label class="badge badge-danger">'.$ticket_type.'</label>';

                }
                if($ticket_type=="New"){

                $tcktyp = '<label class="badge badge-danger">'.$ticket_type.'</label>';
                }

                if($ticket_type=="Complete"){

                $tcktyp = '<label class="badge badge-success">'.$ticket_type.'</label>';

                }

            echo '
            <tr>
            <td>'.$complain_type.'</td>
           <td>'.$tcktyp.'</td>
            <td>'.$startdate.'</td>
            </tr>
            ';
        }
    }

     ?>
</tbody>
                                </table>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    
                    
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    


                                    <div class="row">
                                        <div class="col-md-8 mt-1 py-2">
                                        <p class="card-title ">POP/Area User</p>
                                        </div>
                                        <div class="col-md-4">
                                            <button style="float: right;">
                                                <a href="customers.php">+</a>
                                            </button>
                                        </div>
                                    </div>



                                    <div class="table-responsive">
                                        <table id="areaDataTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    <th>Package</th>
                                                    <th>POP</th>
                                                    <th>Area</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php 
                          $sql="SELECT * FROM customers WHERE area='$areaId' ";
                          $result=mysqli_query($con,$sql);

                          while ($rows=mysqli_fetch_assoc($result)) {
                            $username = $rows["username"];

                           ?>

                           <tr>
                                    <td><?php echo $rows['id']; ?></td>
                                    <td><a href="profile.php?clid=<?php echo $rows['id']; ?>">
                                    <?php 
                                    
                                    $onlineusr = $con->query("SELECT * FROM radacct WHERE radacct.acctstoptime IS NULL AND username='$username'");
                                                                $chkc = $onlineusr->num_rows;
                                                                if($chkc==1)
                                                                {
                                                                    echo '<abbr title="Online"><img src="images/icon/online.png" height="10" width="10"/></abbr>';
                                                                } else{
                                                                    echo '<abbr title="Offline"><img src="images/icon/offline.png" height="10" width="10"/></abbr>';
        
                                                                }
                                    
                                    
                                    echo " ". $rows["fullname"]; ?></a></td>
                                    <td>
                                        
                                        <?php echo $packageId= $rows["package_name"]; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $popID= $rows["pop"]; 
                                        $allPOP=$con->query("SELECT * FROM add_pop WHERE id=$popID ");
                                        while ($popRow=$allPOP->fetch_array()) {
                                        echo $popRow['pop'];
                                        }

                                        ?>

                                    </td>
                                    <td>
                                    <?php $id= $rows["area"];
                                        $allArea=$con->query("SELECT * FROM area_list WHERE id='$id' ");
                                        while ($popRow=$allArea->fetch_array()) {
                                        echo $popRow['name'];
                                        }

                                        ?>
                                        
                                    </td>

                                    </tr>
                       <?php } ?>
                                         

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php include '../Footer.php';?>

</div>
<!-- end main content-->
        
        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        
        
         <!-- JAVASCRIPT -->
        <?php include '../script.php';?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#areaDataTable').dataTable();
            });
var xValues = [1,2,3,4,5,6];

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{ 
      data: [860,1140,1060,1060,1070,1110],
      borderColor: "red",
      fill: false
    }, { 
      data: [<?php echo "10"; ?>,2400,1700,1900,2000,2700],
      borderColor: "green",
      fill: false
    }, { 
      data: [300,700,2000,3000,3000,4000],
      borderColor: "blue",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});
//this is  chart 1 grape
var xValues = ["Italy", "France", "Spain", ];
var yValues = [55, 49, 20];
var barColors = [
  'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
];

new Chart("myChart1", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: ""
    }
  }
});

///////////////this  is chart 2 ///////////////////////
var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = [55, 49, 44, 24, 15];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myChart2", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "World Wide Wine Production 2018"
    }
  }
});
</script>

<script type="text/javascript">

//Storage
    var fm = new FluidMeter();
fm.init({
  targetContainer: document.getElementById("fluid-meter1"),
  fillPercentage:<?php echo $mem1; ?>,
});

// CPU
 var fm = new FluidMeter();
fm.init({
  targetContainer: document.getElementById("fluid-meter2"),
  fillPercentage: <?php echo $cpu1; ?>,
  
});

//RAM
var fm = new FluidMeter();
fm.init({
  targetContainer: document.getElementById("fluid-meter"),
  fillPercentage:<?php echo $mem1; ?>,
  options: {
    fontSize: "70px",
    fontFamily: "Arial",
    fontFillStyle: "white",
    drawShadow: true,
    drawText: true,
    drawPercentageSign: true,
    drawBubbles: true,
    size: 300,
    borderWidth: 25,
    backgroundColor: "#e2e2e2",
    foregroundColor: "#fafafa",
    foregroundFluidLayer: {
      fillStyle: "#F1C40F",
      angularSpeed: 100,
      maxAmplitude: 12,
      frequency: 30,
      horizontalSpeed: -150
    },
    backgroundFluidLayer: {
      fillStyle: "#F1C40F",
      angularSpeed: 100,
      maxAmplitude: 9,
      frequency: 30,
      horizontalSpeed: 150
    },
     backgroundFluidLayer: {
      fillStyle: "  #CCCCFF",
      angularSpeed: 100,
      maxAmplitude: 9,
      frequency: 30,
      horizontalSpeed: 150
    },
  }
});
fm.setPercentage(percentage);
</script>
    </body>
</html>
