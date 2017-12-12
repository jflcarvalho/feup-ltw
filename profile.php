<?php
include_once('includes/init.php');
include_once('includes/session.php');
checkUserSession();

include_once('templates/header.php');

function displayProfile($user = null) {
?>
<body onload="initCalendar()">

    <?php
        include_once('templates/nav-bar.php');
        userNavBar();
        include_once('templates/calendar.php');
        include_once('show_user_info.php');
    ?>

    <section class="profile-container" id="profile">
        <?php $user? getUserProfile($user) : displayCurrUserInfo(); ?>
    </section>

    <footer>
        &copy; 2017 EzeeDo
    </footer>

</body>
<?php
}

displayProfile($_GET['user']);
?>