from django.db import models
from django.core.validators import MaxValueValidator, MinValueValidator


class Feedback(models.Model):
    first_name = models.CharField(max_length=255)
    last_name = models.CharField(max_length=255)
    email = models.CharField(max_length=255)
    quality = models.IntegerField(
        validators=[MinValueValidator(1), MaxValueValidator(5)]
    )
    like_service_speed = models.BooleanField(default=False)
    like_interface = models.BooleanField(default=False)
    like_assortment = models.BooleanField(default=False)
    comment = models.CharField(max_length=255)
