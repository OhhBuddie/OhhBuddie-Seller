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
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="public/assets/dashboard/css/style.css">
  <!-- endinject -->
  <!--<link rel="shortcut icon" href="{{asset('public/assets/dashboard/images/Ohbuddielogo.png')}}" />-->
  
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

    <!-- partial:./partials/_sidebar.html -->
   
    <!-- partial -->
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
            <!--<li class="nav-item dropdown me-1">-->
            <!--  <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">-->
            <!--    <i class="mdi mdi-calendar mx-0"></i>-->
            <!--    <span class="count bg-info">2</span>-->
            <!--  </a>-->
            <!--  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">-->
            <!--    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>-->
            <!--    <a class="dropdown-item preview-item">-->
            <!--      <div class="preview-thumbnail">-->
            <!--          <img src="images/faces/face4.jpg" alt="image" class="profile-pic">-->
            <!--      </div>-->
            <!--      <div class="preview-item-content flex-grow">-->
            <!--        <h6 class="preview-subject ellipsis font-weight-normal">David Grey-->
            <!--        </h6>-->
            <!--        <p class="font-weight-light small-text text-muted mb-0">-->
            <!--          The meeting is cancelled-->
            <!--        </p>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item preview-item">-->
            <!--      <div class="preview-thumbnail">-->
            <!--          <img src="images/faces/face2.jpg" alt="image" class="profile-pic">-->
            <!--      </div>-->
            <!--      <div class="preview-item-content flex-grow">-->
            <!--        <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook-->
            <!--        </h6>-->
            <!--        <p class="font-weight-light small-text text-muted mb-0">-->
            <!--          New product launch-->
            <!--        </p>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--    <a class="dropdown-item preview-item">-->
            <!--      <div class="preview-thumbnail">-->
            <!--          <img src="images/faces/face3.jpg" alt="image" class="profile-pic">-->
            <!--      </div>-->
            <!--      <div class="preview-item-content flex-grow">-->
            <!--        <h6 class="preview-subject ellipsis font-weight-normal"> Johnson-->
            <!--        </h6>-->
            <!--        <p class="font-weight-light small-text text-muted mb-0">-->
            <!--          Upcoming board meeting-->
            <!--        </p>-->
            <!--      </div>-->
            <!--    </a>-->
            <!--  </div>-->
            <!--</li>-->
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
        <div class="content-wrapper">
          <div class="row">
            @php
            
                $seller_data =DB::table('sellers')->where('user_table_id',Auth::user()->id)->latest()->first();
                $total_products = DB::table('products')->where('seller_id',$seller_data->seller_id)->count();
                $total_brands = DB::table('brands')->where('seller_id',$seller_data->seller_id)->count();
                $total_warehouses = DB::table('warehouses')->where('seller_id',$seller_data->seller_id)->count();
                $total_orders = DB::table('orderdetails')->where('seller_id',$seller_data->seller_id)->count();
                $total_order_amount = DB::table('orderdetails')->where('seller_id',$seller_data->seller_id)->sum('price');
            @endphp
            <div class="col-12 col-xl-12 grid-margin stretch-card">
              <div class="row w-100 flex-grow">
                <!--<div class="col-md-3 grid-margin stretch-card">-->
                <!--  <div class="card">-->
                <!--      <div class="card-header" style="background-color:#EFC475"><p class="card-title">Welcome</p></div>-->
                <!--        <div class="card-body">-->
                          
                <!--         <img src="https://help.indiamart.com/wp-content/uploads/2018/06/paid-services1-e1527767297851.jpg" style="width:100%;object-fit:fill">-->
                <!--        </div>-->
                <!--        <div class="card-footer">{{Auth::user()->name}}</div>-->
                <!--  </div>-->
                <!--</div>-->
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-header" style="background-color:#EFC475"><p class="card-title">Company</p></div>

                    <div class="card-body pb-0">
                        <img src="https://img.freepik.com/free-vector/many-office-buildings-city_1308-35976.jpg?t=st=1743408237~exp=1743411837~hmac=efc949292f19af54c9d364b77fa27fcc5b543cc1f68e9def45bbf99e57d7529e&w=900" style="width:100%;object-fit:fill">
                    </div>
                    <!--<canvas height="150" id="activity-chart"></canvas>-->
                    <div class="card-footer"><b>{{$seller_data->company_name}}</b></div>
                  </div>
                </div>

                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-header" style="background-color:#EFC475"><p class="card-title">Total Brands</p></div>
                     <!-- Target number in data attribute -->
    


                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-8"><img src="https://previews.123rf.com/images/shiyiershier/shiyiershier1303/shiyiershier130300005/19666750-women-s-clothing-items-accessories.jpg" style="width:100%;object-fit:fill"></div>
                            <div class="col-md-4"><br><br><br><br><h1><div class="counter" data-target="{{$total_brands}}">0</div></h1></div>
                        </div>

                    </div>
                    <!--<canvas height="150" id="activity-chart"></canvas>-->
                  </div>
                </div>
                
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-header" style="background-color:#EFC475"><p class="card-title">Total Warehouses</p></div>

                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-8"><img src="https://img.freepik.com/free-vector/isolated-clothes-rack-display_1308-55056.jpg?t=st=1743410730~exp=1743414330~hmac=ee4907054a9d441e337da9dfb73fb1431b7d16233bd29edd554c57d3815490a9&w=740" style="width:100%;object-fit:fill"></div>
                                <div class="col-md-4"><br><br><br><br><h1><div class="counter" data-target="{{$total_warehouses}}">0</div></h1></div>
                            </div>
    
                        </div>
                    <!--<canvas height="150" id="activity-chart"></canvas>-->
                  </div>
                </div>
                
                
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-header" style="background-color:#EFC475"><p class="card-title">Total Products</p></div>

                    <div class="card-body pb-0">
                     <div class="row">
                            <div class="col-md-8"><img src="https://static.vecteezy.com/system/resources/previews/011/883/312/non_2x/fashion-clothing-store-for-women-template-hand-drawn-cartoon-flat-illustration-with-shopping-buying-products-cloth-or-dresses-design-vector.jpg" style="width:100%;object-fit:fill"></div>
                            <div class="col-md-4" style="vertical-align:middle"><br><br><br><br><h1><div class="counter" data-target="{{$total_products}}">0</div></h1></div>
                        </div>
                    </div>
                    <!--<canvas height="150" id="activity-chart"></canvas>-->
                  </div>
                </div>
                
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-header" style="background-color:#EFC475"><p class="card-title">Total Orders</p></div>

                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-8"><img src="https://thumbs.dreamstime.com/b/clothing-store-sales-retail-manager-checking-stock-using-tablet-clothing-store-business-owner-orders-goods-via-his-smartphone-303465901.jpg" style="width:100%;object-fit:fill"></div>
                                <div class="col-md-4"><br><br><br><br><h1><div class="counter" data-target="{{$total_orders}}">0</div></h1></div>
                            </div>
    
                        </div>
                    <!--<canvas height="150" id="activity-chart"></canvas>-->
                  </div>
                </div>
                
                
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-header" style="background-color:#EFC475"><p class="card-title">Total Order Amount (In INR)</p></div>

                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-8"><img src="https://img.freepik.com/free-vector/delivery-staff-ride-motorcycles-shopping-concept_1150-34879.jpg?t=st=1743416458~exp=1743420058~hmac=16a9b95a6ee0625174b8308371ec0684a24696fc9190c0180589a1a579f98fda&w=826" style="width:100%;object-fit:fill"></div>
                                <div class="col-md-4"><br><br><br><br><h3><div class="counter1" data-target="{{$total_order_amount}}">Rs.0</div></h3></div>
                            </div>
    
                        </div>
                    <!--<canvas height="150" id="activity-chart"></canvas>-->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- row end -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:./partials/_footer.html -->
        <footer class="footer text-center">
           <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">© 2025 <a href="https://www.ohhbuddie.com/" target="_blank">ohhbuddie.com </a>All Rights Reserved</span>
        </footer>
        <!-- partial -->
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