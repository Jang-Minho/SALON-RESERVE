<head>
    <script src="../../js/menu-active.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<div class="salon_top">
    <div class="salon_header">
        <img src="/img/salon.png" alt="" width="250" height="100" />

        <div class="salon_menu">
            <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="../review/index.php">Reviews</a></li>
                    <li><a href="../contact-form/index.php">問い合わせ</a></li>
                @guest

                    <li><a href="{{ url('/login') }}">ログイン</a></li>
                @endguest
                @auth
                    @if (auth()->user()->is_admin === 1)
                        <div class="dropdown-box">
                            <button type="button" class="dropdown-toggle">
                                {{ auth()->user()->name_sei }} {{ auth()->user()->name_mei }}さん
                            </button>

                            <div class="dropdown-menu" style="display: none;">
                                <a href="{{ route('dashboard') }}" wire:navigate>プロファイル</a>
                                <a href="{{ url('/admin/posts')}}">掲示板管理</a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">ログアウト</button>
                                </form>
                            </div>

                        </div>
                    @elseif(auth()->user()->is_admin === 0)

                        <div class="dropdown-box">
                            <button type="button" class="dropdown-toggle">
                                {{ auth()->user()->name_sei }} {{ auth()->user()->name_mei }}さん
                            </button>

                            <div class="dropdown-menu" style="display: none;">
                                <a href="{{ route('dashboard') }}" wire:navigate>プロファイル</a>
                                

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">ログアウト</button>
                                </form>
                            </div>

                        </div>
                    @endif

                @endauth


            </ul>
        </div>

    </div>
    <div class="salon_footer">
        <img src="../../img/main_picture.png" alt="">
    </div>
</div>
