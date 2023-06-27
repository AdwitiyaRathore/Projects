<?php require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT;?>/posts" class="btn btn-secondary"><i class="fa fa-backward"></i>Back</a><br><br>
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Followings</h1>
        </div>

        <div class="col-md-6">
        </div>
    </div>
    <?php foreach($data['request'] as $request) : ?>
        <div class="card card-body mb-3">
        
            <div class="bg-light p-2 mb-3">
                Following id:<?php echo $request->receiver_id;?><br><br>
                Name <?php echo $request->name?>

            </div><br>
            
            
        </div>
    <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?> 