/**
 * Copyright 2016 Google Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
*/

// DO NOT EDIT THIS GENERATED OUTPUT DIRECTLY!
// This file should be overwritten as part of your build process.
// If you need to extend the behavior of the generated service worker, the best approach is to write
// additional code and include it using the importScripts option:
//   https://github.com/GoogleChrome/sw-precache#importscripts-arraystring
//
// Alternatively, it's possible to make changes to the underlying template file and then use that as the
// new base for generating output, via the templateFilePath option:
//   https://github.com/GoogleChrome/sw-precache#templatefilepath-string
//
// If you go that route, make sure that whenever you update your sw-precache dependency, you reconcile any
// changes made to this original template file with your modified copy.

// This generated service worker JavaScript will precache your site's resources.
// The code needs to be saved in a .js file at the top-level of your site, and registered
// from your pages in order to be used. See
// https://github.com/googlechrome/sw-precache/blob/master/demo/app/js/service-worker-registration.js
// for an example of how you can register this script and handle various service worker events.

/* eslint-env worker, serviceworker */
/* eslint-disable indent, no-unused-vars, no-multiple-empty-lines, max-nested-callbacks, space-before-function-paren, quotes, comma-spacing */
'use strict';

var precacheConfig = [["assets/css/admin/common.css","2a10d919dc5490ac054f596ba204f5dc"],["assets/css/admin/dishes.css","b4b107206a24fcb6c40267bd99a2099b"],["assets/css/admin/feedback.css","d41d8cd98f00b204e9800998ecf8427e"],["assets/css/admin/ingredients.css","411d9039f96ecc2697708b1bec4291aa"],["assets/css/admin/inventory.css","6bc8ad7e574ffb2e0208106679abe198"],["assets/css/admin/items.css","81051bcc2cf1bedf378224b0a93e2877"],["assets/css/admin/menus.css","e66078d41878ea937118715ad97706ca"],["assets/css/admin/order.detail.css","a8651883f09ef06b685a5978abaa3c2a"],["assets/css/admin/orders.css","4c90d97800f35298507ecc62fa5dc845"],["assets/css/admin/promotions.css","b09a97035a55a0a153487260c3dba05a"],["assets/css/admin/purchases.css","bedca202c6c301e9ecd5363188147960"],["assets/css/admin/tables.css","d7cb51fcedf3a997c1f5bf9318a3c33e"],["assets/css/admin/users.css","7e3414a7132f61bbb2f49b34e9c38b00"],["assets/css/styles.css","51c5e464a9de3e7b262d550343c6b2e7"],["assets/css/styles.css.map","d91c0f616b914fc25fa07366b7769c96"],["assets/favicons/android-chrome-192x192.png","1ebb589ccf46ac67b74529012983842d"],["assets/favicons/android-chrome-512x512.png","95f0d99765bde5e3d5e21fe632c7ab2b"],["assets/favicons/apple-touch-icon.png","15f152315d0b31a4eea3f8c8c6c26139"],["assets/favicons/browserconfig.xml","b459c4c24dfcb4b18d55c08e3003dfc1"],["assets/favicons/bulk.svg","c03b6e97fcdf707b463e1e8eec020963"],["assets/favicons/fastcart.png","29163ab1d1809b323312b6ea5a9b5d7b"],["assets/favicons/favicon-16x16.png","cbd2f38bcb7e03f704497d83190f0a82"],["assets/favicons/favicon-32x32.png","390f3966c39007ff3207d631fd72b7f8"],["assets/favicons/favicon.ico","11d35880bf543c54ef75e5b1d6a81791"],["assets/favicons/mstile-144x144.png","f8d40c8a538cbea062d9e7be107d55ae"],["assets/favicons/mstile-150x150.png","20ae6305730f11d5cedf23a369dde51e"],["assets/favicons/mstile-310x150.png","11ed955038192535fc38d465bc9cfbc0"],["assets/favicons/mstile-310x310.png","7d6b6920d9d22809a596437b18242ae0"],["assets/favicons/mstile-70x70.png","35850f0c4659b20440b0e50524bff7e3"],["assets/favicons/safari-pinned-tab.svg","68696289c50239eae64317b29d3c224d"],["assets/favicons/site.webmanifest","21875b1dfd8369c0f3255573d22e1cf8"],["assets/favicons/table.png","03ce5d946d24bac3ea8bd6a532a640d5"],["assets/images/404.svg","ce5bf7065c945a6a081c29284d515eb3"],["assets/images/ChevronDownsvg.svg","9d655887b008a346d65156b72e4dc2ea"],["assets/images/dishes/ChillieParata07_26_41.jpg","7a7dc63a77dfc5663e7b839f2b482d57"],["assets/images/dishes/Cookies07_26_12.jpg","added093b3a8e776c48174b060b9b18e"],["assets/images/dishes/Donuts06_25_41.jpg","fb1e6a256c1fd9743b4118a1f07760dd"],["assets/images/dishes/Gateau06_00_05.jpeg","b9e05495bcf614f5f60c31e07191b8a6"],["assets/images/dishes/Hotbuttermushrooms06_32_14.jpg","6387bfb0184d450f04aa06f28d22b767"],["assets/images/dishes/Naan07_27_22.jpg","7f7007db133745ed274e0e7373c3d039"],["assets/images/dishes/Pancakes07_29_44.jpg","0549146faeb24a84cb591a640b7f2e71"],["assets/images/dishes/Pilau07_27_42.jpg","13cacb861933981091c0719fdf02291b"],["assets/images/dishes/Pizza06_24_40.jpg","30f58bf2f0f8994b8796fcdfacdb31bb"],["assets/images/dishes/Salad06_25_11.jpg","f5d659221ea2ca7ee192c798762686bf"],["assets/images/dishes/Salad09_25_04.jpg","f5d659221ea2ca7ee192c798762686bf"],["assets/images/dishes/fds06_17_23.jpg","30f58bf2f0f8994b8796fcdfacdb31bb"],["assets/images/dishes/garlicbread07_28_59.jpg","3f2105b479c08f57e12b2b20377bef53"],["assets/images/dishes/normaldish.jpg","65c1b1de2170a3efcedaa5c2b48c2429"],["assets/images/dishes/samosa07_28_14.jpg","f3ddbf05358003efc43373908393ddb8"],["assets/images/dishes/waffles07_30_15.jpg","f8d1632b71451b89549467a3b0cc32db"],["assets/images/home/banner.jpg","087a341ac9b5afeb4c1cf8883c6ee5b2"],["assets/images/login/logo.png","13543fcb210aade7e220421e18334a29"],["assets/images/logos/logo_Full Logo.svg","2ad7e72394fc41f4b76f9dcc42e0cba9"],["assets/images/logos/logo_Logo Red + Background.svg","4b0e1688f16180ed4ad65a39fe23882e"],["assets/images/logos/logo_Logo Red.svg","a9df40956907a7fef0fc4ea0f14fd158"],["assets/images/logos/logo_Logo White + Background.svg","24322668dd03d1bce5864248b06629f6"],["assets/images/logos/logo_Logo White.svg","89ffedc5e45f6e4b81f7e1a04b8d0bf3"],["assets/images/menus/euromenu.jpg","67bc86a485cbfe44098bcdd961d3f2b1"],["assets/images/menus/indianmenu.jpg","44f64f0ebf9809af4cbdaff03039ec15"],["assets/js/admin.js","74eeecd3c3fa21fe76b9ac7476070b89"],["assets/js/admin/dashboard.js","f59fadbc69b8aa3db545750c57976dda"],["assets/js/admin/dishes.js","c6e8c3afa5a54087d5ff46a688d48499"],["assets/js/admin/employees.js","b50d3f424b166901b360047ca9b76d69"],["assets/js/admin/ingredients.js","ba82630112f66518f3cd99641000c121"],["assets/js/admin/inventory.js","ff487b0e07b19142978abc6142de0afa"],["assets/js/admin/inventory2.js","115a6a345c1e1bac71b7e068b30f8566"],["assets/js/admin/items.js","1c96b8383eb4517109e9fe590db7713f"],["assets/js/admin/menus.js","4f3666a72b10bd18c4b7e6dc125e4671"],["assets/js/admin/order.detail.js","4349ef78b40f4abea7b18fa039dfee5c"],["assets/js/admin/orders.js","57b314ed8b4c2b1df86ef9bf852ef7c5"],["assets/js/admin/promotions.js","422f52e7fa50c79e7d29ea3d8656100a"],["assets/js/admin/purchases.js","bda47351d6abdffadf6dad3bef15c2a0"],["assets/js/admin/user.js","3555dfda475a9482781b2a92061d20da"],["assets/js/admin/vendors.js","2416c9dbc536fd1976be3116cdefcc14"],["assets/js/cart.js","fda7533530b266fea4a1aadc45e50dbd"],["assets/js/home.js","cc48492ac98b5f7cf0c79ecc551abdc8"],["assets/js/register.js","3a898f89b5f755d296088204a450dc39"],["assets/js/sw.js","7985cb4389913b7caf36237decccc3c1"],["assets/js/verifyEmail.js","dc52909f87189b9f6e0824e3dc948ef9"],["assets/scss/_colors.scss","a19ec6f963ae145d3b029c1a1543741b"],["assets/scss/_components.scss","4769f089d4d964e8d28b44181199e11a"],["assets/scss/_form.scss","51b5fe08345dee9a5986904b7670d48a"],["assets/scss/_layout.scss","4bfae84f1adc85abf57c2f3a7f85d186"],["assets/scss/_structure.scss","dfccacb003dfce1af545014b315639c0"],["assets/scss/_tables.scss","8f6fa0fa08a70a82c2a4ef26a428451d"],["assets/scss/_typography.scss","5783d36cd077c60b87feaae1f33de1d3"],["assets/scss/styles.css","47a8317c0099935f5ae6309c78a1483f"],["assets/scss/styles.css.map","508031f22bfb467467e8195997e9c37c"],["assets/scss/styles.scss","55ad1539b5365f0fdd28a95159343211"],["index.php","7b60cd8dfafc9e988ac5b298b672de0f"],["robots.txt","90ea4f35863958550c4a38405aebefbb"]];
var cacheName = 'sw-precache-v3-sw-precache-' + (self.registration ? self.registration.scope : '');


