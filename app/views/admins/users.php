<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <!-- BREADCRUMBS -->
    <div class="col-12 col-md">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item active">Admin Dashboard</li>
            <li class="breadcrumb-item active">Users List</li>
        </ol>
    </div>
</div>

<div class="animate__animated animate__fadeInUp">
  <h3>List of Users</h3>
  <table class="table table-hover bg-light">
    <thead>
      <tr>
        <th scope="col">User ID</th>
        <th scope="col">Name</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Created at</th>
        <th scope="col">Category</th>
        <th scope="col">Is activated</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($data['users'] as $user): ?>
        <tr>
          <th scope="row"><?= $user->id ?></th>
          <td><?= $user->name ?></td>
          <td><?= $user->username ?></td>
          <td><?= $user->email ?></td>
          <td><?= $user->created_at ?></td>
          <td><?= $user->category ?></td>
          <td>
            <div class="spinner-sm" id="activation_spinner_<?= $user->id ?>"></div>
            <div class="custom-control custom-switch" id="activation_<?= $user->id ?>">
              <input onchange="onActivationUserChange(this)" data-user-id="<?= $user->id ?>" type="checkbox" class="custom-control-input" id="activation_switch_<?= $user->id ?>" <?= $user->is_activated == 1 ? 'checked' : '' ?>>
              <label class="custom-control-label" for="activation_switch_<?= $user->id ?>"></label>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  function onActivationUserChange(e) {
    var userId = e.getAttribute('data-user-id');
    var action = e.checked ? 'activate' : 'deactivate';
    startLoadingAnimation(userId);
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        stopLoadingAnimation(userId);
      }
    }
    xml.open("GET", "<?= URLROOT ?>/admins/" + action + "/" + userId, true);
    xml.send();
  }

  function startLoadingAnimation(id) {
    var activationSwitch = document.getElementById("activation_" + id);
    activationSwitch.style.display = 'none';

    var spinner = document.getElementById("activation_spinner_" + id);
    spinner.style.display = 'block';
  }

  function stopLoadingAnimation(id) {
    var activationSwitch = document.getElementById("activation_" + id);
    activationSwitch.style.display = 'block';

    var spinner = document.getElementById("activation_spinner_" + id);
    spinner.style.display = 'none';
  }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>