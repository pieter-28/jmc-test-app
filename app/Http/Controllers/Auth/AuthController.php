<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $validated = $request->validate(
            [
                'credential' => 'required|string',
                'password' => 'required|string',
                'captcha' => 'required|string',
            ],
            [
                'credential.required' => 'Username, email, atau nomor telepon harus diisi',
                'password.required' => 'Password harus diisi',
                'captcha.required' => 'CAPTCHA harus diisi',
            ],
        );

        // Validate CAPTCHA
        if (!$this->validateCaptcha($request->session()->get('captcha_code'), $request->input('captcha'))) {
            throw ValidationException::withMessages([
                'captcha' => 'Kode CAPTCHA tidak sesuai',
            ]);
        }

        // Find user by username, email, or phone
        $user = User::where('username', $validated['credential'])->orWhere('email', $validated['credential'])->orWhere('phone', $validated['credential'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'credential' => 'Kredensial tidak valid',
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'credential' => 'Akun Anda tidak aktif',
            ]);
        }

        // Update last login time
        $user->update(['last_login_at' => now()]);

        // Log activity
        ActivityLog::log($user->id, 'login', 'Auth', 'User login successfully');

        // Handle remember me
        Auth::login($user, $request->boolean('remember_me'));

        // Regenerate session
        $request->session()->regenerate();

        // Clear captcha
        $request->session()->forget('captcha_code');

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Generate CAPTCHA code.
     */
    public function generateCaptcha(Request $request)
    {
        $code = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6));
        $request->session()->put('captcha_code', $code);

        return response()->json([
            'captcha_code' => $code,
            'captcha_image' => $this->generateCaptchaImage($code),
        ]);
    }

    /**
     * Generate CAPTCHA image (base64).
     */
    private function generateCaptchaImage($code)
    {
        $width = 150;
        $height = 50;

        // Create image
        $image = imagecreatetruecolor($width, $height);

        // Define colors
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        $lineColor = imagecolorallocate($image, 200, 200, 200);

        // Fill background
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        // Draw random lines
        for ($i = 0; $i < 5; $i++) {
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        }

        // Add text
        $textX = 15;
        $textY = 35;
        imagestring($image, 5, $textX, $textY, $code, $textColor);

        // Convert to base64
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    /**
     * Validate CAPTCHA.
     */
    private function validateCaptcha($sessionCode, $inputCode)
    {
        return $sessionCode && strtoupper($inputCode) === $sessionCode;
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        // Log activity
        ActivityLog::log(Auth::id(), 'logout', 'Auth', 'User logout');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