var ignoreUrlParametersMatching = [/^utm_/];



var addDirectoryIndex = function(originalUrl, index) {
    var url = new URL(originalUrl);
    if (url.pathname.slice(-1) === '/') {
      url.pathname += index;
    }
    return url.toString();
  };

var cleanResponse = function(originalResponse) {
    // If this is not a redirected response, then we don't have to do anything.
    if (!originalResponse.redirected) {
      return Promise.resolve(originalResponse);
    }

    // Firefox 50 and below doesn't support the Response.body stream, so we may
    // need to read the entire body to memory as a Blob.
    var bodyPromise = 'body' in originalResponse ?
      Promise.resolve(originalResponse.body) :
      originalResponse.blob();

    return bodyPromise.then(function(body) {
      // new Response() is happy when passed either a stream or a Blob.
      return new Response(body, {
        headers: originalResponse.headers,
        status: originalResponse.status,
        statusText: originalResponse.statusText
      });
    });
  };

var createCacheKey = function(originalUrl, paramName, paramValue,
                           dontCacheBustUrlsMatching) {
    // Create a new URL object to avoid modifying originalUrl.
    var url = new URL(originalUrl);

    // If dontCacheBustUrlsMatching is not set, or if we don't have a match,
    // then add in the extra cache-busting URL parameter.
    if (!dontCacheBustUrlsMatching ||
        !(url.pathname.match(dontCacheBustUrlsMatching))) {
      url.search += (url.search ? '&' : '') +
        encodeURIComponent(paramName) + '=' + encodeURIComponent(paramValue);
    }

    return url.toString();
  };

