<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $product = Storage::disk('s3')->url('Product/Comp 1 (4).gif');
       return view('product.index', compact('product'));

    }
    
    public function sellerproduct()
    {

      $seller_id = DB::table('sellers')->where('user_table_id', Auth::user()->id)->latest()->first();
       
      $seller_products = DB::table('products')->where('seller_id', $seller_id->seller_id)->whereNotNull('product_name')->distinct()->latest()->get();
       
       

       $product = Storage::disk('s3')->url('Product/Comp 1 (4).gif');
       return view('product.sellerproduct', compact('product','seller_products'))->with('i');

    }
    
    public function toggleStatus(Request $request)
    {
        $product = Product::find($request->id);
        
        // return $product;
        if ($product) {
            $product->pstatus = $request->status;
            $product->update();
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }

    
    public function listing()
    {
       return view('product.listing');

    }
    public function listing1()
    {
        $level1 = DB::table('categories')->select('id','category')->where('level',0)->get();
        
        $level2_men = DB::table('categories')->select('id','subcategory')->where('level',1)->where('category','Men')->get();
        $level2_women = DB::table('categories')->select('id','subcategory')->where('level',1)->where('category','Women')->get();

        
        // return $level2_men;
        return view('product.listing1',compact('level1'));

    }
    
    public function form()
    {
        $seller_id = DB::table('sellers')->where('user_table_id', Auth::user()->id)->latest()->first();
        $parentid = DB::table('products')->where('seller_id',$seller_id->seller_id)->whereNotNull('parent_id')->latest()->get();
        
        $shipping_mode = $seller_id->shipping_mode;
        $brand_cnt = DB::table('brands')->where('seller_id',$seller_id->seller_id)->count();
        
        $brands = DB::table('brands')->where('seller_id',$seller_id->seller_id)->distinct()->get();
        
        $attr = DB::table('attributes')->latest()->get();
        
        $cate = request()->query('id'); 
    
        $table = DB::table('products')->where('id', $cate)->latest()->first();
        
        $cat_id = $table->category_id; 
        $subcat_id = $table->subcategory_id; 
        $subsubcat_id = $table->sub_subcategory_id; 
        $pid = $table->product_id;
        
        // return $table;

        $a = DB::table('categories')->where('id', $table->category_id)->select('category')->latest()->first();
        $b = DB::table('categories')->where('id', $table->subcategory_id)->select('subcategory')->latest()->first();
        $c = DB::table('categories')->where('id', $table->sub_subcategory_id)->select('sub_subcategory')->latest()->first();
        
        // return $b;
        
        if($b->subcategory == 'Lingerie & Sleepwear')
        {
            $size = DB::table('sizes')->where('id',5)->latest()->get();
        }
        else if($a->category == 'Kids')
        {
            $size = DB::table('sizes')->where('id',2)->latest()->get();
        }
        else if($b->subcategory == 'Bottom Wear')
        {
            $size = DB::table('sizes')->where('id',3)->latest()->get();
        }
        else if($b->subcategory == 'Footwear')
        {
            $size = DB::table('sizes')->where('id',4)->latest()->get();
        }
        else
        {
            $size = DB::table('sizes')->where('id',1)->latest()->get();
        }
        
        $cat = $a->category;
        $subcat = $b->subcategory;
        
        if($c == Null)
        {
            $subsubcat = 'NA';
        }
        else
        {
            $subsubcat = $c->sub_subcategory;
        }
        
        
        $colors = DB::table('colors')->where('level','1')->get(); // Fetch all colors from the database


        return view('product.create', compact('parentid','brand_cnt','attr', 'cat', 'subcat', 'subsubcat', 'cat_id', 'subcat_id', 'subsubcat_id','colors','size','pid','shipping_mode', 'brands'));


    }
    
    public function getSubcategories($id)
    {
        $subcategories = Category::where('parent_id', $id)->get();
        return response()->json($subcategories);
    }
    
    public function getSubSubcategories($id)
    {
        $subsubcategories = Category::where('parent_id', $id)->get();
    
        // Debugging: Check if data is returned
        if ($subsubcategories->isEmpty()) {
            return response()->json(['message' => 'No Sub-Subcategories Found']);
        }
    
        return response()->json($subsubcategories);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
   
    public function saveProductData(Request $request)
    {
       
        // Get the seller ID associated with the authenticated user
        $seller = DB::table('sellers')->where('user_table_id', Auth::id())->latest()->first();


        $lastProduct = DB::table('products')
            ->where('seller_id', $seller->seller_id)
            ->where('product_id', 'LIKE', 'OBD-PR-' . $seller->seller_id . '-%')
            ->orderBy('id', 'desc')
            ->first();
        
        // Extract last number and increment
        if ($lastProduct) {
            preg_match('/OBD-PR-' . $seller->seller_id . '-(\d+)/', $lastProduct->product_id, $matches);
            $nextNumber = isset($matches[1]) ? ((int) $matches[1] + 1) : 1001;
        } else {
            $nextNumber = 1001;
        } 
        
        // Generate unique product ID
        $product_id = 'OBD-PR-' . $seller->seller_id . '-' . $nextNumber;
        
        
    
        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller not found for this user.'
            ], 404);
        }
    
        $seller_id = $seller->seller_id; // Ensure $seller_id is available
    
        $validator = Validator::make($request->all(), [
            'file.*' => 'required|file|mimes:jpg,jpeg,png,webp',
            'category_id' => 'required|integer',
            'sub_category_id' => 'nullable|integer',
            'sub_sub_category_id' => 'nullable|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
    
        try {
            $imageUrls = [];
    
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    // Define the folder path with seller_id
                    $folderPath = "products/{$seller_id}/{$product_id}";
    
                    // Ensure the folder exists (not needed for S3, but for clarity)
                    if (!Storage::disk('s3')->exists($folderPath)) {
                        Storage::disk('s3')->makeDirectory($folderPath);
                    }
    
                    // Generate a unique filename
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    
                    // Upload the file to S3 inside the seller's folder
                    $filePath = $file->storeAs($folderPath, $fileName, 's3');
    
                    // Generate the public URL
                    $url = Storage::disk('s3')->url($filePath);
                    $imageUrls[] = $url;
                }
            }
    
            // Insert product data into the database
            $productId = DB::table('products')->insertGetId([
                'seller_id' => $seller_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->sub_category_id,
                'sub_subcategory_id' => $request->sub_sub_category_id,
                'images' => json_encode($imageUrls),
                'product_id' => $product_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Product saved successfully!',
                'product_id' => $productId
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Error saving product data: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to save product data.'
            ], 500);
        }
    }


    
    public function store(Request $request)
    {    
        
        
        // Set_type

        if(!empty($request->set_type_kurti))
        {
            $set_type = $request->set_type_kurti;
        }
        elseif(!empty($request->set_type_kurta))
        {
            $set_type = $request->set_type_kurta;
        }
        elseif(!empty($request->set_type_coord))
        {
            $set_type = $request->set_type_coord;
        }
        else{
            $set_type = null;
        }
        
        // Sleeve Length
        
        if(!empty($request->sleeve_length_1))
        {
            $sleeve_length = $request->sleeve_length_1;
        }
        
        elseif(!empty($request->sleeve_length_2))
        {
            $sleeve_length = $request->sleeve_length_2;
        }
        
        elseif(!empty($request->sleeve_length_3))
        {
            $sleeve_length = $request->sleeve_length_3;
        }
                else{
            $sleeve_length = null;
        }
        
        // Sleeve pattern
        
        if(!empty($request->sleeve_pattern_1))
        {
            $sleeve_pattern = $request->sleeve_pattern_1;
        }
        elseif(!empty($request->sleeve_pattern_2))
        {
            $sleeve_pattern = $request->sleeve_pattern_2;
        }
        elseif(!empty($request->sleeve_pattern_3))
        {
            $sleeve_pattern = $request->sleeve_pattern_3;
        }
        elseif(!empty($request->sleeve_pattern_4))
        {
            $sleeve_pattern = $request->sleeve_pattern_4;
        }
        
                        else{
            $sleeve_pattern = null;
        }
        // Closure Type 
        
        if(!empty($request->closure_type_1))
        {
            $closure_type = $request->closure_type_1;
        }
        elseif(!empty($request->closure_type_2))
        {
            $closure_type = $request->closure_type_2;
        }
        elseif(!empty($request->closure_type_3))
        {
            $closure_type = $request->closure_type_3;
        }
        elseif(!empty($request->closure_type_4))
        {
            $closure_type = $request->closure_type_4;
        }
        elseif(!empty($request->closure_type_5))
        {
            $closure_type = $request->closure_type_5;
        }
        elseif(!empty($request->closure_type_6))
        {
            $closure_type = $request->closure_type_6;
        }
        elseif(!empty($request->closure_type_7))
        {
            $closure_type = $request->closure_type_7;
        }
                                else{
            $closure_type = null;
        }
        // Work Details
        
        if(!empty($request->work_details_1))
        {
            $work_details = $request->work_details_1;
        }
        elseif(!empty($request->work_details_2))
        {
            $work_details = $request->work_details_2;
        }
        elseif(!empty($request->work_details_3))
        {
            $work_details = $request->work_details_3;
        }
                                        else{
            $work_details = null;
        }
        
        // Border Type
        
        if(!empty($request->border_type_1))
        {
            $border_type = $request->border_type_1;
        }
        elseif(!empty($request->border_type_2))
        {
            $border_type = $request->border_type_2;
        }
                                                else{
            $border_type = null;
        }
        // Bottom Type
        
        if(!empty($request->bottom_type_1))
        {
            $bottom_type = $request->bottom_type_1;
        }
        elseif(!empty($request->bottom_type_2))
        {
            $bottom_type = $request->bottom_type_2;
        }
        elseif(!empty($request->bottom_type_3))
        {
            $bottom_type = $request->bottom_type_3;
        }
                                                        else{
            $bottom_type = null;
        }
        
        // Dupatta Length
        
         if(!empty($request->dupatta_length_1))
        {
            $dupatta_length = $request->dupatta_length_1;
        }
        elseif(!empty($request->dupatta_length_2))
        {
            $dupatta_length = $request->dupatta_length_2;
        }
        elseif(!empty($request->dupatta_length_3))
        {
            $dupatta_length = $request->dupatta_length_3;
        }
                                                        else{
            $dupatta_length = null;
        }

        // Length 
        
        
        if(!empty($request->length_1))
        {
            $length = $request->length_1;
        }
        elseif(!empty($request->length_2))
        {
            $length = $request->length_2;
        }
        elseif(!empty($request->length_3))
        {
            $length = $request->length_3;
        }
        elseif(!empty($request->length_4))
        {
            $length = $request->length_4;
        }
        elseif(!empty($request->length_5))
        {
            $length = $request->length_5;
        }
        elseif(!empty($request->length_6))
        {
            $length = $request->length_6;
        }
                                                                else{
            $length = null;
        }
        // Fit Type
        
        if (!empty($request->fit_type_1)) {
            $fit_type = $request->fit_type_1;
        } elseif (!empty($request->fit_type_2)) {
            $fit_type = $request->fit_type_2;
        } elseif (!empty($request->fit_type_3)) {
            $fit_type = $request->fit_type_3;
        } elseif (!empty($request->fit_type_4)) {
            $fit_type = $request->fit_type_4;
        } elseif (!empty($request->fit_type_5)) {
            $fit_type = $request->fit_type_5;
        } elseif (!empty($request->fit_type_6)) {
            $fit_type = $request->fit_type_6;
        } elseif (!empty($request->fit_type_7)) {
            $fit_type = $request->fit_type_7;
        } elseif (!empty($request->fit_type_8)) {
            $fit_type = $request->fit_type_8;
        } elseif (!empty($request->fit_type_9)) {
            $fit_type = $request->fit_type_9;
        } elseif (!empty($request->fit_type_10)) {
            $fit_type = $request->fit_type_10;
        } elseif (!empty($request->fit_type_11)) {
            $fit_type = $request->fit_type_11;
        } elseif (!empty($request->fit_type_12)) {
            $fit_type = $request->fit_type_12;
        } elseif (!empty($request->fit_type_13)) {
            $fit_type = $request->fit_type_13;
        } elseif (!empty($request->fit_type_14)) {
            $fit_type = $request->fit_type_14;
        } elseif (!empty($request->fit_type_15)) {
            $fit_type = $request->fit_type_15;
        } elseif (!empty($request->fit_type_16)) {
            $fit_type = $request->fit_type_16;
        } elseif (!empty($request->fit_type_17)) {
            $fit_type = $request->fit_type_17;
        } elseif (!empty($request->fit_type_18)) {
            $fit_type = $request->fit_type_18;
        } elseif (!empty($request->fit_type_19)) {
            $fit_type = $request->fit_type_19;
        } elseif (!empty($request->fit_type_20)) {
            $fit_type = $request->fit_type_20;
        } elseif (!empty($request->fit_type_21)) {
            $fit_type = $request->fit_type_21;
        } elseif (!empty($request->fit_type_22)) {
            $fit_type = $request->fit_type_22;
        } elseif (!empty($request->fit_type_23)) {
            $fit_type = $request->fit_type_23;
        } elseif (!empty($request->fit_type_24)) {
            $fit_type = $request->fit_type_24;
        } elseif (!empty($request->fit_type_25)) {
            $fit_type = $request->fit_type_25;
        } elseif (!empty($request->fit_type_26)) {
            $fit_type = $request->fit_type_26;
        }
                                                                     else{
            $fit_type = null;
        }
        // Waistband Type
        
        if (!empty($request->waistband_type_1)) 
        {
            $waistband_type = $request->waistband_type_1;
        }
        elseif (!empty($request->waistband_type_2)) 
        {
            $waistband_type = $request->waistband_type_2;
        }
        elseif (!empty($request->waistband_type_3)) 
        {
            $waistband_type = $request->waistband_type_3;
        }
        elseif (!empty($request->waistband_type_4)) 
        {
            $waistband_type = $request->waistband_type_4;
        }
                                                                     else{
            $waistband_type = null;
        }
        
        // return $request;
        $color_name =  DB::table('colors')
                            ->where('color_name', $request->color_name)
                            ->latest()
                            ->first()
                            ->hex_code;
        

        $id = $request->product_id;
        
        // return $id;
        
        // Retrieve the existing product
        $product = DB::table('products')->where('id', $id)->first();
        
        
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }
    
        // Fetch existing images (if any)

        // Handle new image uploads
        $existingImages = json_decode($product->images, true) ?? [];
        
        $seller_id = $request->input('seller_id');
        $product_id = $request->pid;

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $imageUrls = [];
            foreach ($request->file('images') as $image) {
                // Define the folder path with seller_id
                $folderPath = "products/{$seller_id}/{$product_id}";
        
                // Ensure the folder exists (not needed for S3, but for clarity)
                if (!Storage::disk('s3')->exists($folderPath)) {
                    Storage::disk('s3')->makeDirectory($folderPath);
                }
        
                // Generate a unique filename
                $fileName = time() . '_' . $image->getClientOriginalName();
        
                // Upload the file to S3 inside the seller's folder
                $filePath = $image->storeAs($folderPath, $fileName, 's3');
        
                // Generate the public URL
                $url = Storage::disk('s3')->url($filePath);
                $imageUrls[] = $url;
            }
            
            // Merge existing images with new ones
            $existingImages = array_merge($existingImages, $imageUrls);
        }
                

        // Generate parent_id if needed
        $pids = DB::table('products')
            ->whereNotNull('parent_id')
            ->where('seller_user_id', Auth::id())
            ->pluck('parent_id')
            ->toArray();
    
        if (!in_array($request->parent_id, $pids)) {
            $lastProduct = DB::table('products')
                ->where('seller_user_id', Auth::id())
                ->orderBy('id', 'desc')
                ->first();
    
            $nextNumber = $lastProduct ? ((int) str_replace('OBD-' . $request->seller_id . '-' . $request->parent_id . '-', '', $lastProduct->product_id) + 1) : 1000;
            $parent_id = 'OBD-' . $request->seller_id . '-' . $request->parent_id;
        } else {
            $parent_id = $request->parent_id;
        }
    
        $seller_user_id = DB::table('sellers')->where('user_table_id', Auth::user()->id)->latest()->first();
        $seller_id_name = DB::table('sellers')->where('user_table_id', Auth::user()->id)->latest()->first();

    
        // return $request->stock_quantity;
        
        $array = json_decode($request->stock_quantity, true); // Convert JSON string to PHP array
        
        // return $array;
        if ($array === null) {
           $elementCount = 0;
        } else {
            $elementCount = count($array);
        }
        
        $brand_cnt = DB::table('brands')->where('seller_id', $seller_id)->count();
        
        if($brand_cnt==0)
        {
            $brand = 'NA';
            $bname = 0;
        }
        else
        {
            $brand = DB::table('brands')->where('brand_name', $request->input('brand_id'))->latest()->first();
            $bname = $brand->id;
        }
        
         
        //  return $elementCount;
         
        //  return $elementCount;
        //  return $brand->id;
      if ($elementCount == 0) {
          
          return redirect()->back()->with('error', 'Please Select A Valid Size');
      }
      
  
    
     else if ($elementCount == 1) {
        $data = json_decode($request->stock_quantity, true); // Decode as an associative array

    
    
    
        $bankSettlementPrice = $request->input('bank_settlement_price');
        $shippingMode = $seller_id_name->shipping_mode;
        $bankprice = 0;
    
        // return $bankSettlementPrice;
        if ($shippingMode == "In-Store") {
            
            if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
                $shipping = 131;
                $bankprice = round($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice))));
            } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
                $shipping = 180;
                $basePrice = $bankSettlementPrice + $shipping;
                $tenPercent = 0.1 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $tenPercent);
                $bankprice = round($basePrice + $tenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
                $shipping = 200;
                $basePrice = $bankSettlementPrice + $shipping;
                $fifteenPercent = 0.15 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $fifteenPercent);
                $bankprice = round($basePrice + $fifteenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
                $shipping = 220;
                $basePrice = $bankSettlementPrice + $shipping;
                $eighteenPercent = 0.18 * $basePrice;
                $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
                $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
            } elseif ($bankSettlementPrice >= 2500) {
                $shipping = 240;
                $basePrice = $bankSettlementPrice + $shipping;
                $twentyPercent = 0.2 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $twentyPercent);
                $bankprice = round($basePrice + $twentyPercent + $threePercent);
            }
        }
    
        elseif ($shippingMode == "Warehouse") {
            
            // return 'out';
            $gurantee = 35;
            $inward = 9;
            
            if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
                $shipping = 131;
                $bankprice = round($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice))));
            } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
                $shipping = 180;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $tenPercent = 0.1 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $tenPercent);
                $bankprice = round($basePrice + $tenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
                $shipping = 200;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $fifteenPercent = 0.15 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $fifteenPercent);
                $bankprice = round($basePrice + $fifteenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
                $shipping = 220;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $eighteenPercent = 0.18 * ($bankSettlementPrice + $shipping);
                $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
                $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
            } elseif ($bankSettlementPrice >= 2500) {
                $shipping = 240;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $twentyPercent = 0.2 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $twentyPercent);
                $bankprice = round($basePrice + $twentyPercent + $threePercent);
            }
        }
        
        // Update the existing row
        $data = [
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'sub_subcategory_id' => $request->input('sub_subcategory_id'),
            'product_name' => $request->input('product_name'),
            'parent_id' => $parent_id,
            'product_id' => $request->pid, // Auto-generated
            'seller_user_id' => Auth::id(),
  
            
            'description' => $request->input('description'),
            'color_name' => $color_name,
            'fabric' => $request->input('fabric'),
            'occasion' => $request->input('occasion'),
            'care_instructions' => $request->input('care_instructions'),
            'video_url' => $request->input('video_url'),
            'seller_id' => $request->input('seller_id'),
            'shipping_time' => $request->input('shipping_time'),
            'return_policy' => $request->input('return_policy'),
            'sku' => $request->input('sku'),
            'hsn' => $request->input('hsn'),
            'gst_rate' => $request->input('gst_rate'),
            'procurement_type' => $request->input('procurement_type'),
            'package_weight' => $request->input('package_weight'),
            'package_length' => $request->input('package_length'),
            'package_breadth' => $request->input('package_breadth'),
            'package_height' => $request->input('package_height'),
            'pack_of' => $request->input('pack_of'),
            'country_of_origin' => $request->input('country_of_origin'),
            'manufacturer_details' => $request->input('manufacturer_details'),
            'packer_details' => $request->input('packer_details'),
            'size_chart_id' => $request->input('size_chart_id'),
            'listing_status' => $request->input('listing_status'),
            'maximum_retail_price' => $request->input('maximum_retail_price'),
            'bank_settlement_price' => $bankSettlementPrice,
            'portal_updated_price' => $bankprice,
            'alt_text' => $request->input('alt_text'),
            'pattern' => $request->input('pattern'),
            
            'added_by' => Auth::id(),
            'updated_at' => now(),
            
            
            'images' => json_encode($existingImages),
            
            
            'size_name' => $data[0]['size'],
            'stock_quantity' => $data[0]['quantity'],
            'tryout_eligibility' => $request->tryout_eligibility,
            
            'sole_material' => $request->input('sole_material'),
            'upper_material' => $request->input('upper_material'),
            'toe_shape' => $request->input('toe_shape'),
            'heel_type' => $request->input('heel_type'),
            
                        
        
            'saree_length' => $request->saree_length,
            'blouse_fabric' => $request->blouse_fabric,
            'blouse_piece_included' => $request->blouse_piece_included,
            'blouse_length' => $request->blouse_length,
            'blouse_stiched' => $request->blouse_stiched,
            'work_details' => $work_details,
            'border_type' => $border_type,
            'weave_type' => $request->weave_type,
            'pattern' => $request->pattern,
            'gown_type' => $request->gown_type,
            'sleeve_length' => $sleeve_length,
            'sleeve_pattern' => $sleeve_pattern,
            'neck_style' => $request->neck_style,
            'closure_type' => $closure_type,
            'embellishment_details' => $request->embellishment_details,
            'lining_present' => $request->lining_present,
            'top_type' => $request->top_type,
            'hemline' => $request->hemline,
            'transparency_level' => $request->transparency_level,
            'set_type' => $set_type,
            'bottom_included' => $request->bottom_included,
            'bottom_type' => $bottom_type,
            'dupatta_fabric' => $request->dupatta_fabric,
            'dupatta_length' => $dupatta_length,
            'dupatta_shawl_type' => $request->dupatta_shawl_type,
            'length' => $length,
            'lehenga_type' => $request->lehenga_type,
            'lehenga_length' => $request->lehenga_length,
            'choli_included' => $request->choli_included,
            'choli_length' => $request->choli_length,
            'choli_sleeve_length' => $request->choli_sleeve_length,
            'dupatta_included' => $request->dupatta_included,
            'flare_type' => $request->flare_type,
            'neckline' => $request->neckline,
            'fit_type' => $fit_type,
            'tshirt_type' => $request->tshirt_type,
            'sleeve_style' => $request->sleeve_style,
            'collar_type' => $request->collar_type,
            'shirt_type' => $request->shirt_type,
            'dress_type' => $request->dress_type,
            'dress_length' => $request->dress_length,
            'top_style' => $request->top_style,
            'bottom_style' => $request->bottom_style,
            'jumpsuit_type' => $request->jumpsuit_type,
            'leg_style' => $request->leg_style,
            'shrug_type' => $request->shrug_type,
            'hoodie_type' => $request->hoodie_type,
            'hood_included' => $request->hood_included,
            'pocket_type' => $request->pocket_type,
            'jacket_type' => $request->jacket_type,
            'pocket_details' => $request->pocket_details,
            'blazer_type' => $request->blazer_type,
            'lapel_style' => $request->lapel_style,
            'playsuit_type' => $request->playsuit_type,
            'shacket_type' => $request->shacket_type,
            'waist_rise' => $request->waist_rise,
            'stretchability' => $request->stretchability,
            'distressed_non_distressed' => $request->distressed_non_distressed,
            'number_of_pockets' => $request->number_of_pockets,
            'waistband_type' => $waistband_type,
            'compression_level' => $request->compression_level,
            'pleated_non_pleated' => $request->pleated_non_pleated,
            'waist_type' => $request->waist_type,
            'cargo_type' => $request->cargo_type,

            
            
        ];
            if ($bname != 0) {
            $data['brand_id'] = $bname;
        }
        // Update the first row
        DB::table('products')->where('id', $id)->update($data);
        return redirect('/product/sellerproduct')->with('success', 'Product Added successfully.');
        
    } else {
    $first = true;

    foreach (json_decode($request->stock_quantity) as $stck) {
        
        
    
    $bankSettlementPrice = $stck->bank_settlement_price;
    $shippingMode = $seller_id_name->shipping_mode;
    $bankprice = 0;

    if ($shippingMode == "In-Store") {
        
        if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
            $shipping = 131;
            $bankprice = round($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice))));
        } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
            $shipping = 180;
            $basePrice = $bankSettlementPrice + $shipping;
            $tenPercent = 0.1 * $basePrice;
            $threePercent = 0.03 * ($basePrice + $tenPercent);
            $bankprice = round($basePrice + $tenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
            $shipping = 200;
            $basePrice = $bankSettlementPrice + $shipping;
            $fifteenPercent = 0.15 * $basePrice;
            $threePercent = 0.03 * ($basePrice + $fifteenPercent);
            $bankprice = round($basePrice + $fifteenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
            $shipping = 220;
            $basePrice = $bankSettlementPrice + $shipping;
            $eighteenPercent = 0.18 * $basePrice;
            $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
            $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
        } elseif ($bankSettlementPrice >= 2500) {
            $shipping = 240;
            $basePrice = $bankSettlementPrice + $shipping;
            $twentyPercent = 0.2 * $basePrice;
            $threePercent = 0.03 * ($basePrice + $twentyPercent);
            $bankprice = round($basePrice + $twentyPercent + $threePercent);
        }
    }

    elseif ($shippingMode == "Warehouse") {
        
        // return 'out';
        $gurantee = 35;
        $inward = 9;
        
        if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
            $shipping = 131;
            $bankprice = round($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice))));
        } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
            $shipping = 180;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $tenPercent = 0.1 * ($bankSettlementPrice + $shipping);
            $threePercent = 0.03 * ($basePrice + $tenPercent);
            $bankprice = round($basePrice + $tenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
            $shipping = 200;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $fifteenPercent = 0.15 * ($bankSettlementPrice + $shipping);
            $threePercent = 0.03 * ($basePrice + $fifteenPercent);
            $bankprice = round($basePrice + $fifteenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
            $shipping = 220;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $eighteenPercent = 0.18 * ($bankSettlementPrice + $shipping);
            $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
            $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
        } elseif ($bankSettlementPrice >= 2500) {
            $shipping = 240;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $twentyPercent = 0.2 * ($bankSettlementPrice + $shipping);
            $threePercent = 0.03 * ($basePrice + $twentyPercent);
            $bankprice = round($basePrice + $twentyPercent + $threePercent);
        }
    }
        
        $data = [
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'sub_subcategory_id' => $request->input('sub_subcategory_id'),
            'product_name' => $request->input('product_name'),
            'product_id' => $request->pid, // Auto-generated
            'seller_user_id' => Auth::id(),
            'parent_id' => $parent_id,
          
            'description' => $request->input('description'),
            'size_name' => $stck->size,
            'stock_quantity' => $stck->quantity,
            'color_name' => $color_name,
            'fabric' => $request->input('fabric'),
            'occasion' => $request->input('occasion'),
            'care_instructions' => $request->input('care_instructions'),
            'video_url' => $request->input('video_url'),
            'seller_id' => $request->input('seller_id'),
            'shipping_time' => $request->input('shipping_time'),
            'return_policy' => $request->input('return_policy'),
            'sku' => $stck->sku,
            'hsn' => $request->input('hsn'),
            'gst_rate' => $request->input('gst_rate'),
            'procurement_type' => $request->input('procurement_type'),
            'package_weight' => $request->input('package_weight'),
            'package_length' => $request->input('package_length'),
            'package_breadth' => $request->input('package_breadth'),
            'package_height' => $request->input('package_height'),
            'pack_of' => $request->input('pack_of'),
            'country_of_origin' => $request->input('country_of_origin'),
            'manufacturer_details' => $request->input('manufacturer_details'),
            'packer_details' => $request->input('packer_details'),
            'size_chart_id' => $request->input('size_chart_id'),
            'listing_status' => $request->input('listing_status'),
            'maximum_retail_price' => $stck->maximum_retail_price,
            'bank_settlement_price' => $stck->bank_settlement_price,
            'portal_updated_price' => $bankprice,
            'alt_text' => $request->input('alt_text'),
            'pattern' => $request->input('pattern'),
            
            'added_by' => Auth::id(),
            'images' => json_encode($existingImages),
            'tryout_eligibility' => $request->tryout_eligibility,
            'sole_material' => $request->input('sole_material'),
            'upper_material' => $request->input('upper_material'),
          
            'toe_shape' => $request->input('toe_shape'),
            'heel_type' => $request->input('heel_type'),
            
                        
        
            'saree_length' => $request->saree_length,
            'blouse_fabric' => $request->blouse_fabric,
            'blouse_piece_included' => $request->blouse_piece_included,
            'blouse_length' => $request->blouse_length,
            'blouse_stiched' => $request->blouse_stiched,
            'work_details' => $work_details,
            'border_type' => $border_type,
            'weave_type' => $request->weave_type,
            'pattern' => $request->pattern,
            'gown_type' => $request->gown_type,
            'sleeve_length' => $sleeve_length,
            'sleeve_pattern' => $sleeve_pattern,
            'neck_style' => $request->neck_style,
            'closure_type' => $closure_type,
            'embellishment_details' => $request->embellishment_details,
            'lining_present' => $request->lining_present,
            'top_type' => $request->top_type,
            'hemline' => $request->hemline,
            'transparency_level' => $request->transparency_level,
            'set_type' => $set_type,
            'bottom_included' => $request->bottom_included,
            'bottom_type' => $bottom_type,
            'dupatta_fabric' => $request->dupatta_fabric,
            'dupatta_length' => $dupatta_length,
            'dupatta_shawl_type' => $request->dupatta_shawl_type,
            'length' => $length,
            'lehenga_type' => $request->lehenga_type,
            'lehenga_length' => $request->lehenga_length,
            'choli_included' => $request->choli_included,
            'choli_length' => $request->choli_length,
            'choli_sleeve_length' => $request->choli_sleeve_length,
            'dupatta_included' => $request->dupatta_included,
            'flare_type' => $request->flare_type,
            'neckline' => $request->neckline,
            'fit_type' => $fit_type,
            'tshirt_type' => $request->tshirt_type,
            'sleeve_style' => $request->sleeve_style,
            'collar_type' => $request->collar_type,
            'shirt_type' => $request->shirt_type,
            'dress_type' => $request->dress_type,
            'dress_length' => $request->dress_length,
            'top_style' => $request->top_style,
            'bottom_style' => $request->bottom_style,
            'jumpsuit_type' => $request->jumpsuit_type,
            'leg_style' => $request->leg_style,
            'shrug_type' => $request->shrug_type,
            'hoodie_type' => $request->hoodie_type,
            'hood_included' => $request->hood_included,
            'pocket_type' => $request->pocket_type,
            'jacket_type' => $request->jacket_type,
            'pocket_details' => $request->pocket_details,
            'blazer_type' => $request->blazer_type,
            'lapel_style' => $request->lapel_style,
            'playsuit_type' => $request->playsuit_type,
            'shacket_type' => $request->shacket_type,
            'waist_rise' => $request->waist_rise,
            'stretchability' => $request->stretchability,
            'distressed_non_distressed' => $request->distressed_non_distressed,
            'number_of_pockets' => $request->number_of_pockets,
            'waistband_type' => $waistband_type,
            'compression_level' => $request->compression_level,
            'pleated_non_pleated' => $request->pleated_non_pleated,
            'waist_type' => $request->waist_type,
            'cargo_type' => $request->cargo_type,

            
            
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        if ($bname != 0) {
            $data['brand_id'] = $bname;
        }
        if ($first) {
            // Update the first row
            DB::table('products')->where('id', $id)->update($data);
            $first = false;
        } else {
            // Insert remaining rows as new entries
            DB::table('products')->insert($data);
        }
    }

    // Redirect after processing all items
    return redirect('/product/sellerproduct')->with('success', 'Product Added successfully.');

    }

    
   
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
      
        $seller_id = DB::table('sellers')->where('user_table_id', Auth::user()->id)->latest()->first();
       
        $parentid = DB::table('products')->where('seller_id', $seller_id->seller_id)->whereNotNull('parent_id')->latest()->get();
        
         $shipping_mode = $seller_id->shipping_mode;
        // $brand_cnt = DB::table('brands')->where('seller_id', $seller_id->seller_id)->count();
        
        $brand_cnt = DB::table('brands')->where('seller_id', $seller_id->seller_id)->select('brand_name')->latest()->first();
        $brand_cnt1 = DB::table('brands')->where('seller_id', $seller_id->seller_id)->select('brand_name')->count();

        
        
        $attr = DB::table('attributes')->latest()->get();
        
        $cat_id = $product->category_id; 
        $subcat_id = $product->subcategory_id; 
        $subsubcat_id = $product->sub_subcategory_id; 
         
        $a = DB::table('categories')->where('id', $product->category_id )->select('category')->latest()->first();
        $b = DB::table('categories')->where('id', $product->subcategory_id )->select('subcategory')->latest()->first();
        $c = DB::table('categories')->where('id', $product->sub_subcategory_id )->select('sub_subcategory')->latest()->first();
        
        $cat = $a->category;
        $subcat = $b->subcategory;
        
        if($c == Null)
        {
            $subsubcat = 'NA';
        }
        else
        {
            $subsubcat = $c->sub_subcategory;
        }
        
        
        $obtained = DB::table('products')->where('color_name',$product->color_name)->where('parent_id',$product->parent_id)->pluck('size_name')->toArray();
        
        if($b->subcategory == 'Lingerie & Sleepwear')
        {
            $size = DB::table('sizes')->where('id',5)->latest()->get();
        }
        else if($a->category == 'Kids')
        {
            $size = DB::table('sizes')->where('id',2)->latest()->get();
        }
        else if($b->subcategory == 'Bottom Wear')
        {
            $size = DB::table('sizes')->where('id',3)->latest()->get();
        }
        else if($b->subcategory == 'Footwear')
        {
            $size = DB::table('sizes')->where('id',4)->latest()->get();
        }
        else
        {
            $size = DB::table('sizes')->where('id',1)->latest()->get();
        }
        
        $colors = DB::table('colors')->where('level','1')->get(); // Fetch all colors from the database
        
         // Find the color name by matching the hex_code
        $colorInfo = DB::table('colors')->where('hex_code', $product->color_name)->first();
        
        // Prepare variables for the view
        $currentColorName = $colorInfo ? $colorInfo->color_name : '--Select a Color--';
        $currentColorHex = $product->color_name; 
        
        // return $product;
        
        return view('product.edit', compact('product', 'currentColorName', 'currentColorHex', 'shipping_mode', 'seller_id', 'attr', 'parentid','brand_cnt', 'cat', 'subcat', 'subsubcat','brand_cnt1', 'cat_id', 'subcat_id', 'subsubcat_id','colors','size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        
        
            if (!empty($request->set_type_kurti)) {
                $set_type = $request->set_type_kurti;
            } elseif (!empty($request->set_type_kurta)) {
                $set_type = $request->set_type_kurta;
            } elseif (!empty($request->set_type_coord)) {
                $set_type = $request->set_type_coord;
            } else 
            {
                $set_type = null; // or any default value like 'N/A', 'None', etc.
            }
            
            // Sleeve Length
            
            if(!empty($request->sleeve_length_1))
            {
                $sleeve_length = $request->sleeve_length_1;
            }
            
            elseif(!empty($request->sleeve_length_2))
            {
                $sleeve_length = $request->sleeve_length_2;
            }
            
            elseif(!empty($request->sleeve_length_3))
            {
                $sleeve_length = $request->sleeve_length_3;
            }
            else 
            {
                $sleeve_length = null; // or any default value like 'N/A', 'None', etc.
            }
            
            
            // Sleeve pattern
            
            if(!empty($request->sleeve_pattern_1))
            {
                $sleeve_pattern = $request->sleeve_pattern_1;
            }
            elseif(!empty($request->sleeve_pattern_2))
            {
                $sleeve_pattern = $request->sleeve_pattern_2;
            }
            elseif(!empty($request->sleeve_pattern_3))
            {
                $sleeve_pattern = $request->sleeve_pattern_3;
            }
            elseif(!empty($request->sleeve_pattern_4))
            {
                $sleeve_pattern = $request->sleeve_pattern_4;
            }
            else 
            {
                $sleeve_pattern = null; // or any default value like 'N/A', 'None', etc.
            }
            
            // Closure Type 
            
            if(!empty($request->closure_type_1))
            {
                $closure_type = $request->closure_type_1;
            }
            elseif(!empty($request->closure_type_2))
            {
                $closure_type = $request->closure_type_2;
            }
            elseif(!empty($request->closure_type_3))
            {
                $closure_type = $request->closure_type_3;
            }
            elseif(!empty($request->closure_type_4))
            {
                $closure_type = $request->closure_type_4;
            }
            elseif(!empty($request->closure_type_5))
            {
                $closure_type = $request->closure_type_5;
            }
            elseif(!empty($request->closure_type_6))
            {
                $closure_type = $request->closure_type_6;
            }
            elseif(!empty($request->closure_type_7))
            {
                $closure_type = $request->closure_type_7;
            }
            else 
            {
                $closure_type = null; // or any default value like 'N/A', 'None', etc.
            }
            
            // Work Details
            
            if(!empty($request->work_details_1))
            {
                $work_details = $request->work_details_1;
            }
            elseif(!empty($request->work_details_2))
            {
                $work_details = $request->work_details_2;
            }
            elseif(!empty($request->work_details_3))
            {
                $work_details = $request->work_details_3;
            }
            else 
            {
                $work_details = null; // or any default value like 'N/A', 'None', etc.
            }
            
            
            // Border Type
            
            if(!empty($request->border_type_1))
            {
                $border_type = $request->border_type_1;
            }
            elseif(!empty($request->border_type_2))
            {
                $border_type = $request->border_type_2;
            }
            else 
            {
                $border_type = null; // or any default value like 'N/A', 'None', etc.
            }
            
            // Bottom Type
            
            if(!empty($request->bottom_type_1))
            {
                $bottom_type = $request->bottom_type_1;
            }
            elseif(!empty($request->bottom_type_2))
            {
                $bottom_type = $request->bottom_type_2;
            }
            elseif(!empty($request->bottom_type_3))
            {
                $bottom_type = $request->bottom_type_3;
            }
            else 
            {
                $bottom_type = null; // or any default value like 'N/A', 'None', etc.
            }
            
            // Dupatta Length
            
             if(!empty($request->dupatta_length_1))
            {
                $dupatta_length = $request->dupatta_length_1;
            }
            elseif(!empty($request->dupatta_length_2))
            {
                $dupatta_length = $request->dupatta_length_2;
            }
            elseif(!empty($request->dupatta_length_3))
            {
                $dupatta_length = $request->dupatta_length_3;
            }
            else 
            {
                $dupatta_length = null; // or any default value like 'N/A', 'None', etc.
            }
            
            // Length 
            
            
            if(!empty($request->length_1))
            {
                $length = $request->length_1;
            }
            elseif(!empty($request->length_2))
            {
                $length = $request->length_2;
            }
            elseif(!empty($request->length_3))
            {
                $length = $request->length_3;
            }
            elseif(!empty($request->length_4))
            {
                $length = $request->length_4;
            }
            elseif(!empty($request->length_5))
            {
                $length = $request->length_5;
            }
            elseif(!empty($request->length_6))
            {
                $length = $request->length_6;
            }
            else 
            {
                $length = null; // or any default value like 'N/A', 'None', etc.
            }
            // Fit Type
            
            if (!empty($request->fit_type_1)) {
                $fit_type = $request->fit_type_1;
            } elseif (!empty($request->fit_type_2)) {
                $fit_type = $request->fit_type_2;
            } elseif (!empty($request->fit_type_3)) {
                $fit_type = $request->fit_type_3;
            } elseif (!empty($request->fit_type_4)) {
                $fit_type = $request->fit_type_4;
            } elseif (!empty($request->fit_type_5)) {
                $fit_type = $request->fit_type_5;
            } elseif (!empty($request->fit_type_6)) {
                $fit_type = $request->fit_type_6;
            } elseif (!empty($request->fit_type_7)) {
                $fit_type = $request->fit_type_7;
            } elseif (!empty($request->fit_type_8)) {
                $fit_type = $request->fit_type_8;
            } elseif (!empty($request->fit_type_9)) {
                $fit_type = $request->fit_type_9;
            } elseif (!empty($request->fit_type_10)) {
                $fit_type = $request->fit_type_10;
            } elseif (!empty($request->fit_type_11)) {
                $fit_type = $request->fit_type_11;
            } elseif (!empty($request->fit_type_12)) {
                $fit_type = $request->fit_type_12;
            } elseif (!empty($request->fit_type_13)) {
                $fit_type = $request->fit_type_13;
            } elseif (!empty($request->fit_type_14)) {
                $fit_type = $request->fit_type_14;
            } elseif (!empty($request->fit_type_15)) {
                $fit_type = $request->fit_type_15;
            } elseif (!empty($request->fit_type_16)) {
                $fit_type = $request->fit_type_16;
            } elseif (!empty($request->fit_type_17)) {
                $fit_type = $request->fit_type_17;
            } elseif (!empty($request->fit_type_18)) {
                $fit_type = $request->fit_type_18;
            } elseif (!empty($request->fit_type_19)) {
                $fit_type = $request->fit_type_19;
            } elseif (!empty($request->fit_type_20)) {
                $fit_type = $request->fit_type_20;
            } elseif (!empty($request->fit_type_21)) {
                $fit_type = $request->fit_type_21;
            } elseif (!empty($request->fit_type_22)) {
                $fit_type = $request->fit_type_22;
            } elseif (!empty($request->fit_type_23)) {
                $fit_type = $request->fit_type_23;
            } elseif (!empty($request->fit_type_24)) {
                $fit_type = $request->fit_type_24;
            } elseif (!empty($request->fit_type_25)) {
                $fit_type = $request->fit_type_25;
            } elseif (!empty($request->fit_type_26)) {
                $fit_type = $request->fit_type_26;
            }
            else 
            {
                $fit_type = null; // or any default value like 'N/A', 'None', etc.
            }
            // Waistband Type
            
            if (!empty($request->waistband_type_1)) 
            {
                $waistband_type = $request->waistband_type_1;
            }
            elseif (!empty($request->waistband_type_2)) 
            {
                $waistband_type = $request->waistband_type_2;
            }
            elseif (!empty($request->waistband_type_3)) 
            {
                $waistband_type = $request->waistband_type_3;
            }
            elseif (!empty($request->waistband_type_4)) 
            {
                $waistband_type = $request->waistband_type_4;
            }
            else 
            {
                $waistband_type = null; // or any default value like 'N/A', 'None', etc.
            }
        
        
        
        // return $request;
        $color_name =  DB::table('colors')
                            ->where('color_name', $request->color_name)
                            ->latest()
                            ->first()
                            ->hex_code;
        

    // Retrieve the existing product
      $product = DB::table('products')->where('id', $id)->first();
    
    if (!$product) {
        return redirect()->back()->with('error', 'Product not found');
    }

     // Fetch existing images (if any)

    // Handle new image uploads
    $existingImages = json_decode($product->images, true) ?? [];
    
    $seller_id = $request->input('seller_id');
    $product_id = $request->pid;

    // Handle new image uploads
    if ($request->hasFile('images')) {
        $imageUrls = [];
        foreach ($request->file('images') as $image) {
            // Define the folder path with seller_id
            $folderPath = "products/{$seller_id}/{$product_id}";
    
            // Ensure the folder exists (not needed for S3, but for clarity)
            if (!Storage::disk('s3')->exists($folderPath)) {
                Storage::disk('s3')->makeDirectory($folderPath);
            }
    
            // Generate a unique filename
            $fileName = time() . '_' . $image->getClientOriginalName();
    
            // Upload the file to S3 inside the seller's folder
            $filePath = $image->storeAs($folderPath, $fileName, 's3');
    
            // Generate the public URL
            $url = Storage::disk('s3')->url($filePath);
            $imageUrls[] = $url;
        }
        
        // Merge existing images with new ones
        $existingImages = array_merge($existingImages, $imageUrls);
    }

    // return $existingImages;
    // Generate parent_id if needed
    $pids = DB::table('products')
        ->whereNotNull('parent_id')
        ->where('seller_user_id', Auth::id())
        ->pluck('parent_id')
        ->toArray();

    if (!in_array($request->parent_id, $pids)) {
        $lastProduct = DB::table('products')
            ->where('seller_user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastProduct ? ((int) str_replace('OBD-' . $request->seller_id . '-' . $request->parent_id . '-', '', $lastProduct->product_id) + 1) : 1000;
        $parent_id = 'OBD-' . $request->seller_id . '-' . $request->parent_id;
    } else {
        $parent_id = $request->parent_id;
    }
    
    // return  $parent_id;
         $array = json_decode($request->stock_quantity, true); // Convert JSON string to PHP array
        
        // return $array;
        if ($array === null) {
           $elementCount = 0;
        } else {
            $elementCount = count($array);
        }
          
        $brand_cnt = DB::table('brands')->where('seller_id', $seller_id)->count();
        
        if($brand_cnt==0)
        {
            $brand = 'NA';
            $bname = 0;
        }
        else
        {
            $brand = DB::table('brands')->where('brand_name', $request->input('brand_id'))->latest()->first();
            $bname = $brand->id;
        }
        
         
        //  return $elementCount;
         
        //  return $elementCount;
        //  return $brand->id;
        $seller_id_name = DB::table('sellers')->where('user_table_id', Auth::user()->id)->latest()->first();

    //   return $request;
    // return $elementCount;
      if ($elementCount == 0) {
          
        $data = json_decode($request->stock_quantity, true); // Decode as an associative array

    
        $bankSettlementPrice = $request->input('bank_settlement_price');
        $shippingMode = $seller_id_name->shipping_mode;
        $bankprice = 0;
    
        // return $bankSettlementPrice;
        if ($shippingMode == "In-Store") {
            
            if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
                $shipping = 131;
                $bankprice = round($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice))));
            } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
                $shipping = 180;
                $basePrice = $bankSettlementPrice + $shipping;
                $tenPercent = 0.1 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $tenPercent);
                $bankprice = round($basePrice + $tenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
                $shipping = 200;
                $basePrice = $bankSettlementPrice + $shipping;
                $fifteenPercent = 0.15 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $fifteenPercent);
                $bankprice = round($basePrice + $fifteenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
                $shipping = 220;
                $basePrice = $bankSettlementPrice + $shipping;
                $eighteenPercent = 0.18 * $basePrice;
                $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
                $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
            } elseif ($bankSettlementPrice >= 2500) {
                $shipping = 240;
                $basePrice = $bankSettlementPrice + $shipping;
                $twentyPercent = 0.2 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $twentyPercent);
                $bankprice = round($basePrice + $twentyPercent + $threePercent);
            }
        }
    
        elseif ($shippingMode == "Warehouse") {
            
            // return 'out';
            $gurantee = 35;
            $inward = 9;
            
            if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
                $shipping = 131;
                $bankprice = round($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice))));
            } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
                $shipping = 180;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $tenPercent = 0.1 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $tenPercent);
                $bankprice = round($basePrice + $tenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
                $shipping = 200;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $fifteenPercent = 0.15 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $fifteenPercent);
                $bankprice = round($basePrice + $fifteenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
                $shipping = 220;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $eighteenPercent = 0.18 * ($bankSettlementPrice + $shipping);
                $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
                $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
            } elseif ($bankSettlementPrice >= 2500) {
                $shipping = 240;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $twentyPercent = 0.2 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $twentyPercent);
                $bankprice = round($basePrice + $twentyPercent + $threePercent);
            }
        }
        
        // Update the existing row
        $data = [
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'sub_subcategory_id' => $request->input('sub_subcategory_id'),
            'product_name' => $request->input('product_name'),
            'parent_id' => $parent_id,
            'product_id' => $request->pid, // Auto-generated
            'seller_user_id' => Auth::id(),
            
            'description' => $request->input('description'),
            'color_name' => $color_name,
            'fabric' => $request->input('fabric'),
            'occasion' => $request->input('occasion'),
            'care_instructions' => $request->input('care_instructions'),
            'video_url' => $request->input('video_url'),
            'seller_id' => $request->input('seller_id'),
            'shipping_time' => $request->input('shipping_time'),
            'return_policy' => $request->input('return_policy'),
            'sku' => $request->input('sku'),
            'hsn' => $request->input('hsn'),
            'gst_rate' => $request->input('gst_rate'),
            'procurement_type' => $request->input('procurement_type'),
            'package_weight' => $request->input('package_weight'),
            'package_length' => $request->input('package_length'),
            'package_breadth' => $request->input('package_breadth'),
            'package_height' => $request->input('package_height'),
            'pack_of' => $request->input('pack_of'),
            'country_of_origin' => $request->input('country_of_origin'),
            'manufacturer_details' => $request->input('manufacturer_details'),
            'packer_details' => $request->input('packer_details'),
            'size_chart_id' => $request->input('size_chart_id'),
            'listing_status' => $request->input('listing_status'),
            'maximum_retail_price' => $request->input('maximum_retail_price'),
            'bank_settlement_price' => $bankSettlementPrice,
            'portal_updated_price' => $bankprice,
            'alt_text' => $request->input('alt_text'),
            'pattern' => $request->input('pattern'),
            
            'added_by' => Auth::id(),
            'updated_at' => now(),
            
            
            'images' => json_encode($existingImages),
            
            
            'size_name' => $request->size,
            'stock_quantity' => $request->quantity,
            'tryout_eligibility' => 'YES',
            
            'sole_material' => $request->input('sole_material'),
            'upper_material' => $request->input('upper_material'),
           
            'toe_shape' => $request->input('toe_shape'),
            'heel_type' => $request->input('heel_type'),
            
        
            'saree_length' => $request->saree_length,
            'blouse_fabric' => $request->blouse_fabric,
            'blouse_piece_included' => $request->blouse_piece_included,
            'blouse_length' => $request->blouse_length,
            'blouse_stiched' => $request->blouse_stiched,
            'work_details' => $work_details,
            'border_type' => $border_type,
            'weave_type' => $request->weave_type,
            'pattern' => $request->pattern,
            'gown_type' => $request->gown_type,
            'sleeve_length' => $sleeve_length,
            'sleeve_pattern' => $sleeve_pattern,
            'neck_style' => $request->neck_style,
            'closure_type' => $closure_type,
            'embellishment_details' => $request->embellishment_details,
            'lining_present' => $request->lining_present,
            'top_type' => $request->top_type,
            'hemline' => $request->hemline,
            'transparency_level' => $request->transparency_level,
            'set_type' => $set_type,
            'bottom_included' => $request->bottom_included,
            'bottom_type' => $bottom_type,
            'dupatta_fabric' => $request->dupatta_fabric,
            'dupatta_length' => $dupatta_length,
            'dupatta_shawl_type' => $request->dupatta_shawl_type,
            'length' => $length,
            'lehenga_type' => $request->lehenga_type,
            'lehenga_length' => $request->lehenga_length,
            'choli_included' => $request->choli_included,
            'choli_length' => $request->choli_length,
            'choli_sleeve_length' => $request->choli_sleeve_length,
            'dupatta_included' => $request->dupatta_included,
            'flare_type' => $request->flare_type,
            'neckline' => $request->neckline,
            'fit_type' => $fit_type,
            'tshirt_type' => $request->tshirt_type,
            'sleeve_style' => $request->sleeve_style,
            'collar_type' => $request->collar_type,
            'shirt_type' => $request->shirt_type,
            'dress_type' => $request->dress_type,
            'dress_length' => $request->dress_length,
            'top_style' => $request->top_style,
            'bottom_style' => $request->bottom_style,
            'jumpsuit_type' => $request->jumpsuit_type,
            'leg_style' => $request->leg_style,
            'shrug_type' => $request->shrug_type,
            'hoodie_type' => $request->hoodie_type,
            'hood_included' => $request->hood_included,
            'pocket_type' => $request->pocket_type,
            'jacket_type' => $request->jacket_type,
            'pocket_details' => $request->pocket_details,
            'blazer_type' => $request->blazer_type,
            'lapel_style' => $request->lapel_style,
            'playsuit_type' => $request->playsuit_type,
            'shacket_type' => $request->shacket_type,
            'waist_rise' => $request->waist_rise,
            'stretchability' => $request->stretchability,
            'distressed_non_distressed' => $request->distressed_non_distressed,
            'number_of_pockets' => $request->number_of_pockets,
            'waistband_type' => $waistband_type,
            'compression_level' => $request->compression_level,
            'pleated_non_pleated' => $request->pleated_non_pleated,
            'waist_type' => $request->waist_type,
            'cargo_type' => $request->cargo_type,

            
        ];
        if ($bname != 0) {
            $data['brand_id'] = $bname;
        }
        // Update the first row
        DB::table('products')->where('id', $id)->update($data);
        return redirect('/product/sellerproduct')->with('success', 'Product Added successfully.');      }
      
  
    
     else if ($elementCount == 1) {
        $data = json_decode($request->stock_quantity, true); // Decode as an associative array

    
        $bankSettlementPrice = $request->input('bank_settlement_price');
        $shippingMode = $seller_id_name->shipping_mode;
        $bankprice = 0;
    
        // return $bankSettlementPrice;
        if ($shippingMode == "In-Store") {
            
            if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
                $shipping = 131;
                $bankprice = round($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice))));
            } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
                $shipping = 180;
                $basePrice = $bankSettlementPrice + $shipping;
                $tenPercent = 0.1 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $tenPercent);
                $bankprice = round($basePrice + $tenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
                $shipping = 200;
                $basePrice = $bankSettlementPrice + $shipping;
                $fifteenPercent = 0.15 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $fifteenPercent);
                $bankprice = round($basePrice + $fifteenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
                $shipping = 220;
                $basePrice = $bankSettlementPrice + $shipping;
                $eighteenPercent = 0.18 * $basePrice;
                $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
                $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
            } elseif ($bankSettlementPrice >= 2500) {
                $shipping = 240;
                $basePrice = $bankSettlementPrice + $shipping;
                $twentyPercent = 0.2 * $basePrice;
                $threePercent = 0.03 * ($basePrice + $twentyPercent);
                $bankprice = round($basePrice + $twentyPercent + $threePercent);
            }
        }
    
        elseif ($shippingMode == "Warehouse") {
            
            // return 'out';
            $gurantee = 35;
            $inward = 9;
            
            if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
                $shipping = 131;
                $bankprice = round($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice))));
            } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
                $shipping = 180;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $tenPercent = 0.1 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $tenPercent);
                $bankprice = round($basePrice + $tenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
                $shipping = 200;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $fifteenPercent = 0.15 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $fifteenPercent);
                $bankprice = round($basePrice + $fifteenPercent + $threePercent);
            } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
                $shipping = 220;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $eighteenPercent = 0.18 * ($bankSettlementPrice + $shipping);
                $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
                $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
            } elseif ($bankSettlementPrice >= 2500) {
                $shipping = 240;
                $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
                $twentyPercent = 0.2 * ($bankSettlementPrice + $shipping);
                $threePercent = 0.03 * ($basePrice + $twentyPercent);
                $bankprice = round($basePrice + $twentyPercent + $threePercent);
            }
        }
        
        // Update the existing row
        $data = [
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'sub_subcategory_id' => $request->input('sub_subcategory_id'),
            'product_name' => $request->input('product_name'),
            'parent_id' => $parent_id,
            'product_id' => $request->pid, // Auto-generated
            'seller_user_id' => Auth::id(),
            
            'description' => $request->input('description'),
            'color_name' => $color_name,
            'fabric' => $request->input('fabric'),
            'occasion' => $request->input('occasion'),
            'care_instructions' => $request->input('care_instructions'),
            'video_url' => $request->input('video_url'),
            'seller_id' => $request->input('seller_id'),
            'shipping_time' => $request->input('shipping_time'),
            'return_policy' => $request->input('return_policy'),
            'sku' => $request->input('sku'),
            'hsn' => $request->input('hsn'),
            'gst_rate' => $request->input('gst_rate'),
            'procurement_type' => $request->input('procurement_type'),
            'package_weight' => $request->input('package_weight'),
            'package_length' => $request->input('package_length'),
            'package_breadth' => $request->input('package_breadth'),
            'package_height' => $request->input('package_height'),
            'pack_of' => $request->input('pack_of'),
            'country_of_origin' => $request->input('country_of_origin'),
            'manufacturer_details' => $request->input('manufacturer_details'),
            'packer_details' => $request->input('packer_details'),
            'size_chart_id' => $request->input('size_chart_id'),
            'listing_status' => $request->input('listing_status'),
            'maximum_retail_price' => $request->input('maximum_retail_price'),
            'bank_settlement_price' => $bankSettlementPrice,
            'portal_updated_price' => $bankprice,
            'alt_text' => $request->input('alt_text'),
            'pattern' => $request->input('pattern'),
            
            'added_by' => Auth::id(),
            'updated_at' => now(),
            
            
            'images' => json_encode($existingImages),
            
            
            'size_name' => $data[0]['size'],
            'stock_quantity' => $data[0]['quantity'],
            'tryout_eligibility' => $request->tryout_eligibility,
            
            'sole_material' => $request->input('sole_material'),
            'upper_material' => $request->input('upper_material'),

            'toe_shape' => $request->input('toe_shape'),
            'heel_type' => $request->input('heel_type'),
            
            
            'saree_length' => $request->saree_length,
            'blouse_fabric' => $request->blouse_fabric,
            'blouse_piece_included' => $request->blouse_piece_included,
            'blouse_length' => $request->blouse_length,
            'blouse_stiched' => $request->blouse_stiched,
            'work_details' => $work_details,
            'border_type' => $border_type,
            'weave_type' => $request->weave_type,
            'pattern' => $request->pattern,
            'gown_type' => $request->gown_type,
            'sleeve_length' => $sleeve_length,
            'sleeve_pattern' => $sleeve_pattern,
            'neck_style' => $request->neck_style,
            'closure_type' => $closure_type,
            'embellishment_details' => $request->embellishment_details,
            'lining_present' => $request->lining_present,
            'top_type' => $request->top_type,
            'hemline' => $request->hemline,
            'transparency_level' => $request->transparency_level,
            'set_type' => $set_type,
            'bottom_included' => $request->bottom_included,
            'bottom_type' => $bottom_type,
            'dupatta_fabric' => $request->dupatta_fabric,
            'dupatta_length' => $dupatta_length,
            'dupatta_shawl_type' => $request->dupatta_shawl_type,
            'length' => $length,
            'lehenga_type' => $request->lehenga_type,
            'lehenga_length' => $request->lehenga_length,
            'choli_included' => $request->choli_included,
            'choli_length' => $request->choli_length,
            'choli_sleeve_length' => $request->choli_sleeve_length,
            'dupatta_included' => $request->dupatta_included,
            'flare_type' => $request->flare_type,
            'neckline' => $request->neckline,
            'fit_type' => $fit_type,
            'tshirt_type' => $request->tshirt_type,
            'sleeve_style' => $request->sleeve_style,
            'collar_type' => $request->collar_type,
            'shirt_type' => $request->shirt_type,
            'dress_type' => $request->dress_type,
            'dress_length' => $request->dress_length,
            'top_style' => $request->top_style,
            'bottom_style' => $request->bottom_style,
            'jumpsuit_type' => $request->jumpsuit_type,
            'leg_style' => $request->leg_style,
            'shrug_type' => $request->shrug_type,
            'hoodie_type' => $request->hoodie_type,
            'hood_included' => $request->hood_included,
            'pocket_type' => $request->pocket_type,
            'jacket_type' => $request->jacket_type,
            'pocket_details' => $request->pocket_details,
            'blazer_type' => $request->blazer_type,
            'lapel_style' => $request->lapel_style,
            'playsuit_type' => $request->playsuit_type,
            'shacket_type' => $request->shacket_type,
            'waist_rise' => $request->waist_rise,
            'stretchability' => $request->stretchability,
            'distressed_non_distressed' => $request->distressed_non_distressed,
            'number_of_pockets' => $request->number_of_pockets,
            'waistband_type' => $waistband_type,
            'compression_level' => $request->compression_level,
            'pleated_non_pleated' => $request->pleated_non_pleated,
            'waist_type' => $request->waist_type,
            'cargo_type' => $request->cargo_type,

            
        ];
        if ($bname != 0) {
            $data['brand_id'] = $bname;
        }
        // Update the first row
        DB::table('products')->where('id', $id)->update($data);
        return redirect('/product/sellerproduct')->with('success', 'Product Added successfully.');
        
    } else {
    $first = true;

    foreach (json_decode($request->stock_quantity) as $stck) {
        
        
    
    $bankSettlementPrice = $stck->bank_settlement_price;
    $shippingMode = $seller_id_name->shipping_mode;
    $bankprice = 0;

    if ($shippingMode == "In-Store") {
        
        if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
            $shipping = 131;
            $bankprice = round($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + (0.05 * $bankSettlementPrice))));
        } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
            $shipping = 180;
            $basePrice = $bankSettlementPrice + $shipping;
            $tenPercent = 0.1 * $basePrice;
            $threePercent = 0.03 * ($basePrice + $tenPercent);
            $bankprice = round($basePrice + $tenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
            $shipping = 200;
            $basePrice = $bankSettlementPrice + $shipping;
            $fifteenPercent = 0.15 * $basePrice;
            $threePercent = 0.03 * ($basePrice + $fifteenPercent);
            $bankprice = round($basePrice + $fifteenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
            $shipping = 220;
            $basePrice = $bankSettlementPrice + $shipping;
            $eighteenPercent = 0.18 * $basePrice;
            $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
            $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
        } elseif ($bankSettlementPrice >= 2500) {
            $shipping = 240;
            $basePrice = $bankSettlementPrice + $shipping;
            $twentyPercent = 0.2 * $basePrice;
            $threePercent = 0.03 * ($basePrice + $twentyPercent);
            $bankprice = round($basePrice + $twentyPercent + $threePercent);
        }
    }

    elseif ($shippingMode == "Warehouse") {
        
        // return 'out';
        $gurantee = 35;
        $inward = 9;
        
        if ($bankSettlementPrice >= 1 && $bankSettlementPrice <= 400) {
            $shipping = 131;
            $bankprice = round($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice) + (0.03 * ($bankSettlementPrice + $shipping + $gurantee + $inward + (0.05 * $bankSettlementPrice))));
        } elseif ($bankSettlementPrice >= 401 && $bankSettlementPrice <= 749) {
            $shipping = 180;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $tenPercent = 0.1 * ($bankSettlementPrice + $shipping);
            $threePercent = 0.03 * ($basePrice + $tenPercent);
            $bankprice = round($basePrice + $tenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 750 && $bankSettlementPrice <= 1499) {
            $shipping = 200;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $fifteenPercent = 0.15 * ($bankSettlementPrice + $shipping);
            $threePercent = 0.03 * ($basePrice + $fifteenPercent);
            $bankprice = round($basePrice + $fifteenPercent + $threePercent);
        } elseif ($bankSettlementPrice >= 1500 && $bankSettlementPrice <= 2499) {
            $shipping = 220;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $eighteenPercent = 0.18 * ($bankSettlementPrice + $shipping);
            $additionalCharge = 0.03 * ($basePrice + $eighteenPercent);
            $bankprice = round($basePrice + $eighteenPercent + $additionalCharge);
        } elseif ($bankSettlementPrice >= 2500) {
            $shipping = 240;
            $basePrice = $bankSettlementPrice + $shipping + $gurantee + $inward;
            $twentyPercent = 0.2 * ($bankSettlementPrice + $shipping);
            $threePercent = 0.03 * ($basePrice + $twentyPercent);
            $bankprice = round($basePrice + $twentyPercent + $threePercent);
        }
    }
        
        $data = [
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'sub_subcategory_id' => $request->input('sub_subcategory_id'),
            'product_name' => $request->input('product_name'),
            'product_id' => $request->pid, // Auto-generated
            'seller_user_id' => Auth::id(),
            'parent_id' => $parent_id,
            
            'description' => $request->input('description'),
            'size_name' => $stck->size,
            'stock_quantity' => $stck->quantity,
            'color_name' => $color_name,
            'fabric' => $request->input('fabric'),
            'occasion' => $request->input('occasion'),
            'care_instructions' => $request->input('care_instructions'),
            'video_url' => $request->input('video_url'),
            'seller_id' => $request->input('seller_id'),
            'shipping_time' => $request->input('shipping_time'),
            'return_policy' => $request->input('return_policy'),
            'sku' => $stck->sku,
            'hsn' => $request->input('hsn'),
            'gst_rate' => $request->input('gst_rate'),
            'procurement_type' => $request->input('procurement_type'),
            'package_weight' => $request->input('package_weight'),
            'package_length' => $request->input('package_length'),
            'package_breadth' => $request->input('package_breadth'),
            'package_height' => $request->input('package_height'),
            'pack_of' => $request->input('pack_of'),
            'country_of_origin' => $request->input('country_of_origin'),
            'manufacturer_details' => $request->input('manufacturer_details'),
            'packer_details' => $request->input('packer_details'),
            'size_chart_id' => $request->input('size_chart_id'),
            'listing_status' => $request->input('listing_status'),
            'maximum_retail_price' => $stck->maximum_retail_price,
            'bank_settlement_price' => $stck->bank_settlement_price,
            'portal_updated_price' => $bankprice,
            'alt_text' => $request->input('alt_text'),
            'pattern' => $request->input('pattern'),
            
            'added_by' => Auth::id(),
            'images' => json_encode($existingImages),
            'tryout_eligibility' => $request->tryout_eligibility,
            'sole_material' => $request->input('sole_material'),
            'upper_material' => $request->input('upper_material'),

            'toe_shape' => $request->input('toe_shape'),
            'heel_type' => $request->input('heel_type'),
            
            
            
            'saree_length' => $request->saree_length,
            'blouse_fabric' => $request->blouse_fabric,
            'blouse_piece_included' => $request->blouse_piece_included,
            'blouse_length' => $request->blouse_length,
            'blouse_stiched' => $request->blouse_stiched,
            'work_details' => $work_details,
            'border_type' => $border_type,
            'weave_type' => $request->weave_type,
            'pattern' => $request->pattern,
            'gown_type' => $request->gown_type,
            'sleeve_length' => $sleeve_length,
            'sleeve_pattern' => $sleeve_pattern,
            'neck_style' => $request->neck_style,
            'closure_type' => $closure_type,
            'embellishment_details' => $request->embellishment_details,
            'lining_present' => $request->lining_present,
            'top_type' => $request->top_type,
            'hemline' => $request->hemline,
            'transparency_level' => $request->transparency_level,
            'set_type' => $set_type,
            'bottom_included' => $request->bottom_included,
            'bottom_type' => $bottom_type,
            'dupatta_fabric' => $request->dupatta_fabric,
            'dupatta_length' => $dupatta_length,
            'dupatta_shawl_type' => $request->dupatta_shawl_type,
            'length' => $length,
            'lehenga_type' => $request->lehenga_type,
            'lehenga_length' => $request->lehenga_length,
            'choli_included' => $request->choli_included,
            'choli_length' => $request->choli_length,
            'choli_sleeve_length' => $request->choli_sleeve_length,
            'dupatta_included' => $request->dupatta_included,
            'flare_type' => $request->flare_type,
            'neckline' => $request->neckline,
            'fit_type' => $fit_type,
            'tshirt_type' => $request->tshirt_type,
            'sleeve_style' => $request->sleeve_style,
            'collar_type' => $request->collar_type,
            'shirt_type' => $request->shirt_type,
            'dress_type' => $request->dress_type,
            'dress_length' => $request->dress_length,
            'top_style' => $request->top_style,
            'bottom_style' => $request->bottom_style,
            'jumpsuit_type' => $request->jumpsuit_type,
            'leg_style' => $request->leg_style,
            'shrug_type' => $request->shrug_type,
            'hoodie_type' => $request->hoodie_type,
            'hood_included' => $request->hood_included,
            'pocket_type' => $request->pocket_type,
            'jacket_type' => $request->jacket_type,
            'pocket_details' => $request->pocket_details,
            'blazer_type' => $request->blazer_type,
            'lapel_style' => $request->lapel_style,
            'playsuit_type' => $request->playsuit_type,
            'shacket_type' => $request->shacket_type,
            'waist_rise' => $request->waist_rise,
            'stretchability' => $request->stretchability,
            'distressed_non_distressed' => $request->distressed_non_distressed,
            'number_of_pockets' => $request->number_of_pockets,
            'waistband_type' => $waistband_type,
            'compression_level' => $request->compression_level,
            'pleated_non_pleated' => $request->pleated_non_pleated,
            'waist_type' => $request->waist_type,
            'cargo_type' => $request->cargo_type,

            
            
            'created_at' => now(),
            'updated_at' => now()
        ];
        if ($bname != 0) {
            $data['brand_id'] = $bname;
        }
        
        if ($first) {
            // Update the first row
            DB::table('products')->where('id', $id)->update($data);
            $first = false;
        } else {
            // Insert remaining rows as new entries
            DB::table('products')->insert($data);
        }
    }

    // Redirect after processing all items
    return redirect('/product/sellerproduct')->with('success', 'Product Added successfully.');

    }
    
   
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return back()->with('success','Product deleted successfully');
    }
    
    
    public function getProductImages(Request $request)
    {
        $product = DB::table('products')->where('id', $request->id)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $images = json_decode($product->images, true) ?? []; // Assuming images are stored as a JSON array

        return response()->json(['images' => $images]);
    }

    /**
     * Get file extension from mime type
     * 
     * @param string $mimeType
     * @return string
     */
    private function getExtensionFromMimeType($mimeType)
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
            'application/pdf' => 'pdf',
            // Add more mime types as needed
        ];
        
        return $extensions[$mimeType] ?? 'jpg';
    }

}
