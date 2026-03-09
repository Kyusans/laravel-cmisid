<?php

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

new class extends Component {
    public $email = '';
    public $password = '';
    public $isLoading = false;

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
    }

    public function render()
    {
        return $this->view();
    }

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (
            Auth::attempt([
                'user_email' => $validated['email'],
                'password' => $validated['password'],
            ])
        ) {
            request()->session()->regenerate();
            session()->flash('success', 'Login successful');
            return redirect()->route('dashboard');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Invalid credentials',
        ]);
    }
};
?>

<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="d-flex justify-content-center align-items-center vh-100">
                <div class="card" style="width: 24rem;">

                    <div class="card-body">

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

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="login">Login</span>
                                    <span wire:loading wire:target="login">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
