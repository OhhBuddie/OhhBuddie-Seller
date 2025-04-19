<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ohh! Buddie</title>
  <!-- base:css -->
  <link rel="stylesheet" href="public/assets/dashboard/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="public/assets/dashboard/vendors/css/vendor.bundle.base.css">

  <link rel="stylesheet" href="public/assets/dashboard/css/style.css">

  <link rel="shortcut icon" href="https://fileuploaderbucket.s3.ap-southeast-1.amazonaws.com/Ohbuddielogo.png" />
  
  <style>
    .dropbtn {
      background-color: transparent;
      border:none;
      color: black;
      padding: 16px;
      font-size: 16px;
      border: none;
    }
    
    .dropdown {
      position: relative;
      display: inline-block;
    }
    
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      font-size:13px;
    }
    
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
    
    .dropdown-content a:hover {background-color: #ddd;}
    
    .dropdown:hover .dropdown-content {display: block;}
    
    /*.dropdown:hover .dropbtn {background-color: #3e8e41;}*/
    
    .row{
          display: flex ;
    }
    .dropbtn {
        font-weight: normal;
        text-decoration: none;
    }
    
    .dropbtn:hover {
        text-decoration: none !important;
        color: inherit; /* Keeps the original text color */
    }
    
    </style>
</head>
<body>
  <div class="container-scroller d-flex">

    <div class="container-fluid page-body-wrapper">
      <!-- partial:./partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
          <!--<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">-->
          <!--  <span class="mdi mdi-menu"></span>-->
          <!--</button>-->
          
          <div class="d-flex">
              <div class="navbar-brand-wrapper">
                <a class="navbar-brand brand-logo" href="index.html"><img src="{{asset('public/assets/dashboard/images/Ohbuddielogo.png')}}" alt="logo" style="height:80px;"/></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="public/assets/dashboard/images/logo-mini.svg" alt="logo"/></a>
              </div>
          
          
              <ul class="navbar-nav">
                  
                <li class="nav-item">
                  <h4 class="mb-0 font-weight-bold d-none d-xl-block">
                     <a href="/home" class="dropbtn" style="font-weight: normal; text-decoration: none;">Home</a>
                  </h4>
                </li>
                <li class="nav-item">
                  <h4 class="mb-0 font-weight-bold d-none d-xl-block">
                      <div class="dropdown">
                          <button class="dropbtn">Inventory</button>
                          <div class="dropdown-content">
                            <a href="/listing">Add New Product</a>
                            <a href="product/sellerproduct">Manage My Products</a>
                            <a href="#">Brands</a>
                          </div>
                      </div>
                  </h4>
                </li>
                <li class="nav-item">
                  <h4 class="mb-0 font-weight-bold d-none d-xl-block">
                      <div class="dropdown">
                          <button class="dropbtn">Orders</button>
                          <div class="dropdown-content">
                            <a href="/allorders">Orders</a>
                            <!--<a href="#">Warehouse Orders</a>-->
                          </div>
                      </div>
                  </h4>
                </li>
                
                <li class="nav-item">
                  <h4 class="mb-0 font-weight-bold d-none d-xl-block">
                     <a href="/payments" class="dropbtn" style="font-weight: normal; text-decoration: none;">Payments</a>
                  </h4>
                </li>
                
                <li class="nav-item">
                  <h4 class="mb-0 font-weight-bold d-none d-xl-block">
                      <div class="dropdown">
                          <button class="dropbtn">Warehouse</button>
                          <div class="dropdown-content">
                            <a href="#">Add new warehouse</a>
                            <a href="#">Manage Warehouse</a>
                          </div>
                      </div>
                  </h4>
                </li>
                <li class="nav-item">
                  <h4 class="mb-0 font-weight-bold d-none d-xl-block">
                     <a href="/reports" class="dropbtn" style="font-weight: normal; text-decoration: none;">Reports</a>
                  </h4>
                </li>
    
                </ul>
            </div>
            
            
            <ul class="navbar-nav">
       
            <li class="nav-item dropdown me-2">
              <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="mdi mdi-email-open mx-0"></i>
                <span class="count bg-danger">1</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-information mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Application Error</h6>

                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Private message
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-account-box mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      2 days ago
                    </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item">
              <!--<h4 class="mb-0 font-weight-bold d-none d-xl-block">{{ \Carbon\Carbon::now()->format('Y-m-d') }}</h4>-->
                <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1" 
                    title="{{ $seller_name->owner_name }}">
                    Welcome back, {{ strlen($seller_name->owner_name) <= 16 ? $seller_name->owner_name : Str::limit($seller_name->owner_name, 16, '...') }}
                </h4>
            </li>
            <li class="nav-item dropdown me-2">
              <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="mdi mdi-account mx-0"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a href="/profile" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-account-check mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Profile</h6>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Private message
                    </p>
                  </div>
                </a>
                <a href="/logout" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-account-box mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Logout</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      2 days ago
                    </p>
                  </div>
                </a>
              </div>
            </li>
            
          </ul>
          
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
        
      </nav>
      <!-- partial -->
    <div class="main-panel">
      <img src="https://fileuploaderbucket.s3.ap-southeast-1.amazonaws.com/Seller/We+This+Feature+Is+Loading+Soon+(desktop+size)+(1).jpg" style="width: 100%; height: auto; display: block;">
      
      <footer class="footer text-center" style="position: fixed; bottom: 0; width: 100%; background-color: #f5f5f5; padding: 10px 0;">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">© 2025 <a href="https://www.ohhbuddie.com/" target="_blank">ohhbuddie.com</a> All Rights Reserved</span>
      </footer>
    </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="public/assets/dashboard/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="public/assets/dashboard/vendors/chart.js/Chart.min.js"></script>
  <script src="public/assets/dashboard/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="public/assets/dashboard/js/off-canvas.js"></script>
  <script src="public/assets/dashboard/js/hoverable-collapse.js"></script>
  <script src="public/assets/dashboard/js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
    <script src="public/assets/dashboard/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="public/assets/dashboard/js/dashboard.js"></script>
  
  
  
<script>
    function animateCounter(element, duration) {
        let start = 0;
        let end = parseInt(element.getAttribute("data-target")); // Get the target from HTML
        
        if (end === 0) {
            element.textContent = "0"; // Ensure it remains 0 if no products
            return; // Stop execution
        }

        let interval = duration / end;

        let counter = setInterval(() => {
            start++;
            element.textContent = start;
            if (start === end) {
                clearInterval(counter);
            }
        }, interval);
    }

    // Select all elements with class "counter" and animate them
    document.querySelectorAll(".counter").forEach(counterElement => {
        animateCounter(counterElement, 2000);
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const counters = document.querySelectorAll('.counter1');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'), 10); // Convert to integer
            let count = 0;
            const increment = target / 100; // Adjust speed
            const speed = 10; // Milliseconds per update

            const updateCounter = () => {
                if (count < target) {
                    count += increment;
                    counter.innerText = "Rs." + formatIndianNumber(Math.floor(count));
                    setTimeout(updateCounter, speed);
                } else {
                    counter.innerText = "Rs." + formatIndianNumber(target); // Ensure exact final value
                }
            };

            updateCounter();
        });

        // Function to format numbers in Indian style (e.g., 1,23,456)
        function formatIndianNumber(num) {
            return num.toLocaleString('en-IN'); // Formats in Indian currency style
        }
    });
</script>
  <!-- End custom js for this page-->
</body>

</html>