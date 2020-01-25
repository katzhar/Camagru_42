<!DOCTYPE html>
    <html lang="en">
    <style>
        div {
            border-radius: 3px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        form {
            margin: 10px;
        }
        #container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            height: 100%;
            width: 100%;
            margin-top: 15%;
        }
        #one {
            color: rgb(82, 82, 82);
            height: 80%;
            width: 20%;
            background: linear-gradient(20deg, #f9e6ff, #e6f9ff);
            padding: 1%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.2);
        }
        #two {
            font-size: 9px;
            padding: 1%;
        }
        a {
            text-decoration: none;
            color: rgb(82, 82, 82);
        }
        a:hover {
            font-weight: bold; 
        }
        #three {
            font-size: 9px;
            color: rgb(82, 82, 82);
            height: 20%;
            width: 20%;
            background: linear-gradient(20deg, #f9e6ff, #e6f9ff);
            padding: 1%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.2);
        }
    </style>
    	<title>Camagru | Log In</title>
    <body>
      <div id="container">
        <div id="one">
            CAMAGRU<br><br>
            <form method="post" action="/auth/login">
                <input type="text" name="login" placeholder="e-mail" value="" required="required"><br><br>
                <input type="password" name="password" placeholder="password" value="" required="required"><br><br>
       <input type="submit" name="submit" value="Log In"><br>
       </form>
       <div id="two">
       <a href="#">FORGET YOUR PASSWORD?</a><br>
      </div>
      </div>
      <br>
    <div id="three">
        DON'T HAVE AN ACCOUNT? <a href="/signup">SIGN UP</a><br>
    </div>
        </div>
    </body>
    </html>