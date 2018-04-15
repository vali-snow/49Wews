<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>DV FeedReader Login|Register</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="../js/login.js"></script>
</head>
<body>
    <div class="container">
        <div class="backbox">
            <div class="loginMsg">
                <div class="textcontent">
                    <p class="title">Don't have an account?</p>
                    <p>Sign up to join the fun.</p>
                    <button id="switch1">Sign Up</button>
                </div>
            </div>
            <div class="signupMsg visibility">
                <div class="textcontent">
                    <p class="title">Have an account?</p>
                    <p>Log in to see your feeds.</p>
                    <button id="switch2">Log In</button>
                </div>
            </div>
        </div>
        <div class="frontbox">
            <div class="login">
                <h2>LOG IN</h2>
                <div class="inputbox">
                    <input type="text" name="username" placeholder="USERNAME">
                    <input type="password" name="password" placeholder="PASSWORD">
                    <err></err>
                </div>
                <button>LOG IN</button>
            </div>
            <div class="signup hide">
                <h2>SIGN UP</h2>
                <div class="inputbox">
                    <input type="text" name="username" placeholder="USERNAME">
                    <input type="text" name="email" placeholder="EMAIL">
                    <input type="password" name="password" placeholder="PASSWORD">
                    <err></err>
                    <scs></scs>
                </div>
                <button>SIGN UP</button>
            </div>
        </div>
    </div>
</body>
</html>