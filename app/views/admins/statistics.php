<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <!-- BREADCRUMBS -->
    <div class="col-12 col-md">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item active">Admin Dashboard</li>
        </ol>
    </div>
</div>

<div class="animate__animated animate__fadeInUp">
    <h3>Statistics</h3>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card card-body bg-light mt-5">
                <div class="row">
                <div class="col col-md-3 col-lg-2">
                    <img width="60" height="60" src="<?= URLROOT ?>/assets/images/active-user.png" alt="" srcset="">
                </div>
                <div class="col-auto">
                    <h3><?= $data['statistics']['activated_users'] ?></h3>
                    <h6>Number of Activated Users</h6>
                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card card-body bg-light mt-5">
                <div class="row">
                <div class="col col-md-3 col-lg-2">
                    <img width="60" height="60" src="<?= URLROOT ?>/assets/images/deactive-user.png" alt="" srcset="">
                </div>
                <div class="col-auto">
                    <h3><?= $data['statistics']['deactivated_users'] ?></h3>
                    <h6>Number of Activated Users</h6>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <pre>
        <?php echo print_r($data['statistics']) ?>
    </pre> -->
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>