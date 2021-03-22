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

                    {{-- フォームはファイルのアップロードをサポートしていますか？  
                    
インスタンス$request['a_file']ではなく文字列を提供しているようですUploadedFile。フォームはファイルのアップロードをサポートしていますか？

laravelcollectiveフォームファサードを使用してこれを追加する方法'files' => true --}}
                    {!! Form::model($employee, ['route' => ['employees.emp_post', $employee->employee_id ], 'method' => 'post', 'files' => true]) !!}
                    
                        {{-- action と  社員ID 写真ID を hidden で送信します --}}
                        {!! Form::hidden('action', $action) !!}
                        {!! Form::hidden('employee_id', $employee->employee_id) !!}
                        {!! Form::hidden('photo_id', $employee->photo_id) !!}

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
                        {{-- 新規作成のページの時には壊れた画像の表示を出したくないので、
                        src 属性の値を "" 空文字にすればいい けど、下のようにもできる --}}

   
                        <div>写真:
                            @if ( $action == "edit" )
                                {{-- @if ($photo->photo_data != null && $photo->mime_type != null) --}}
                            
                                <img src="data:image/{{$employee->photo->mime_type}};base64,{{$image}}" alt="写真" title="社員の写真" width="300" height="250">
                               
                                {{-- @endif --}}
                            @endif
                        </div>

                                {{-- 写真のアップロード 'photo_id' カラムしかもってない--}}
                                {{-- imageカラムはないが 'employees.emp_post'に送ってる --}}

                        @error('photo_id')
                        <p>{{$message}}</p>
                        @enderror
                        {{-- フォームタグの'files' => trueが必要である --}}
                        <div class="form-group">
                            {!! Form::label('image', '写真:') !!}                           
                            {!! Form::file('image', null, ['class' => 'form-control', 'accept' => ".jpeg, .jpg, .png"]) !!}
                            {!! Form::hidden('photo_id', $employee->photo_id) !!}
                        </div> 
                        
                        @error('zip_number')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('zip_number', '郵便番号:') !!}
                            {!! Form::text('zip_number', null, ['class' => 'form-control']) !!}
                        </div> 


                        @error('pref')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('pref', '都道府県:') !!}
                            {!! Form::text('pref', null, ['class' => 'form-control']) !!}
                        </div> 


                        

                        @error('address')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('address', '住所:') !!}
                            {!! Form::text('address', null, ['class' => 'form-control']) !!}
                        </div> 

                        @error('department_id')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('department_id', '所属:') !!}
                            {!! Form::text('department_id', $employee->department->department_name , ['class' => 'form-control']) !!}
                        </div> 

                        @error('hire_date')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('hire_date', '入社日:') !!}
                            {!! Form::date('hire_date', $employee->hire_date, ['class' => 'form-control']) !!}
                        </div> 

                        @error('retire_date')
                        <p>{{$message}}</p>
                        @enderror
                        <div class="form-group">
                            {!! Form::label('retire_date', '退社日:') !!}
                            {!! Form::date('retire_date', $employee->retire_date, ['class' => 'form-control']) !!}
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


