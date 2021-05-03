<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-icon.png')}}" >
    <style>
        #card-login{
            border-radius: 20px;
        }
    </style>
    <title>My Church</title>
</head>
<body style="background: #A3CEF1">
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-md-3 shadow-lg bg-light p-md-4 m-3 mt-md-5" id="card-login">
                <img class="img-fluid" src="images/logo.png"/>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-12 col-form-label pb-0"><b>{{ __('E-mail') }}</b></label>

                        <div class="col-md-12 pt-0">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-12 col-form-label pb-0"><b>{{ __('Senha') }}</b></label>

                        <div class="col-md-12 pt-0">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Senha" >

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 pt-0">
                            <button type="submit" class="btn btn-primary col-md-12">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>

                    {{-- <div class="form-group row text-center">
                        <div class="col-md-12 pt-0 pb-0">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Esqueceu sua Senha?') }}
                                </a>
                            @endif
                        </div>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</body>
</html>
