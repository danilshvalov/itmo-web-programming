from django import forms
from django.core.validators import MaxValueValidator, MinValueValidator


class FeedbackForm(forms.Form):
    first_name = forms.CharField(max_length=255)
    last_name = forms.CharField(max_length=255)
    email = forms.CharField(max_length=255)
    quality = forms.IntegerField(
        validators=[MinValueValidator(1), MaxValueValidator(5)]
    )
    like_service_speed = forms.BooleanField(initial=False, required=False)
    like_interface = forms.BooleanField(initial=False, required=False)
    like_assortment = forms.BooleanField(initial=False, required=False)
    comment = forms.CharField(max_length=255, required=False)
