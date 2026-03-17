<h2>Sign up:</h2>
<form action="./index.php?form=signup" method="POST">
    Email:<input type="email" name="email" required><br>
    Username:<input type="text" name="username" required><br>
    Real name:<input type="text" name="realname" required><br>
    Password:<input type="text" name="password" required><br>
    Zip code: <input type="int" name="zip" required><br>
    Bio: <input type="text" name="bio" required><br>
    Annual salary: <input type="int" name="salary" required><br>
    Gender:
    <p>
        <input type="radio" id="woman" name="gender" value="1" required>
        <label for="woman">woman</label><br>
        <input type="radio" id="man" name="gender" value="2">
        <label for="man">man</label><br>
        <input type="radio" id="non-binary" name="gender" value="3">
        <label for="non-binary">non-binary</label><br>
        <input type="radio" id="other" name="gender" value="4">
        <label for="other">other / prefer not to say</label>
    </p>
    Dating preference:
    <p>
        <input type="radio" id="women" name="preference" value="1" required>
        <label for="women">women</label><br>
        <input type="radio" id="men" name="preference" value="2">
        <label for="men">men</label><br>
        <input type="radio" id="both" name="preference" value="3">
        <label for="both">both</label><br>
        <input type="radio" id="other" name="preference" value="4">
        <label for="other">other</label><br>
        <input type="radio" id="all" name="preference" value="5">
        <label for="all">all</label>
    </p>
    <input type="submit" name="signup" value="Sign up">
</form>

<p>Already have an account?</p> 
<a href='./index.php?form=login'>Log in here</a>