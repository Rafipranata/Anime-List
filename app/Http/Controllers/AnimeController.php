<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class AnimeController extends Controller
{
    public function Anime()
    {
        $data = Http::get("https://api.jikan.moe/v4/top/anime");
        $dataAnime = Http::get("https://api.jikan.moe/v4/seasons/now");
        $dataManga = Http::get("https://api.jikan.moe/v4/top/manga");
        $dataAnimeNew = Http::get("https://api.jikan.moe/v4/anime/");
        $decodedData = json_decode($data, true);
        $decodedDataAnime = json_decode($dataAnime, true);
        $decodedDataManga = json_decode($dataManga, true);
        $decodedDataAnimeNew = json_decode($dataAnimeNew, true);
        $JadwalAnime = array_slice($decodedDataAnimeNew['data'], 0, 6);
        $randomAnime = array_slice($decodedDataAnime['data'], 0, 6);
        $randomManga = array_slice($decodedDataManga['data'], 0, 6);
        $topAnime = array_slice($decodedData['data'], 0, 6);
        return view("Anime", [
            "response" => $topAnime,
            "responseAnime" => $randomAnime,
            "responseAnimeNew" => $JadwalAnime,
            "responseManga" => $randomManga,
        ]
        );

    }

    public function detail($id)
    {
        $data = Http::get("https://api.jikan.moe/v4/anime/{$id}");
        $animeDetail = $data->json();

        return view("DetailAnime.Anime_details", [
            "response" => $animeDetail,
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
    
    public function viewAllManga()
    {
        $data = Http::get("https://api.jikan.moe/v4/top/manga");
        return view("ViewAll.Manga", [
            "response" => json_decode($data),
        ]);
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
