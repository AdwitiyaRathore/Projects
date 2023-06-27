<?php require APPROOT . '/views/inc/header.php'; ?>
<h2><?php echo $data['title']; ?></h2>
<p class='lead'><?php echo $data['description']; ?></p>
<p>Version: <strong><?php echo APPVERSION; ?></strong></p>
<br><br>
<ol class="fs-5 border border-success p-2 mb-2">
    Register: <hr><br>
    <p class="text-capitalize">If you are a new user for this site you need to register first to login. <br>
    To register you need to enter your details such as name, email, and a secure password which will be used
    to login.
    <br>
    You need to remember the email and password you have entered since if you forgot you won't be able to login.
    </p>
</ol>

<ol class="fs-5 border border-success p-2 mb-2">
    Login: <hr><br>
    <p class="text-capitalize">To login you need to register first. Then go to the login form and enter the email and password 
        which you used to register.
        <br>
        If the login credencials are correct then you will be sent to the post page.
    </p>
</ol>

<ol class="fs-5 border border-success p-2 mb-2">
    Post: <hr><br>
    <p class="text-capitalize">After you have logged in you may you are send to past page where you can see posts of other users
        and can also make your own posts.
        <br>
        You may edit your post or delete it according to your need.
    </p>
</ol>

<ol class="fs-5 border border-success p-2 mb-2">
    Follow: <hr><br>
    <p class="text-capitalize">This feature allows users to follow other users.Also the user may see a list of other users they are following. 
    </p>
</ol>

<ol class="fs-5 border border-success p-2 mb-2">
    Reply: <hr><br>
    <p class="text-capitalize">This feature allows users to reply to the post of other users, the reply may be seen by any other user since it is a public 
        platform.
    </p>
</ol>
<?php require APPROOT . '/views/inc/footer.php';?>