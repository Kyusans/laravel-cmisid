<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

new class extends Component {
    public bool $isSaving = false;

    public string $roleName = '';
    public string $officeName = '';

    public string $firstName = '';
    public string $middleName = '';
    public string $lastName = '';
    public string $email = '';

    protected function rules(): array
    {
        return [
            'firstName' => 'required|string|max:100',
            'middleName' => 'nullable|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|unique:tblusers,user_email,' . Auth::id() . ',user_id',
        ];
    }

    protected function messages(): array
    {
        return [
            'firstName.required' => 'First name is required.',
            'lastName.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken by another account.',
        ];
    }

    public function mount(): void
    {
        $user = Auth::user()->load('role', 'office');

        $this->firstName = $user->user_firstName ?? '';
        $this->middleName = $user->user_middleName ?? '';
        $this->lastName = $user->user_lastName ?? '';
        $this->email = $user->user_email ?? '';
        $this->roleName = $user->role?->role_name ?? '—';
        $this->officeName = $user->office?->office_name ?? '—';
    }

    public function updateProfile()
    {
        $this->validate();
        $this->isSaving = true; 
        try {
            User::where('user_id', Auth::id())->update([
                'user_firstName' => $this->firstName,
                'user_middleName' => $this->middleName ?: null,
                'user_lastName' => $this->lastName,
                'user_email' => $this->email,
            ]);
            $this->dispatch('toast', type: 'success', message: 'Profile updated successfully.');
            return redirect()->route('profile');
        } catch (\Throwable $th) {
            $this->dispatch('toast', type: 'error', message: "Network Error");
        } finally {
            $this->isSaving = false;
        }
    }

    public function render()
    {
        return $this->view();
    }
};
?>

<div class="prf-root">

    <div class="prf-page-header">
        <div>
            <h1 class="prf-title">My Profile</h1>
            <p class="prf-sub">Manage your personal information and account details.</p>
        </div>
    </div>

    <div class="prf-layout">
        <div class="prf-sidebar">
            <div class="prf-avatar-card">
                <div class="prf-avatar">
                    {{ strtoupper(mb_substr($firstName, 0, 1)) }}{{ strtoupper(mb_substr($lastName, 0, 1)) }}
                </div>
                <div class="prf-avatar-info">
                    <p class="prf-avatar-name">{{ trim($firstName . ' ' . $lastName) ?: 'Your Name' }}</p>
                    <p class="prf-avatar-email">{{ $email ?: 'your@email.com' }}</p>
                </div>
            </div>
            <div class="prf-info-card">
                <p class="prf-info-heading">Account Details</p>
                <div class="prf-info-row">
                    <span class="prf-info-label">Role</span>
                    <span class="prf-info-value">
                        <span class="prf-role-badge">{{ $roleName }}</span>
                    </span>
                </div>
                <div class="prf-info-row prf-info-row-last">
                    <span class="prf-info-label">Office</span>
                    <span class="prf-info-value">{{ $officeName }}</span>
                </div>
            </div>

        </div>
        <div class="prf-form-col">

            <div class="prf-section-header">
                <h2 class="prf-section-title">Personal Information</h2>
                <p class="prf-section-desc">Update your name and email address.</p>
            </div>
            @if ($errors->any())
                <div class="prf-alert" x-data
                    x-init="$nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' }))">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8"
                        class="flex-shrink-0 mt-1">
                        <circle cx="7" cy="7" r="6" />
                        <line x1="7" y1="4" x2="7" y2="7" />
                        <line x1="7" y1="9.5" x2="7" y2="10" stroke-linecap="round" stroke-width="2" />
                    </svg>
                    <ul class="prf-alert-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form wire:submit.prevent="updateProfile" class="prf-form">
                @csrf
                <div class="prf-field-grid">

                    <div class="prf-field">
                        <label class="prf-label" for="prf-first">
                            First Name <span class="prf-req">*</span>
                        </label>
                        <input wire:model="firstName" id="prf-first" type="text"
                            class="prf-input @error('firstName') prf-input-error @enderror" placeholder="Juan">
                        @error('firstName')
                            <p class="prf-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="prf-field">
                        <label class="prf-label" for="prf-middle">
                            Middle Name
                            <span class="prf-optional">(optional)</span>
                        </label>
                        <input wire:model="middleName" id="prf-middle" type="text" class="prf-input"
                            placeholder="Santos">
                    </div>

                    <div class="prf-field">
                        <label class="prf-label" for="prf-last">
                            Last Name <span class="prf-req">*</span>
                        </label>
                        <input wire:model="lastName" id="prf-last" type="text"
                            class="prf-input @error('lastName') prf-input-error @enderror" placeholder="dela Cruz">
                        @error('lastName')
                            <p class="prf-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="prf-divider"></div>
                <div class="prf-field">
                    <label class="prf-label" for="prf-email">
                        Email Address <span class="prf-req">*</span>
                    </label>
                    <input wire:model="email" id="prf-email" type="email"
                        class="prf-input prf-input-md @error('email') prf-input-error @enderror"
                        placeholder="juan@example.com" autocomplete="email">
                    @error('email')
                        <p class="prf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="prf-readonly-row">
                    <div class="prf-readonly-field">
                        <span class="prf-readonly-label">Role</span>
                        <span class="prf-readonly-value">{{ $roleName }}</span>
                    </div>
                    <div class="prf-readonly-field">
                        <span class="prf-readonly-label">Office</span>
                        <span class="prf-readonly-value">{{ $officeName }}</span>
                    </div>
                </div>
                <p class="prf-readonly-note">Role and office are managed by your system administrator.</p>

                <div class="prf-actions">
                    <button type="submit" class="isf-btn-submit" @disabled($isSaving)>
                        @if (!$isSaving)
                            Save Changes
                        @else
                            <span class="d-flex align-items-center gap-2">
                                Saving…
                            </span>
                        @endif
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>