{{-- @authによってログインしてるユーザだけ見られる --}}
@auth
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

            @if($user == Auth::user())
        <td class="noborder">
            {{-- @ifによって自分だけが見れる $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            <button type="button" class="btn btn-light">{!! link_to_route('users.show', '詳細ページ', ['user' => Auth::id()]) !!}</button>

        </td>
        <td class="noborder">

            {{-- @ifによって自分だけが削除できる $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            {!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
                {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm']) !!}
            {!! Form::close() !!}
        </td>
            @endif

        </tr>
        @endforeach
    </table>

    @endif

    {{-- ログインしてなかったら --}}
@else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

@endauth
