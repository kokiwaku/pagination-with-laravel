<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

        <style type="text/css">
            tr {
                border-bottom: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <div class="container m-2">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="font-weight-bold" style="font-size: 30px;">オフセットベースのページネーションのテスト</span></p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>title</th>
                        <th>content</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($postsList as $key => $post)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->content }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-12 mt-2">
                {{ $postsList->links() }}
            </div>
        </div>
    </div>
    </body>
</html>
