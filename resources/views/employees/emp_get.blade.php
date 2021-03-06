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
        <p style="color: red ;">入力に問題があります</p>
    @endif
   
    @if(isset($employee))
        @if ( $action == "edit")
        <h3>社員ID: {{ $employee->employee_id }} の{{$label}}ページ</h3>
        @else
        <h3>社員の{{$label}}ページ</h3>
        @endif 
        {{-- <h3>社員の{{$label}}ページ</h3> --}}
        {{-- フラッシュメッセージ --}}
        @if (session('flash_message'))
        <p class="notice">
            メッセージ：{{ session('flash_message') }}
        </p>
        @endif
        
        <div class="toolbar">{!! link_to_route('employees.index', '社員一覧ページへ戻る',[]) !!}</div>
        
        <div class="row cmt">
            <div class="col-sm-6 offset-sm-3">
                    {{-- 新規作成の時には、空のインスタンスをコントローラで作ってるから
                    編集の時にも表示するが、変更不可  よって社員IDは、表示だけ--}}
                {{-- RESTのルーティングじゃないから　メソッドは post --}}
                @if ( $action == "edit")
                <h4>社員ID: {{ $employee->employee_id }} </h4>
                @endif 

                {{-- フォームはファイルのアップロードをサポートしていますか？  
laravelcollectiveフォームファサードを使用してこれを追加する方法'files' => true --}}
                {!! Form::model($employee, ['route' => ['employees.emp_post', $employee->employee_id ], 'method' => 'post', 'files' => true]) !!}
                
                    {{-- action と  社員ID 写真ID を hidden で送信します --}}
                    {!! Form::hidden('action', $action) !!}
                    {!! Form::hidden('employee_id', $employee->employee_id) !!}
                    {!! Form::hidden('photo_id', $employee->photo_id) !!}

                    @error('name')
                    <p class="validation">{{$message}}</p>
                    @enderror
                    <div class="form-group">
                        {!! Form::label('name', '名前:') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div> 

                    @error('age')
                    <p class="validation">{{$message}}</p>
                    @enderror
                    <div class="form-group">
                        {!! Form::label('age', '年齢:') !!}
                        {!! Form::text('age', null, ['class' => 'form-control']) !!}
                    </div>

                    @error('gender')
                    <p class="validation">{{$message}}</p>
                    @enderror                   
                    <div class="form-check form-check-inline">
                        {{ Form::radio('gender', '男', false, ['id' => 'radio-one', 'class' => 'form-check-input']) }}
                        {{ Form::label('radio-one', '男性', ['class' => 'form-check-label']) }}
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('gender', '女', false, ['id' => 'radio-two', 'class' => 'form-check-input']) }}
                        {{ Form::label('radio-two', '女性', ['class' => 'form-check-label']) }}
                    </div>

                    {{-- 写真の表示 imgタグは ブロック要素で囲む p とか div などで囲む --}} 
                    {{-- 新規作成のページの時には壊れた画像の表示を出したくないので、
                    src 属性の値を "" 空文字にすればいい けど、下のようにもできる --}}

                    <div style="margin-top:15px" >
                        @if ( $action == "edit" )                            
                            写真:
                            <img src="data:image/{{$employee->photo->mime_type}};base64,{{$photo_data}}" alt="写真" title="社員の写真" width="300" height="250">
                        @endif
                    </div>

                    {{-- 写真のアップロードemployeesは 'photo_id' カラムしかもってない--}}                           
                    @error('photo_id')
                    <p class="validation">{{$message}}</p>
                    @enderror
                    @error('photo_data')
                    <p class="validation">{{$message}}</p>
                    @enderror
                    {{-- 画像のためにフォームタグの'files' => trueが必要である --}}
                    <div class="form-group">                          
                        {!! Form::label('photo_data', '写真:') !!}                           
                        {!! Form::file('photo_data', null, ['class' => 'form-control', 'accept' => ".jpeg, .jpg, .png"]) !!}
                        {!! Form::hidden('photo_id', $employee->photo_id) !!}
                    </div> 
                    
                    <div class="form-group">
                        {{-- 直接blade.phpファイルに書くか、public/jsフォルダでも切ってインクルードする。
                        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script> --}}
                        @error('zip_number')
                        <p class="validation">{{$message}}</p>
                        @enderror
                        <small>※ 000-0000 の形式で入力してください</small><br>
                        {!! Form::label('zip_number', '郵便番号:') !!}
                        {!!  Form::text('zip_number', null, [ 'onkeyup'=>"AjaxZip3.zip2addr(this,'','pref','address1','address2','address3') "], ['class' => 'form-control' ]);  !!}<br>
                        {{-- なぜか都道府県が1個後ろにズレる…。とりあえず空要素を先頭に入れてみた。プルダウンの場合は、都道府県コードで返ってきている？ --}}
                    </div> 
                    <div class="form-group">       
                        @error('pref')
                        <p class="validation">{{$message}}</p>
                        @enderror
                        {!! Form::label('pref', '都道府県:') !!}
                        {!! Form::select('pref', [ '', '北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'], $employee->pref  , ['class' => 'form-control', 'placeholder' => '選択してください']); !!}<br>
                    </div> 
                    <div class="form-group">         
                        @error('address1')
                        <p class="validation">{{$message}}</p>
                        @enderror
                        {!! Form::label('address1', '住所（市区町村郡）:') !!}
                        {!!  Form::text('address1', null, ['class' => 'form-control']); !!}
                    </div> 
                    <div class="form-group">             
                        @error('address2')
                        <p class="validation">{{$message}}</p>
                        @enderror
                        {!! Form::label('address2', '住所（町名番地）:') !!} 
                        {!!  Form::text('address2', null, ['class' => 'form-control']); !!}
                    </div> 
                    <div class="form-group">             
                        @error('address3')
                        <p class="validation">{{$message}}</p>
                        @enderror
                        {!! Form::label('address3', '住所（建物名や番号）:') !!} 
                        {!!  Form::text('address3', null, ['class' => 'form-control']); !!}
                    </div> 
                    
                    @error('department_id')
                    <p class="validation">{{$message}}</p>
                    @enderror                                              
                    {{--  $dep_name は連想配列です D01 から総務部 D02 営業部 D03 経理部　そのほか --}}
                    @if($action === "add")
                        <div class="form-group">
                        {!! Form::label('department_id','所属:') !!}
                        {!! Form::select('department_id',   $dep_name , null, ['class' => 'form-control' , 'placeholder' => '選択してください']); !!}
                        </div>
                    @elseif($action === "edit")
                        <div class="form-group">
                        {!! Form::label('department_id','所属:') !!}
                        {!! Form::select('department_id',   $dep_name , $employee->department_id, ['class' => 'form-control' ]); !!}
                        </div>
                    @endif

                    @error('hire_date')
                    <p class="validation">{{$message}}</p>
                    @enderror
                    <div class="form-group">
                        {!! Form::label('hire_date', '入社日:') !!}
                        {!! Form::date('hire_date', $employee->hire_date, ['class' => 'form-control']) !!}
                    </div> 

                    @error('retire_date')
                    <p class="validation">{{$message}}</p>
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
