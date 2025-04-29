<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
class UserController extends Controller{

    public function index(){
        $users = User::all();
        return Inertia::render('Users/UserList', [
            'users' => $users,
        ]);
    }

    public function create(){
        return Inertia::render('Users/AddUser');
    }

    public function store(Request $request){
        try {
            $request->validate([
                'role' => 'required|string|in:admin,editor',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4',
            ]);

            User::create([
                'role' => $request->role,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show(string $id){//
    }

    public function edit(string $id){
        $user = User::findOrFail($id);
        return Inertia::render('Users/EditUser',[
            'user'=> $user
        ]);
    }

    public function update(Request $request, string $id){
        try {
            $request->validate([
                'role' => 'required|string|in:admin,editor',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:4',
            ]);

            $user = User::findOrFail($id);
            $data = [
                'role' => $request->role,
                'email'=> $request->email
            ];
            if($request->filled('password')) {
                $data['password'] = $request->password;
            }

            $user->update($data);

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }       
    }

    public function destroy(string $id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully.');
    }
}