<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <!-- BREADCRUMBS -->
    <div class="col-12 col-md">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item active">Albums</li>
        </ol>
    </div>

    <!-- ADD NEW ALBUM BUTTON -->
    <div class="col-12 col-md-auto">
        <a href="<?= URLROOT ?>/albums/create" class="btn btn-primary btn-block text-white">
            <span>Create New Album</span>
            <i class="far fa-plus-square text-white"></i>
        </a>
    </div>
</div>

<!-- LIST OF ALBUMS -->
<div class="row mt-3 align-items-stretch">

    <!-- INBOX FOR EMPTY LIST -->
    <?php if(count($data['albums']) <= 0): ?>
        <i class="fas fa-inbox col-12 mx-auto text-center display-1"></i>
        <div class="col-12 text-muted text-center">No Albums yet</div>
    <?php endif; ?>

    <!-- THE LIST OF ALBUMS -->
    <?php foreach($data['albums'] as $i => $album): ?>
        <div class="col-12 col-md-6 col-lg-3 mt-3 mx-auto animate__animated animate__fadeInUp" style="animation-delay: <?= (0.2 * $i) ?>s">
            <div class="card mb-3 h-100 card-hover">
                <h3 class="card-header"><?= $album->title ?></h3>
                <div class="overflow-hidden d-flex justify-content-center">
                    <img class="album-cover-thumbnail"
                        src="<?= COVERS_URL . '/' . $album->cover_image ?>"
                        alt="<?= $album->title ?>" />
                </div>
                <div class="card-body">
                    <div class="mt-auto"><?= $album->created_at ?></div>
                </div>
                <div class="card-footer d-flex">
                    <a href="<?= URLROOT ?>/albums/album/<?= $album->id ?>" class="card-link col text-left">more</a>
                    <a href="#" class="card-link col text-right">favorate</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>