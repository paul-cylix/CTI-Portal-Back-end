<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CTI Portal Reset Password</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="section-form">
        <div class="container">
            
            <div class="container-logo">
                <img class="logo" src="{{ asset('images/cylix.png') }}" alt="cylix">
            </div>
            
            <form class="main-form" method="POST" action="{{ route('reset.password') }}">
                @csrf
                @if(Session::get('response') === true)
                <div class="response-success">
                    <p class="response-title">Password reset successfully!</p>
                    <p class="response-detail">Your new password is <strong class="response-password">Letmein2022</strong></p>
                </div>
                @elseif (Session::get('response') === false)
                <div class="response-failed">
                    <p class="response-title">Can't find Cylix email address!</p>
                </div>
                @else
                <h1>Reset your password</h1>
                <p>Lost your Cylix portal password? Enter your email address.</p>
                @endif

                
                <div class="container-form">
                    <label for="email">Email Address <span>*</span></label>
                    <input required type="email" name="email" placeholder="username@mailserver.domain" id="email">
                    {{-- <span class="validation-message">Invalid email address</span> --}}
                </div>
                <button>Reset password</button>
            </form>
        </div>
    </div>
</body>

</html>