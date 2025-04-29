<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller{
    public function index(){
        $categories = Category::all();
        return Inertia::render("Categories/CategoryList",["categories"=>$categories,]);}
    public function create(){
        return Inertia::render("Categories/AddCategory");
    }
    public function store(Request $request){
        try{
            $request->validate([
                'name'=> 'required|string|max:255',
                'image'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageLocation='';
            if($request->hasFile('image')){
                $image=$request->file('image');
                $imageName=time().'.'.$image->getClientOriginalExtension();
                $imagePath=$image->storeAs('images', $imageName,'shared');
                $imageLocation= Storage::disk('shared')->url($imagePath);// absolute path
            }    
            Category::create([
                'name'=>$request->name,
                'image'=>$imageLocation,// saved as absolute path
            ]);
            return redirect()->route('categories.index')->with('success','Category Created Successfully');
        }catch(\Throwable $th){
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
    public function show(string $id){//
    }
    public function edit(string $id){
        $category = Category::findOrFail($id);
        return Inertia::render('Categories/EditCategory',[ 'category'=>$category]);
    }
    public function update(Request $request, string $id){
        try{
            $request->validate([
                'name'=> 'required|string|max:255',
                'image'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $category = Category::findOrFail($id);
            $imageLocation=$category->image;
            $oldImage = $category->image;
            if($request->hasFile('image')){
                // Delete old image from disk
                if ($oldImage) {
                    $parsed = parse_url($oldImage);
                    //http://localhost:8000/shared/images/1745438247.jpg
                    $urlPath = ltrim($parsed['path'], '/'); // e.g. shared/images/1745438234.jpg                
                    // Remove the 'shared/' part to get relative path inside the disk
                    if (str_starts_with($urlPath, 'shared/')) {
                        $relativePath = substr($urlPath, strlen('shared/')); // e.g. images/1745438234.jpg
                
                        if (Storage::disk('shared')->exists($relativePath)) {
                            Storage::disk('shared')->delete($relativePath);
                        }
                    }
                }

                // Upload new image
                $image=$request->file('image');
                $imageName=time().'.'.$image->getClientOriginalExtension();
                $imagePath=$image->storeAs('images', $imageName,'shared');
                $imageLocation= Storage::disk('shared')->url($imagePath);// absolute path
            }
    
            $category->update([
                'name'=>$request->name,
                'image'=>$imageLocation,// saved as absolute path
            ]);
            return redirect()->route('categories.index')->with('success','Category Updated Successfully');
        }catch(\Throwable $th){
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
    public function destroy(string $id){
        $category = Category::findOrFail($id);
        if ($category->image) {  //http://localhost:8000/shared/images/1745438247.jpg
            $imagePath = str_replace(Storage::disk('shared')->url(''), '', $category->image);
            if (Storage::disk('shared')->exists($imagePath)) {
                Storage::disk('shared')->delete($imagePath);
            }
        }
        $category->delete();
    }
}
