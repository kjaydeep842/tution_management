<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Mark Attendance</h1>
        <p class="text-gray-500">Select a class and date to record student attendance.</p>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('attendance.index') }}"
        class="flex flex-wrap items-end gap-4 mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Select Class</label>
            <select name="class_id" required
                class="px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                <option value="">Choose a class...</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
            <input type="date" name="date" value="{{ $date }}"
                class="px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
        </div>
        <button type="submit"
            class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm">Load
            Students</button>
    </form>

    @if(count($students) > 0)
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="tuition_class_id" value="{{ $class_id }}">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900">Students – {{ $date }}</h3>
                    <div class="flex space-x-2 text-sm font-semibold">
                        <button type="button" onclick="markAll('present')"
                            class="px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200">All Present</button>
                        <button type="button" onclick="markAll('absent')"
                            class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg hover:bg-rose-200">All Absent</button>
                    </div>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($students as $student)
                        <div class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-9 h-9 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ substr($student->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                    <div class="text-xs text-gray-500">Roll: {{ $student->roll_no ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                @foreach(['present' => 'green', 'absent' => 'rose', 'late' => 'amber'] as $status => $color)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="attendance[{{ $student->id }}]" value="{{ $status }}"
                                            class="sr-only attendance-radio" {{ $student->attendance_status == $status ? 'checked' : '' }}>
                                        <span
                                            class="status-btn px-4 py-1.5 rounded-xl text-xs font-semibold border-2 transition-all
                                            {{ $student->attendance_status == $status ? "bg-{$color}-100 text-{$color}-700 border-{$color}-300" : 'bg-gray-50 text-gray-500 border-transparent hover:border-gray-200' }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="px-10 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all">Save
                    Attendance</button>
            </div>
        </form>

        <script>
            function markAll(status) {
                document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(r => {
                    r.checked = true;
                    r.dispatchEvent(new Event('change'));
                });
            }
            // Visual toggle for radio-based status buttons
            document.querySelectorAll('.attendance-radio').forEach(radio => {
                radio.addEventListener('change', function () {
                    const siblings = document.querySelectorAll(`input[name="${this.name}"]`);
                    siblings.forEach(sib => {
                        const btn = sib.nextElementSibling;
                        const color = { present: 'green', absent: 'rose', late: 'amber' }[sib.value] || 'gray';
                        if (sib.checked) {
                            btn.className = btn.className.replace(/bg-\w+-\d+ text-\w+-\d+ border-\w+-\d+/g, '');
                            btn.classList.add(`bg-${color}-100`, `text-${color}-700`, `border-${color}-300`);
                        } else {
                            btn.className = btn.className.replace(/bg-\w+-\d+ text-\w+-\d+ border-\w+-\d+/g, '');
                            btn.classList.add('bg-gray-50', 'text-gray-500', 'border-transparent');
                        }
                    });
                });
            });
        </script>
    @elseif(request('class_id'))
        <p class="text-center text-gray-500 italic py-10">No students in this class.</p>
    @endif
</x-admin-layout>