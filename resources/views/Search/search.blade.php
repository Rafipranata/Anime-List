@extends('ViewAll.vendor.Template')

@section('title', 'Search Anime')

@section('sub-judul', 'Search Anime')

@section('content')
<div class="col-lg-12" style="margin-bottom: 24px;">

    {{-- Search Input Bar --}}
    <div style="position: relative; margin-bottom: 8px;">
        <input
            id="live-search-input"
            type="text"
            value="{{ $searchTerm ?? '' }}"
            placeholder="Ketik nama anime... (min. 2 karakter)"
            autocomplete="off"
            style="
                width: 100%;
                padding: 14px 50px 14px 18px;
                background: #1c1c2e;
                border: 2px solid #6c5ce7;
                border-radius: 8px;
                color: #fff;
                font-size: 16px;
                outline: none;
                transition: border-color 0.2s;
            "
        >
        {{-- Spinner icon --}}
        <span id="search-spinner" style="
            display: none;
            position: absolute;
            right: 16px; top: 50%;
            transform: translateY(-50%);
            color: #6c5ce7;
        ">
            <i class="fa fa-spinner fa-spin fa-lg"></i>
        </span>
    </div>

    {{-- Status text --}}
    <p id="search-status" style="color: #a0a0b0; font-size: 13px; margin: 0 0 16px 2px;">
        @if($searchTerm)
            Menampilkan hasil untuk: <strong style="color:#fff">{{ $searchTerm }}</strong>
        @else
            Mulai mengetik untuk mencari anime...
        @endif
    </p>
</div>

{{-- Results Container --}}
<div id="search-results" class="row" style="width:100%; margin:0;">
    {{-- Diisi oleh JavaScript --}}
    @if(!$searchTerm)
    <div class="col-12" style="text-align:center; padding: 60px 0; color: #666;">
        <i class="fa fa-search fa-3x" style="margin-bottom:16px; color:#6c5ce7;"></i>
        <p style="font-size:16px;">Cari anime favoritmu di sini</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
(function () {
    const input       = document.getElementById('live-search-input');
    const results     = document.getElementById('search-results');
    const spinner     = document.getElementById('search-spinner');
    const statusText  = document.getElementById('search-status');
    const apiUrl      = '{{ route("anime.search.api") }}';

    let debounceTimer = null;
    let currentQuery  = '';

    // Jalankan search awal kalau ada query dari URL
    const initialQuery = input.value.trim();
    if (initialQuery.length >= 2) {
        doSearch(initialQuery);
    }

    input.addEventListener('input', function () {
        const q = this.value.trim();
        clearTimeout(debounceTimer);

        if (q.length < 2) {
            results.innerHTML = `
                <div class="col-12" style="text-align:center; padding:60px 0; color:#666;">
                    <i class="fa fa-search fa-3x" style="margin-bottom:16px; color:#6c5ce7;"></i>
                    <p style="font-size:16px;">Ketik minimal 2 karakter...</p>
                </div>`;
            statusText.innerHTML = 'Mulai mengetik untuk mencari anime...';
            spinner.style.display = 'none';
            return;
        }

        // Debounce 400ms — tunggu user selesai mengetik
        spinner.style.display = 'inline';
        statusText.innerHTML = 'Mencari <strong style="color:#fff">' + q + '</strong>...';

        debounceTimer = setTimeout(() => doSearch(q), 400);
    });

    function doSearch(q) {
        if (q === currentQuery) return;
        currentQuery = q;

        spinner.style.display = 'inline';

        fetch(apiUrl + '?q=' + encodeURIComponent(q))
            .then(res => res.json())
            .then(json => {
                spinner.style.display = 'none';
                renderResults(json.data, q);
            })
            .catch(() => {
                spinner.style.display = 'none';
                results.innerHTML = `
                    <div class="col-12" style="text-align:center; padding:60px 0; color:#e74c3c;">
                        <i class="fa fa-exclamation-circle fa-3x" style="margin-bottom:16px;"></i>
                        <p>Gagal mengambil data. Coba beberapa saat lagi.</p>
                    </div>`;
            });
    }

    function renderResults(data, q) {
        statusText.innerHTML = data.length > 0
            ? 'Ditemukan <strong style="color:#fff">' + data.length + ' anime</strong> untuk: <strong style="color:#fff">' + q + '</strong>'
            : 'Tidak ada hasil untuk: <strong style="color:#fff">' + q + '</strong>';

        if (data.length === 0) {
            results.innerHTML = `
                <div class="col-12" style="text-align:center; padding:60px 0; color:#666;">
                    <i class="fa fa-frown-o fa-3x" style="margin-bottom:16px;"></i>
                    <p style="font-size:16px;">Anime tidak ditemukan</p>
                </div>`;
            return;
        }

        results.innerHTML = data.map(item => `
            <div class="col-lg-4 col-md-6 col-sm-6" style="margin-bottom: 24px;">
                <div class="product__item">
                    <div class="product__item__pic set-bg"
                         style="background-image: url('${item.image}'); background-size: cover; background-position: center;">
                        <div class="ep">${item.score !== 'N/A' ? '⭐ ' + item.score : 'N/A'}</div>
                        <div class="view">
                            <i class="fa fa-eye"></i>
                            ${formatNumber(item.members)}
                        </div>
                    </div>
                    <div class="product__item__text">
                        <ul>
                            ${item.genres.slice(0, 2).map(g => `<li>${g}</li>`).join('')}
                            ${item.type ? `<li>${item.type}</li>` : ''}
                        </ul>
                        <h5>
                            <a href="/detail-anime/${item.mal_id}">${item.title}</a>
                        </h5>
                        <small style="color:#888;">
                            ${item.episodes !== '?' && item.episodes ? item.episodes + ' eps · ' : ''}${item.status}
                        </small>
                    </div>
                </div>
            </div>
        `).join('');

        // Re-init background images (pakai fungsi dari main.js template)
        if (typeof $ !== 'undefined') {
            $('.set-bg').each(function () {
                var bg = $(this).data('setbg');
                if (bg) $(this).css('background-image', 'url(' + bg + ')');
            });
        }
    }

    function formatNumber(n) {
        if (!n) return '0';
        if (n >= 1000000) return (n / 1000000).toFixed(1) + 'M';
        if (n >= 1000) return (n / 1000).toFixed(1) + 'K';
        return n.toString();
    }
})();
</script>
@endpush
