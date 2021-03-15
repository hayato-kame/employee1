@extends('layouts.myapp')

@section('title', 'Index')

@section('menubar')
   @parent
   ユーザー一覧ページ
@endsection

@section('content')

   {{-- ユーザー一覧 --}}
   @include('users.users')

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
