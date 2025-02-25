@include('admin._partials.header2')
    <div id="login">
        {{ Form::open(array('route' => 'admin.login.post', 'class' => 'login')) }}
            <h2>Please login</h2>
            @if (Session::has('message') ) 
                <center><p class="error">{{ Session::get('message') }}</p></center>       
            @endif 
            <ul>
                <li>
                    {{ Form::label('username', 'Username') }}
                    {{ Form::text('username') }}
                    {{ $errors->first('username', '<p class="error">:message</p>') }}
                </li>
                <li>
                    {{ Form::label('password', 'Password') }}
                    {{ Form::password('password') }}
                    {{ $errors->first('password', '<p class="error">:message</p>') }}
                </li>
                <li>
                    {{ Form::submit('Log in') }}
                </li>
            </ul>
        {{ Form::close() }}
    </div>
</body>
</html>