{{-- @authによってログインしてるユーザだけ見られる --}}
    {{-- @auth @else @endauth は、ミドルウェアで'middleware' => 'auth'　をつけてるから本当はいらないかも --}}

@auth
{{-- link_to_route　なので　'/dashboard'  ではない --}}
<div class="toolbar">{!! link_to_route('dashboard', 'DashBoardページへ',[]) !!}</div>
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

            {{-- @ifによって自分だけが見れる $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            @if($user == Auth::user())
            <table class="noborder">
                <tr><td class="noborder"><button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('users.show', '詳細ページ', ['user' => Auth::id()]) !!}</button></td>
                <td class="noborder">{!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
                    {!! Form::submit('削除', ['class' => 'btn btn-danger' , 'onclick' => 'confirm("本当に削除してよろしいですか")']) !!}
                {!! Form::close() !!}</td></tr>
            </table>

        </td>

        @endif
        
    </tr>
    @endforeach
</table>

@endif

{{-- ページネーションのリンク --}}

{{ $users->links() }}

{{-- どこかのページへのリンクをあとでつくる
    link_to_route('messages.create', '新規メッセージの投稿', [], ['class' => 'btn btn-primary']　　--}}

    {{-- ログインしてなかったら --}}
@else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
    @if (Route::has('register'))
    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
    @endif

@endauth

{{-- <button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('users.show', '詳細ページ', ['user' => Auth::id()]) !!}</button>
        {!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
            {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm']) !!}
        {!! Form::close() !!} --}}
