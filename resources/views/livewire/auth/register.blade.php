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

<div
    class="flex flex-col gap-6 w-full max-w-xl mx-auto bg-white dark:bg-zinc-900 rounded-xl p-10 shadow-2xl text-center">
    <h2 class="text-2xl font-bold text-primary-700 dark:text-white">Registration Closed</h2>
    <p class="text-zinc-600 dark:text-zinc-400">
        We have currently closed new member registrations. Thank you for your interest.<br>
        We’ll be back soon with exciting updates. Stay tuned!
    </p>
    <a href="{{ url('/') }}"
        class="mt-6 inline-block bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
        Back to Home
    </a>
</div>
