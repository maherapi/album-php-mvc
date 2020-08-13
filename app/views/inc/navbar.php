<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#"><?= SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="<?= URLROOT; ?>">Home</a>
        </li>
        <?php if(isset($_SESSION['user_category']) && userIsActivated()) : ?>
          <li class="nav-item">
            <a class="nav-link" href=""><?= $_SESSION['user_category'] ?></a>
          </li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ml-auto">
      <?php if(isset($_SESSION['user_is_activated']) && userIsActivated()) : ?>
        <li class="nav-item dropdown show">
          <a class="nav-link dropdown-toggle notification-bell" id="notification-icon" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
            <i class="fa fa-bell text-white" aria-hidden="true"></i>
            <span class="badge badge-primary badge-pill notification-badge-position" id="notifications-badge"></span>
            <div class="spinner-sm notification-badge-position bg-warning" id="notifications-spinner"></div>
          </a>
          <div class="dropdown-menu p-3" id="notifications-menu">
          </div>
      </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URLROOT; ?>/users/logout">Logout</a>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= URLROOT; ?>/users/register">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URLROOT; ?>/users/login">Login</a>
        </li>
      <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<?php if(isset($_SESSION['user_is_activated']) && userIsActivated()) : ?>
  <script><?php require_once APPROOT . "/views/inc/ajax/notifications.js" ?></script>
<?php endif; ?>
