<header class="flex shadow-md py-4 px-4 sm:px-10 bg-white min-h-[70px] tracking-wide relative z-50">
      <div class="flex flex-wrap items-center justify-between gap-5 w-full">
        <a href="{{ route('home') }}" class="max-sm:hidden flex items-center space-x-3">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Konveksi" class="w-12 h-12 object-contain rounded-lg" />
            <span class="text-xl font-bold text-gray-900">Konveksi Surabaya</span>
        </a>
        <a href="{{ route('home') }}" class="hidden max-sm:block">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Konveksi" class="w-10 h-10 object-contain rounded-lg" />
        </a>

        <div id="collapseMenu"
          class="max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50">
          <button id="toggleClose" class="lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white w-9 h-9 flex items-center justify-center border border-gray-200 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-black" viewBox="0 0 320.591 320.591">
              <path
                d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                data-original="#000000"></path>
              <path
                d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                data-original="#000000"></path>
            </svg>
          </button>

          <ul
            class="lg:flex gap-x-4 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50">
            <li class="mb-6 hidden max-lg:block">
              <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Konveksi" class="w-10 h-10 object-contain rounded-lg" />
                <span class="text-lg font-bold text-gray-900">Konveksi Surabaya</span>
              </a>
            </li>
            <li class="max-lg:border-b max-lg:border-gray-300 max-lg:py-3 px-3">
              <a href='{{ route('home') }}'
                class="hover:text-slate-700 text-slate-700 block font-medium text-[15px]">Beranda</a>
            </li>
            <li class="max-lg:border-b max-lg:border-gray-300 max-lg:py-3 px-3"><a href='{{ route('layanan.index') }}'
              class="hover:text-slate-700 text-slate-900 block font-medium text-[15px]">Layanan</a>
            </li>
            <li class="max-lg:border-b max-lg:border-gray-300 max-lg:py-3 px-3"><a href='{{ route('katalog.index') }}'
              class="hover:text-slate-700 text-slate-900 block font-medium text-[15px]">Katalog</a>
            </li>
            <li class="max-lg:border-b max-lg:border-gray-300 max-lg:py-3 px-3"><a href='{{ route('frontend.portfolio.index') }}'
              class="hover:text-slate-700 text-slate-900 block font-medium text-[15px]">Portfolio</a>
            </li>
            <li class="max-lg:border-b max-lg:border-gray-300 max-lg:py-3 px-3"><a href='{{ route('about.index') }}'
              class="hover:text-slate-700 text-slate-900 block font-medium text-[15px]">Tentang Kami</a>
            </li>
            <li class="max-lg:border-b max-lg:border-gray-300 max-lg:py-3 px-3"><a href='{{ route('contact.index') }}'
              class="hover:text-slate-700 text-slate-900 block font-medium text-[15px]">Kontak</a>
            </li>
          </ul>
        </div>

        <div class="flex max-lg:ml-auto space-x-3">
          @auth
            <div class="relative">
              <!-- Avatar Dropdown Button -->
              <button id="userMenuButton" class="flex items-center space-x-2 px-3 py-2 rounded-full hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-slate-500">
                <div class="w-8 h-8 bg-slate-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-sm text-slate-700 hidden sm:block">{{ auth()->user()->name }}</span>
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>

              <!-- Dropdown Menu -->
              <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                <div class="py-1">
                  <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                  </div>
                  <a href="{{ route('pesanan.riwayat') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Riwayat Pesanan
                  </a>
                  <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors">
                      <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                      </svg>
                      Logout
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @else
            <a href="{{ route('login') }}" class="px-4 py-2 text-sm rounded-full font-medium cursor-pointer tracking-wide text-slate-900 border border-blue-400 bg-transparent hover:bg-blue-50 transition-all">Masuk</a>
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm rounded-full font-medium cursor-pointer tracking-wide text-white border border-blue-600 bg-blue-600 hover:bg-blue-700 transition-all">Daftar</a>
          @endauth

          <button id="toggleOpen" class="lg:hidden cursor-pointer">
            <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
      </div>
    </header>
