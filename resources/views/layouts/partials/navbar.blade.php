<nav class="bg-white/80 backdrop-blur-xl border-b border-sand-200/40 sticky top-0 z-50 shadow-[0_1px_3px_rgba(61,31,22,0.04)] transition-all duration-300" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-1.5 group">
                    <span class="font-heading font-bold text-2xl tracking-tight text-sand-900 group-hover:text-teak-700 transition-colors duration-300">Jati</span>
                    <span class="font-heading font-bold text-2xl tracking-tight text-teak-700">Akbar</span>
                </a>
                
                {{-- Desktop Nav Links --}}
                <div class="hidden md:ml-10 md:flex md:space-x-1">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-2 rounded-sm text-sm font-medium transition-all duration-300 {{ request()->routeIs('home') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:text-teak-800 hover:bg-sand-50' }}">Beranda</a>
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-3 py-2 rounded-sm text-sm font-medium transition-all duration-300 {{ request()->routeIs('catalog.*') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:text-teak-800 hover:bg-sand-50' }}">Katalog</a>
                    <a href="{{ route('custom-order.create') }}" class="inline-flex items-center px-3 py-2 rounded-sm text-sm font-medium text-sand-600 hover:text-teak-800 hover:bg-sand-50 transition-all duration-300">Custom Order</a>
                    <a href="{{ route('tracking.index') }}" class="inline-flex items-center px-3 py-2 rounded-sm text-sm font-medium transition-all duration-300 {{ request()->routeIs('tracking.*') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:text-teak-800 hover:bg-sand-50' }}">Lacak Pesanan</a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-3 py-2 rounded-sm text-sm font-medium transition-all duration-300 {{ request()->routeIs('about') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:text-teak-800 hover:bg-sand-50' }}">Tentang Kami</a>
                </div>
            </div>
            
            {{-- Desktop Right Actions --}}
            <div class="hidden md:ml-6 md:flex md:items-center space-x-3">
                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative p-2 rounded-sm text-sand-500 hover:text-teak-700 hover:bg-sand-50 transition-all duration-300 group">
                    <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    @php $cartCount = collect(session('cart', []))->sum('qty'); @endphp
                    @if($cartCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-teak-700 rounded-full shadow-sm ring-2 ring-white">{{ $cartCount }}</span>
                    @endif
                </a>
                
                {{-- Divider --}}
                <div class="h-5 w-px bg-sand-200"></div>
                
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-medium text-sand-600 hover:text-teak-700 px-3 py-2 rounded-sm hover:bg-sand-50 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        Login
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 text-sm font-medium text-sand-700 hover:text-teak-800 px-3 py-2 rounded-sm hover:bg-sand-50 focus:outline-none transition-all duration-300">
                            <div class="w-7 h-7 rounded-full bg-teak-100 flex items-center justify-center text-xs font-bold text-teak-700">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden lg:block">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-sand-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-sm bg-white border border-sand-200/60 shadow-lg py-1 z-50 dropdown-animate" style="display: none;">
                            <div class="px-4 py-2 border-b border-sand-100">
                                <p class="text-sm font-semibold text-sand-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-sand-400">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('customer.profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-sand-700 hover:bg-sand-50 hover:text-teak-800 transition duration-150">
                                <svg class="w-4 h-4 text-sand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('customer.orders') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-sand-700 hover:bg-sand-50 hover:text-teak-800 transition duration-150">
                                <svg class="w-4 h-4 text-sand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                                Pesanan Saya
                            </a>
                            @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-sand-700 hover:bg-sand-50 hover:text-teak-800 transition duration-150">
                                    <svg class="w-4 h-4 text-sand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                                    Dashboard Admin
                                </a>
                            @endif
                            <div class="border-t border-sand-100 mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
            
            {{-- Mobile: Cart + Hamburger --}}
            <div class="-mr-2 flex items-center md:hidden gap-2">
                <a href="{{ route('cart.index') }}" class="relative p-2 text-sand-500 hover:text-teak-700 transition duration-300">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    @if($cartCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-teak-700 rounded-full shadow-sm ring-2 ring-white">{{ $cartCount }}</span>
                    @endif
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-sm text-sand-500 hover:text-teak-700 hover:bg-sand-50 focus:outline-none transition duration-300">
                    <svg x-show="!mobileMenuOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="h-5 w-5" style="display:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="md:hidden border-t border-sand-200/60 bg-white/95 backdrop-blur-xl" style="display: none;">
        <div class="py-2 space-y-0.5 px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-sm text-base font-medium transition duration-300 {{ request()->routeIs('home') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:bg-sand-50 hover:text-teak-800' }}">Beranda</a>
            <a href="{{ route('catalog.index') }}" class="block px-3 py-2.5 rounded-sm text-base font-medium transition duration-300 {{ request()->routeIs('catalog.*') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:bg-sand-50 hover:text-teak-800' }}">Katalog</a>
            <a href="{{ route('custom-order.create') }}" class="block px-3 py-2.5 rounded-sm text-base font-medium text-sand-600 hover:bg-sand-50 hover:text-teak-800 transition duration-300">Custom Order</a>
            <a href="{{ route('tracking.index') }}" class="block px-3 py-2.5 rounded-sm text-base font-medium transition duration-300 {{ request()->routeIs('tracking.*') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:bg-sand-50 hover:text-teak-800' }}">Lacak Pesanan</a>
            <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-sm text-base font-medium transition duration-300 {{ request()->routeIs('about') ? 'text-teak-700 bg-teak-50 font-semibold' : 'text-sand-600 hover:bg-sand-50 hover:text-teak-800' }}">Tentang Kami</a>
        </div>
        <div class="py-3 px-3 border-t border-sand-200/50">
            @guest
                <a href="{{ route('login') }}" class="flex items-center gap-2 px-3 py-2.5 text-base font-medium text-sand-600 hover:text-teak-800 hover:bg-sand-50 rounded-sm transition duration-150">
                    <svg class="w-5 h-5 text-sand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    Login
                </a>
            @else
                <div class="flex items-center gap-3 px-3 py-2 mb-2">
                    <div class="w-8 h-8 rounded-full bg-teak-100 flex items-center justify-center text-xs font-bold text-teak-700">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-sand-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-sand-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('customer.orders') }}" class="block px-3 py-2.5 text-base font-medium text-sand-600 hover:text-teak-800 hover:bg-sand-50 rounded-sm transition duration-150">Pesanan Saya</a>
                @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 text-base font-medium text-sand-600 hover:text-teak-800 hover:bg-sand-50 rounded-sm transition duration-150">Dashboard Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2.5 text-base font-medium text-red-600 hover:bg-red-50 rounded-sm transition duration-150">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