var isPathWhitelisted = function(whitelist, absoluteUrlString) {
    // If the whitelist is empty, then consider all URLs to be whitelisted.
    if (whitelist.length === 0) {
      return true;
    }

    // Otherwise compare each path regex to the path of the URL passed in.
    var path = (new URL(absoluteUrlString)).pathname;
    return whitelist.some(function(whitelistedPathRegex) {
      return path.match(whitelistedPathRegex);
    });
  };

var stripIgnoredUrlParameters = function(originalUrl,
    ignoreUrlParametersMatching) {
    var url = new URL(originalUrl);
    // Remove the hash; see https://github.com/GoogleChrome/sw-precache/issues/290
    url.hash = '';

    url.search = url.search.slice(1) // Exclude initial '?'
      .split('&') // Split into an array of 'key=value' strings
      .map(function(kv) {
        return kv.split('='); // Split each 'key=value' string into a [key, value] array
      })
      .filter(function(kv) {
        return ignoreUrlParametersMatching.every(function(ignoredRegex) {
          return !ignoredRegex.test(kv[0]); // Return true iff the key doesn't match any of the regexes.
        });
      })
      .map(function(kv) {
        return kv.join('='); // Join each [key, value] array into a 'key=value' string
      })
      .join('&'); // Join the array of 'key=value' strings into a string with '&' in between each

    return url.toString();
  };


