<?php
  function getCategorySelectOptionsTree($categories, $parentId = null, $level = 0) {
    $select = "";
    $currentCategories = array_filter($categories, function($v, $k) use ($parentId) {
          return $v->parent_id === $parentId;
        }, ARRAY_FILTER_USE_BOTH);
  
      foreach($currentCategories as $cat) {
        $children = getCategorySelectOptionsTree($categories, $cat->id, $level+1);
        $select .= '<option value="' . $cat->id . '">' . str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $level) . $cat->category . "</option>";
        if(!empty($children)) {
            $select .= $children;
        }
      }
    return $select;
  }
?> 

<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row animate__animated animate__<?= $data['error'] ? 'shakeX' : 'fadeInUp' ?>">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <h2>Create An Account</h2>
      <p>Please fill this form to register with us</p>
      <?php flash('register_faild'); ?>
      <form action="<?= URLROOT; ?>/users/register" method="post">
        <div class="form-group">
            <label>Name:<sup>*</label>
            <input type="text" name="name" class="form-control form-control-lg <?= (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['name']; ?>">
            <span class="invalid-feedback"><?= $data['name_err']; ?></span>
        </div> 
        <div class="form-group">
            <label>Username:<sup>*</sup></label>
            <input type="text" name="username" class="form-control form-control-lg <?= (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['username']; ?>">
            <span class="invalid-feedback"><?= $data['username_err']; ?></span>
        </div>    
        <div class="form-group">
            <label>Email Address:<sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['email']; ?>">
            <span class="invalid-feedback"><?= $data['email_err']; ?></span>
        </div>    
        <div class="form-group">
            <label>Password:<sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['password']; ?>">
            <span class="invalid-feedback"><?= $data['password_err']; ?></span>
        </div>
        <div class="form-group">
            <label>Confirm Password:<sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['confirm_password']; ?>">
            <span class="invalid-feedback"><?= $data['confirm_password_err']; ?></span>
        </div>

        <div class="form-group">
          <label for="category">Category:<sup>*</sup></label>
          <select class="form-control form-control-lg" id="category" name="category">
            <?= getCategorySelectOptionsTree($data['categories']) ?>
          </select>
        </div>

        <div class="form-row">
          <div class="col">
            <input type="submit" class="btn btn-success btn-block" value="Register">
          </div>
          <div class="col">
            <a href="<?= URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  
<?php require APPROOT . '/views/inc/footer.php'; ?>