<link rel="stylesheet" href="css/new-navbar.css">
<header id="navbar">
<a href="login.php" id="logo" class="head-navbar"><h1 id="logo">Sining</h1></a>
    <ul>
        <div class="nav-con">
            <a href="login.php" class="nav-links">
                <li class="nav-item">Buy</li>
            </a>
            <a href="login.php" class="nav-links">
                <li class="nav-item">Sell</li>
            </a>
            <a href="login.php" class="nav-links">
                <li class="nav-item">Newsfeed</li>
            </a>
            <a href="login.php" class="nav-links">
                <li class="nav-item">Notification</li>
            </a>
            <a href="login.php" class="nav-links">
                <li class="nav-item">About</li>
            </a>
        </div>
    </ul>
<!--     
    <div class="search-box1">
        <button onclick="searchFunction()" class="search-btn1">
            <img src="assets/img/search.png">
        </button>
        <input id="search" class="search-txt1" type="text" name="" placeholder="Type to search">
    </div> -->
    <div class="con-btn">
        <div class="drop-down-btn">
            <img id="drop-down" src="assets/img/arrow.png" onclick="openDiv()">
            <div class="hidden" id="myDiv">
                <a href=login.php" class="nav-links">
                    <li class="nav-item">Buy</li><br>
                </a>
                <a href="login.php" class="nav-links">
                    <li class="nav-item">Sell</li>
                </a>
                <a href="login.php" class="nav-links">
                    <li class="nav-item">Newsfeed</li>
                </a>
                <a href="login.php" class="nav-links">
                    <li class="nav-item">Notification</li>
                </a>
                <a href="login.php" class="nav-links">
                    <li class="nav-item">About</li>
                </a>
            </div>
        </div>
        <div class="account-btn">
            <img src="assets/img/account.png" onclick="openSubmenu()">
            <div class="submenu" id="submenu">
            <a href="login.php" id="account-lbl">Manage Account</a><br><br>
            <a href="login.php" id="account-lbl">Purchased</a><br><br>
            <a href="login.php" id="account-lbl">Login</a>
            </div>
        </div>
        <div class="cart-btn">
            <a href="login.php"><img src="assets/img/shopping-cart.png"></a>
        </div>
    </div>
    
<script>
    // When the user scrolls down 20px from the top of the document, slide down the navbar
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("navbar").style.background = "#212529";
    } else {
        document.getElementById("navbar").style.background = "none";
    }
    }
    
    function openDiv() {
        var x = document.getElementById("myDiv");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function openSubmenu(){
        var x = document.getElementById("submenu");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

</script>
</header>