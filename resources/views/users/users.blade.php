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
        @auth
            @if($user == Auth::user())
        <td class="noborder">
            {{-- 自分だけが見れるようにすること $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            <button>{!! link_to('users/show', '詳細ページ', ['user' => Auth::id()]) !!}</button>

        </td>
        <td class="noborder">

            {{-- 自分だけが削除できるようにすること $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            <button>{!! link_to('users/destroy', '削除ページ', ['user' => Auth::id()]) !!}</button>
        </td>
            @endif
        @endauth
    </tr>
    @endforeach
</table>

@endif
