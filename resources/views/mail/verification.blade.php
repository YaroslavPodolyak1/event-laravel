<h1>Hello {{$user->name}}, confirm your email</h1>
<p>Для завершения регистрации перейдите <a href='{{ url("register/verification/{$user->token}") }}'>по ссылке </a>!</p>