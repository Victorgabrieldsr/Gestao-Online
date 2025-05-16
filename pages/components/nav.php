<nav class="navbar">
    <ul class="navbar-left">
        <li onclick="barraLateral()"><img src="../../icon/menu.png"></li><label><?= $_SESSION['tituloNav'] ?></label>
    </ul>
    <ul class="navbar-right">
        <li>
            <img onclick="openMenuUser()" src="../../icon/user.png">
            <div class="menu-user">
                <div class="menu-backdown"></div>
                <a href="./config/deslogar.php">Sair</a>
            </div>
        </li>
        <li>
            <div class="notification">
                <img onclick="openMenuNotification()" src="../../icon/sino.png">
                <span onclick="openMenuNotification()">2</span>
                <div class="menu-notification">
                    <div class="menu-backdown"></div>
                    <label>Atualize os ativos</label>
                    <div class="linha"></div>
                    <label>Recebimento de proventos!</label>
                </div>
            </div>
        </li>
    </ul>
</nav>
