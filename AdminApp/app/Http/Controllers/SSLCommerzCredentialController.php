<?php
namespace App\Http\Controllers;

use App\Models\SSLCommerzCredential;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SSLCommerzCredentialController extends Controller{
    public function index(){
        $settings=SSLCommerzCredential::first();
        return Inertia::render("Settings/Settings",['settings'=>$settings]);}
    public function create(){
        //
    }
    public function store(Request $request){
        //
    }
    public function show(string $id){
        //
    }
    public function edit(string $id){
        //
    }
    public function update(Request $request, string $id){
        try {
            $request->validate([
                'store_id' => 'required|string',
                'store_password' => 'required|string',
                'currency' => 'required|string',
                'success_url' => 'required|string',
                'fail_url' => 'required|string',
                'cancel_url' => 'required|string',
                'ipn_url' => 'required|string',
                'init_url' => 'required|string',
            ]);

            $setting = SSLCommerzCredential::first();
            $setting->update($request->all());
            return redirect()->back()->with('success', 'SSLCommerz settings updated successfully.');
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy(string $id){
        //
    }
}
