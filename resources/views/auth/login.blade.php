<!DOCTYPE html>
<html>
<head>
	<title>Fundación Katupyry</title>
	{{-- <link rel="stylesheet" type="text/css" href="css/style.css"> --}}
    <link href="{{Storage::url('iconos/favicon16x16.png')}}" rel="icon">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@300&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
    {{-- @vite(['resources/login/css/style.css', 'resources/login/js/main.js']) --}}
    <link rel="stylesheet" href="{{asset('rostro/css/style.css')}}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	{{-- <img class="wave" src="{{Storage::url('iconos/wave.png')}}"> --}}
	<div class="container">
		<div class="img">
			<img src="{{Storage::url('iconos/login_po.jpg')}}">
		</div>
		<div class="login-content">
			<form method="POST" action="{{ route('login') }}">
                @csrf
				<a href="{{route('inicio')}}"><img class="logo" src="{{Storage::url('iconos/logo_katu.jpg')}}"></a>
				<h2 class="title">Bienvenido</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Usuario</h5>
           		   		<input type="text" id="email" name="email" class="input">
                        @error('email')
                            <p>
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i">
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Contraseña</h5>
           		    	<input type="password"  name="password" id="password" class="input">
                        @error('password')
                            <p>
                                <strong>{{ $message }}</strong>
                            </p>
                        @enderror
            	   </div>
            	</div>
            	{{-- <a href="#">Forgot Password?</a> --}}
            	{{-- <input type="submit" class="btn" value="Iniciar Sessión"> --}}
                <button type="submit" class="btn"><span>Iniciar Session</span></button>
            </form>

            {{-- <div style="margin-top: 5px">
                @error('email')
                    <span style="color: red;margin-top:5px">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
        </div>
    </div>
    <script type="text/javascript" src="{{asset('rostro/js/main.js')}}"></script>
</body>
</html>
