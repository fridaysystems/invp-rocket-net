# invp-rocket-net

WordPress plugin. Add-on for Inventory Presser. Purges Rocket.net CDN cache when vehicles are updated via the WordPress REST API

## Requires API token in option `invp_api_rocket_net_token`

Generate a token here https://rocketdotnet.readme.io/reference/post_login

### Save a Rocket.net API token in every site in a multisite

`wp site list --field=url | xargs -n1 -I % wp --url=% option update invp_api_rocket_net_token "token here"`