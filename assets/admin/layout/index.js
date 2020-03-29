import {library, dom} from '@fortawesome/fontawesome-svg-core';
import {fas} from '@fortawesome/free-solid-svg-icons';
import {far} from '@fortawesome/free-regular-svg-icons';
import {fab} from '@fortawesome/free-brands-svg-icons';

import './index.scss';

const $ = require('jquery');
require('bootstrap-datepicker');

library.add(fas, far, fab);

dom.i2svg().then(r => {
});

let coll = document.getElementsByClassName('collapsible');
for (let i = 0; i < coll.length; i++) {
  coll[i].addEventListener('click', function () {
    this.classList.toggle('active');
    let content = this.nextElementSibling;
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + 'px';
    }
  });
}

let sidebarToggler = document.getElementsByClassName('sidebar-toggler')[0];
sidebarToggler.addEventListener('click', function () {
  this.classList.toggle('sidebar-toggler--active');
  let content = document.getElementsByClassName('main')[0];
  content.classList.toggle('main--active');
});

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

