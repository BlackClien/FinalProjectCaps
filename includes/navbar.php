<nav>
    <a href="../index.php">Home</a>
    <?php if (isAdmin()): ?>
        <a href="../admin/dashboard.php">Dashboard</a>
    <?php elseif (isCounselor()): ?>
        <a href="../counselor/dashboard.php">Dashboard</a>
    <?php endif; ?>
    <a href="../logout.php">Logout</a>
</nav>
