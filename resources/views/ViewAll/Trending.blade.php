@extends('ViewAll.vendor.Template')

@section('title', 'All-Trending')

@section('sub-judul', 'Trending Now')

@section('content')
    @foreach ($response->data as $item)
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="product__item">
                <div class="product__item__pic set-bg" data-setbg="{{ $item->images->jpg->image_url }}">
                    <div class="ep">{{ $item->score }} </div>
                    <div class="view"><i class="fa fa-eye"></i>
                        {{ number_format($item->members) }} </div>
                </div>
                <div class="product__item__text">
                    <ul>
                        @foreach ($item->genres as $genre)
                            <li>{{ $genre->name }}</li>
                        @endforeach
                    </ul>
                    <h5><a href="/detail-manga/{{ $item->mal_id }}">{{ $item->title }}
                        </a></h5>
                </div>
            </div>
        </div>
    @endforeach
@endsection
