<?php
    if(!isset($_SESSION)){
        session_start();
    }
?>
<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarTogglerDemo03"
        aria-controls="navbarTogglerDemo03"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand logo" href="index.php">BOOKIE</a>

    <div
        class="collapse navbar-collapse justify-content-between my-4"
        id="navbarTogglerDemo03"
    >
        <form class="form-inline my-2 my-lg-0 mx-4" id="searchForm" method="GET" action="search_result.php">
            <input
                class="form-control mr-sm-2"
                type="search"
                placeholder="Find Your Bookie"
                aria-label="Search"
                name="search"
                id="search"
            />
            <button class="btn searchBut my-2 my-sm-0" type="submit">
                Search
            </button>
        </form>
        <ul class="navbar-nav navbar-right">
        <li class="nav-item mx-2">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <?php if(!isset($_SESSION['logged_in'])|| empty($_SESSION['logged_in']) 
                || $_SESSION['logged_in'] == false):?>
            <button class="btn signUpBut my-sm-0 px-3" type="submit">
                <a href="signup.php">Sign Up</a>
            </button>
        <?php else:?>
            <li class="nav-item mx-2">
                <a class="nav-link profile" href="profile.php?i=<?php echo $_SESSION['userid']?>"><?php echo $_SESSION['username']?></a>
            </li>
            <button class="btn signUpBut my-sm-0 px-3 mx-2" type="submit">
                <a href="logout.php">Log Out</a>
            </button>
        <?php endif;?>
        </ul>
    </div>
</nav>

