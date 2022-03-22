<?php

//Als er nog geen log in in de Session is opgeslagen, wordt het automatisch op false gezet
if(!isset($_SESSION['loggedIn'])){
    $_SESSION['loggedIn'] = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<header>
    <!-- adds navbar and bootstap link -->
    <?php include_once('./view/navbar.php') ?>
</header>

<body>
    <div class="container">

        <h1>Lorem Ipsum</h1>
        <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In suscipit leo nec erat tincidunt, nec accumsan
            nisl fringilla. Pellentesque porttitor sodales fringilla. Fusce sed tincidunt nisl. Donec sagittis vehicula
            orci sed ullamcorper. Aenean congue rutrum lectus eu imperdiet. In tristique erat eu sapien efficitur
            bibendum. Mauris in turpis nulla. In pretium elementum felis non faucibus. Vestibulum mauris mi, facilisis
            non euismod vitae, consectetur vel orci. In pellentesque ligula risus, sit amet feugiat orci molestie non.
            Quisque in imperdiet elit. Nam nec sapien tristique, egestas libero sed, venenatis massa. Ut erat massa,
            pharetra ac felis venenatis, sagittis tristique magna. In nisl erat, dapibus a orci at, aliquet vestibulum
            mi.</h3>

        <h3> Vivamus volutpat fermentum tincidunt. Proin blandit rhoncus sapien nec bibendum. Duis interdum quam nec
            orci
            porta, in semper turpis condimentum. Suspendisse vitae justo et leo vestibulum congue. Donec et sapien
            iaculis, pretium urna sit amet, cursus ligula. Etiam et volutpat enim. Cras imperdiet, sapien ut facilisis
            tempor, purus augue vulputate metus, non elementum mi sapien a justo. Donec non tincidunt turpis, a
            malesuada nisl.</h3>
    </div>
</body>

</html>