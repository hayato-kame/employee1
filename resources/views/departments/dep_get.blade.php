@extends('layouts.myapp')

@php
$label = "";
@endphp

@if ( $action === "add")
@php
    $label = "新規作成";
    
@endphp 
@else
@php
    $label = "編集";

@endphp
@endif


@section('title',$label)

@section('menubar')
   @parent
   部署{{$label}}ページ
@endsection

@section('content')
    
       
        @if (count($errors) > 0)
            <p>入力に問題があります</p>
        @endif

        @error('department_name')
        <p>{{$message}}</p>
        @enderror
  
        @if(isset($department))
            <h3>部署の{{$label}}ページ</h3>
            {{-- フラッシュメッセージ --}}
            @if (session('flash_message'))
            <p class="notice">
              メッセージ：{{ session('flash_message') }}
            </p>
            @endif

            <div class="toolbar">{!! link_to_route('departments.index', '部署一覧ページへ戻る',[]) !!}</div>

            <div class="row">
                <div class="col-sm-6 offset-sm-3">

                    {{-- RESTのルーティングじゃないから　メソッドは post --}}
                    {!! Form::model($department, ['route' => ['departments.dep_post', $department->department_id ], 'method' => 'post']) !!}

                        <div class="form-group">
                            {!! Form::label('department_name', '部署名:') !!}
                            {!! Form::text('department_name', null, ['class' => 'form-control']) !!}
                        </div>

                        {!! Form::hidden('action', $action) !!}
                        {{-- 新規の時にはdepartment_id にはnullが入って送られます --}}
                        {!! Form::hidden('department_id', $department->department_id) !!}
                    
                        {!! Form::submit('送信', ['class' => 'btn btn-primary' , 'confirm' => 'この内容で送信しますか？']) !!}
                    {!! Form::close() !!}  
                    
                        <div style="margin-top:10px">
                    {!! Form::model($department, ['route' => ['departments.dep_post', $department->department_id ], 'method' => 'post']) !!}
                        {!! Form::hidden('action', "cancel") !!}
                        {!! Form::submit('キャンセル', ['class' => 'btn btn-primary' ]) !!}
                    {!! Form::close() !!} 
                        </div>
                </div>
            </div>

        @endif


@endsection

@section('footer')
copyright 2021 kameyama
@endsection


