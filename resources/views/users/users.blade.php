@if (count($users) > 0)

<p>ユーザ一覧:</p>
<table border="1">
    <tr>
        <th>ID</th>
        <th>ユーザ名</th>
    </tr>
    @foreach ($users as $user)
    <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        <td>
            {!! link_to('users/show', '詳細ページ', ['user' => $user->id]) !!}
        </td>
        <td>
            {!! link_to('users/destroy', '削除ページ', ['user' => $user->id]) !!}
        </td>
    </tr>
    @endforeach
</table>

@endif
