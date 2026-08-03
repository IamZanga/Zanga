<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Please set a new password before continuing.
    </div>
    <form method="POST" action="{{ route('password.force.update') }}">
        @csrf
        <div>
            <x-input-label for="password" value="New Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>
        <div class="flex justify-end mt-4">
            <x-primary-button>Set Password</x-primary-button>
        </div>
    </form>
</x-guest-layout>