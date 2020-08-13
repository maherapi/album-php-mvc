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
      <?php flash('not_activated'); ?>
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

        <div id="category-selects">
          <div class="form-group">
            <label for="category">Category:<sup>*</sup></label>
            <select class="form-control form-control-lg" id="category" name="category" onchange="getSubCategories(this)" onfocus="this.selectedIndex = 0;">
              <option selected disabled>--select--</option>
              <?= getCategorySelectOptionsTree($data['categories']) ?>
            </select>
          </div>
          <div class="sub-categories"></div>
        </div>
        <?php if(isset($data['category_err']) && $data['category_err'] !== ''): ?>
          <div class="alert alert-dismissible alert-danger"><?= $data['category_err'] ?></div>
        <?php endif; ?>

        <div class="spinner" id="category-spinner"></div>

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
  
  <!-- close container div (from header file) -->
  </div>

  <script>
    function getSubCategories(selectElm) {

      document.querySelectorAll("select[name='category']")
        .forEach(s => {
          s.removeAttribute("id");
          s.removeAttribute("name");
        });
      selectElm.setAttribute("id", "category");
      selectElm.setAttribute("name", "category");

      var subCatContainer = selectElm.parentNode.parentNode.querySelector(".sub-categories");

      startLoadingAnimation();
      subCatContainer.innerHTML = '';

      var categoryId = selectElm.value;
      var xml = new XMLHttpRequest();
      xml.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {

          var subCats = JSON.parse(this.responseText);

          if(!subCats.length) {
            stopLoadingAnimation();
            return;
          }

          var options = '';
          for(var i = 0; i < subCats.length; i++) {
            options += '<option value="' + subCats[i].id + '">' + subCats[i].category + '</option>';
          }
          var template = `
            <div class="form-group">
              <label for="category">sub category of ${selectElm.options[selectElm.selectedIndex].text}:<sup>*</sup></label>
              <select class="form-control form-control-lg" onchange="getSubCategories(this)" onfocus="this.selectedIndex = 0;">
                <option selected disabled>--select--</option>
                ${options}
              </select>
              </div>
            <div class="sub-categories"></div>`;
          subCatContainer.innerHTML = template;

          stopLoadingAnimation();
        }
      }
      xml.open("GET", "<?= URLROOT ?>/users/category/" + categoryId, true);
      xml.send();
    }

    function startLoadingAnimation() {
      var spinner = document.getElementById("category-spinner");
      spinner.style.display = 'block';
    }

    function stopLoadingAnimation() {
      var spinner = document.getElementById("category-spinner");
      spinner.style.display = 'none';
    }
  </script>
</body>
</html>