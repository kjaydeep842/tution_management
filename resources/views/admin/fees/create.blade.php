<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Add Fee Record</h1>
        <p class="text-gray-500">Create a new fee invoice for a student.</p>
    </div>

    <form action="{{ route('fees.store') }}" method="POST" class="max-w-xl w-full" x-data="{ target: 'single' }">
        @csrf
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700">Fee Target *</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="fee_target" value="single" x-model="target"
                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">Single Student</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="fee_target" value="bulk" x-model="target"
                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">Entire Class</span>
                    </label>
                </div>
            </div>

            <div x-show="target === 'single'">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Student *</label>
                <select name="student_id" x-bind:required="target === 'single'"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->full_name }} ({{ $student->tuitionClass->name ?? '' }})
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div x-show="target === 'bulk'" x-cloak>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Select Class *</label>
                <select name="tuition_class_id" x-bind:required="target === 'bulk'"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('tuition_class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} ({{ $class->students_count ?? $class->students()->count() }} students)
                        </option>
                    @endforeach
                </select>
                @error('tuition_class_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Amount (₹) *</label>
                    <input type="number" name="amount" step="0.01" required value="{{ old('amount') }}"
                        placeholder="e.g. 2500"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
                <div x-data="{ 
                    showNewType: false, 
                    newTypeName: '',
                    feeTypes: {{ $feeTypes->toJson() }},
                    async addNewType() {
                        if (!this.newTypeName.trim()) return;
                        
                        try {
                            const response = await fetch('{{ route('fee-types.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ name: this.newTypeName })
                            });
                            
                            if (response.ok) {
                                const data = await response.json();
                                this.feeTypes.push(data);
                                this.newTypeName = '';
                                this.showNewType = false;
                            } else {
                                const error = await response.json();
                                alert(error.message || 'Error adding fee type');
                            }
                        } catch (e) {
                            console.error(e);
                            alert('Network error while adding fee type');
                        }
                    }
                }">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-700">Fee Type *</label>
                        <button type="button" @click="showNewType = !showNewType"
                            class="text-indigo-600 hover:text-indigo-800 text-xs font-bold flex items-center gap-1">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add New
                        </button>
                    </div>

                    <div x-show="showNewType" x-transition
                        class="mb-3 p-3 bg-indigo-50 rounded-xl border border-indigo-100 flex gap-2">
                        <input type="text" x-model="newTypeName" placeholder="New fee type name"
                            class="flex-1 px-3 py-1.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="addNewType"
                            class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700">Save</button>
                    </div>

                    <select name="fee_type" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <template x-for="type in feeTypes" :key="type.id">
                            <option :value="type.name" x-text="type.name"
                                :selected="type.name === '{{ old('fee_type') }}'"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>
        </div>
        <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('fees.index') }}"
                class="px-6 py-2.5 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-center order-2 sm:order-1">Cancel</a>
            <button type="submit"
                class="px-10 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all order-1 sm:order-2">Create
                Fee Records</button>
        </div>
    </form>

</x-admin-layout>