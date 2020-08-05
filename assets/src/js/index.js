import "./import/modules";
import {Rating} from './plugins/rating';
import {Slider} from './plugins/slider';

new Rating('rating');
new Rating('rating-2');
new Rating('rating-1');

if(window.matchMedia('(max-width: 768px)').matches) {
  new Slider('.slider-compare');
  new Slider('.slider-compare-2');
}

// Сокращене в сравнеии
const an = document.querySelectorAll('.compare__table-annotation');
if(an) {
  an.forEach((item)=> {
    const button = item.querySelector('button');
    if(button) {
      button.addEventListener('click', () => {
        const text =  item.querySelector('.annotation-text');
        text.classList.toggle('show');
        if(text.classList.contains('show')) {
          button.textContent = 'Свернуть';
        }else {
          button.textContent = 'Подробнее';
        }
        an.forEach((itm)=> {
          itm.classList.toggle('height');
        });
      });
    }
  });
}

// Сокращене в сравнеии
const pr = document.querySelectorAll('.compare__table-program');
if(pr) {
  pr.forEach((item)=> {
    const button = item.querySelector('button');
    if(button) {
      button.addEventListener('click', () => {
        const text =  item.querySelector('.hidden');
        text.classList.toggle('show');
        if(text.classList.contains('show')) {
          button.textContent = 'Свернуть';
        }else {
          button.textContent = 'Подробнее';
        }
        pr.forEach((itm)=> {
          itm.classList.toggle('height');
        });
      });
    }
  });
}

// Plugins
tippy('[data-tippy-content]', {
  theme: 'light',
  maxWidth: '300px',
  allowHTML: true
});

const tabService = () => {
  let tabNavs = document.querySelectorAll(`.nav-item`),
    tabContent = document.querySelectorAll(`.tab__content-item`),
    tabName;
  tabNavs.forEach((item) => {
    item.addEventListener('click', selectTabNav);
  });
  function selectTabNav() {
    tabNavs.forEach((item) => {
      // Удаляем активный класс у всех элементов навигации табов
      item.classList.remove('active');
    });
    this.classList.add('active');  // Добавляем активный укласс у элемента по которому кликнули
    tabName = this.getAttribute('data-tab-name'); // Получаем имя таба, который нам нужен
    selectTabContent(tabName); // Запускаем функцию, чтобы показать выбранный таб
  }
  function selectTabContent(tab) {
    // Проходим по всем табам и проверяем есть ли у элемента класс, равный имени таба(переменной tabName). Если есть, то добавляем класс активного таба, если нет, то удаляем этот класс
    tabContent.forEach((item) => {
      let classList = item.classList;
      classList.contains(tab) ? classList.add('active') : classList.remove('active');
    });
  }
};
tabService();

const range = document.querySelectorAll('.range-container');
const defaultStart = [100000, 500000];
if (range) {
  range.forEach(r => {
    const from = r.querySelector('.from');
    const before = r.querySelector('.before');
    if (from && before) {
      from.value = defaultStart[0];
      before.value = defaultStart[1];
      const rangeItem = r.querySelector('.range');
      noUiSlider.create(rangeItem, {
        start: defaultStart,
        connect: true,
        range: {
          'min': 0,
          'max': 1000000
        },
        step: 1,
      });
      from.addEventListener('input', function (e) {
        rangeItem.noUiSlider.set([+e.target.value, defaultStart[1]]);
        defaultStart[0] = +e.target.value;
      });
      before.addEventListener('input', function (e) {
        rangeItem.noUiSlider.set([defaultStart[0], +e.target.value]);
        defaultStart[1] = +e.target.value;
      });
    }
  });
}

let dropdown = () => {
  const itemDrop = document.querySelectorAll('.dropdown__menu-item');
  const back = document.querySelector('.dropdown > .wrapper > .back-drop');
  const close = document.querySelector('.dropdown > .wrapper > .close-drop');
  const open = document.querySelector('.open-drop');
  const dropdown = document.querySelector('.dropdown');
  if(close) {
    close.addEventListener('click', () => {
      dropdown.classList.remove('active');
    });
  }
  if(open) {
    open.addEventListener('click', () => {
      dropdown.classList.toggle('active');
    });
  }
  if(window.matchMedia('(max-width: 768px)').matches) {
    itemDrop.forEach((item, index) => {
      item.children[0].addEventListener('click', () => {
        if(item.children[2]) {
          itemDrop.forEach((i, idx) => {
            if (index !== idx) {
              i.classList.toggle('deactivate');
            }
          });
          item.children[2].classList.toggle('active');
          back.classList.add('active');
        }
      });
    });
    if(back) {
      back.addEventListener('click', () => {
        itemDrop.forEach((item, idx) => {
          if(item.classList.contains('deactivate')) {
            item.classList.remove('deactivate')
          }
          if(item.children[2] && item.children[2].classList.contains('active')) {
            console.log(item.children[2].classList.remove('active'));
          }
          back.classList.remove('active');
        });
      });
    }
  }
};
dropdown();

const openModal = (selectorModal) => {
  const modal = document.getElementById(selectorModal);
  const btn = document.querySelectorAll(`.open-${selectorModal}`);
  if (!modal) {
    return 0;
  }
  const span = modal.children[0].children[0];
  btn.forEach(b => {
    b.onclick = function() {
      modal.style.display = "block";
    };
  })
  span.onclick = function() {
    modal.style.display = "none";
  }
  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  }
}

