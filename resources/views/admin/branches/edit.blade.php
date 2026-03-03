<x-admin-layout>
    <div class="max-w-xl w-full">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Edit Branch — {{ $branch->name }}</h1>
            <p class="text-gray-500">Update branch details</p>
        </div>

        <form action="{{ route('branches.update', $branch) }}" method="POST">
            @csrf @method('PUT')
            <div class="card mb-6">
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Branch Name *</label>
                        <input type="text" name="name" class="input-field" required value="{{ old('name', $branch->name) }}">
                        @error('name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" class="input-field" value="{{ old('address', $branch->address) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone', $branch->phone) }}">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="is_active" {{ $branch->is_active ? 'checked' : '' }}
                            class="w-5 h-5 accent-indigo-600 cursor-pointer">
                        <label for="is_active" class="text-sm font-semibold text-gray-700 cursor-pointer">Branch is Active</label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('branches.index') }}" class="btn-secondary w-full sm:w-auto text-center order-2 sm:order-1">Cancel</a>
                <button type="submit" class="btn-primary w-full sm:w-auto order-1 sm:order-2">Save Changes</button>
            </div>
        </form>
    </div>
</x-admin-layout>
