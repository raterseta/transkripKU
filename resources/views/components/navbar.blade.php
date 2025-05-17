<nav class="bg-[#002849]" x-data="{ isMobileOpen: false, isLaptopOpen: false }">
    <div class="mx-auto w-full px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

                </div> -->
            <!--Tab Nav 1-->
            <div class="flex flex-1 items-center sm:items-stretch">
                <!--Tab ikon-->
                <a href="{{ url('/') }}" class="flex shrink-0 items-center">
                    <img src="{{ asset('images/ubub.png') }}" alt="ubub" class="w-auto h-9" />
                </a>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <!-- Profile dropdown -->
                <div class="relative ml-3 flex flex-row">
                    <div class="pr-6 lg:pr-16">
                        <a href="{{ url('/track') }}">
                            <button class="bg-orange-500 rounded-md px-3 py-1 text-sm text-white">Track Pengajuan</button>
                        </a>
                    </div>
                    <div>
                        <button
                            class="inline-flex border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <a href="{{ url('/admin/login') }}">
                                <img src="{{ asset('images/user.svg') }}" alt="My SVG" class="w-6 h-6" />
                            </a>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
