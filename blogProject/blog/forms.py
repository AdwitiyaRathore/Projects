from django import forms
from blog.models import Post, Comment

class PostForm(forms.ModelForm):
    class Meta():
        model = Post
        fields = ('author', 'title', 'text')
    
        # to add css to the fields we use widgets...
        widgets = {
            # these class widgets are in built in django...
            # for eg-> "textinput" in for CharField...
            'title': forms.TextInput(attrs={'class': 'textinputclass'}), 
            'text': forms.Textarea(attrs={'class': 'editable medium-editor-textarea postcontent'})
            # 'text' is connected to three classes-> 1st: editable, hence we can edit it, thats coming from medium editor library
            # 2nd: 'text-area' which gives styling of an actual medium editor
            # 3rd: 'postcontent' our own class we will define...

            # we make sure that the "postcontent" class is suitable for Post form class.
            
        }

class CommentForm(forms.ModelForm):
    class Meta():
        model = Comment
        fields = ('author', 'text')

        widgets = {
            'author': forms.TextInput(attrs={'class': 'textinputclass'}),
            'text': forms.Textarea(attrs={'class': 'editable medium-editor-textarea'})
        }