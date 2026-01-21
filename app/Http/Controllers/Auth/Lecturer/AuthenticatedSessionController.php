<?php

namespace App\Http\Controllers\Auth\Lecturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\Auth\LectureRegisterRequest;
use App\Http\Requests\Auth\LecturerLoginRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.lecturer.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function attempt(LecturerLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('lect.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('lect.login');
    }

    // for register function

    public function register()
    {
        return view('auth.lecturer.register');
    }

    public function store(LectureRegisterRequest $request): RedirectResponse
    {

        $referCode = $request->referCode;
        $email = $request->email;

        $role = User::LECTURER_ROLE;

        $findLecturer = User::where('email', $email)->where('refer_code', $referCode)
            ->where('role', $role)
            ->whereNull('email_verified_at')
            ->first();

        if (!$findLecturer) {
            flash(__('Email and Code do not match.'))->error();
            return redirect()->back();
        }

        $findLecturer->password = Hash::make($request->password);
        $findLecturer->email_verified_at = Carbon::now();
        $findLecturer->save();

        Auth::login($findLecturer);

        flash(__('Successfully registered.'))->success();
        return redirect(route('lect.dashboard', absolute: false));
    }
}
