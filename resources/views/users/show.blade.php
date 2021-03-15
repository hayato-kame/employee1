@extends('layouts.myapp')

@section('title', 'Show')

@section('menubar')
   @parent
   ユーザー詳細ページ
@endsection

@section('content')
    @auth
        @if(isset($user))
            <h3>{{ $user->name }}さんの詳細ページ</h3>
            {{ $user->id }}
            {{ $user->email }}

            @if($user == Auth::user())

            {{-- 自分だけが削除できるようにすること $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
            {!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete'])  !!}
                {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm']) !!}
            {!! Form::close() !!}
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


