<x-admin-layout>
    <div class="max-w-xl w-full">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Add New Branch</h1>
            <p class="text-gray-500">Create a new tuition centre location</p>
        </div>

        <form action="{{ route('branches.store') }}" method="POST">
            @csrf
            <div class="card mb-6">
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Branch Name *</label>
                        <input type="text" name="name" class="input-field" required value="{{ old('name') }}"
                            placeholder="e.g. Nikol, Naroda …">
                        @error('name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" class="input-field" value="{{ old('address') }}"
                            placeholder="e.g. 102 Main Road, Nikol, Ahmedabad">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone') }}"
                            placeholder="e.g. 98765 43210">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('branches.index') }}" class="btn-secondary w-full sm:w-auto text-center order-2 sm:order-1">Cancel</a>
                <button type="submit" class="btn-primary w-full sm:w-auto order-1 sm:order-2">Create Branch</button>
            </div>
        </form>
    </div>
</x-admin-layout>