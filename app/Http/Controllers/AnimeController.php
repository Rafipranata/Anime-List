<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AnimeController extends Controller
{
    /**
     * Cache duration in minutes.
     * Homepage list data: 30 menit
     * Detail data per item: 60 menit (jarang berubah)
     * Search: 10 menit
     */
    private const CACHE_SHORT  = 10;   // menit - search
    private const CACHE_MEDIUM = 30;   // menit - homepage lists
    private const CACHE_LONG   = 60;   // menit - detail page

    /**
     * Helper: fetch dari API dengan caching — return array asosiatif.
     * Dipakai untuk homepage & detail (blade pakai $item['key']).
     */
    private function fetchApi(string $url, int $minutes = self::CACHE_MEDIUM): array
    {
        $cacheKey = 'jikan_arr_' . md5($url);

        return Cache::remember($cacheKey, now()->addMinutes($minutes), function () use ($url) {
            try {
                $response = Http::timeout(10)->get($url);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("Jikan API gagal: {$url} | Status: {$response->status()}");
                return [];
            } catch (\Exception $e) {
                Log::error("Jikan API error: {$url} | " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Helper: fetch dari API dengan caching — return stdClass object.
     * Dipakai untuk ViewAll pages (blade pakai $response->data, $item->title).
     */
    private function fetchApiAsObject(string $url, int $minutes = self::CACHE_MEDIUM): ?object
    {
        $cacheKey = 'jikan_obj_' . md5($url);

        return Cache::remember($cacheKey, now()->addMinutes($minutes), function () use ($url) {
            try {
                $response = Http::timeout(10)->get($url);

                if ($response->successful()) {
                    return json_decode($response->body());
                }

                Log::warning("Jikan API gagal: {$url} | Status: {$response->status()}");
                return null;
            } catch (\Exception $e) {
                Log::error("Jikan API error: {$url} | " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Helper to fetch sidebar top views data
     */
    private function getSidebarTopViews(): array
    {
        return $this->fetchApi("https://api.jikan.moe/v4/top/anime?limit=10&filter=bypopularity", self::CACHE_MEDIUM);
    }

    public function Anime()
    {
        // Semua request di-cache terpisah — tidak perlu ke API kalau masih fresh
        $topAnimeRaw      = $this->fetchApi('https://api.jikan.moe/v4/top/anime',            self::CACHE_MEDIUM);
        $seasonNowRaw     = $this->fetchApi('https://api.jikan.moe/v4/seasons/now',           self::CACHE_MEDIUM);
        // User requested to change popular manga to live action (movie/live action API)
        $liveActionRaw    = $this->fetchApi('https://api.jikan.moe/v4/top/anime?type=movie',  self::CACHE_MEDIUM);
        $upcomingRaw      = $this->fetchApi('https://api.jikan.moe/v4/seasons/upcoming',      self::CACHE_MEDIUM);
        $mangaRekomendasi = $this->fetchApi('https://api.jikan.moe/v4/recommendations/manga', self::CACHE_MEDIUM);

        return view('Anime', [
            'response'            => array_slice($topAnimeRaw['data']      ?? [], 0, 6),
            'responseAnime'       => array_slice($seasonNowRaw['data']     ?? [], 0, 6),
            'responseManga'       => array_slice($liveActionRaw['data']    ?? [], 0, 6), // Passing live action as responseManga to avoid breaking blade
            'responseAnimeNew'    => array_slice($upcomingRaw['data']      ?? [], 0, 6),
            'responseAnimeRekomen'=> array_slice($mangaRekomendasi['data'] ?? [], 0, 6),
        ]);
    }

    public function detail($id)
    {
        $animeDetail    = $this->fetchApi("https://api.jikan.moe/v4/anime/{$id}",            self::CACHE_LONG);
        $animeCharacter = $this->fetchApi("https://api.jikan.moe/v4/anime/{$id}/characters", self::CACHE_LONG);

        if (empty($animeDetail)) {
            abort(404);
        }

        return view('DetailAnime.Anime_details', [
            'response'     => $animeDetail,
            'responseChar' => $animeCharacter,
        ]);
    }

    public function detailManga($id)
    {
        $mangaDetail = $this->fetchApi("https://api.jikan.moe/v4/manga/{$id}", self::CACHE_LONG);

        if (empty($mangaDetail)) {
            abort(404);
        }

        return view('DetailManga.Manga_details', [
            'response' => $mangaDetail,
        ]);
    }

    public function viewAllPopular()
    {
        $data = $this->fetchApiAsObject('https://api.jikan.moe/v4/top/anime', self::CACHE_MEDIUM);
        $topViews = $this->getSidebarTopViews();

        return view('ViewAll.Popular', [
            'response' => $data,
            'topViews' => $topViews['data'] ?? [],
        ]);
    }

    public function viewAllTrending()
    {
        $data = $this->fetchApiAsObject('https://api.jikan.moe/v4/seasons/now', self::CACHE_MEDIUM);
        $topViews = $this->getSidebarTopViews();

        return view('ViewAll.Trending', [
            'response' => $data,
            'topViews' => $topViews['data'] ?? [],
        ]);
    }

    public function viewAllUpcoming()
    {
        $data = $this->fetchApiAsObject('https://api.jikan.moe/v4/seasons/upcoming', self::CACHE_MEDIUM);
        $topViews = $this->getSidebarTopViews();

        return view('ViewAll.Upcoming', [
            'response' => $data,
            'topViews' => $topViews['data'] ?? [],
        ]);
    }

    public function viewAllManga()
    {
        $data = $this->fetchApiAsObject('https://api.jikan.moe/v4/top/manga', self::CACHE_MEDIUM);
        $topViews = $this->getSidebarTopViews();

        return view('ViewAll.Manga', [
            'response' => $data,
            'topViews' => $topViews['data'] ?? [],
        ]);
    }

    public function search(Request $request)
    {
        // Render halaman search — hasil diload via AJAX
        $searchTerm = trim($request->input('q', ''));
        return view('Search.search', ['searchTerm' => $searchTerm]);
    }

    /**
     * AJAX endpoint — return JSON untuk live search.
     * Dipanggil oleh JavaScript setiap kali user mengetik (debounce 400ms).
     */
    public function searchApi(Request $request)
    {
        $searchTerm = trim($request->input('q', ''));

        if (strlen($searchTerm) < 2) {
            return response()->json(['data' => []]);
        }

        $data = $this->fetchApi(
            "https://api.jikan.moe/v4/anime?q=" . urlencode($searchTerm) . "&limit=20&sfw=true",
            self::CACHE_SHORT
        );

        return response()->json([
            'data' => array_map(fn($item) => [
                'mal_id'    => $item['mal_id'],
                'title'     => $item['title'],
                'image'     => $item['images']['webp']['image_url'] ?? $item['images']['jpg']['image_url'] ?? '',
                'score'     => $item['score'] ?? 'N/A',
                'episodes'  => $item['episodes'] ?? '?',
                'members'   => $item['members'] ?? 0,
                'genres'    => array_map(fn($g) => $g['name'], $item['genres'] ?? []),
                'type'      => $item['type'] ?? '',
                'status'    => $item['status'] ?? '',
            ], $data['data'] ?? [])
        ]);
    }

    public function detailWatch($id)
    {
        $animeWatch = $this->fetchApi("https://api.jikan.moe/v4/anime/{$id}",        self::CACHE_LONG);
        $animeData  = $this->fetchApi("https://api.jikan.moe/v4/anime/{$id}/videos", self::CACHE_LONG);

        if (empty($animeWatch)) {
            abort(404);
        }

        return view('Detail_view', [
            'response'      => $animeWatch,
            'responseAnime' => $animeData,
        ]);
    }
}
