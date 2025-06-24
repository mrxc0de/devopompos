mv resources/views/vendor/Chatify resources/views/vendor/chatify

// register.blade.php
<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $is_developer = false;
    public string $title = '';
    public string $telegram_username = '';
    public string $telegram_id = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'telegram_username' => ['nullable', 'string', 'max:255'],
            'telegram_id' => ['nullable', 'string', 'max:255'],
        ]);

        if ($this->is_developer) {
            $this->validate([
                'title' => ['required', 'string', 'max:255'],
            ]);
        }

        try {
            \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\TestEmail());
        } catch (\Exception $e) {
            $this->addError('email', 'Use your real email to register.');
            return;
        }

        $validated = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'telegram_username' => $this->telegram_username,
            'telegram_id' => $this->telegram_id,
        ];

        if ($this->is_developer) {
            $validated['title'] = $this->title;
        }

        event(new Registered(($user = User::create($validated))));

        $user->assignRole($this->is_developer ? 'Developer' : 'Viewer');

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6 w-full max-w-xl mx-auto bg-white dark:bg-zinc-900 rounded-xl p-10 shadow-2xl">
    <x-auth-header :title="'Register'" :description="''"
        class="text-center text-2xl font-bold text-primary-700 dark:text-white" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" x-data="{ is_developer: @entangle('is_developer') }" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" />

        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

        <!-- Telegram Username -->
        <flux:input wire:model="telegram_username" :label="__('Telegram Username')" type="text"
            placeholder="@yourhandle" />

        <!-- Telegram ID -->
        {{-- <flux:input wire:model="telegram_id" :label="__('Telegram ID')" type="text" placeholder="123456789" /> --}}

        <label class="flex items-center space-x-2 text-sm text-gray-800 dark:text-gray-200 font-medium">
            <input type="checkbox" wire:model="is_developer"
                class="rounded border-gray-300 text-primary shadow-sm focus:ring focus:ring-primary focus:ring-opacity-50">
            <span>I am a developer</span>
        </label>

        <div x-show="is_developer" x-cloak>
            <flux:select wire:model.defer="title" label="Title" x-bind:required="is_developer">
                <option value="">Select a title</option>
                <option value="Junior Laravel Developer">Junior Laravel Developer</option>
                <option value="Mid Laravel Developer">Mid Laravel Developer</option>
                <option value="Senior Laravel Developer">Senior Laravel Developer</option>
                <option value="Junior React Developer">Junior React Developer</option>
                <option value="Mid React Developer">Mid React Developer</option>
                <option value="Senior React Developer">Senior React Developer</option>
                <option value="Fullstack Developer">Fullstack Developer</option>
                <option value="DevOps Engineer">DevOps Engineer</option>
                <option value="QA Engineer">QA Engineer</option>
            </flux:select>
        </div>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary"
                class="w-full bg-primary-600 hover:bg-primary-700 text-black py-3 rounded-lg transition-all duration-300">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link href="{{ url('/into/login') }}">{{ __('Log in') }}</flux:link>
    </div>
    <div class="h-4"></div>
</div>

