@extends('ViewAll.vendor.Template')

@section('title', 'Search')

@section('sub-judul', 'Search')

@section('content')
    <div class="row">
        @foreach ($searchResults as $item)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg"
                        data-setbg="{{ isset($item['images']['webp']['image_url']) ? $item['images']['webp']['image_url'] : 'placeholder.jpg' }}">
                        <div class="ep"> ? </div>
                        <div class="view"><i class="fa fa-eye"></i>{{ isset($item['members']) ? $item['members'] : '' }}
                        </div>
                    </div>
                    <div class="product__item__text">
                        <ul>
                            @if (isset($item['genres']))
                                @foreach ($item['genres'] as $genre)
                                    <li>{{ $genre['name'] }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
