@extends('layouts.myapp')

@section('title', 'Edit')

@section('menubar')
   @parent
   ユーザー編集ページ
@endsection

@section('content')
    {{-- 自分だけが編集  削除  できるようにすること $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
    {{-- @if (Auth::check()) @else  @endif  と同じ意味の  @auth  @else  @endauth  --}}
    @auth
        @if(isset($user))
            <h3>{{ $user->name }}さんの編集ページ</h3>

            <div class="toolbar">{!! link_to_route('users.show', 'ユーザ詳細ページへ戻る',['user' => Auth::id()]) !!}</div>

            <div class="row">
                <div class="col-sm-6 offset-sm-3">

                    {{-- $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
                    {!! Form::model($user, ['route' => ['users.update', Auth::user()->id], 'method' => 'put']) !!}

                   
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('更新', ['class' => 'btn btn-primary' , 'confirm' => 'この内容で更新しますか？']) !!}
                    {!! Form::close() !!}

            

                </div>
            </div>



        @endif

       {{-- ログインしてなかったら --}}
    @else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

    @endauth

@endsection

@section('footer')
copyright 2021 kameyama
@endsection


