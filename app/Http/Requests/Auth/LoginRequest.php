<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Menentukan apakah request diperbolehkan.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi form login.
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email'
            ],

            'password' => [
                'required',
                'string'
            ],
        ];
    }


    /**
     * Melakukan proses autentikasi user.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        // Cek batas percobaan login
        $this->ensureIsNotRateLimited();


        // Coba login menggunakan email dan password
        if (! Auth::attempt(
            $this->only('email', 'password'),
            $this->boolean('remember')
        )) {

            // Tambahkan jumlah percobaan gagal
            RateLimiter::hit($this->throttleKey());


            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }


        // Reset limit ketika berhasil login
        RateLimiter::clear($this->throttleKey());
    }


    /**
     * Mengecek apakah login terkena batas percobaan.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts(
            $this->throttleKey(),
            5
        )) {
            return;
        }


        event(new Lockout($this));


        $seconds = RateLimiter::availableIn(
            $this->throttleKey()
        );


        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }


    /**
     * Membuat key untuk rate limiter login.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->input('email'))
            . '|'
            . $this->ip()
        );
    }
}