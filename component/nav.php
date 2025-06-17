<!-- Menu Navigasi -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">To Do List</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="daftar_tugas.php">Daftar Tugas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="hari_ini.php">Hari Ini</a>
                </li>
            </ul>

            <!-- Search bar -->
            <form class="d-flex me-3" action="search.php" method="GET">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari tugas..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Cari</button>
            </form>

            <!-- Logout -->
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>
