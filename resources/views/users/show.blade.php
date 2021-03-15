@extends('layouts.myapp')

@section('title', 'Show')

@section('menubar')
   @parent
   ユーザー詳細ページ
@endsection

@section('content')

    @if(isset($user))
        <h3>{{ $user->name }}さんの詳細ページ</h3>

        @if($user == Auth::user())

        {{-- 自分だけが削除できるようにすること $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
        <button>{!! link_to_route('users.destroy', '削除', ['user' => Auth::id()]) !!}</button>
         @endif

    @endif
@endsection

@section('footer')
copyright 2021 kameyama
@endsection
