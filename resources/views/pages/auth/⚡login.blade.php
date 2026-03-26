<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

new class extends Component {
    public string $email = '';
    public string $password = '';
    public bool $showPassword = false;

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
    }

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        if (
            Auth::attempt([
                'user_email' => $validated['email'],
                'password' => $validated['password'],
            ])
        ) {
            $this->dispatch("toast", type: "success", message: "Login successful.");
            request()->session()->regenerate();
            return redirect()->route('dashboard');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Invalid email or password. Please try again.',
        ]);
    }

    public function render()
    {
        return $this->view();
    }
};
?>

<div>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="lgn-form-wrap">
            <div class="lgn-form-header">
                <h1 class="lgn-title text-center">Welcome to CGISMS</h1>
                <p class="text-center text-muted">Sign in to your account to continue.</p>
            </div>

            @error('credentials')
                <div class="lgn-alert">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 14 14"
                        class="flex-shrink-0">
                        <circle cx="7" cy="7" r="6" />
                        <line x1="7" y1="4" x2="7" y2="7" />
                        <line x1="7" y1="9.5" x2="7" y2="10" stroke-linecap="round" stroke-width="2" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror

            <form wire:submit="login" class="lgn-form">
                @csrf
                <div class="lgn-field">
                    <label class="lgn-label" for="lgn-email">Email address</label>
                    <input wire:model="email" id="lgn-email" type="email"
                        class="lgn-input @error('email') lgn-input-error @enderror" placeholder="you@example.com"
                        autocomplete="email" autofocus>
                    @error('email')
                        <p class="lgn-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="lgn-field">
                    <label class="lgn-label" for="lgn-password">Password</label>
                    <div class="lgn-input-wrap" x-data="{ show: false }">
                        <input wire:model="password" id="lgn-password" x-bind:type="show ? 'text' : 'password'"
                            class="lgn-input @error('password') lgn-input-error @enderror"
                            placeholder="Enter your password" autocomplete="current-password">
                        <button type="button" class="lgn-eye" x-on:click="show = !show" tabindex="-1">
                            <svg x-show="!show" width="15" height="15" fill="none" stroke="currentColor"
                                stroke-width="1.8" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg x-show="show" width="15" height="15" fill="none" stroke="currentColor"
                                stroke-width="1.8" viewBox="0 0 24 24" style="display:none;">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="lgn-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="lgn-submit mt-2" wire:loading.attr="disabled"
                    wire:loading.class="lgn-submit-loading">
                    <span wire:loading.remove wire:target="login">Sign in</span>
                    <span wire:loading wire:target="login" class="lgn-loading-inner" style="display:none;">
                        Signing in…
                    </span>
                </button>

            </form>

        </div>
    </div>

</div>