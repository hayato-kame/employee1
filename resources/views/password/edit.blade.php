@extends('layouts.myapp')

@section('title', 'Password')

@section('menubar')
   @parent
   ユーザーパスワード編集ページ
@endsection

@section('content')
    {{-- 自分だけが編集  削除  できるようにすること $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
    
    {{-- @if (Auth::check()) @else  @endif  と同じ意味の  @auth  @else  @endauth  --}}
    {{-- @auth は、ミドルウェアで'middleware' => 'auth'　をつけてるから本当はいらないかも --}}
    @auth
        @if(isset($user))
            <h3>{{ $user->name }}さんのパスワード編集ページ</h3>

            {{-- フラッシュメッセージ --}}
            @if (session('flash_message'))

            <p class="notice">
              メッセージ：{{ session('flash_message') }}
            </p>
            @endif

            <div class="toolbar">{!! link_to_route('users.show', 'ユーザ詳細ページへ戻る',['user' => Auth::id()]) !!}</div>

            
                    {{-- $user->id ではなくAuth::id()  Auth::user()->id と同じ --}}
                    {!! Form::model($user, ['route' => ['password.update', Auth::user()->id], 'method' => 'put']) !!}
                   
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3">
                            <table class="table table-striped">
                                <tr>
                                    <td>{!! Form::label('current_password', '現在のパスワード') !!}</td>
                                    <td>{!! Form::password('current_password', ['class' => 'form-control']) !!}</td>
                                </tr>
                                
                                <tr>
                                    <td>{!! Form::label('password', '新しいパスワード') !!}</td>
                                    <td>{!! Form::password('password', ['class' => 'form-control']) !!}</td>
                                </tr>
                                
                                <tr>
                                    <td>{!! Form::label('password_confirmation', '確認のため新しいパスワードを入力') !!}</td>
                                    <td>{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}</td>
                                </tr>
                                
                            </table>
                            
                            <div>{!! Form::submit('変更', ['class' => 'btn btn-primary btn-block']) !!}</div>
                        </div>
                    </div>
                    {!! Form::close() !!}

            

          



        @endif

       {{-- ログインしてなかったら --}}
    @else
    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

    @endauth

@endsection

@section('footer')
copyright 2021 kameyama
@endsection


