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
        {{--  Form::open 使うか Form::model　編集ボタンを押したら、編集ページの表示をするので、'method' => 'get' です --}}
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
            {!! Form::model($employee, ['route' => ['employees.delete', $employee->employee_id], 'method' => 'post'])  !!}
            {{-- {!! Form::open(['route' => ['employees.emp_post', $employee->employee_id], 'method' => 'post'])  !!} --}}
                {!! Form::hidden('photo_id', $employee->photo->photo_id)  !!}
                {!! Form::hidden('employee_id', $employee->employee_id)  !!}
                {!! Form::submit('削除', ['class' => 'btn btn-danger' , 'onclick' => 'confirm("本当に削除してよろしいですか")']) !!}
            {!! Form::close() !!}
        </td>                   
    </tr>
    @endforeach
</table>