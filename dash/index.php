<?php
include "koneksi.php"
?>
<!doctype html>
<html lang="en" class="light-theme">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- loader-->
	  <link href="../assets/css/pace.min.css" rel="stylesheet" />
	  <script src="../assets/js/pace.min.js"></script>

    <!--plugins-->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!--Theme Styles-->
    <link href="../assets/css/dark-theme.css" rel="stylesheet" />
    <link href="../assets/css/semi-dark.css" rel="stylesheet" />
    <link href="../assets/css/header-colors.css" rel="stylesheet" />

    <title>DASHBOARD DPMPTSP</title>
  </head>
  <body>
    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">DASHBOARD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ms-auto">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            <a class="nav-link" href="#">Izin</a>
            <a class="nav-link" href="#">Investasi</a>
            <a class="nav-link btn btn-primary text-white" href="login.html">Login</a>
          </div>
        </div>
      </div>
    </nav>
  </div>

 <!--start wrapper-->
    <div class="wrapper">
  <div class="container">
                  
         <div class="row">
          <div class="col-12 col-lg-3 col-xl-3 d-flex">
            <div class="card radius-10 w-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-6">
                  <h6 class="mb-4">Triwulan 1</h6>
                </div>
                <div class="chart-container7">
                  <canvas id="charttw1" height="450px"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 col-xl-3 d-flex">
            <div class="card radius-10 w-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-6">
                  <h6 class="mb-4">Triwulan 2</h6>
                </div>
                <div class="chart-container7">
                  <canvas id="charttw2" height="450px"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 col-xl-3 d-flex">
            <div class="card radius-10 w-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-6">
                  <h6 class="mb-4">Triwulan 3</h6>
                </div>
                <div class="chart-container7">
                  <canvas id="charttw3" height="450px"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 col-xl-3 d-flex">
            <div class="card radius-10 w-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-6">
                  <h6 class="mb-4">Triwulan 4</h6>
                </div>
                <div class="chart-container7">
                  <canvas id="charttw4" height="450px"></canvas>
                </div>
              </div>
            </div>
          </div>
         <div class="row">
           <div class="col-12 col-lg-12 col-xl-6 d-flex">
             <div class="card radius-10 w-100">
               <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <h6 class="mb-0">Izin Per Kecamatan</h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-borderless align-middle mb-0">
                     <tbody>
                       <tr>
                         <td>
                          <div class="country-icon">
                          </div>
                         </td>
                         <td><div class="country-name h6 mb-0">Tarogong Kidul</div></td>
                         <td class="w-100">
                          <div class="progress flex-grow-1" style="height: 6px;">
                            <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 68%;"></div>
                           </div>
                         </td>
                         <td>
                          <div class="percent-data">68%</div>
                         </td>
                       </tr>
                       <tr>
                        <td>
                         <div class="country-icon">
                         </div>
                        </td>
                        <td><div class="country-name h6 mb-0">Tarogong Kaler</div></td>
                        <td class="w-100">
                         <div class="progress flex-grow-1" style="height: 6px;">
                           <div class="progress-bar bg-gradient-purple" role="progressbar" style="width: 52%;"></div>
                          </div>
                        </td>
                        <td>
                         <div class="percent-data">52%</div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                         <div class="country-icon">
                         </div>
                        </td>
                        <td><div class="country-name h6 mb-0">Karangpawitan</div></td>
                        <td class="w-100">
                         <div class="progress flex-grow-1" style="height: 6px;">
                           <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 35%;"></div>
                          </div>
                        </td>
                        <td>
                         <div class="percent-data">35%</div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                         <div class="country-icon">
                          
                         </div>
                        </td>
                        <td><div class="country-name h6 mb-0">Wanaraja</div></td>
                        <td class="w-100">
                         <div class="progress flex-grow-1" style="height: 6px;">
                           <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 24%;"></div>
                          </div>
                        </td>
                        <td>
                         <div class="percent-data">24%</div>
                        </td>
                      </tr>
                     </tbody>
                  </table>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-12 col-lg-12 col-xl-6 d-flex">
            <div class="card radius-10 w-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <h6 class="mb-0">Status Perusahaan</h6>
                </div>
                <div class="chart-container6">
                  <div class="piechart-legend">
                    <h2 class="mb-1">8,452</h2>
                    <h6 class="mb-0">Jumlah</h6>
                   </div>
                  <canvas id="chart5"></canvas>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center border-top">
                  PT
                  <span class="badge bg-tiffany rounded-pill">558</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Perseorangan
                  <span class="badge bg-success rounded-pill">204</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  CV
                  <span class="badge bg-danger rounded-pill">108</span>
                </li>
              </ul>
            </div>
          </div>
         
         </div><!--end row-->
        </div>
          </div>
          <!-- end page content-->
         
        </div>
         <!--end page content wrapper-->


         

         <!--Start Back To Top Button-->
		     <a href="javaScript:;" class="back-to-top"><ion-icon name="arrow-up-outline"></ion-icon></a>
         <!--End Back To Top Button-->
  
         <!--start switcher-->
         <div class="switcher-body">
          <button class="btn btn-primary btn-switcher shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><ion-icon name="color-palette-sharp" class="me-0"></ion-icon></button>
          <div class="offcanvas offcanvas-end shadow border-start-0 p-2" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling">
            <div class="offcanvas-header border-bottom">
              <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Theme Customizer</h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
              <h6 class="mb-0">Theme Variation</h6>
              <hr>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="LightTheme" value="option1" checked>
                <label class="form-check-label" for="LightTheme">Light</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="DarkTheme" value="option2">
                <label class="form-check-label" for="DarkTheme">Dark</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="SemiDark" value="option3">
                <label class="form-check-label" for="SemiDark">Semi Dark</label>
              </div>
              <hr/>
              <h6 class="mb-0">Header Colors</h6>
              <hr/>
              <div class="header-colors-indigators">
                <div class="row row-cols-auto g-3">
                  <div class="col">
                    <div class="indigator headercolor1" id="headercolor1"></div>
                  </div>
                  <div class="col">
                    <div class="indigator headercolor2" id="headercolor2"></div>
                  </div>
                  <div class="col">
                    <div class="indigator headercolor3" id="headercolor3"></div>
                  </div>
                  <div class="col">
                    <div class="indigator headercolor4" id="headercolor4"></div>
                  </div>
                  <div class="col">
                    <div class="indigator headercolor5" id="headercolor5"></div>
                  </div>
                  <div class="col">
                    <div class="indigator headercolor6" id="headercolor6"></div>
                  </div>
                  <div class="col">
                    <div class="indigator headercolor7" id="headercolor7"></div>
                  </div>
                  <div class="col">
                    <div class="indigator headercolor8" id="headercolor8"></div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
         </div>
         <!--end switcher-->


         <!--start overlay-->
          <div class="overlay"></div>
         <!--end overlay-->

     </div>
  <!--end wrapper-->

  <?php 
    $datatw121 = $koneksi->query("select * from data where triwulan = 'Triwulan 1'");
    $tw121 = array();
    while($fetch121 = $datatw121->fetch_assoc()) {
        $tw121[] = $fetch121;
    }
    $datatw221 = $koneksi->query("select * from data where triwulan = 'Triwulan 2'");
    $tw221 = array();
    while($fetch221 = $datatw221->fetch_assoc()) {
        $tw221[] = $fetch221;
    }
    $datatw321 = $koneksi->query("select * from data where triwulan = 'Triwulan 3'");
    $tw321 = array();
    while($fetch321 = $datatw321->fetch_assoc()) {
        $tw321[] = $fetch321;
    }
    $datatw421 = $koneksi->query("select * from data where triwulan = 'Triwulan 4'");
    $tw421 = array();
    while($fetch421 = $datatw421->fetch_assoc()) {
        $tw421[] = $fetch421;
    }
    $tw121 = $tw121[0];
    $tw221 = $tw221[0];
    $tw321 = $tw321[0];
    $tw421 = $tw421[0];
  ?>
    <!-- JS Files-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!--plugins-->
    <script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="../assets/plugins/chartjs/chart.min.js"></script>
    <script src="../assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    <!-- <script src="../assets/js/index2.js"></script> -->
    <!-- Main JS-->
    <script src="../assets/js/main.js"></script>

    <script>
    
    var tw121 = <?php echo json_encode($tw121['total'], JSON_HEX_TAG); ?>;
    var tw221 = <?php echo json_encode($tw221['total'], JSON_HEX_TAG); ?>;
    var tw321 = <?php echo json_encode($tw321['total'], JSON_HEX_TAG); ?>;
    var tw421 = <?php echo json_encode($tw421['total'], JSON_HEX_TAG); ?>;
    // charttw1
