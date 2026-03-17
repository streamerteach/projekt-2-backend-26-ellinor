<h2>Log in:</h2>
<form id= 'loginform' action="./index.php?form=login" method="POST">
    Username:<input type="text" name="username" required>
    Password:<input type="password" name="password" required>
</form>
<button type="submit" name ="login" form= 'loginform'>Log in</button>

<p>Don't have an account yet?</p> 
<a href='./index.php?form=signup'>Sign up!</a>