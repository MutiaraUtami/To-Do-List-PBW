<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once dirname(__DIR__) . '/config.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm border-bottom border-secondary">
  <div class="container-fluid">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-neon" href="<?= $BASE_URL ?>/index.php">ToDoList</a>

    <!-- Toggle Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Content -->
    <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
          <a class="nav-link text-light" href="<?= $BASE_URL ?>/index.php?id=<?= $_SESSION['id']; ?>">
            <i class="bi bi-calendar-event"></i> Kalender
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-light" href="<?= $BASE_URL ?>/tasks/add_task.php">
            <i class="bi bi-plus-circle"></i> Tambah
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-light" href="<?= $BASE_URL ?>/list/list_tasks.php?id=<?= $_SESSION['id']; ?>">
            <i class="bi bi-list-task"></i> Tugas
          </a>
        </li>
      </ul>

      <form class="d-flex mx-auto cyber-search" action="<?= $BASE_URL ?>search.php" method="GET" role="search">
        <input 
          class="form-control me-2 cyber-input" 
          type="search" 
          name="query" 
          placeholder="Cari tugas..." 
          aria-label="Search"
        >
        <button class="btn btn-cyber-glow" type="submit">Cari</button>
      </form>


        <div class="d-flex align-items-center gap-2">
          <a href="<?= $BASE_URL ?>/profile/profile.php?id=<?= $_SESSION['id']; ?>" class="btn btn-outline-info d-flex align-items-center px-3 py-2 h-100">
            <i class="bi bi-person-circle me-1"></i> Profil
          </a>
          <form action="<?= $BASE_URL ?>/logout/logout.php" method="POST" class="m-0">
            <button type="submit" class="btn btn-cyber d-flex align-items-center px-3 py-2 h-100">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
          </form>
        </div>
    </div>
  </div>
</nav>
