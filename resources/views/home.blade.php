<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>美容室WEB</title>
</head>

<body>
    <div class="salon">
        <div class="salon_main">
            @include('top-menu')
        </div>
        <div class="home">
            <div class="home_information">
                <div class="business-hours">
                    <table>
                        <tr>
                            <th class="time">営業時間</th>
                            <th>月</th>
                            <th>火</th>
                            <th>水</th>
                            <th>木</th>
                            <th>金</th>
                            <th style="color: blue;">土</th>
                            <th style="color: red;">日</th>
                        </tr>
                        <tr>
                            <td class="time">10:00～12:00</td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ng"></span></td>
                        </tr>
                        <tr>
                            <td class="time">13:00～20:00</td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ok"></span></td>
                            <td><span class="ng"></span></td>
                            <td><span class="ng"></span></td>
                        </tr>
                    </table>

                </div>
                <div class="phone">
                    <h3>電話番号</h3>
                    <div class="phone_number">
                        <a href="tel:07012345678">📞 090-1234-5678</a>
                    </div>

                </div>
            </div>
            <div class="border">
                <div class="border-h3">
                    <h3>掲示板</h3>
                </div>
                @foreach ($posts as $post)
                    <div class="post">
                        <div class="post-title">
                            <p>タイトル</p>
                            <a href="/post-view/{{ $post->id }}">{{ $post->title }}</a>
                        </div>
                        <div class="post-body">
                            <p>本文</p>
                            <p>{{ Str::limit(strip_tags($post->body), 50) }}</p>
                        </div>
                        <div class="post-date">
                            <p>投稿日時</p>
                            <small>{{ $post->created_at }}</small>
                        </div>

                    </div>
                @endforeach
                <div class="page">
                    {{ $posts->links('vendor.pagination.my-posts') }}
                </div>
            </div>
        </div>



    </div>

</body>

</html>
