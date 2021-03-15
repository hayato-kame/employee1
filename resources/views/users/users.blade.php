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
        <td>{{$user->name}}

            @if($user == Auth::user())
            <table class="noborder">
                <tr><td class="noborder"><button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('users.show', '詳細ページ', ['user' => Auth::id()]) !!}</button></td>
                <td class="noborder">{!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
                    {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}</td></tr>
            </table>

        </td>

        @endif
        {{-- @ifによって自分だけが見れる $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
        {{-- @ifによって自分だけが削除できる $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}

    </tr>
    @endforeach
    </table>

    @endif

    {{-- ログインしてなかったら --}}
@else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

@endauth

{{-- <button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('users.show', '詳細ページ', ['user' => Auth::id()]) !!}</button>
        {!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
            {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm']) !!}
        {!! Form::close() !!} --}}
