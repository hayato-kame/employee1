@extends('layouts.myapp')

@section('title', 'Index')

@section('menubar')
   @parent
   部署一覧ページ
@endsection

@section('content')


<h3>部署一覧:</h3>
{{-- フラッシュメッセージ --}}
@if (session('flash_message'))

<p class="notice">
  メッセージ：{{ session('flash_message') }}
</p>
@endif

{{-- all関数を使ってるので @if　が必要  --}}
@if (count($departments) > 0)

<table border="1">
    <tr>
        <th>部署ID</th>
        <th>部署名</th>
        <th></th><th></th>
    </tr>
    @foreach ($departments as $department)
    <tr>
        <td>{{$department->department_id}}</td>
        <td>{{$department->department_name}}</td>
        {{-- <td><button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('departments.edit', '編集ページ', ['department' => $department->department_id]) !!}</button></td>
        <td>{!! Form::open(['route' => ['departments.destroy', $department->department_id], 'method' => 'delete'])  !!}
            {!! Form::submit('削除', ['class' => 'btn btn-danger' , 'onclick' => 'confirm("本当に削除してよろしいですか")']) !!}
        {!! Form::close() !!}</td>    --}}
        
    </tr>
    @endforeach
</table>

@endif
<div>
<button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('departments.dep_get', '部署新規作成ページ', []) !!}</button>
</div>

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
