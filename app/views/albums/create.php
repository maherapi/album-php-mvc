<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <!-- BREADCRUMBS -->
    <div class="col-12 col-md">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="<?= URLROOT ?>/albums">Albums</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>

<div class="row animate__animated animate__<?= $data['error'] ? 'shakeX' : 'fadeInUp' ?>">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <h2>Create An New Album</h2>
      <form action="<?= URLROOT; ?>/albums/create" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title:<sup>*</label>
            <input type="text" name="title" class="form-control form-control <?= (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['title']; ?>">
            <span class="invalid-feedback"><?= $data['title_err']; ?></span>
        </div> 
        <div class="form-group">
            <label>Description:<sup>*</sup></label>
            <textarea type="text" name="description" class="form-control form-control<?= (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"><?= $data['description']; ?></textarea>
            <span class="invalid-feedback d-block"><?= $data['description_err']; ?></span>
        </div>    
        <div class="form-group">
            <label>Cover image:<sup>*</sup></label>
            <input id="imageInput" type="file" accept="image/*" name="cover_image" class="form-control form-control <?= (!empty($data['cover_image_err'])) ? 'is-invalid' : ''; ?>"
                data-toggle="modal" data-target="#imagePreview" data-backdrop="true">
            <span class="invalid-feedback"><?= $data['cover_image_err']; ?></span>
        </div>

        <div class="form-row">
          <div class="col">
            <input type="submit" class="btn btn-success btn-block" value="Create">
          </div>
          <div class="col">
            <a href="<?= URLROOT; ?>/albums" class="btn btn-light btn-block">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  
<?php require APPROOT . '/views/inc/footer.php'; ?>

<!-- IMAGE PREVIEW Modal TEMPLATE -->
<div class="modal fade" id="imagePreview" tabindex="-1" role="dialog" aria-labelledby="imagePreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imagePreviewLabel">Album Cover Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body overflow-hidden">
        <div class="w-100 h-100">
            <img id="imagePreviewElm" class="w-100 mx-auto">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>