var ctx = document.getElementById('charttw1').getContext('2d');

var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#009efd');
    gradientStroke1.addColorStop(1, '#2af598');

var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke2.addColorStop(0, '#7928ca');  
    gradientStroke2.addColorStop(1, '#ff0080'); 

var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke3.addColorStop(0, '#ff8359');
    gradientStroke3.addColorStop(1, '#ffdf40');


var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['2020', '2021', '2022'],
        datasets: [{
            data: [15, tw121, 100],
            backgroundColor: [
                gradientStroke1
            ],
            borderColor: [
                gradientStroke1
            ],
            borderWidth: 0,
            borderRadius: 20
        },
        {
            data: [20, 35, 30],
            backgroundColor: [
                gradientStroke1
            ],
            borderColor: [
                gradientStroke1
            ],
            borderWidth: 0,
            borderRadius: 20
        },{
            data: [10, 15, 9],
            backgroundColor: [
                gradientStroke1
            ],
            borderColor: [
                gradientStroke1
            ],
            borderWidth: 0,
            borderRadius: 20
        }]
    },
    options: {
        maintainAspectRatio: false,
        barPercentage: 0.9,
        categoryPercentage: 0.4,
        plugins: {
            legend: {
                maxWidth: 20,
                boxHeight: 20,
                position:'bottom',
                display: false,
            }
        },
        scales: {
            x: {
              stacked: false,
              beginAtZero: true
            },
            y: {
              stacked: false,
              beginAtZero: true
            }
          }
    }
});

