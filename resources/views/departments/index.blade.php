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

         {{-- RESTful じゃないから 'method' => 'put'  じゃない --}}
        <td>{!! Form::open(['route' => ['departments.dep_get', $department->department_id], 'method' => 'get'])  !!}
            {!! Form::hidden('action', "edit")  !!}
            {!! Form::hidden('department_id', $department->department_id)  !!}
            {!! Form::hidden('department_name', $department->department_name)  !!}
            {!! Form::submit('編集', ['class' => 'btn btn-primary' ]) !!}
            {!! Form::close() !!}
        </td>

        {{-- RESTful じゃないから 'method' => 'delete'  じゃない --}}
        <td>{!! Form::open(['route' => ['departments.dep_post', $department->department_id], 'method' => 'post'])  !!}
            {!! Form::hidden('action', "delete")  !!}
            {!! Form::hidden('department_id', $department->department_id)  !!}
            {!! Form::submit('削除', ['class' => 'btn btn-danger' , 'onclick' => 'confirm("本当に削除してよろしいですか")']) !!}
            {!! Form::close() !!}
        </td>   
        
    </tr>
    @endforeach
</table>

@endif
<div>
    {{-- 第三引数で ? のクエリー文字列を指定できてます --}}
<button type="button" class="btn btn-light" display="inline-block">{!! link_to_route('departments.dep_get', '部署新規作成ページ', ['action' => "add", ] , []) !!}</button>
</div>

@endsection

@section('footer')
copyright 2021 kameyama
@endsection
