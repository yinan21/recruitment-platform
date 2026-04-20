<x-guest-layout>
    <form method="POST" action="{{ route('register.company') }}">
        @csrf

        <p class="text-sm text-gray-600 mb-4">Create an employer account and your company profile in one step.</p>

        <div>
            <x-input-label for="name" :value="__('Your name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="mobile_no" :value="__('Mobile number')" />
            <x-text-input id="mobile_no" class="block mt-1 w-full" type="tel" name="mobile_no" :value="old('mobile_no')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('mobile_no')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="company_name" :value="__('Company name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="company_description" :value="__('Company description (optional)')" />
            <textarea id="company_description" name="company_description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('company_description') }}</textarea>
            <x-input-error :messages="$errors->get('company_description')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="company_website" :value="__('Website (optional)')" />
            <x-text-input id="company_website" class="block mt-1 w-full" type="url" name="company_website" :value="old('company_website')" placeholder="https://..." />
            <x-input-error :messages="$errors->get('company_website')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('register') }}">
                {{ __('Register as candidate instead') }}
            </a>
            <x-primary-button>
                {{ __('Create company account') }}
            </x-primary-button>
        </div>

        <p class="mt-4 text-center text-sm text-gray-600">
            <a class="underline" href="{{ route('login') }}">{{ __('Already registered?') }}</a>
        </p>
    </form>
</x-guest-layout>
