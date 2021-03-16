@extends('layouts.myapp')

@section('title', 'Show')

@section('menubar')
   @parent
   ユーザー詳細ページ
@endsection

@section('content')
    {{-- @if (Auth::check()) @else  @endif  と同じ意味の  @auth  @else  @endauth  --}}
    @auth
        @if(isset($user))
            <h3>{{ $user->name }}さんの詳細ページ</h3>

            <table>
                <tr><th>id</th><th>name</th><th>email</th><th></th><th></th></tr>
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    @if($user == Auth::user())
                    <td><button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('users.edit', '編集', ['user' => $user->id]) !!}</button></td>

                    <td>{!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
                        {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'confirm("本当に削除してよろしいですか")']) !!}
                        {!! Form::close() !!}</td>
                </tr>
            </table>

                {{-- 自分だけが編集  削除  できるようにすること $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}

            @endif

        @endif

       {{-- ログインしてなかったら --}}
    @else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

    @endauth

@endsection

@section('footer')
copyright 2021 kameyama
@endsection


