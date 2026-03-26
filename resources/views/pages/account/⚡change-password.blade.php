<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

new class extends Component {
    public string $currentPassword = '';
    public string $newPassword = '';
    public string $newPasswordConfirmation = '';

    protected function rules(): array
    {
        return [
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|different:currentPassword',
            'newPasswordConfirmation' => 'required|same:newPassword',
        ];
    }

    protected function messages(): array
    {
        return [
            'currentPassword.required' => 'Current password is required.',
            'newPassword.required' => 'New password is required.',
            'newPassword.min' => 'New password must be at least 8 characters.',
            'newPassword.different' => 'New password must be different from your current password.',
            'newPasswordConfirmation.required' => 'Please confirm your new password.',
            'newPasswordConfirmation.same' => 'Passwords do not match.',
        ];
    }

    public function changePassword()
    {
        $userCurrentPassword = User::find(Auth::user()->user_id)->user_password;

        $this->validate();

        if (!Hash::check($this->currentPassword, $userCurrentPassword)) {

            $this->addError('currentPassword', 'The current password you entered is incorrect.');
            return;
        }

        Auth::user()->update([
            'user_password' => $this->newPassword,
        ]);
        $this->currentPassword = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
        Auth::logout();
        $this->dispatch('toast', type: 'success', message: 'Password changed successfully.');
        return redirect()->route('change-password');
    }

    public function render()
    {
        return $this->view();
    }
};
?>

