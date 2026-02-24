<x-guest-layout>
    <div class="mb-14 text-center reveal delay-100">
        <h2 class="text-4xl font-black text-gray-900 tracking-tight">Login to Dashboard</h2>
        <p class="mt-4 text-lg text-gray-500 font-medium">Enter your credentials to access your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-10 reveal delay-200" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-10">
        @csrf

        <!-- Email Address -->
        <div class="space-y-3 text-left reveal delay-300">
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-bold text-base ml-2" />
            <x-text-input id="email"
                class="block w-full px-6 py-5 rounded-[2rem] border-gray-200 bg-gray-50/50 text-lg text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 shadow-sm transition-all duration-300"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm ml-2" />
        </div>

        <!-- Password -->
        <div class="space-y-3 text-left reveal delay-400">
            <div class="flex items-center justify-between px-3">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold text-base" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-indigo-600 hover:text-indigo-700 transition-colors duration-200"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password"
                class="block w-full px-6 py-5 rounded-[2rem] border-gray-200 bg-gray-50/50 text-lg text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 shadow-sm transition-all duration-300"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm ml-2" />
        </div>

        <div class="flex items-center ml-3 reveal delay-500">
            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="w-6 h-6 rounded-lg border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500/30 transition-all duration-200 cursor-pointer" name="remember">
                <span class="ms-4 text-base text-gray-600 font-semibold group-hover:text-gray-900 transition-colors duration-200">{{ __('Keep me logged in') }}</span>
            </label>
        </div>

        <div class="pt-6 reveal delay-[600ms]">
            <button type="submit"
                style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;"
                class="w-full flex items-center justify-center py-6 px-10 rounded-[2.5rem] shadow-[0_20px_45px_-5px_rgba(99,102,241,0.4)] text-xl font-black text-white hover:shadow-[0_25px_55px_-5px_rgba(99,102,241,0.5)] hover:scale-[1.01] active:scale-[0.98] transition-all duration-300 uppercase tracking-widest cursor-pointer">
                {{ __('Secure Sign In →') }}
            </button>
        </div>
    </form>
</x-guest-layout>