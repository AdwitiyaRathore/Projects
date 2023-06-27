<?php require APPROOT . '/views/inc/header.php'; ?>
    
    <a href="<?php echo URLROOT;?>/posts" class="btn btn-secondary"><i class="fa fa-backward"></i>Back</a><br><br>

    <?php if($data['post']->user_id != $_SESSION['user_id']): ?>
        <?php if(!empty($data['follower'])) :?>
            <form class="float-end" action="<?php echo URLROOT;?>/requests/unfollow/<?php echo $data['post']->id;?>" method="post">
                <input type="submit" value="Unfollow" class='btn btn-success'>
            </form>
        <?php else :?>
            <form class="float-end" action="<?php echo URLROOT;?>/requests/checkFriend/<?php echo $data['post']->user_id;?>" method="post">
                <input type="submit" value="Follow" class='btn btn-success'>
            </form>
        <?php endif ;?>
    <?php endif; ?>
    
    <h1><?php echo $data['post']->title; ?></h1>
    
    <div class="bg-secondary text-white p-2 mb-3">
        Written By <?php echo $data['user']->name; ?> <br> on <?php echo $data['post']->created_at;?>
    </div>
            <br>
    <h4><p><?php echo $data['post']->body;?></p></h4>
    <hr>

    <?php if($data['post']->user_id == $_SESSION['user_id']): ?>
        <hr>
        <!-- here after /edit we are giving id as another link parameter only for that perticular id-->
        <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit</a>

        <form class="float-end" action="<?php echo URLROOT;?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
            <input type="submit" value="Delete" class='btn btn-danger'>
        </form>
    <?php endif; ?><br><br>
    <a href="<?php echo URLROOT; ?>/posts/reply/<?php echo $data['post']->id; ?>" class="btn btn-success">Reply</a>
    <a href="<?php echo URLROOT; ?>/posts/showReply/<?php echo $data['post']->id; ?>" class="btn btn-success float-end">View all replies</a>

<?php require APPROOT . '/views/inc/footer.php'; ?>