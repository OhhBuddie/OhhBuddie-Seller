<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Registration Form</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        
        .form-row {
            display: flex;
            margin-bottom: 20px;
            gap: 20px;
        }
        
        .form-group {
            flex: 1;
            min-width: 0; /* Prevents flex items from overflowing */
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        input[type="text"], 
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        input[type="file"] {
            padding: 10px 0;
        }
        
        .logo-preview {
            width: 100%;
            max-width: 150px;
            height: 150px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .logo-preview span {
            color: #777;
        }
        
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 30px auto 0;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
            
            .container {
                padding: 20px 15px;
            }
            
            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Brand Registration Form</h1>
        
        <form id="brandForm" method="POST" action="{{ route('brands.store') }}" enctype='multipart/form-data' >
            
            @csrf
            
            @php
              $seller_data = DB::table('sellers')->where('user_table_id',Auth::user()->id)->latest()->first();
            @endphp
            <!-- Row 1 -->
            <div class="form-row" >
                <div class="form-group" hidden>
                    <label for="user_table_id">User Table ID</label>
                    <input type="hidden" id="user_table_id" name="user_table_id" value={{Auth::user()->id}} >
                </div>
                
                <div class="form-group" hidden>
                    <label for="seller_table_id">Seller Table ID</label>
                    <input type="hidden" id="seller_table_id" name="seller_table_id" value ="{{$seller_data->id}}" >
                </div>
            </div>
            
            <!-- Row 2 -->
            <div class="form-row">
                <div class="form-group" hidden>
                    <label for="seller_id">Seller ID</label>
                    <input type="hidden" id="seller_id" name="seller_id" value ="{{$seller_data->seller_id}}" >
                </div>
                
                <!--<div class="form-group">-->
                <!--    <label for="brand_id">Brand ID</label>-->
                <!--    <input type="text" id="brand_id" name="brand_id" required>-->
                <!--</div>-->
            </div>
            
            <!-- Row 3 -->
            <div class="form-row">
                <div class="form-group">
                    <label for="brand_name">Brand Name</label>
                    <input type="text" id="brand_name" name="brand_name">
                </div>
                
                <div class="form-group">
                    <label for="nature_of_brand">Nature of Brand</label>
                    <select id="nature_of_brand" name="nature_of_brand" >
                        <option value="">Select Nature of Brand</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Home & Kitchen">Home & Kitchen</option>
                        <option value="Beauty & Personal Care">Beauty & Personal Care</option>
                        <option value="Food & Beverage">Food & Beverage</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            
            <!-- Row 4 -->
            <div class="form-row">
                <div class="form-group">
                    <label for="brand_logo">Brand Logo</label>
                    <input type="file" id="brand_logo" name="brand_logo" accept="image/*" onchange="previewLogo(this)">
                    <div class="logo-preview" id="logoPreview">
                        <span>Logo preview</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="document_type">Document Type</label>
                    <select id="document_type" name="document_type" >
                        <option value="">Select Document Type</option>
                        <option value="Trademark Certificate">Trademark Certificate</option>
                        <option value="Brand Authorization Letter">Brand Authorization Letter</option>
                        <option value="Copyright Certificate">Copyright Certificate</option>
                        <option value="Brand Registry Certificate">Brand Registry Certificate</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            
            <!-- Row 5 -->
            <div class="form-row">
                <div class="form-group">
                    <label for="document">Document</label>
                    <input type="file" id="document" name="document" >
                </div>
                
                <div class="form-group">
                    <label for="no_of_products">Number of Products</label>
                    <input type="number" id="no_of_products" name="no_of_products" min="1" >
                </div>
            </div>
            
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        function previewLogo(input) {
            const preview = document.getElementById('logoPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = '';
                    preview.style.backgroundImage = `url('${e.target.result}')`;
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.backgroundImage = 'none';
                preview.innerHTML = '<span>Logo preview</span>';
            }
        }
        
        
    </script>
</body>
</html>