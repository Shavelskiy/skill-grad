import {library, dom} from '@fortawesome/fontawesome-svg-core';
import {fas} from '@fortawesome/free-solid-svg-icons';
import {far} from '@fortawesome/free-regular-svg-icons';
import {fab} from '@fortawesome/free-brands-svg-icons';

import './index.scss';

const $ = require('jquery');
require('bootstrap-datepicker');

library.add(fas, far, fab);

dom.i2svg();

// $(function () {
//
//   var classes = {
//       cssActive: "active",
//       iconCollapse: "fa-chevron-right",
//       iconExpand: "fa-chevron-down",
//       iconFont: "fas",
//       container: "menu-container"
//     },
//     selectors = {},
//     config = {
//       animationSpeed: "fast"
//     };
//
//   for (var className in classes) {
//     selectors[className] = "." + classes[className];
//   }
//
//   function slideDown($icon) {
//     $icon.removeClass(classes.iconExpand).addClass(classes.iconCollapse);
//     $icon.parent().next().slideDown(config.animationSpeed);
//   }
//
//   function slideUp($icon) {
//     $icon.removeClass(classes.iconCollapse).addClass(classes.iconExpand);
//     $icon.parent().next().slideUp(config.animationSpeed);
//   }
//
//   function scrollActiveMenuItemIntoView() {
//     var $active = $(selectors.container + " " + selectors.cssActive);
//
//     $(selectors.container).animate({
//       scrollTop: $active.offset().top
//     });
//   }
//
//   // toggle expand/collapse of menu item on icon click
//   $(selectors.container).find(selectors.iconCollapse + "," + selectors.iconExpand).click(function (ev) {
//     ev.preventDefault();
//
//     var $icon = $(this);
//
//     if ($icon.hasClass(classes.iconCollapse)) {
//       slideUp($icon);
//     } else if ($icon.hasClass(classes.iconExpand)) {
//       slideDown($icon);
//     }
//   });
//
//   // collapse all menu items on page load
//   $(selectors.container + " " + selectors.iconCollapse).each(function (index) {
//     slideUp($(this));
//   });
//
//   // expands the active menu item and any parents of the active menu item
//   function expandMenuItems() {
//
//     function expandMenuItemsHelper($li) {
//
//       var $collapsedIcon = $li.children().find(selectors.iconFont).first();
//
//       if ($collapsedIcon.length) {
//         slideDown($collapsedIcon);
//       }
//
//       if ($li.parent().closest("li").length) {
//         expandMenuItemsHelper($li.parent().closest("li").first());
//       }
//     }
//
//     expandMenuItemsHelper($(selectors.container + " " + selectors.cssActive));
//   }
//
//   expandMenuItems();
//
//
//   setTimeout(function () {
//     $(selectors.container).show();
//     scrollActiveMenuItemIntoView();
//   }, 200);
// });

const userProfileButton = $('.user-profile');
const userProfileMenu = $('.user-profile-card');

const userProfileButtonDom = document.querySelector('.user-profile');
const userProfileMenuDom = document.querySelector('.user-profile-card');


$.fn.datepicker.dates['ru'] = {
  days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
  daysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
  daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
  months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
  monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
  today: 'Сегодня',
  clear: 'Очистить',
  format: 'mm.dd.yyyy',
  titleFormat: 'MM yyyy',
  weekStart: 0
};


$(document).ready(function () {
  userProfileButton.click(function () {
    userProfileMenu.toggleClass('user-profile-card-hidden');
  });

  $('.datepicker').datepicker({
    language: 'ru',
    orientation: 'bottom',
  });

  $('.filter-form-reset-btn').click(function () {
    const filterForm = $('.filter-form');
    filterForm.find('input').each(function (index, element) {
      $(element).removeAttr('value');
    });

    filterForm.find('select').each(function (index, element) {
      $(element).prop('selectedIndex', 0);
    });
  });
});

$(document).click(function (event) {
  if (!userProfileMenuDom.contains(event.target) && !userProfileButtonDom.contains(event.target)) {
    userProfileMenu.addClass('user-profile-card-hidden');
  }
});

