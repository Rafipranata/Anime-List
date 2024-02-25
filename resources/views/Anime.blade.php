<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/plyr.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">


    <title>yi</title>
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="index.html">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="index.html">Homepage</a></li>
                                <li><a href="categories.html">Categories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="categories.html">Categories</a></li>
                                        <li><a href="anime-details.html">Anime Details</a></li>
                                        <li><a href="anime-watching.html">Anime Watching</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                        <li><a href="signup.html">Sign Up</a></li>
                                        <li><a href="login.html">Login</a></li>
                                    </ul>
                                </li>
                                <li><a href="blog.html">Our Blog</a></li>
                                <li><a href="#">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <a href="login.html"><span class="icon_profile"></span></a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Adventure</div>
                                <h2>Fate / Stay Night: Unlimited Blade Works</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Adventure</div>
                                <h2>Fate / Stay Night: Unlimited Blade Works</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Adventure</div>
                                <h2>Fate / Stay Night: Unlimited Blade Works</h2>
                                <p>After 30 days of travel across the world...</p>
                                <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="trending__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Trending Now</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="/View-All/Trending" class="primary-btn">View All <span
                                            class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($responseAnime as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg"
                                            data-setbg="{{ $item['images']['jpg']['image_url'] }}">
                                            <div class="ep">{{ $item['score'] }} </div>
                                            <div class="view"><i class="fa fa-eye"></i>
                                                {{ number_format($item['members']) }} </div>
                                        </div>
                                        <div class="product__item__text">
                                            <ul>
                                                @foreach ($item['genres'] as $genre)
                                                    <li>{{ $genre['name'] }}</li>
                                                @endforeach
                                            </ul>
                                            <h5><a href="/detail-anime/{{ $item['mal_id'] }}">{{ $item['title'] }}
                                                </a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach




                        </div>
                    </div>
                    <div class="popular__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Popular Shows</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="/View-All/Popular" class="primary-btn">View All <span
                                            class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($response as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg"
                                            data-setbg="{{ $item['images']['jpg']['image_url'] }}">
                                            <div class="ep">{{ $item['score'] }} </div>
                                            <div class="view"><i class="fa fa-eye"></i>
                                                {{ number_format($item['members']) }} </div>
                                        </div>
                                        <div class="product__item__text">
                                            <ul>
                                                @foreach ($item['genres'] as $genre)
                                                    <li>{{ $genre['name'] }}</li>
                                                @endforeach
                                            </ul>
                                            <h5><a href="/detail-anime/{{ $item['mal_id'] }}">{{ $item['title'] }}
                                                </a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Random Anime</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="#" class="primary-btn">View All <span
                                            class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($responseAnimeNew as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg"
                                            data-setbg="{{ $item['images']['jpg']['image_url'] }}">
                                            <div class="ep">{{ $item['score'] }} </div>
                                            <div class="view"><i class="fa fa-eye"></i>
                                                {{ number_format($item['members']) }} </div>
                                        </div>
                                        <div class="product__item__text">
                                            <ul>
                                                @foreach ($item['genres'] as $genre)
                                                    <li>{{ $genre['name'] }}</li>
                                                @endforeach
                                            </ul>
                                            <h5><a href="/detail-anime/{{ $item['mal_id'] }}">{{ $item['title'] }}
                                                </a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="live__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>POPULAR MANGA</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="/View-All/Manga" class="primary-btn">View All <span
                                            class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            @foreach ($responseManga as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg"
                                            data-setbg="{{ $item['images']['jpg']['image_url'] }}">
                                            <div class="ep">{{ $item['score'] }} </div>
                                            <div class="view"><i class="fa fa-eye"></i>
                                                {{ number_format($item['members']) }} </div>
                                        </div>
                                        <div class="product__item__text">
                                            <ul>
                                                @foreach ($item['genres'] as $genre)
                                                    <li>{{ $genre['name'] }}</li>
                                                @endforeach
                                            </ul>
                                            <h5><a href="/detail-manga/{{ $item['mal_id'] }}">{{ $item['title'] }}
                                                </a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Top Views</h5>
                            </div>
                            <ul class="filter__controls">
                                <li class="active" data-filter="*">Day</li>
                                <li data-filter=".week">Week</li>
                                <li data-filter=".month">Month</li>
                                <li data-filter=".years">Years</li>
                            </ul>
                            <div class="filter__gallery">
                                <div class="product__sidebar__view__item set-bg mix day years"
                                    data-setbg="img/sidebar/tv-1.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Boruto: Naruto next generations</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix month week"
                                    data-setbg="img/sidebar/tv-2.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix week years"
                                    data-setbg="img/sidebar/tv-3.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Sword art online alicization war of underworld</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix years month"
                                    data-setbg="img/sidebar/tv-4.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
                                </div>
                                <div class="product__sidebar__view__item set-bg mix day"
                                    data-setbg="img/sidebar/tv-5.jpg">
                                    <div class="ep">18 / ?</div>
                                    <div class="view"><i class="fa fa-eye"></i> 9141</div>
                                    <h5><a href="#">Fate stay night unlimited blade works</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="product__sidebar__comment">
                            <div class="section-title">
                                <h5>Reandom Manga</h5>
                            </div>
                            @foreach ($responseManga as $item)
                                <div class="product__sidebar__comment__item">
                                    <div class="product__sidebar__comment__item__pic">
                                        <img src="{{ $item['images']['jpg']['image_url'] }}" alt="">
                                    </div>
                                    <div class="product__sidebar__comment__item__text">
                                        <ul>
                                            @foreach ($item['genres'] as $genre)
                                                <li>{{ $genre['name'] }}</li>
                                            @endforeach
                                        </ul>
                                        <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                                        <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="index.html">Homepage</a></li>
                            <li><a href="categories.html">Categories</a></li>
                            <li><a href="blog.html">Our Blog</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i
                            class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com/"
                            target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>

                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->



    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/player.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
