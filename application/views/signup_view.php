<!DOCTYPE html>
    <html lang="en">
    <style>
        div {
            border-radius: 3px;
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: rgb(82, 82, 82);
            height: 80%;
            width: 20%;
            background: linear-gradient(20deg, #f9e6ff, #e6f9ff);
            padding: 1%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.2);
        }
    </style>
    	<title>Camagru | Sign Up</title>
    <body>
      <div id="container">
        <div id="one">
            CAMAGRU<br><br>
            <form method="post" action="/signup/confirm">
                <input type="text" name="e-mail" placeholder="e-mail" value="" required="required"><br><br>
                <input type="text" name="login" placeholder="login" value="" required="required"><br><br>
                <input type="password" name="password" placeholder="password" value="" required="required"><br><br>
                <input type="submit" name="submit" value="Sign Up"><br><br>
       </form>
      </div>
      <br>
        </div>
    </body>
    </html>