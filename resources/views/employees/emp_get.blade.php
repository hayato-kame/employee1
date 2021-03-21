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
   社員{{$label}}ページ
@endsection

@section('content')
    
       
        @if (count($errors) > 0)
            <p>入力に問題があります</p>
        @endif

        
        @if(isset($employee))
            <h3>社員の{{$label}}ページ</h3>
            {{-- フラッシュメッセージ --}}
            @if (session('flash_message'))
            <p class="notice">
                メッセージ：{{ session('flash_message') }}
            </p>
            @endif
            
            <div class="toolbar">{!! link_to_route('employees.index', '社員一覧ページへ戻る',[]) !!}</div>
            
            <div class="row">
                <div class="col-sm-6 offset-sm-3">

                     {{-- 新規作成の時には、社員IDが表示される、空のインスタンスをコントローラで作ってるから
                        編集の時にも表示するが、変更不可  よって社員IDは、表示だけ--}}
                    {{-- RESTのルーティングじゃないから　メソッドは post --}}
                    @if ( $action == "edit")
                    <h3>社員ID: {{ $employee->employee_id }} </h3>
                    @endif 
                    {!! Form::model($employee, ['route' => ['employees.emp_post', $employee->employee_id ], 'method' => 'post']) !!}
                    
                        @error('employee_name')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('name', '名前:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>


                        @error('employee_age')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('age', '年齢:') !!}
                            {!! Form::text('age', null, ['class' => 'form-control']) !!}
                        </div>

                        @error('employee_gender')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('gender', '性別:') !!}
                            {!! Form::text('gender', null, ['class' => 'form-control']) !!}
                        </div>

                        {{-- 写真の表示 imgタグは ブロック要素で囲む p とか div などで囲む --}} 
                        {{-- <div>写真:
                            <img src="PhotoImage?photo=<%=employeeBean.getPhotoId() %>" alt="写真" title="社員の写真" width="300" height="250">
                        </div> --}}

                                {{-- 写真のアップロード --}}
                        @error('employee_gender')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('employee_image', '写真:') !!}
                            {!! Form::hidden('photo_id', $employee->photo_id) !!}
                            {!! Form::file('employee_image', null, ['class' => 'form-control', 'accept' => ".jpeg, .jpg, .png"]) !!}
                        </div>                     


                        {!! Form::submit('送信', ['class' => 'btn btn-primary' , 'confirm' => 'この内容で送信しますか？']) !!}
                    {!! Form::close() !!}  
                    
                        <div style="margin-top:10px">
                    {!! Form::model($employee, ['route' => ['employees.emp_post', $employee->employee_id ], 'method' => 'post']) !!}
                        {!! Form::hidden('action', "cancel") !!}
                        {!! Form::submit('キャンセル', ['class' => 'btn btn-primary' ]) !!}
                    {!! Form::close() !!} 
                      
                </div>
            </div>

        @endif


@endsection

@section('footer')
copyright 2021 kameyama
@endsection


