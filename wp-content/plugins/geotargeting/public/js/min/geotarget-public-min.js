!function($){"use strict";function e(e,t,n){if(n){var o=new Date;o.setTime(o.getTime()+24*n*60*60*1e3);var r="; expires="+o.toGMTString()}else var r="";document.cookie=e+"="+t+r+"; path=/"}function t(e){for(var t=e+"=",n=document.cookie.split(";"),o=0;o<n.length;o++){for(var r=n[o];" "==r.charAt(0);)r=r.substring(1,r.length);if(0==r.indexOf(t))return r.substring(t.length,r.length)}return null}$(document).ready(function(){$("#geot_dropdown").ddslick({onSelected:function(t){var n=t.selectedData.value;e("geot_country",n,999),window.location.reload()}})})}(jQuery);