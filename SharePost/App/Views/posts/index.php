<?php require APPROOT . '/views/inc/header.php'; ?>
    <?php flash('post_message');?>
    <?php flash('Request_message');?>
    <?php flash('reply_message');?>
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Posts</h1>
        </div>

        <div class="col-md-6">
            <a href="<?php echo URLROOT;?>/posts/add" class="btn btn-primary float-end">
                <i class="fa fa-pencil"></i>ADD Posts 
            </a>
        </div>
    </div>
    <!-- initialising foreach loop to get the posts... -->
    <?php foreach($data['posts'] as $post) : ?>
        <div class="card card-body mb-3">
        
            <h4 class="card-title"><?php echo $post->title;?></h4>
            <div class="bg-light p-2 mb-3">
                Written by <?php echo $post->name; ?><br><br> On <?php echo $post->postCreated;?>
            </div><br>
            <h5><p class="card-text"><?php echo $post->body; ?></p></h5><hr><br>
            
            <a href="<?php echo URLROOT;?>/posts/show/<?php echo $post->postId;?>" class="btn btn-dark">More</a><br>
            
        </div>
    <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?> 