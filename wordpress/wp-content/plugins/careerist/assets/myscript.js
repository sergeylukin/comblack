!function n(o,s,c){function a(t,e){if(!s[t]){if(!o[t]){var r="function"==typeof require&&require;if(!e&&r)return r(t,!0);if(u)return u(t,!0);throw(e=new Error("Cannot find module '"+t+"'")).code="MODULE_NOT_FOUND",e}r=s[t]={exports:{}},o[t][0].call(r.exports,function(e){return a(o[t][1][e]||e)},r,r.exports,n,o,s,c)}return s[t].exports}for(var u="function"==typeof require&&require,e=0;e<c.length;e++)a(c[e]);return a}({1:[function(e,t,r){"use strict";function n(){document.querySelectorAll(".field-msg").forEach(function(e){return e.classList.remove("show")})}window.addEventListener("load",function(){for(var e=document.querySelectorAll("ul.nav-tabs > li"),t=0;t<e.length;t++)e[t].addEventListener("click",r);function r(e){e.preventDefault(),document.querySelector("ul.nav-tabs li.active").classList.remove("active"),document.querySelector(".tab-pane.active").classList.remove("active");var t=e.currentTarget,e=e.target.getAttribute("href");t.classList.add("active"),document.querySelector(e).classList.add("active")}}),document.addEventListener("DOMContentLoaded",function(e){var r=document.getElementById("careerist-sync-trigger-form");r.addEventListener("submit",function(e){e.preventDefault(),n();r.querySelector('[name="nonce"]').value;var e=r.dataset.url,t=new URLSearchParams(new FormData(r));r.querySelector(".js-form-submission").classList.add("show"),fetch(e,{method:"POST",body:t}).then(function(e){return e.json()}).catch(function(e){n(),r.querySelector(".js-form-error").classList.add("show")}).then(function(e){n(),0===e||"error"===e.status?r.querySelector(".js-form-error").classList.add("show"):(r.querySelector(".js-form-success").classList.add("show"),r.reset())})})})},{}]},{},[1]);
//# sourceMappingURL=myscript.js.map
