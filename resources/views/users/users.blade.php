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

        {{-- 自分だけ見られる --}}
        @auth
            @if($user == Auth::user())
        <td class="noborder">
            {{-- @authによって自分だけが見れる $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            <button>{!! link_to_route('users.show', '詳細ページ', ['user' => Auth::id()]) !!}</button>

        </td>
        <td class="noborder">

            {{-- @authによって自分だけが削除できる $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            {!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
                {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm']) !!}
            {!! Form::close() !!}
        </td>
            @endif
        @endauth

    </tr>
    @endforeach
</table>

@endif
