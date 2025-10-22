<?php
// Determine profile link based on role
$role = $_SESSION['USER']['role'] ?? '';
$profileLink = '#'; // fallback
switch ($role) {
    case 'student':
        $profileLink = ROOT . '/StudentProfile';
        break;
    case 'teacher':
        $profileLink = ROOT . '/TeacherProfile';
        break;
    case 'institute':
        $profileLink = ROOT . '/InstituteProfile';
        break;
}
?>
<nav class="navbar">
  <div class="navbar-logo">
    <a href="<?php echo ROOT ?>/home">
      <img src="<?php echo ROOT ?>/assets/images/logo.png" alt="Institute Logo">
    </a>
  </div>

  <div class="navbar-right-section">
    <input type="search" placeholder="Search here..." class="navbar-search-bar">
    
    <div class="navbar-links">
      <?php echo $role ?>
      <a href="<?php echo ROOT ?>/Login" class="navbar-btn navbar-secondary-btn">Log in</a>
      <a href="<?php echo ROOT ?>/signup" class="navbar-btn">Sign up</a>
      <a href="<?php echo ROOT ?>/ClassManager" class="navbar-btn">Classes</a>
      <a href="<?php echo $profileLink ?>" class="navbar-btn navbar-profile-icon" title="View Profile">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
      </a>
    </div>
  </div>
</nav>
