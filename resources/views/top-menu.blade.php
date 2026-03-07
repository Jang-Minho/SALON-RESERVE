<head>
    <script src="../../js/menu-active.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                    <li>
                        <a href="{{ route('profile') }}">
                            {{ auth()->user()->name_sei }} {{ auth()->user()->name_mei }}さん
                            
                        </a>
                    </li>
                @endauth
            </ul>
        </div>

    </div>
    <div class="salon_footer">
        <img src="../../img/main_picture.png" alt="">
    </div>
</div>
