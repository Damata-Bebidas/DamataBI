<div id="navbar">
    <a href="index.php" id="logo"></a>
    <div id="navbar-right">
        <a href="treinamentos.php">Treinamentos</a>
        <a href="institucional.php">Institucional</a>
        <a href="eventos.php">Eventos</a>
        <a href="suporte.php">Suporte</a>
        <div class="dropdown">
            <div class="dropdown-btn">
                    <?php
                    if (isset($_SESSION['nome'])) {
                        $usuario = $_SESSION['nome'];
                        echo "<a href='user.php' ><b><font size='2'>" . $usuario . "</font></b></a>";
                    } else {
                        echo "<a href='login.php'>Login</a>";
                    }
                    ?>
                </div>
            <div class="dropdown-content">
                    <?php
                    if (isset($_SESSION['nome'])) {
                        echo "<li><a href='user.php'>Acessar</a></li>";
                        echo "<li><a href='_controller/logout.php'>Logout</a></li>";
                    }
                    ?>
            </div>
        </div>
    </div>
</div>
<script src="../_bootstrap4.5.0/js/header.js"></script>