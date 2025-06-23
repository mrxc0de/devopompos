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

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($this->is_developer) {
            $validated['title'] = $this->title;
        }

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $user->assignRole($this->is_developer ? 'Developer' : 'Viewer');

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
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

        <label class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
            <input type="checkbox" wire:model="is_developer"
                class="rounded border-gray-300 text-primary shadow-sm focus:ring focus:ring-primary focus:ring-opacity-50">
            <span>I am a developer</span>
        </label>

        <div x-show="$wire.is_developer" x-cloak>
            <flux:select wire:model.defer="title" label="Title" required>
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
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
