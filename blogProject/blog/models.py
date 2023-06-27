from django.db import models
from django.utils import timezone
from django.urls import reverse

# Create your models here.

class Post(models.Model):
    author = models.ForeignKey('auth.User', on_delete=models.CASCADE)
    # author is someone who is a super user, since it is connected to the User class...
    title = models.CharField(max_length=200)
    text = models.TextField()
    created_date = models.DateTimeField(default=timezone.now())
    published_date = models.DateTimeField(blank=True, null=True)


    def publish(self):
        self.published_date = timezone.now()
        self.save()
    
    def approve_comments(self):
        return self.comments.filter(approved_comment=True)
        # we filter the "comments" and check which one are approved...
    
    def get_absolute_url(self):
        return reverse("post_detail", kwargs={'pk': self.pk})
    
    def __str__(self):
        return self.title
    

# Commet model is very similar to Post model...
class Comment(models.Model):
    post = models.ForeignKey('blog.Post', related_name='comments', on_delete=models.CASCADE)
    # each post is connected to a Post, hence each commnent is aligned to a post.
    author = models.CharField(max_length=200)
    text = models.TextField()
    created_date = models.DateTimeField(default=timezone.now())
    approved_comment = models.BooleanField(default=False)
    # approved_comment in the funtion "approved_comment=True" show be same...
    # basically by default it is false, but if a comment is approved then it should be true... 

    def approve(self):
        self.approved_comment = True
        self.save()
    
    def get_absolute_url(self):
        return reverse('post_list')

    def __str__(self):
        return self.text