var hashParamName = '_sw-precache';
var urlsToCacheKeys = new Map(
  precacheConfig.map(function(item) {
    var relativeUrl = item[0];
    var hash = item[1];
    var absoluteUrl = new URL(relativeUrl, self.location);
    var cacheKey = createCacheKey(absoluteUrl, hashParamName, hash, false);
    return [absoluteUrl.toString(), cacheKey];
  })
);

function setOfCachedUrls(cache) {
  return cache.keys().then(function(requests) {
    return requests.map(function(request) {
      return request.url;
    });
  }).then(function(urls) {
    return new Set(urls);
  });
}

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return setOfCachedUrls(cache).then(function(cachedUrls) {
        return Promise.all(
          Array.from(urlsToCacheKeys.values()).map(function(cacheKey) {
            // If we don't have a key matching url in the cache already, add it.
            if (!cachedUrls.has(cacheKey)) {
              var request = new Request(cacheKey, {credentials: 'same-origin'});
              return fetch(request).then(function(response) {
                // Bail out of installation unless we get back a 200 OK for
                // every request.
                if (!response.ok) {
                  throw new Error('Request for ' + cacheKey + ' returned a ' +
                    'response with status ' + response.status);
                }

                return cleanResponse(response).then(function(responseToCache) {
                  return cache.put(cacheKey, responseToCache);
                });
              });
            }
          })
        );
      });
    }).then(function() {
      
      // Force the SW to transition from installing -> active state
      return self.skipWaiting();
      
    })
  );
});

self.addEventListener('activate', function(event) {
  var setOfExpectedUrls = new Set(urlsToCacheKeys.values());

  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache.keys().then(function(existingRequests) {
        return Promise.all(
          existingRequests.map(function(existingRequest) {
            if (!setOfExpectedUrls.has(existingRequest.url)) {
              return cache.delete(existingRequest);
            }
          })
        );
      });
    }).then(function() {
      
      return self.clients.claim();
      
    })
  );
});


self.addEventListener('fetch', function(event) {
  if (event.request.method === 'GET') {
    // Should we call event.respondWith() inside this fetch event handler?
    // This needs to be determined synchronously, which will give other fetch
    // handlers a chance to handle the request if need be.
    var shouldRespond;

    // First, remove all the ignored parameters and hash fragment, and see if we
    // have that URL in our cache. If so, great! shouldRespond will be true.
    var url = stripIgnoredUrlParameters(event.request.url, ignoreUrlParametersMatching);
    shouldRespond = urlsToCacheKeys.has(url);

    // If shouldRespond is false, check again, this time with 'index.html'
    // (or whatever the directoryIndex option is set to) at the end.
    var directoryIndex = 'index.html';
    if (!shouldRespond && directoryIndex) {
      url = addDirectoryIndex(url, directoryIndex);
      shouldRespond = urlsToCacheKeys.has(url);
    }

    // If shouldRespond is still false, check to see if this is a navigation
    // request, and if so, whether the URL matches navigateFallbackWhitelist.
    var navigateFallback = '';
    if (!shouldRespond &&
        navigateFallback &&
        (event.request.mode === 'navigate') &&
        isPathWhitelisted([], event.request.url)) {
      url = new URL(navigateFallback, self.location).toString();
      shouldRespond = urlsToCacheKeys.has(url);
    }

    // If shouldRespond was set to true at any point, then call
    // event.respondWith(), using the appropriate cache key.
    if (shouldRespond) {
      event.respondWith(
        caches.open(cacheName).then(function(cache) {
          return cache.match(urlsToCacheKeys.get(url)).then(function(response) {
            if (response) {
              return response;
            }
            throw Error('The cached response that was expected is missing.');
          });
        }).catch(function(e) {
          // Fall back to just fetch()ing the request if some unexpected error
          // prevented the cached response from being valid.
          console.warn('Couldn\'t serve response for "%s" from cache: %O', event.request.url, e);
          return fetch(event.request);
        })
      );
    }
  }
});







