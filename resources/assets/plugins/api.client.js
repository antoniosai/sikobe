(function(self) {
  'use strict';

  if (self.ddClient) {
    return
  }

  function Client(options) {
    this.baseUrl = options.url;
    this.headers = options.headers;
    this.token   = options.token;

    this.saveToken(options.token);
  }

  Client.prototype.saveToken = function(token) {
    this.token = token;

    store.set('jwt_token', token);
    store.set('jwt_token_expire_at', getTokenExpirationDate(token));
    store.remove('jwt_token_being_refresh_at');
  }

  Client.prototype.get = function(path, props) {
    return this.send('get', path, props);
  }

  Client.prototype.post = function(path, props) {
    return this.send('post', path, props);
  }

  Client.prototype.delete = function(path, props) {
    return this.send('delete', path, props);
  }

  Client.prototype.patch = function(path, props) {
    return this.send('patch', path, props);
  }

  Client.prototype.send = function(method, path, props) {
    var baseUrl = this.baseUrl;
    var url = baseUrl + path;
    var headers = this.headers;
    var currentToken = this.token;
    var saveToken = this.saveToken.bind(this);

    if (isTokenExpired(currentToken, 60)) {
      return refreshToken(baseUrl, headers, currentToken).then(function(token) {
        saveToken(token);
        return doSend(method, url, headers, token, props);
      }).catch(function(error) {
        if (error.status === 401) {
          notify('error', 'Access token is expired, please refresh the browser', 'Error', 15000);
        }

        if (error.status === 500) {
          notify('error', 'Server error, please contact administrator', 'Error', 15000);
        }

        throw error;
      });
    }

    return doSend(method, url, headers, this.token, props)
    .catch(function(error) {
      if (error.status === 401) {
        return refreshToken(baseUrl, headers, currentToken).then(function(token) {
          saveToken(token);
          return doSend(method, url, headers, token, props);
        }).catch(function(error) {
          if (error.status === 401) {
            notify('error', 'Access token is expired, please refresh the browser', 'Error', 15000);
          }

          if (error.status === 500) {
            notify('error', 'Server error, please contact administrator', 'Error', 15000);
          }

          throw error;
        });
      }

      throw error;
    });
  }

  function doSend(method, path, headers, token, props) {
    return request(method, path, headers, token, props).then(function(response) {
      if (response.status != 204) {
        return response.json().then(function(body) {
          if (typeof body.message != "undefined") {
            throw buildError(response, body, body.message);
          }

          return body;
        });
      }

      return response;
    });
  }

  function request(method, path, headers, token, props) {
    const uri = new URI(path);

    var args = {
      method: method,
      headers: _.extend(headers, {
        Authorization: 'Bearer ' + token
      })
    };

    if (method == 'get') {
      if (typeof props != "undefined") {
        uri.setSearch(props);
      }
    }

    if (method == 'post') {
      if (typeof props != "undefined") {
        args.headers = _.extend(args.headers, {
          'Content-Type': 'application/json'
        });
        args.body = JSON.stringify(props);
      }
    }

    return fetch(uri.toString(), args).then(checkStatus);
  }

  function refreshToken(baseUrl, headers, token) {
    if (isBeingRefreshed()) {
      return new Promise(function(resolve, reject) {
        holdRefreshToken(function(newToken) {
          if (newToken != null) {
            resolve(newToken);
          } else {
            resolve(null);
          }
        });
      }).then(function(newToken) {
        if (newToken != null) {
          return newToken;
        }

        return refreshToken(baseUrl, headers, token);
      });
    }

    return doRefreshToken(baseUrl, headers, token);
  }

  function doRefreshToken(baseUrl, headers, token) {
    store.set('jwt_token_being_refresh_at', new Date());

    return fetch(baseUrl + '/refresh_token', {
      headers: _.extend(headers, {
        Authorization: 'Bearer ' + token
      })
    }).then(checkStatus)
    .then(function(response) {
      var authorization = response.headers.get('Authorization');
      if (authorization) {
        authorization = authorization.replace('Bearer ', '');
      }

      if (authorization) {
        return authorization;
      }

      throw new Error('Cannot find refreshed token in Authorization header');
    });
  }

  function isTokenExpired(token, offsetSeconds) {
    var expireDate = store.get('jwt_token_expire_at');
    if (expireDate) {
      expireDate = new Date(expireDate);
    } else {
      expireDate = getTokenExpirationDate(token);
      offsetSeconds = offsetSeconds || 0;
      if (expireDate === null) {
        return false;
      }
    }

    return !(expireDate.valueOf() > (new Date().valueOf() + (offsetSeconds * 1000)));
  }

  function checkStatus(response) {
    if ((response.status >= 200 && response.status < 300) || response.status == 422) {
      return response;
    } else {
      return response.json().then(function(body) {
        if (typeof body.message != "undefined") {
          throw buildError(response, body, body.message);
        } else {
          throw buildError(response, body, response.statusText);
        }
      });
    }
  }

  function buildError(response, body, message) {
    var error = new Error(message);
    error.payload  = body;
    error.status   = response.status;
    error.response = response;

    throw error;
  }

  function holdRefreshToken(callback) {
    setTimeout(function() {
      if (isBeingRefreshed()) {
        callback(null);
      } else {
        callback(store.get('jwt_token'));
      }
    }, 1000);
  }

  function isBeingRefreshed() {
    var beingRefreshAt = store.get('jwt_token_being_refresh_at');
    if (beingRefreshAt) {
      return true;
    }

    return false;
  }

  function getTokenExpirationDate(token) {
    var decoded = decodeToken(token);
    
    if(typeof decoded.exp === "undefined") {
      return null;
    }

    var d = new Date(0); // The 0 here is the key, which sets the date to the epoch
    d.setUTCSeconds(decoded.exp);
    
    return d;
  }

  function decodeToken(token) {
    var parts = token.split('.');

    if (parts.length !== 3) {
      throw new Error('JWT must have 3 parts');
    }

    var decoded = urlBase64Decode(parts[1]);
    if (!decoded) {
      throw new Error('Cannot decode the token');
    }

    return JSON.parse(decoded);
  }

  function urlBase64Decode(str) {
    var output = str.replace(/-/g, '+').replace(/_/g, '/');
    switch (output.length % 4) {
      case 0: { break; }
      case 2: { output += '=='; break; }
      case 3: { output += '='; break; }
      default: {
        throw 'Illegal base64url string!';
      }
    }
    return decodeURIComponent(escape(atob(output))); //polyfill https://github.com/davidchambers/Base64.js
  }

  function notify(type, message, title) {
    toastr.options = {
      closeButton: true,
      debug: false,
      positionClass: 'toast-top-full-width',
      onclick: null,
      showDuration: 1000,
      hideDuration: 1000,
      timeOut: 0,
      extendedTimeOut: 0,
      showEasing: 'swing',
      hideEasing: 'linear',
      showMethod: 'fadeIn',
      hideMethod: 'fadeOut'
    };

    toastr[type](message, title);
  }

  self.ddClient = function(options) {
    return new Client(options);
  }
  self.ddClient.polyfill = true

})(typeof self !== 'undefined' ? self : this);