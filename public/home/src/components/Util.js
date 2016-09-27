export function notify(type, message, title, timeOut) {
  if (typeof timeOut == "undefined") {
    timeOut = 5000;
  }
  
  toastr.options = {
    closeButton: true,
    debug: false,
    positionClass: 'toast-top-right',
    onclick: null,
    showDuration: 1000,
    hideDuration: 1000,
    timeOut: timeOut,
    extendedTimeOut: 1000,
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut'
  };

  toastr[type](message, title);
}
