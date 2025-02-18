<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimeController extends Controller
{
    public function Anime()
    {
        $data = Http::get("https://api.jikan.moe/v4/top/anime");
        $dataAnimeRekomen = Http::get("https://api.jikan.moe/v4/recommendations/manga");
        $dataAnime = Http::get("https://api.jikan.moe/v4/seasons/now");
        $dataManga = Http::get("https://api.jikan.moe/v4/top/manga");
        $dataAnimeNew = Http::get("https://api.jikan.moe/v4/seasons/upcoming/");
        $decodedData = json_decode($data, true);
        $decodedDataAnime = json_decode($dataAnime, true);
        $decodedDataManga = json_decode($dataManga, true);
        $decodedAnimeRekomen = json_decode($dataAnimeRekomen, true);
        $decodedDataAnimeNew = json_decode($dataAnimeNew, true);
        $JadwalAnime = array_slice($decodedDataAnimeNew['data'], 0, 6);
        $randomAnime = array_slice($decodedDataAnime['data'], 0, 6);
        $randomAnimeRekomen = array_slice($decodedAnimeRekomen['data'], 0, 6);
        $randomManga = array_slice($decodedDataManga['data'], 0, 6);
        $topAnime = array_slice($decodedData['data'], 0, 6);
        return view("Anime", [
            "response" => $topAnime,
            "responseAnime" => $randomAnime,
            "responseAnimeRekomen" => $randomAnimeRekomen,
            "responseAnimeNew" => $JadwalAnime,
            "responseManga" => $randomManga,
        ]
        );

    }

    public function detail($id)
    {
        $data = Http::get("https://api.jikan.moe/v4/anime/$id");
        $dataChar = Http::get("https://api.jikan.moe/v4/anime/$id/characters");
        $animeDetail = $data->json();
        $animeCharacter = $dataChar->json();

        return view("DetailAnime.Anime_details", [
            "response" => $animeDetail,
            "responseChar" => $animeCharacter,
        ]);
    }

    public function detailManga($id)
    {
        $data = Http::get("https://api.jikan.moe/v4/manga/{$id}");
        $MangaDetail = $data->json();

        return view("DetailManga.Manga_details", [
            "response" => $MangaDetail,
        ]);
    }

    public function viewAllPopular()
    {
        $data = Http::get("https://api.jikan.moe/v4/top/anime");
        return view("ViewAll.Popular", [
            "response" => json_decode($data),
        ]);
    }

    public function viewAllTrending()
    {
        $data = Http::get("https://api.jikan.moe/v4/seasons/now");
        return view("ViewAll.Trending", [
            "response" => json_decode($data),
        ]);
    }

    public function viewAllUpcoming()
    {

        $data = Http::get("https://api.jikan.moe/v4/seasons/upcoming/");

        return view("ViewAll.Upcoming", [
            "response" => json_decode($data),
        ]);

    }

    public function viewAllManga()
    {
        $data = Http::get("https://api.jikan.moe/v4/top/manga");

        return view("ViewAll.Manga", [
            "response" => json_decode($data),
        ]);
    }

    public function Search(Request $request)
    {
        $searchTerm = $request->input('q');

        $response = Http::get("https://api.jikan.moe/v4/search/anime?q=$searchTerm");

        if ($response->successful()) {
            $data = $response->json();

            if ($searchTerm) {
                $searchResults = array_filter($data['data'], function ($anime) use ($searchTerm) {
                    return stripos($anime['title'], $searchTerm) != false;
                });
            } else {
                $searchResults = $data['data'];
            }

            return view('Search.search', [
                'searchTerm' => $searchTerm,
                'searchResults' => $searchResults,
            ]);
        } else {
            return view('errors.404');
        }
    }

    public function detailWatch($id)
    {
        $data = Http::get("https://api.jikan.moe/v4/anime/{$id}");
        $dataAnime = Http::get("https://api.jikan.moe/v4/anime/{$id}/videos");
        $animeWatch = $data->json();
        $animeData = $dataAnime->json();
        return view('Detail_view', [
            "response" => $animeWatch,
            "responseAnime" => $animeData,
        ]);

    }
}
