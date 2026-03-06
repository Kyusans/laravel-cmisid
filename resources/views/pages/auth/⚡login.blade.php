<?php

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

new class extends Component {

    public $email = "";
    public $password = "";

    public function render()
    {
        return $this->view();
    }

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (
            Auth::attempt([
                "user_email" => $validated["email"],
                "password" => $validated["password"]
            ])
        ) {
            request()->session()->regenerate();
            session()->flash("success", "Login successful");
            return redirect()->route('dashboard');
        }

        throw ValidationException::withMessages([
            "credentials" => "Invalid credentials"
        ]);
    }
};
?>

<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="d-flex justify-content-center align-items-center vh-100">
                <div class="card" style="width: 24rem;">
                    {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-4">
                            <h5 class="fw-bold">Login to your account</h5>
                            <h6 class="text-muted">Enter your email below to login to your account</h6>
                        </div>

                        <form wire:submit="login">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="mb-2">Email address</label>
                                <input wire:model="email" type="email" class="form-control" placeholder="Enter email">
                            </div>
                            <div class="form-group mb-4">
                                <label class="mb-2">Password</label>
                                <input wire:model="password" type="password" class="form-control"
                                    placeholder="Password">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-dark btn-block">Login</button>
                            </div>
                        </form>
                        {{-- <form wire:submit="login">
                            @csrf
                            <div class="">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" wire:model="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                    }}</label>

                                <div class="col-md-6">
                                    <input wire:model="password" id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                            old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>