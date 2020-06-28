<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <!-- BREADCRUMBS -->
    <div class="col-12 col-md">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="<?= URLROOT ?>/albums">Albums</a></li>
            <li class="breadcrumb-item active"><?= $data['album']->id ?></li>
        </ol>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12 mx-auto">
      <div class="card card-body bg-light mt-3 p-0">

        <div class="overflow-hidden mb-4 rounded-top">
          <img class="d-block mx-auto max-w-100" src="<?= URLROOT . '/' . COVERS_URL . '/' . $data['album']->cover_image ?>" alt="">
        </div>

        <div class="p-4">
          <h4 class="text-center"><?= $data['album']->title ?></h4>
          <p class="text-center"><?= $data['album']->description ?></p>

          <div class="row">
            <!-- THE LIST OF ALBUMS -->
            <?php foreach($data['album']->images as $i => $img): ?>
                <div class="col-12 col-md-6 col-lg-3 mt-3 mx-auto animate__animated animate__fadeInLeft" style="animation-delay: <?= (0.2 * $i) ?>s">
                    <div class="card mb-3 h-100">
                      <h3 class="card-header"><?= $img->title ?></h3>
                      <div class="overflow-hidden d-flex justify-content-center">
                          <img class="album-cover-thumbnail"
                              src="<?= URLROOT . '/' . IMAGES_URL . '/' . $img->image_url ?>"
                              alt="<?= $data['album']->title ?>" />
                      </div>
                      
                      <div class="card-footer mt-auto">
                        <?= $img->created_at ?>
                      </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- ADD NEW IMAGES -->
            <?php if($data['album']->user_id === $_SESSION['user_id']): ?>
            <div class="col-12 col-md-6 col-lg-3 mt-3 mx-auto animate__animated animate__fadeInLeft" style="animation-delay: <?= (0.2 * $i) ?>s">
              <div class="card mb-3 h-100">
                <h3 class="card-header">Add New Images</h3>
                <div class="overflow-hidden h-100 d-flex justify-content-center align-items-center">
                  <div class="col h-100 d-flex justify-content-center align-items-center">
                    <a role="button" data-toggle="modal" data-target="#imageUpload" data-backdrop="true">
                      <i id="uploadImagesLink" class="far fa-plus-square display-1 text-center"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>

          </div>
        </div>

      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<!-- IMAGE UPLOAD MODAL -->
<div class="modal fade" id="imageUpload" tabindex="-1" role="dialog" aria-labelledby="imageUploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageUploadLabel">Upload Images (max 5)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body overflow-hidden">
        <form action="<?= URLROOT; ?>/images/upload/<?= $data['album']->id ?>" method="post" enctype="multipart/form-data">  
          <div class="form-group">
              <label>Images:<sup>*</sup></label>
              <input type="file" accept="image/*" name="images[]" class="form-control form-control" multiple required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Upload</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>