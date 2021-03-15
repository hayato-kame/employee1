@extends('layouts.myapp')

@section('title', 'Show')

@section('menubar')
   @parent
   ユーザー詳細ページ
@endsection

@section('content')

    @if(isset($user))
        <h3>{{ $user->name }}さんの詳細ページ</h3>

        

    @endif
@endsection

@section('footer')
copyright 2021 kameyama
@endsection
