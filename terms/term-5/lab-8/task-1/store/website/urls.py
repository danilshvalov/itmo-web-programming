from django.urls import path

from . import views

urlpatterns = [
    path("", views.index, name="index"),
    path("about/", views.about, name="about"),
    path("feedback/", views.feedback, name="feedback"),
    path("feedback-submit/", views.feedback_submit, name="feedback-submit"),
    path("404/", views.not_found, name="404"),
]

handler404 = "website.views.not_found"
