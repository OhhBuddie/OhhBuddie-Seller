<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Auth::user()->id;
        $brands = DB::table('brands')->where('user_table_id', Auth::user()->id)->latest()->get();
        
        return view('brands.index',compact('brands'));
        // return $brands;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller = DB::table('sellers')->where('user_table_id', Auth::id())->latest()->first();


        $lastProduct = DB::table('brands')
            ->where('seller_id', $seller->seller_id)
            ->where('brand_id', 'LIKE', 'OBD-BR-' . $seller->seller_id . '-%')
            ->orderBy('id', 'desc')
            ->first();
        
        // Extract last number and increment
        if ($lastProduct) {
            preg_match('/OBD-BR-' . $seller->seller_id . '-(\d+)/', $lastProduct->brand_id, $matches);
            $nextNumber = isset($matches[1]) ? ((int) $matches[1] + 1) : 1001;
        } else {
            $nextNumber = 1001;
        }
        
        // Generate unique product ID
        $brand_id = 'OBD-BR-' . $seller->seller_id . '-' . $nextNumber;
        
        
        
        
        
        $brand_count = DB::table('brands')->where('user_table_id',Auth::user()->id)->count();
        
        $brands_total = $brand_count + 1;
        
        DB::table('sellers')->where('user_table_id',Auth::user()->id)->update(['total_brands'=>$brands_total]);

        try {
            // Handle file uploads
            if ($request->hasFile('brand_logo')) {
                $logoPath = $request->file('brand_logo')->store('brand_logos', 'public');
            }
            
            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('brand_documents', 'public');
            }
            
            // Create new brand record
            $brand = new Brand;
            $brand->user_table_id = $request->user_table_id;
            $brand->seller_table_id = $request->seller_table_id;
            $brand->seller_id = $request->seller_id;
            $brand->brand_id = $brand_id;
            $brand->brand_name = $request->brand_name;
            $brand->nature_of_brand = $request->nature_of_brand;
            $brand->brand_logo = $logoPath;
            $brand->document_type = $request->document_type;
            $brand->document = $documentPath;
            $brand->no_of_products = $request->no_of_products;
            $brand->save();
            
            return redirect()->route('brands.create')
                             ->with('success', 'Brand registered successfully');
        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error', 'Failed to register brand. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
