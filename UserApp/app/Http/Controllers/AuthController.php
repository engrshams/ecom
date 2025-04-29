<?php
namespace App\Http\Controllers;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Helpers\MailerHelper;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{
    public function loginPage(){
        return Inertia::render("Auth/Login");
    }

    public function login(Request $request){
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required|string"
            ]);
            $email = $request->email;
            $password = $request->password;

            //Auth — is Laravel’s authentication system.
            // true — this second parameter is the "remember me" flag:
            //     true = the user will be remembered even after closing the browser (long-term login, via a persistent cookie).
            //     false = session-only login (logout happens when browser is closed or session expires).            

            if (!Auth::attempt(["email" => $email, "password" => $password], true)) {
                return redirect()->back()->with("error", "Invalid credentials");
            }
            return redirect('/')->with('success', 'Login success');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function registerPage(){
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request){
        // First, validate basic fields without checking uniqueness or confirmation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:4',
            'password_confirmation' => 'required|string|min:4',
        ]);

        // Check if email already exists
        if (User::where('email', $request->email)->exists()) {
            return back()->with('error', 'User with this email address already exists.');
        }

        // Check if password and confirmation match
        if ($request->password !== $request->password_confirmation) {
            return back()->with('error', 'Password and Confirm Password do not match.');
        }

        // All good, create user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create customer profile
        $customerProfile = CustomerProfile::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'cus_name' => $request->name,
            'ship_name' => $request->name,
        ]);

        // Send OTP
        $otp = MailerHelper::sendOtp($user->email);

        $user->update([
            'otp' => $otp,
        ]);

        // Redirect with success
        return redirect()->route('verify', [
            'email' => $user->email,
        ])->with('success', 'Registration successful, please verify your email.');
    }

    public function verifyPage(Request $request){
        $email = $request->query('email');
        return Inertia::render('Auth/Verify', [
            'email' => $email,
        ]);
    }

    public function verify(Request $request){
        try {
            $request->validate([
                'otp' => 'required|numeric|digits:4',
                'email' => 'required|email',]);

            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Invalid OTP');}

            $user->otp = null;
            $user->save();

            Auth::login($user);

            // In short:
            // ✅ Laravel stores the user's ID into the session. (session based login)
            // ✅ Auth::login($user); logs in the user manually.
            // ✅ No password checking here — you’re trusting that $user is valid.
            // ✅ Very useful after registration, social login, or admin actions.

            return redirect('/')->with('success', 'Registration completed successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function resend(Request $request){
        try {
            $request->validate([
                'email' => 'required|email',]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Invalid Email');}

            $otp = MailerHelper::sendOtp($user->email);

            $user->otp = $otp;
            $user->save();

            return redirect()->route('verify', [
                'email' => $user->email,
            ])->with('success', ' OTP resent successfully, please check your email');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/')->with('success', 'Logout success');
    }
}