<h1>Hello {{$user->name}}</h1>


<p>
    Please reset your password by clicking <a href="{{env('APP_URL')}}/reset/{{$user->email}}/{{$code}}">here</a>
</p>