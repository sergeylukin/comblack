!function a(n,o,c){function s(t,e){if(!o[t]){if(!n[t]){var r="function"==typeof require&&require;if(!e&&r)return r(t,!0);if(d)return d(t,!0);throw(e=new Error("Cannot find module '"+t+"'")).code="MODULE_NOT_FOUND",e}r=o[t]={exports:{}},n[t][0].call(r.exports,function(e){return s(n[t][1][e]||e)},r,r.exports,a,n,o,c)}return o[t].exports}for(var d="function"==typeof require&&require,e=0;e<c.length;e++)s(c[e]);return s}({1:[function(e,t,r){"use strict";function a(){document.querySelectorAll(".field-msg").forEach(function(e){return e.classList.remove("show")})}window.addEventListener("load",function(){for(var e=document.querySelectorAll("ul.nav-tabs > li"),t=0;t<e.length;t++)e[t].addEventListener("click",r);function r(e){e.preventDefault(),document.querySelector("ul.nav-tabs li.active").classList.remove("active"),document.querySelector(".tab-pane.active").classList.remove("active");var t=e.currentTarget,e=e.target.getAttribute("href");t.classList.add("active"),document.querySelector(e).classList.add("active")}document.querySelectorAll(".word span").forEach(function(e,t){e.addEventListener("click",function(e){e.target.classList.add("active")}),e.addEventListener("animationend",function(e){e.target.classList.remove("active")}),setTimeout(function(){e.classList.add("active")},750*(t+1))}),document.querySelectorAll(".js-taxonomy-selector").forEach(function(t){var r=t.dataset.url;t.addEventListener("change",function(e){e={taxonomy:t.dataset.taxonomy,careerist_id:t.dataset.careerist_id,id:e.target.value,action:t.dataset.action,nonce:t.dataset.nonce},e=new URLSearchParams(e);fetch(r,{method:"POST",body:e}).then(function(e){return e.json()}).then(function(e){})})})}),document.addEventListener("DOMContentLoaded",function(e){var r=document.getElementById("careerist-sync-trigger-form");r.addEventListener("submit",function(e){e.preventDefault(),a();r.querySelector('[name="nonce"]').value;var e=r.dataset.url,t=new URLSearchParams(new FormData(r));r.querySelector(".js-form-submission").classList.add("show"),fetch(e,{method:"POST",body:t}).then(function(e){return e.json()}).catch(function(e){a(),r.querySelector(".js-form-error").classList.add("show")}).then(function(e){a(),0===e||"error"===e.status?r.querySelector(".js-form-error").classList.add("show"):(r.querySelector(".js-form-success").classList.add("show"),r.reset())})})}),jQuery(document).ready(function(){var e=jQuery("#myTable"),r=jQuery("#myTable").DataTable({ajax:e[0].dataset.fetchUrl,columns:[{className:"dt-control",orderable:!1,data:null,defaultContent:""},{data:"adam_id"},{data:"name"},{data:"category"},{data:"subcategory"},{data:"post"}],order:[[1,"desc"]]});jQuery("#myTable tbody").on("click","td.dt-control",function(){var e=jQuery(this).parent(),t=r.row(e);t.child.isShown()?(t.child.hide(),e.removeClass("shown")):(t.child(function(e){var t,r="";for(t in r+='<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">',e)"adam"==t.slice(0,4)&&(r+="<tr><td>"+t.replace("adam_","")+":</td><td>"+e[t]+"</td></tr>");return r+="</table>"}(t.data())).show(),e.addClass("shown"))})})},{}]},{},[1]);
//# sourceMappingURL=myscript.js.map
