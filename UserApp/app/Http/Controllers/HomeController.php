<?php
namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
class HomeController extends Controller{

    public function index(Request $request){
        $filter = $request->query('filter');

        $sliders  = Slider::all();
        $products = Product::query();

        if($filter){
            $products = $products->where('remark', $filter);
        }

        return Inertia::render("Home/Home",[
            'sliders' => $sliders,
            // 'products'=> $products->get()->load('details'),
            'products' => $products->with('details')->get(),
        ]);
    }

    public function create(){//
    }

    public function store(Request $request){//
    }

    public function show(string $id){//
    }

    public function edit(string $id){//
    }

    public function update(Request $request, string $id){//
    }

    public function destroy(string $id){//
    }
}
