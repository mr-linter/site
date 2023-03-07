#!/bin/sh

php artisan config:cache

rr serve -c .rr.yaml