<div class="cpw-root" x-data="{
    cur: '',
    np: '',
    cp: '',
    showCur: false,
    showNp: false,
    showCp: false,
    get len()       { return this.np.length >= 8 },
    get upper()     { return /[A-Z]/.test(this.np) },
    get number()    { return /[0-9]/.test(this.np) },
    get special()   { return /[^A-Za-z0-9]/.test(this.np) },
    get different() { return this.np.length > 0 && this.np !== this.cur },
    get matches()   { return this.np.length > 0 && this.np === this.cp },
    get score()     { return [this.len, this.upper, this.number, this.special, this.different, this.matches].filter(Boolean).length },
}">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div class="cpw-header">
        <div>
            {{-- <p class="cpw-breadcrumb">Settings &rsaquo; <span>Security</span></p> --}}
            <h1 class="cpw-title">Change Password</h1>
            <p class="cpw-sub">Keep your account secure by using a strong, unique password.</p>
        </div>
    </div>

    <div class="cpw-layout">

        {{-- ══ LEFT: Form ═════════════════════════════════════ --}}
        <div class="cpw-form-col">

            @if ($errors->any())
                <div class="cpw-alert" x-data
                    x-init="$nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' }))">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8"
                        class="flex-shrink-0 mt-1">
                        <circle cx="7" cy="7" r="6" />
                        <line x1="7" y1="4" x2="7" y2="7" />
                        <line x1="7" y1="9.5" x2="7" y2="10" stroke-linecap="round" stroke-width="2" />
                    </svg>
                    <ul class="cpw-alert-list"> @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                        </div>
            @endif

                <form wire:submit="changePassword" class="cpw-form">

                    {{-- Current Password --}}
                    <div class="cpw-field">
                        <label class="cpw-label" for="cpw-cur">
                            Current Password <span class="cpw-req">*</span>
                        </label>
                        <div class="cpw-input-wrap">
                            <input wire:model="currentPassword" id="cpw-cur" x-model="cur"
                                x-bind:type="showCur ? 'text' : 'password'"
                                class="cpw-input @error('currentPassword') cpw-input-error @enderror"
                                placeholder="Enter your current password" autocomplete="current-password">
                            <button type="button" class="cpw-eye" x-on:click="showCur = !showCur" tabindex="-1">
                                <svg x-show="!showCur" width="15" height="15" fill="none" stroke="currentColor"
                                    stroke-width="1.8" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg x-show="showCur" width="15" height="15" fill="none" stroke="currentColor"
                                    stroke-width="1.8" viewBox="0 0 24 24" style="display:none;">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                            </div>
                            @error('currentPassword')
                                <p class="cpw-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="cpw-field">
                            <label class="cpw-label" for="cpw-new">
                                New Password <span class="cpw-req">*</span>
                            </label>
                            <div class="cpw-input-wrap">
                                <input wire:model="newPassword" id="cpw-new" x-model="np"
                                    x-bind:type="showNp ? 'text' : 'password'"
                                    class="cpw-input @error('newPassword') cpw-input-error @enderror"
                                    placeholder="Enter your new password" autocomplete="new-password">
                                <button type="button" class="cpw-eye" x-on:click="showNp = !showNp" tabindex="-1">
                                    <svg x-show="!showNp" width="15" height="15" fill="none" stroke="currentColor"
                                        stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg x-show="showNp" width="15" height="15" fill="none" stroke="currentColor"
                                        stroke-width="1.8" viewBox="0 0 24 24" style="display:none;">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                        <path
                                            d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                        <line x1="1" y1="1" x2="23" y2="23" />
                                    </svg>
                                </button>
                                </div>
                                @error('newPassword')
                                    <p class="cpw-error">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="cpw-field">
                                <label class="cpw-label" for="cpw-conf">
                                    Confirm New Password <span class="cpw-req">*</span>
                                </label>
                                <div class="cpw-input-wrap">
                                    <input wire:model="newPasswordConfirmation" id="cpw-conf" x-model="cp" x-bind:type="showCp ? 'text' : 'password'"
                            class=" cpw-input @error('newPasswordConfirmation') cpw-input-error @enderror"
                                        placeholder="Re-enter your new password" autocomplete="new-password">
                                    <button type="button" class="cpw-eye" x-on:click="showCp = !showCp" tabindex="-1">
                                        <svg x-show="!showCp" width="15" height="15" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg x-show="showCp" width="15" height="15" fill="none" stroke="currentColor"
                                            stroke-width="1.8" viewBox="0 0 24 24" style="display:none;">
                                            <path
                                                d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                            <path
                                                d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    </button>
                                    </div>
                                    @error('newPasswordConfirmation')
                                        <p class="cpw-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="cpw-actions">
                                    <button type="submit" class="isf-btn-submit" wire:loading.attr="disabled"
                                        wire:target="changePassword" :disabled="score < 6">

                                        <span wire:loading.remove wire:target="changePassword">
                                            Update Password
                                        </span>

                                        <span wire:loading wire:target="changePassword"
                                            class="align-items-center gap-2">
                                            <span class="isf-spinner"></span>
                                            Updating...
                                        </span>

                                    </button>
                                </div>

                </form>
            </div>

            {{-- ══ RIGHT: Requirements ══════════════════════════════ --}}
            <div class="cpw-req-col">

                {{-- Progress bar --}}
                <div class="cpw-prog-wrap">
                    <div class="cpw-prog-top">
                        <span class="cpw-prog-heading">Password strength</span>
                        <span class="cpw-prog-score" x-bind:class="
                            score <= 2 ? 'cpw-score-red' :
                            score <= 4 ? 'cpw-score-amber' :
                            'cpw-score-green'
                        " x-text="
                            score === 0 ? 'None' :
                            score <= 2  ? 'Weak' :
                            score <= 4  ? 'Fair' :
                                        'Strong'
                        ">
                        </span>
                    </div>
                    <div class="cpw-prog-track">
                        <div class="cpw-prog-fill" x-bind:style="'width:' + Math.round(score / 6 * 100) + '%'"
                            x-bind:class="
                            score <= 2 ? 'cpw-fill-red' :
                            score <= 4 ? 'cpw-fill-amber' :
                            'cpw-fill-green'
                        ">
                        </div>
                    </div>
                    <p class="cpw-prog-sub" x-text="score + ' of 6 requirements met'"></p>
                </div>
                <ul class="cpw-req-list">
                    <template x-for="(req, idx) in [
                    { label: 'At least 8 characters',           met: len },
                    { label: 'At least one uppercase letter',   met: upper },
                    { label: 'At least one number',             met: number },
                    { label: 'At least one special character',  met: special },
                    { label: 'Different from current password', met: different },
                    { label: 'Passwords match',                 met: matches },
                ]" :key="idx">
                        <li class="cpw-req-item" x-bind:class="req.met ? 'cpw-item-met' : 'cpw-item-unmet'">
                            <span class="cpw-req-badge" x-bind:class="req.met ? 'cpw-badge-met' : 'cpw-badge-unmet'">
                                {{-- Check --}}
                                <svg x-show="req.met" width="10" height="10" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    viewBox="0 0 12 12">
                                    <polyline points="1.5,6 5,9.5 10.5,2.5" />
                                </svg>
                                {{-- X --}}
                                <svg x-show="!req.met" width="10" height="10" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" viewBox="0 0 12 12" style="display:none;">
                                    <line x1="2.5" y1="2.5" x2="9.5" y2="9.5" />
                                    <line x1="9.5" y1="2.5" x2="2.5" y2="9.5" />
                                </svg>
                            </span>
                            <span class="cpw-req-text" x-text="req.label"></span>
                        </li>
                    </template>

                </ul>
            </div>

        </div>
    </div>