// charttw2
var ctx = document.getElementById('charttw2').getContext('2d');

var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#009efd');
    gradientStroke1.addColorStop(1, '#2af598');

var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke2.addColorStop(0, '#7928ca');  
    gradientStroke2.addColorStop(1, '#ff0080'); 

var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke3.addColorStop(0, '#ff8359');
    gradientStroke3.addColorStop(1, '#ffdf40');


var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['2020', '2021', '2022'],
        datasets: [{
            data: [22, tw221, 15],
            backgroundColor: [
                gradientStroke2
            ],
            borderColor: [
                gradientStroke2
            ],
            borderWidth: 0,
            borderRadius: 20
        },
        {
            data: [35, 30, 35],
            backgroundColor: [
                gradientStroke2
            ],
            borderColor: [
                gradientStroke2
            ],
            borderWidth: 0,
            borderRadius: 20
        },{
            data: [15, 9, 12],
            backgroundColor: [
                gradientStroke2
            ],
            borderColor: [
                gradientStroke2
            ],
            borderWidth: 0,
            borderRadius: 20
        }]
    },
    options: {
        maintainAspectRatio: false,
        barPercentage: 0.9,
        categoryPercentage: 0.4,
        plugins: {
            legend: {
                maxWidth: 20,
                boxHeight: 20,
                position:'bottom',
                display: false,
            }
        },
        scales: {
            x: {
              stacked: false,
              beginAtZero: true
            },
            y: {
              stacked: false,
              beginAtZero: true
            }
          }
    }
});

// charttw3
var ctx = document.getElementById('charttw3').getContext('2d');

var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#009efd');
    gradientStroke1.addColorStop(1, '#2af598');

var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke2.addColorStop(0, '#7928ca');  
    gradientStroke2.addColorStop(1, '#ff0080'); 

var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke3.addColorStop(0, '#ff8359');
    gradientStroke3.addColorStop(1, '#ffdf40');


var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['2020', '2021', '2022'],
        datasets: [{
            data: [15, tw321, 15],
            backgroundColor: [
                gradientStroke3
            ],
            borderColor: [
                gradientStroke3
            ],
            borderWidth: 0,
            borderRadius: 20
        },
        {
            data: [20, 35, 35],
            backgroundColor: [
                gradientStroke3
            ],
            borderColor: [
                gradientStroke3
            ],
            borderWidth: 0,
            borderRadius: 20
        },{
            data: [10, 15, 12],
            backgroundColor: [
                gradientStroke3
            ],
            borderColor: [
                gradientStroke3
            ],
            borderWidth: 0,
            borderRadius: 20
        }]
    },
    options: {
        maintainAspectRatio: false,
        barPercentage: 0.9,
        categoryPercentage: 0.4,
        plugins: {
            legend: {
                maxWidth: 20,
                boxHeight: 20,
                position:'bottom',
                display: false,
            }
        },
        scales: {
            x: {
              stacked: false,
              beginAtZero: true
            },
            y: {
              stacked: false,
              beginAtZero: true
            }
          }
    }
});

// charttw4
var ctx = document.getElementById('charttw4').getContext('2d');

var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#009efd');
    gradientStroke1.addColorStop(1, '#2af598');

var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke2.addColorStop(0, '#7928ca');  
    gradientStroke2.addColorStop(1, '#ff0080'); 

var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke3.addColorStop(0, '#ff8359');
    gradientStroke3.addColorStop(1, '#ffdf40');

var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke4.addColorStop(0, '#483D8B');
    gradientStroke4.addColorStop(1, '#00CED1');


var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['2020', '2021', '2022'],
        datasets: [{
            data: [15, tw421, 15],
            backgroundColor: [
                gradientStroke4
            ],
            borderColor: [
                gradientStroke4
            ],
            borderWidth: 0,
            borderRadius: 20
        },
        {
            data: [20, 30, 35],
            backgroundColor: [
                gradientStroke4
            ],
            borderColor: [
                gradientStroke4
            ],
            borderWidth: 0,
            borderRadius: 20
        },{
            data: [10, 9, 12],
            backgroundColor: [
                gradientStroke4
            ],
            borderColor: [
                gradientStroke4
            ],
            borderWidth: 0,
            borderRadius: 20
        }]
    },
    options: {
        maintainAspectRatio: false,
        barPercentage: 0.9,
        categoryPercentage: 0.4,
        plugins: {
            legend: {
                maxWidth: 20,
                boxHeight: 20,
                position:'bottom',
                display: true,
            }
        },
        scales: {
            x: {
              stacked: false,
              beginAtZero: true
            },
            y: {
              stacked: false,
              beginAtZero: true
            }
          }
    }
});
  </script>


  </body>
</html>