@extends('layouts.myapp')

@section('title', 'Index')

@section('menubar')
   @parent
   社員一覧ページ
@endsection

@section('content')

    <h3>社員一覧:</h3>
    {{-- フラッシュメッセージ --}}
    @if (session('flash_message'))
        <p class="notice">
        メッセージ：{{ session('flash_message') }}
        </p>
    @endif

    <div class="toolbar">{!! link_to_route('dashboard', 'Dashboardへ戻る',[]) !!}</div>

    @if (count($employees) > 0)
        {{-- 従業員一覧を表示する --}}
        @include('employees.employees')
    @endif

    {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  --}}
    <button style="margin-right: 15px" type="button" class="btn btn-light" display="inline-block">{!! link_to_route('employees.emp_get', '社員新規作成ページ', ['action' => "add", ] , []) !!}</button>

    {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  --}}
    <button style="margin-right: 15px" type="button" class="btn btn-light" display="inline-block">{!! link_to_route('employees.find', '検索...', [] , []) !!}</button>
    
    {{-- CSVのボタンは、社員が一人でもいたら、表示することにする --}}
    {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  --}}
    <button style="margin-right: 15px" type="button" class="btn btn-light" display="inline-block">{!! link_to_route('employees.emp_get', 'CSVファイルに出力', [] , []) !!}</button>

    <hr>
    {{-- ページネーション  --}}
    {{ $employees->links() }}
@endsection

@section('footer')
copyright 2021 kameyama
@endsection
