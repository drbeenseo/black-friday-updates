!function(t){"use strict";var i=t(".wp-deadline-flyout");if(i.hasClass("flyout-top")){document.body.style.marginTop=i.innerHeight()+"px";var n=i.find(".tg-close-btn");n.click(function(t){i.slideUp(),document.body.style.marginTop=0})}if(i.hasClass("flyout-bottom")){var n=i.find(".tg-close-btn");n.click(function(t){i.slideUp()})}}(jQuery);