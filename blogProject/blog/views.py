from typing import Any
from django.db.models.query import QuerySet
from django.utils import timezone
# import datetime  
from django.shortcuts import render, get_object_or_404, redirect

from django.views.generic import (TemplateView, ListView,
                                  DeleteView, CreateView,
                                  UpdateView, DetailView)
from blog.models import Post, Comment

# from datetime import timezone
from django.urls import reverse_lazy
from blog.forms import PostForm, CommentForm

from django.contrib.auth.mixins import LoginRequiredMixin
from django.contrib.auth.decorators import login_required

# Create your views here.

class AboutView(TemplateView):
    template_name = 'about.html'

class PostListView(ListView):
    model = Post

    # get_queryset->it determines the list of objects that you want to 
    # display. By default it will just give you all for the 
    # model you specify. By overriding this method you can 
    # extend or completely replace this logic.
    def get_queryset(self):
        return Post.objects.filter(published_date__lte=timezone.now()).order_by('-published_date')
    
class PostDetailView(DetailView):
    model = Post

# we don't want to let users create post if they are not authenticated...
# we use "LoginRequiredMixin" to as to mix it with other classes, 
# in function based views we used decorators but in class based views we use "mixin".
class CreatePostView(LoginRequiredMixin, CreateView):
    login_url = '/login/' # if the user is not logged in they should be directed to the 
    # login page.
    redirect_field_name = 'blog/post_detail.html' # to redirect to detail view.
    form_class = PostForm
    model = Post

class PostUpdateView(LoginRequiredMixin, UpdateView):
    login_url = '/login/' # if the user is not logged in they should be directed to the 
    # login page.
    redirect_field_name = 'blog/post_detail.html' # to redirect to detail view.
    form_class = PostForm
    model = Post

class PostDeleteView(LoginRequiredMixin, DeleteView):
    model = Post
    success_url = reverse_lazy('post_list')

# it is going to have a query set specifying that i want to make sure they publish date is'nt there.
class DraftListView(LoginRequiredMixin, ListView):
    login_url = '/login/'
    redirect_field_name = 'blog/post_list.html'
    model = Post

    def get_queryset(self):
        return Post.objects.filter(published_date__isnull=True).order_by('created_date')

####################################################
####################################################

@login_required
def post_publish(request, pk):
    post = get_object_or_404(Post, pk=pk)
    post.publish()
    return redirect('post_detail', pk=pk)

@login_required
def add_comment_to_post(request, pk):
    post = get_object_or_404(Post, pk=pk) # This function calls the given model and get object from that if that object or model doesn’t exist it raise 404 error.

    if request.method == 'POST':
        form = CommentForm(request.POST)
        if form.is_valid():
            comment = form.save(commit=False)
            comment.post = post # When you have created a comment you must need to mention its Post, before saving it. Otherwise, you will not find the comments under the post.
            # comment-> post(field in model "Comment") = post(with id=pk) 
            comment.save()
            return redirect('post_detail', pk=post.pk)
    
    else:
        form = CommentForm()
    
    return render(request, 'blog/comment_form.html', {'form': form})

@login_required
def comment_approve(request, pk):
    comment = get_object_or_404(Comment, pk=pk)
    comment.approve() # we called the approve method in model "Comment".
    # the default approve is "False", but when called the method it turns to true.
    return redirect('post_detail', pk=comment.post.pk) # here we want to go to the post
    # the comment is connected to, so we say go the comment->post(field in Comment model)-> Post(model) and get the primary key for this comment's post.


@login_required
def comment_remove(request, pk):
    comment = get_object_or_404(Comment, pk=pk)
    post_pk = comment.post.pk # get the id of the comment's post.
    comment.delete() # delete() is a default method.
    return redirect('post_detail', pk=post_pk) # we needed to save it as an extra variable because
    # by the time we delete it, it will forget the id of the post hence to redirect to the post we did this.
