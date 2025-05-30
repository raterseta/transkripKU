<nav class="bg-[#002849] font-poppins text-white" x-data="{ isMobileOpen: false }">
    <div class="mx-auto w-full px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between sm:px-6 lg:px-6">
            <!-- Logo -->
            <div class="flex flex-1 items-center sm:items-stretch">
                <a href="{{ url('/') }}" class="flex shrink-0 items-center">
                    <img src="{{ asset('images/ubub.png') }}" alt="ubub" class="w-auto h-9" />
                </a>
            </div>

            <!-- Hamburger button for mobile -->
            <div class="sm:hidden flex items-center">
                <button @click="isMobileOpen = !isMobileOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-orange-500 focus:outline-none">
                    <svg class="h-6 w-6" x-show="!isMobileOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="h-6 w-6" x-show="isMobileOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Menu items (desktop) -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <a href="{{ url('/track') }}">
                    <button class="text-white font-semibold bg-orange-500 rounded-2xl px-3 py-1 text-sm">Track Pengajuan</button>
                </a>
                <a href="{{ url('/admin/login') }}">
                    <img src="{{ asset('images/user.svg') }}" alt="My SVG" class="w-6 h-6" />
                </a>
            </div>
        </div>
    </div>

    <!-- Menu items (mobile) -->
    <div class="sm:hidden px-4 pt-2 pb-4 space-y-2" x-show="isMobileOpen" x-transition>
        <a href="{{ url('/track') }}">
            <button class="w-full text-left text-white font-semibold bg-orange-500 rounded-2xl px-3 py-2 text-sm">Track Pengajuan</button>
        </a>
        <a href="{{ url('/admin/login') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/user.svg') }}" alt="My SVG" class="w-6 h-6" />
            <span>Admin</span>
        </a>
    </div>
</nav>
