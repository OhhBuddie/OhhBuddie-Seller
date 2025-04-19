@extends('layouts.seller.sellerportal')
@section('content')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: all 0.3s ease-in-out;
        }
        .form-control:focus {
            border: var(--bs-border-width) solid var(--bs-border-color);
            box-shadow: none;
        }
        a {
            text-decoration: none !important;
        }
        
        a:hover {
            text-decoration: none !important;
        }
        th, td, h3, h4, h6 {
            text-transform: none !important;
        }

    </style>

<body class="bg-light">
    @php
        $customer_details = DB::table('users')->where('id',$order_id->user_id)->latest()->first();
        $customer_address = DB::table('addresses')->where('user_id',$order_id->user_id)->latest()->first();
        $city = DB::table('cities')->where('id',$customer_address->city)->latest()->first();
        $state = DB::table('states')->where('id',$customer_address->state)->latest()->first();

    @endphp
    <div class="container-fluid py-4">
        <div class="table-responsive">
            <table id="sellerProductsTable" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="14" class="text-center">
                            <h4>All Orders Details for Order ID: <span style="color:blue">{{ $order_id->order_id }}</span></h4>
                        </th>
                    </tr>

                    <tr>
                        <th colspan="14" class="text-center">
                            <h4 style="text-align:left;"><b><i class="fa fa-truck"></i>&nbsp; Delivery Details</b></h4>
                            <h6 style="text-align:left;">
                                <i class="fa fa-user"></i>&nbsp; Name: {{$customer_address->name}} 
                            </h6>
                            <h6 style="text-align:left;">
                                <i class="fa fa-phone"></i>&nbsp; Contact: {{$customer_address->phone}} 
                            </h6>
                            <h6 style="text-align:left;">
                                <i class="fa fa-city"></i>&nbsp; City: {{$city->name}}
                            </h6>
                            <h6 style="text-align:left;">
                                <i class="fa fa-map-marker-alt"></i>&nbsp; Area: {{$customer_address->locality}} 
                            </h6>
                            <h6 style="text-align:left;">
                                <i class="fa fa-flag"></i>&nbsp; State: {{$state->name}} 
                            </h6>     
                            <h6 style="text-align:left;">
                                <i class="fa fa-map-pin"></i>&nbsp; Pincode: {{$customer_address->pincode}}
                            </h6>
                            <h6 style="text-align:left;">
                                <i class="fa fa-home"></i>&nbsp; Address: {{$customer_address->address_line_1}} {{$customer_address->address_line_2}}
                            </h6>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="14" class="text-center">
                            <h6>
                                Payment Mode: {{$order_id->payment_type}}
                            </h6>
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align:center">SL No.</th>
                        <th style="text-align:center">Product</th>
                        <th style="text-align:center">Product Name</th>
                        <th style="text-align:center">Sold By</th>
                        <th style="text-align:center">Brand Name</th>
                         <th style="text-align:center">SKU</th>
                        <th style="text-align:center">Color</th>
                        <th style="text-align:center">Size</th>
                        <th style="text-align:center">MRP</th>
                        <th style="text-align:center">Bank Settlement Price</th>
                        <th style="text-align:center">Amount</th>
                        <th style="text-align:center">Discount</th>
                        <th style="text-align:center">Quantity</th>
                        <th style="text-align:center">Delivery Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allorderdetails as $index => $allords)
                        <tr>
                            <td style="text-align:center">{{ $index + 1 }}</td>
                            <td><img src="{{ $allords['images'] }}" style="object-fit:fill; width:80px; height:80px;"></td>
                            <td>{{ $allords['product_name'] }}</td>
                            <td>{{ $allords['sold_by'] }}</td>
                            <td>{{ $allords['brand_name'] }}</td>
                            <td>{{ $allords['sku'] }}</td>
                            <td>{{ $allords['color'] }}</td>
                            <td>{{ $allords['size'] }}</td>
                            <td>Rs. {{ number_format($allords['mrp'], 2) }}</td>
                            <td>Rs. {{ number_format($allords['bsp'], 2) }}</td>
                            <td>Rs. {{ number_format($allords['price'], 2) }}</td>
                            <td>Rs. {{ number_format($allords['discount'], 2) }}</td>
                            <td>{{ $allords['quantity'] }}</td>
                            <td>{{ $allords['delivery_status'] }}</td>

                                                    
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery, Bootstrap & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#sellerProductsTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "lengthMenu": "Show _MENU_ entries per page",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries available",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });
    </script>
    

@endsection