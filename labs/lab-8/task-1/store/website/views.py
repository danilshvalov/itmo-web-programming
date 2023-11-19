from django.shortcuts import render
from django.http import HttpResponse
from django.shortcuts import render

from . import forms
from . import models


def index(request):
    return render(request, "index.html")


def about(request):
    return render(request, "about.html")


def feedback(request):
    return render(request, "feedback.html")


def feedback_submit(request):
    form = forms.FeedbackForm(request.POST)
    if form.is_valid():
        data = form.cleaned_data
        feedback = models.Feedback(
            first_name=data["first_name"],
            last_name=data["last_name"],
            email=data["email"],
            quality=data["quality"],
            like_service_speed=data.get("like_service_speed"),
            like_interface=data.get("like_interface"),
            like_assortment=data.get("like_assortment"),
            comment=data.get("comment"),
        )
        feedback.save()

    return render(request, "feedback-success.html")


def not_found(request, exception=None):
    return render(request, "not_found.html")
