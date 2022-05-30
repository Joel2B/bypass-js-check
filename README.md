# Bypass JS Check

this script returns the solution (cookie) of a JS check.

## Supported sites

- PornHub
- InfinityFree
- Sites using stackpath

## Usage

in your application, you send the url to this script,
will return the cookie,
and you will send the request again but with the cookie.

## Demo

if you want the content a pornhub video,

you will probably get this:
[without cookie](https://tmp02.appsdev.cyou/bypass-js-check/samples/ph/test.php)

using the cookie, will return the following content:
[with cookie](https://tmp01.appsdev.cyou/?url=https://www.pornhub.com/view_video.php?viewkey=ph6116a13a48187&cookie_id=pornhub)

### Notes

two methods are used to solve the js verification.

1. a script that runs JS code, works but takes too long to complete and has to be used in PHP 5.2.
2. convert JS code to PHP code and use eval, it's faster but more insecure.

by default the second method is used.

this script is part of the [XVideos PornHub RedTube API](https://github.com/Joel2B/XVideos-PornHub-RedTube-API)

this must be on the same server that the application, to work.

**_i don't recommend using this script without first knowing what each line of code does._**
