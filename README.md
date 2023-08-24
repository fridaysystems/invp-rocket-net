# invp-rocket-net

Purges Rocket.net CDN cache when vehicles are updated via the WordPress REST API

## Requires API token in option `invp_api_rocket_net_token`

Generate a token here https://rocketdotnet.readme.io/reference/post_login

### Save our Rocket.net API token in every site in a multisite

`wp site list --field=url | xargs -n1 -I % wp --url=% option update invp_api_rocket_net_token "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2OTI4ODMyMDgsIm5iZiI6MTY5Mjg4MzIwOCwianRpIjoiODkyOTMwMDAtMzViMC00MzQ0LThlZGEtMjA5NjhkNjhmYzMxIiwiZXhwIjoyMDA4MjQzMjA4LCJpZGVudGl0eSI6IndlYkBmcmlkYXluZXQuY29tIiwiZnJlc2giOmZhbHNlLCJ0eXBlIjoiYWNjZXNzIiwidXNlcl9jbGFpbXMiOnsidXNlcm5hbWUiOiJ3ZWJAZnJpZGF5bmV0LmNvbSIsImNsaWVudF9pZCI6MjA1NjQsImFjY291bnRfdHlwZSI6Im1hbmFnZWQifX0.uavvUmmrh_gtArBEaejJDXtSZLvf8OOL1jBBjfeff0Q"`