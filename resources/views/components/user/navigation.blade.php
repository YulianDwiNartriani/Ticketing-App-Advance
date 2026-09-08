<div class="navbar bg-base-100 shadow-sm">
    <div class="navbar-start pl-4">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
        </div>
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/lokatix.png') }}" alt="Logo LokaTix" class="h-10" />
        </a>
    </div>
    <div class="navbar-center hidden lg:flex relative z-[100]">
        <div class="relative w-72">
            <input
                type="text"
                id="search-input"
                name="search"
                class="input input-bordered w-full"
                placeholder="Cari Event..."
                autocomplete="off"
            />

            <div
                id="search-results"
                class="absolute left-0 right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-xl hidden z-[999] max-h-60 overflow-y-auto">
            </div>
        </div>
    </div>
    <div class="navbar-end gap-2">
        <!-- check user session -->
        @guest
            <a href="{{ route('login') }}" class="btn bg-blue-900 text-white">Login</a>
            <a href="{{ route('register') }}" class="btn text-blue-900">Register</a>
        @endguest

        @auth
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost rounded-btn">
                    Halo, {{ Auth::user()->name }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                    <li>
                        <a href="{{ route('orders.index') }}" class="justify-between">
                            Riwayat Pembelian
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @endauth



    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    if (!searchInput || !searchResults) {
        console.warn('Search element tidak ditemukan!');
        return;
    }

    console.log('🔥 USER NAVIGATION SEARCH AKTIF');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        console.log('Sedang mengetik:', query);

        if (query.length < 3) {
            searchResults.innerHTML = '';
            searchResults.classList.add('hidden');
            return;
        }

        fetch(`/api/search-events?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }

                return response.json();
            })
            .then(data => {
                console.log('Data diterima dari backend:', data);

                searchResults.innerHTML = '';

                if (data.length > 0) {
                    searchResults.classList.remove('hidden');

                    data.forEach(event => {
                        const item = document.createElement('a');

                        item.href = `/events/${event.id}`;
                        item.className = 'block px-4 py-3 text-sm font-semibold text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition border-b border-gray-100 bg-white';
                        item.textContent = event.judul;

                        searchResults.appendChild(item);
                    });
                } else {
                    searchResults.innerHTML = `
                        <div class="px-4 py-3 text-sm text-gray-400 text-center bg-white">
                            Event tidak ditemukan
                        </div>
                    `;

                    searchResults.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error fetching search:', error);

                searchResults.innerHTML = `
                    <div class="px-4 py-3 text-sm text-red-400 text-center bg-white">
                        Gagal mencari event
                    </div>
                `;

                searchResults.classList.remove('hidden');
            });
    });

    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>