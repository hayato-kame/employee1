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
        <table border="1">
            <tr>
                <th>社員ID</th>
                <th>名前</th>
                <th></th><th></th>
            </tr>
            @foreach ($employees as $employee)
            <tr>
                <td>{{$employee->employee_id}}</td>
                <td>{{$employee->name}}</td>
                {{-- RESTful じゃないから 'method' => 'put' フォームの表示をするので'method' => 'get' じゃない --}}
                {{--  Form::open 使うか Form::model　--}}
                <td>
                    {!! Form::model($employee, ['route' => ['employees.emp_get', $employee->employee_id ], 'method' => 'get']) !!}
                    {{-- {!! Form::open(['route' => ['employees.emp_get', $employee->employee_id], 'method' => 'get'])  !!} --}}
                        {!! Form::hidden('action', "edit")  !!}
                        {!! Form::hidden('employee_id', $employee->employee_id)  !!}            
                        {!! Form::submit('編集', ['class' => 'btn btn-primary' ]) !!}
                    {!! Form::close() !!}
                </td>                    
                <td>
                    {{-- RESTful じゃないから 'method' => 'delete'  じゃない 'method' => 'post' です 'method' => 'post' だったら省略可 --}}
                    {!! Form::model($employee, ['route' => ['employees.emp_post', $employee->employee_id], 'method' => 'post'])  !!}
                    {{-- {!! Form::open(['route' => ['employees.emp_post', $employee->employee_id], 'method' => 'post'])  !!} --}}
                        {!! Form::hidden('action', "delete")  !!}
                        {!! Form::hidden('employee_id', $employee->employee_id)  !!}
                        {!! Form::submit('削除', ['class' => 'btn btn-danger' , 'onclick' => 'confirm("本当に削除してよろしいですか")']) !!}
                    {!! Form::close() !!}
                </td>                   
            </tr>
            @endforeach
        </table>
    @endif

    {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  --}}
    <button style="margin-right: 15px" type="button" class="btn btn-light" display="inline-block">{!! link_to_route('employees.emp_get', '社員新規作成ページ', ['action' => "add", ] , []) !!}</button>

    {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  --}}
    <button style="margin-right: 15px" type="button" class="btn btn-light" display="inline-block">{!! link_to_route('employees.emp_get', '検索...', ['action' => "add", ] , []) !!}</button>
    
    {{-- CSVのボタンは、社員が一人でもいたら、表示することにする --}}
    {{-- 第三引数で ? のクエリー文字列を指定できてます  ?action=add   などのクエリー文字列  --}}
    <button style="margin-right: 15px" type="button" class="btn btn-light" display="inline-block">{!! link_to_route('employees.emp_get', 'CSVファイルに出力', ['action' => "add", ] , []) !!}</button>

    <hr>
    {{-- ページネーション  --}}
    {{ $employees->links() }}
@endsection

@section('footer')
copyright 2021 kameyama
@endsection