openModal('change-city');
openModal('type-account');
openModal('auth');
openModal('reg');
openModal('restore-pass');
openModal('send-message');
openModal('add-favorites');
openModal('send-mail');
openModal('add-favorites');
openModal('send-mail');
openModal('change-city');
openModal('delete');
openModal('deactivate');
openModal('pay-service');
openModal('no-balance');
openModal('reject');
openModal('answer');
openModal('pay-balance');
openModal('learn');
openModal('callback');
openModal('add-publication');
openModal('reviews');
openModal('pay-account');
openModal('no-money');
openModal('not-available');
openModal('add-provider');
openModal('add-provider-select');
openModal('add-provider-form');
openModal('add-execl');

function openFilter() {
  document.querySelectorAll(`#open-filter`).forEach(filter => {
    filter.addEventListener('click', function() {
      if(this.children[0].classList.contains('icon-more')) {
        this.children[0].classList.remove('icon-more');
        this.children[0].classList.add('icon-no-entry');
      }else {
        this.children[0].classList.remove('icon-no-entry');
        this.children[0].classList.add('icon-more');
      }
      document.getElementById(`filter`).classList.toggle("active");
    });
  })
}
function toggleMenu() {
  document.querySelectorAll(`.toggle-menu`).forEach(filter => {
    filter.addEventListener('click', function() {
      this.children[1].classList.toggle('rotate-180');
      document.querySelectorAll('.toggle-item').forEach(item => {
        item.classList.toggle('show');
      });
    });
  })
}
function customSelect() {
  document.querySelectorAll('.select').forEach(select => {
    select.addEventListener('click', function() {
      this.querySelector('.custom-select').classList.toggle('open');
      this.querySelectorAll(`.custom-option`).forEach(option => {
        option.addEventListener('click', function() {
          if (!this.classList.contains('selected')) {
            this.parentNode.querySelector(`.custom-option.selected`).classList.remove('selected');
            this.classList.add('selected');
            this.closest('.custom-select').querySelector('.custom-select__trigger span').textContent = this.textContent;
          }
        })
      });
    })
  });
  window.addEventListener('click', function(e) {
    const selects = document.querySelectorAll('.select').forEach(select => {
      if (!select.contains(e.target)) {
        select.classList.remove('open');
      }
    });
  });
}
const openMessages = () => {
  const users = document.querySelectorAll('.users > .user');
  const messageBox = document.querySelector('.messages-content');
  const sidebarBox = document.querySelector('.messages-sidebar');
  const back = document.getElementById('back');
  if (users.length > 0) {
    users.forEach(user => {
      user.addEventListener('click', function () {
        messageBox.classList.toggle('active');
        sidebarBox.classList.toggle('active');
      })
    });
    back.addEventListener('click', () => {
      messageBox.classList.toggle('active');
      sidebarBox.classList.toggle('active');
    });
  }
}

openMessages();

toggleMenu();
openFilter();
customSelect();


const openProgram = () => {
  const allProgram = document.querySelector('.all-program');
  let activeContainer = '';
  const containers = {
    applications: document.querySelector('.applications'),
    questions: document.querySelector('.questions'),
    assessment: document.querySelector('.assessment')
  };
  const buttons = document.querySelectorAll('.icon-button');
  const backs = document.querySelectorAll('.back');
  buttons.forEach(button => {
    button.addEventListener('click', () => {
      allProgram.classList.toggle('active');
      activeContainer = button.dataset.name;
      containers[activeContainer].classList.toggle('active');
    });
  });
  backs.forEach(back => {
    back.addEventListener('click', () => {
      allProgram.classList.toggle('active');
      containers[activeContainer].classList.toggle('active');
    });
  });
};
openProgram();

const openCity = () => {
  if(window.matchMedia('(max-width: 768px)').matches) {
    const drop = document.querySelectorAll('.container-dropdown > .item > .circle-checkbox > input');
    if (!drop) {
      return 0;
    }
    drop.forEach(item => {
      item.onclick = () => {
        const subMobile = item.parentNode.parentNode.querySelector('.sub-mobile');
        if(subMobile) {
          subMobile.classList.toggle('active');
        }
      };
    });
  }else {
    const drop = document.querySelectorAll('.container-dropdown > .sub > .circle-checkbox > input');
    const sub = document.querySelector('.add-dropdown > .sub-container');
    if (!drop) {
      return 0;
    }
    drop.forEach(item => {
      item.onclick = () => {
        sub.classList.toggle('active');
      };
    });
  }
};
openCity();

const open = document.querySelector('#changeCity');
const button = document.querySelector('.open-changeCity');

if(button) {
  button.onclick = () => {
    open.classList.toggle('active');
  };
}

const element = document.querySelectorAll('.scroll-block');
element.forEach(item => {
  new SimpleBar(item, {
    direction: 'rlt',
    autoHide: false,
    scrollbarMinSize: 55,
    scrollbarMaxSize: 0,
    forceVisible: true
  });
});

const right = document.querySelectorAll('.dropdown__right');
right.forEach((item) => {
  item.addEventListener('mouseover', () => {
    document.querySelector('body').style.overflowY = 'hidden';
  });
  item.addEventListener('mouseout', () => {
    document.querySelector('body').style.overflowY = 'auto';
  });
});


// Кнопка в избранное блог

const likeButton = document.getElementById('button-like');
if(likeButton) {
  likeButton.addEventListener('click', (event) => {
    const target = event.target;
    target.classList.toggle('active');
  });
}

//

const moreButton = document.getElementById('more');
const hiddenBlock = document.getElementById('hidden-block');

if(moreButton && hiddenBlock) {
  moreButton.addEventListener('click', () => {
    hiddenBlock.classList.toggle('active');
    if(hiddenBlock.classList.contains('active')) {
      moreButton.textContent = 'Свернуть';
    } else {
      moreButton.textContent = 'Развернуть';
    }
  });
}
