<?php require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT;?>/posts/show/<?php echo $data['post_id']->id ; ?>" class="btn btn-secondary"><i class="fa fa-backward"></i>Back</a><br><br>
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Replies</h1>
        </div>

        <div class="col-md-6">
        </div>
    </div>
    <?php foreach($data['reply'] as $reply) : ?>
        <div class="card card-body mb-3">
        
            <div class="bg-light p-2 mb-3">
                replied On <br><?php echo $reply->replySent;?>
            </div><br>
            <h5><p class="card-text"><?php echo $reply->body; ?></p></h5><hr><br>
            
            
        </div>
    <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?> 