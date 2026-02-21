<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-800 text-gray-900 mb-2">Tuition Settings</h1>
            <p class="text-gray-500 text-sm">Manage your tuition's branding, logo, and core configuration.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-500">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card p-0 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-700 text-gray-900">General Branding</h2>
                    <p class="text-xs text-gray-500 mt-1">These details appear across the admin and parent portals.</p>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                    class="p-8">
                    @csrf
                    <div class="space-y-8">
                        <div>
                            <label class="block text-sm font-600 text-gray-700 mb-2">Tuition Name</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'BrightMind' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder-gray-400"
                                placeholder="Enter your tuition centre name">
                            <p class="mt-2 text-xs text-gray-400">This name will be used in headings and browser titles.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-600 text-gray-700 mb-2">Tuition Address</label>
                            <textarea name="site_address" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder-gray-400"
                                placeholder="Enter your center's physical address">{{ $settings['site_address'] ?? '123 Education Lane, Mumbai, Maharashtra 400001' }}</textarea>
                            <p class="mt-2 text-xs text-gray-400">This address will appear on receipts and the contact
                                section.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-600 text-gray-700 mb-2">Contact Email</label>
                            <input type="email" name="contact_email"
                                value="{{ $settings['contact_email'] ?? 'admissions@brightmind.in' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder-gray-400"
                                placeholder="admissions@yourtuition.com">
                            <p class="mt-2 text-xs text-gray-400">Used for automated emails and contact info.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-600 text-gray-700 mb-2">Tuition Logo</label>
                            <div class="mt-2 flex items-center gap-6">
                                <div
                                    class="w-24 h-24 rounded-2xl bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-200 overflow-hidden group relative">
                                    @if(isset($settings['site_logo']))
                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="site_logo" id="site_logo" class="hidden">
                                    <label for="site_logo"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-600 text-gray-700 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Choose New Logo
                                    </label>
                                    <p class="mt-2 text-xs text-gray-400">Recommended: Square PNG/SVG, max 2MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="btn-primary px-8">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-indigo-900 text-white border-none relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-700 text-lg mb-2">Live Preview</h3>
                    <p class="text-indigo-200 text-xs mb-6">See how your branding looks in the sidebar.</p>

                    <div class="bg-white/10 rounded-xl p-4 flex items-center gap-3 border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            @if(isset($settings['site_logo']))
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                    class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <div class="font-800 text-sm tracking-tight capitalize">
                                {{ $settings['site_name'] ?? 'BrightMind' }}</div>
                            <div class="text-[10px] text-indigo-300 font-600 uppercase tracking-widest">Admin Panel
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decorative background elements -->
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute -left-4 -top-4 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl"></div>
            </div>

            <div class="card">
                <h3 class="font-700 text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Setup Note
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    If your logo doesn't appear after uploading, ensure you have linked your storage folder by running:
                </p>
                <div class="mt-3 p-3 bg-gray-50 rounded-lg font-mono text-[11px] text-gray-500 border border-gray-200">
                    php artisan storage:link
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>