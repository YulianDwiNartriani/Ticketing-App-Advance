<div class="navbar bg-base-100 shadow-sm relative z-50">
  <div class="fixed top-0 left-0 z-[9999] bg-red-600 text-white px-4 py-2">
      NAVBAR TEST
  </div>
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </div>
    </div>
    <img src="{{ asset('assets/images/lokatix.png') }}" class="h-8" />
  </div>
  
  <div class="navbar-center hidden lg:flex relative z-[100]">
      <div class="relative w-80">
          <input
              type="text"
              id="search-input"
              name="search"
              class="input input-bordered w-full text-xs"
              placeholder="Cari Event (min. 3 huruf)..."
              autocomplete="off"
              data-test="SEARCH-NAVBAR-AKTIF"
          />

          <div
              id="search-results"
              class="absolute left-0 right-0 top-full mt-2 bg-white border border-gray-200 rounded-xl shadow-xl hidden z-[999] max-h-60 overflow-y-auto"
          ></div>
      </div>
  </div>

  <div class="navbar-end gap-2">
    <a href="{{ route('login') }}" class="btn bg-blue-900 text-white btn-sm">Login</a>
    <a href="{{ route('register') }}" class="btn text-blue-900 btn-sm">Register</a>
  </div>
</div>

<script>
console.log("🔥 NAVBAR SEARCH FILE AKTIF");
(function () {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    if (!searchInput || !searchResults) {
        console.error('Search element tidak ditemukan', {
            searchInput,
            searchResults
        });
        return;
    }

    console.log('Search initialized');

    searchInput.addEventListener('input', async function () {
        const query = this.value.trim();

        console.log('Sedang mengetik:', query);

        if (query.length < 3) {
            searchResults.innerHTML = '';
            searchResults.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`/api/search-events?q=${encodeURIComponent(query)}`);

            console.log('Response API:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }

            const data = await response.json();

            console.log('Data diterima dari backend:', data);

            searchResults.innerHTML = '';

            if (data.length > 0) {
                data.forEach(event => {
                    const item = document.createElement('a');

                    item.href = `/events/${event.id}`;
                    item.className = 'block px-4 py-3 text-xs font-semibold text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition border-b border-gray-100 bg-white';
                    item.textContent = event.judul;

                    searchResults.appendChild(item);
                });

                searchResults.classList.remove('hidden');
            } else {
                searchResults.innerHTML = `
                    <div class="px-4 py-3 text-xs text-gray-400 text-center bg-white">
                        Event tidak ditemukan
                    </div>
                `;

                searchResults.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error fetching search:', error);

            searchResults.innerHTML = `
                <div class="px-4 py-3 text-xs text-red-400 text-center bg-white">
                    Gagal mengambil data event
                </div>
            `;

            searchResults.classList.remove('hidden');
        }
    });

    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
})();
</script>