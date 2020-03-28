@extends('layouts.app')

@section('content')

<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <center><h3 class="letra">Iniciar Sesion</h3></center>
                
            </div>
            <div class="card-body"  >
                <form method="POST" action="{{ route('login') }}">
                        @csrf
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user cwhite"></i> </span>
                        </div>
                        <!-- <input type="text" class="form-control" placeholder="Nombre Usuario" > -->
                         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Nombre Usuario">
                          @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key cwhite "></i></span>
                        </div>
                        <!-- <input type="password" class="form-control" placeholder="contraseña" > -->
                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"  placeholder="contraseña">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="row align-items-center remember">
                        <!-- <input type="checkbox">Recuérdame -->
                         <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>{{ __('Remember Me') }}

                                   <!--  <label class="form-check-label" for="remember">
                                        
                                    </label> -->
                    </div>

                    <center><div class="form-group " >
                        <!-- <input type="submit" value="Iniciar" class="btn  login_btn cwhite"> -->
                        <button type="submit" class=" btn login_btn cwhite">
                                    {{ __('Login') }}
                                </button><br>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                    </div></center>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    No tienes una Cuenta?<!-- <a href="">Registrate</a> -->
                      <a  href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>
                <div class="d-flex justify-content-center">
                    <!-- <a href="#">Olvidaste tu contraseña?</a>- -->
                    <!-- <a href="index.html"> Regresar</a> -->
                </div>

            </div>
        </div>
    </div>
</div>
<style type="text/css">
    
/*@import url('https://fonts.googleapis.com/css?family=Numans');*/

html,body{
background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg');
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;
}
.pt-4, .py-4{
        padding-top: 10% !important;
}
.container{
height: 100%;
align-content: center;
}

.card{
height: 370px;
margin-top: auto;
margin-bottom: auto;
width: 400px;
background-color: rgba(0,0,0,0.5) !important;
}

.social_icon span{
font-size: 60px;
margin-left: 10px;
color: #3F7B26;
}

.social_icon span:hover{
color: white;
cursor: pointer;
}

.card-header h3{
color: white;
}

.social_icon{
position: absolute;
right: 20px;
top: -45px;
}

.input-group-prepend span{
width: 50px;
background-color: #3F7B26;
color: black;
border:0 !important;
}

input:focus{
outline: 0 0 0 0  !important;
box-shadow: 0 0 0 0 !important;

}

.remember{
color: white;
}

.remember input
{
width: 15px;
height: 15px;
margin-left: 15px;
margin-right: 5px;
}

.login_btn{
color: black;
background-color: #3F7B26;
width: 100px;
}

.login_btn:hover{
color: black;
background-color: white;
}

.links{
color: white;
}

.links a{
margin-left: 4px;
}
.cwhite{
  color: white;
}
.letra{
    font-family: Arial, Helvetica, sans-serif;
}
</style>
@endsection
