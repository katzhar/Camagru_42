<!DOCTYPE html>
    <html lang="en">
    <style>
    	body {
            font-family: Arial;
            padding: 10px;
            background: #f1f1f1;
  	    }
        div {
            border-radius: 3px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        form {
            margin: 10px;
        }
        a {
            text-decoration: none;
            color: rgb(82, 82, 82);
        }
        a:hover {
            font-weight: bold; 
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
            background: linear-gradient(20deg, #c2c2d6, #e6f9ff);
            padding: 1%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.2);
        }
        #two {
            font-size: 9px;
            padding: 1%;
        }
        #three {
            font-size: 9px;
            color: rgb(82, 82, 82);
            height: 20%;
            width: 20%;
            background: linear-gradient(20deg, #c2c2d6, #e6f9ff);
            padding: 1%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.2);
        }
        #msg {
            padding: 3px;
            font-weight: bold;
            text-align: center;
            color: red;
            font-size: 11px;
        }
    </style>
    	<title>Camagru | Reset password</title>
    <body>
      <div id="container">
        <div id="one"><a href="/main">CAMAGRU</a><br><br>
            <form method="post" action="/reset/update">
                <input type="text" name="email" placeholder="e-mail" value="" required="required"><br><br>
                <input type="submit" name="submit" value="Reset password"><br>
       </form>
       <?php
            if (isset($_SESSION['message'])) {
                echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']); 
        ?>
       <div id="two">
       <a href="/auth">BACK TO LOGIN</a><br>
      </div>
      </div>
      <br>
    <div id="three">
    <a href="/signup">CREATE NEW ACCOUNT</a><br>
    </div>
        </div>
    </body>
    </html>