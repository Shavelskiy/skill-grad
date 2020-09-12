import React from 'react'

import css from './programs.scss'

const Programs = () => {
  return (
    <div className="container-0 all-program active mt-20">
      <div className="tab">
        <div className="tab__nav">
          <ul className="nav">
            <li data-tab-name="tab-1" className="nav-item active">Активные</li>
            <li data-tab-name="tab-2" className="nav-item">Неактивные</li>
          </ul>
          <a href="/program-create" className="button-blue">Добавить программу обучения</a>
        </div>
        <div className="form-inline profile-search">
          <div className="input-search-gray">
            <input className="input search" type="text" placeholder="Поиск по каталогу"/>
            <i className="icon-search"></i>
          </div>
          <div className="select custom-select-wrapper">
            <div className="custom-select">
              <div className="custom-select__trigger"><span>Выберите категорию</span>
                <div className="arrow"></div>
              </div>
              <div className="custom-options scrollbar">
                <span className="custom-option category-option selected" data-value="tesla">Категория 1</span>
                <span className="custom-option category-option" data-value="volvo">Категория 2</span>
                <span className="custom-option category-option" data-value="mercedes">Категория 3</span>
              </div>
            </div>
          </div>
        </div>
        <div className="tab__content">
          <div className="tab__content-item tab-1 active">
            <table className="table">
              <thead>
              <tr>
                <th>Название программы</th>
                <th>Категории</th>
                <th>Заявки</th>
                <th>Вопросы</th>
                <th>Оценки</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td className="program-first-column">
                  <a className="title-link" href="/pages/card-program.html">
                    Маркетинг (многопрофильный бакалавриат «Маркетинг и управление продажами»)
                  </a>
                </td>
                <td className="mobile-p-b">
                  <a href="#">Маркетинг,</a>
                  <a href="#">Офис, </a>
                  <a href="#">Управление и бизнес</a>
                </td>
                <td className="col-sm-1">
                  <strong className="accent mobile">Заявки</strong>
                  <div data-name="applications" className="icon-button">
                    <span className="icon mail"></span>
                    <span className="button-notification">12</span>
                  </div>
                  <p className="text nowrap">
                    Всего: 121
                  </p>
                </td>
                <td className="col-sm-1">
                  <strong className="accent mobile">Вопросы</strong>
                  <div data-name="questions" className="icon-button">
                    <span className="icon mail"></span>
                    <span className="button-notification">12</span>
                  </div>
                  <p className="text nowrap">
                    Всего: 121
                  </p>
                </td>
                <td className="col-sm-1">
                  <strong className="accent mobile">Оценки</strong>
                  <div data-name="assessment" className="icon-button">
                    <span className="icon email-f"></span>
                  </div>
                  <p className="text nowrap">
                    Всего: 121
                  </p>
                </td>
                <td>
                  <div className="rules d-flex">
                    <span className="open-pay-service icon goal"></span>
                    <span data-tippy-content="Снять программус публикации"
                          className="open-deactivate icon status"></span>
                    <i className="open-no-balance icon-pencil">
                      <span className="path1"></span>
                      <span className="path2"></span>
                      <span className="path3"></span>
                    </i>
                    <span className="delete open-delete"></span>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <a className="title-link" href="/pages/card-program.html">
                    Маркетинг (многопрофильный бакалавриат «Маркетинг и управление продажами»)
                  </a>
                </td>
                <td className="mobile-p-b">
                  <a href="#">Маркетинг,</a>
                  <a href="#">Офис, </a>
                  <a href="#">Управление и бизнес</a>
                </td>
                <td className="col-sm-1">
                  <strong className="accent mobile">Заявки</strong>
                  <div data-name="applications" className="icon-button">
                    <span className="icon mail"></span>
                    <span className="button-notification">12</span>
                  </div>
                  <p className="text nowrap">
                    Всего: 121
                  </p>
                </td>
                <td className="col-sm-1">
                  <strong className="accent mobile">Вопросы</strong>
                  <div data-name="questions" className="icon-button">
                    <span className="icon mail"></span>
                    <span className="button-notification">12</span>
                  </div>
                  <p className="text nowrap">
                    Всего: 121
                  </p>
                </td>
                <td className="col-sm-1">
                  <strong className="accent mobile">Оценки</strong>
                  <div data-name="assessment" className="icon-button">
                    <span className="icon email-f"></span>
                  </div>
                  <p className="text nowrap">
                    Всего: 121
                  </p>
                </td>
                <td>
                  <div className="rules d-flex">
                    <span className="open-pay-service icon goal"></span>
                    <span data-tippy-content="Опубликовать программу"
                          className="open-deactivate icon not status"></span>
                    <i className="open-no-balance icon-pencil">
                      <span className="path1"></span>
                      <span className="path2"></span>
                      <span className="path3"></span>
                    </i>
                    <span className="delete open-delete"></span>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
            <div id="pay-service" className="pay-service modal">
              <div className="modal-content">
                <span className="close">&times;</span>
                <div className="content">
                  <h4>Выберите платную услугу</h4>
                  <div className="block-modal d-flex">
                    <p className="text"><strong>Выделить цветом</strong> <br/> на 30 дней</p>
                    <button className="button-b">Купить за 990 руб</button>
                  </div>
                  <div className="block-modal d-flex">
                    <p className="text"><strong>Однократно поднять</strong> <br/> в результатах поиска</p>
                    <button className="button-b">Купить за 490 руб</button>
                  </div>
                  <div className="block-modal d-flex">
                    <p className="text"><strong>Выделить цветом +</strong> <br/> <strong>Однократно поднять</strong></p>
                    <button className="button-r">Купить за 490 руб</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="deactivate" className="deactivate modal">
              <div className="modal-content">
                <span className="close">&times;</span>
                <div className="content delete-modal">
                  <p className="text--center">
                    Программ будет деактивирована и не видна пользователям
                  </p>
                  <p className="text--center">Она будет доступна во вкладке «Неактивные программы»</p>
                  <div className="buttons-deactivate d-flex">
                    <button className="button-red">Деактивировать программу</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="delete" className="deactivate modal">
              <div className="modal-content">
                <span className="close">&times;</span>
                <div className="content delete-modal">
                  <p className="text--center">
                    Вы хотите удалить данную программу без возможности восстановления?
                  </p>
                  <div className="buttons d-flex">
                    <button className="button-blue">Нет</button>
                    <button className="button-red">Да</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="no-balance" className="deactivate modal">
              <div className="modal-content">
                <span className="close">&times;</span>
                <div className="content delete-modal">
                  <p className="text--center">
                    На вашем счете недостаточно средств, пополните баланс
                  </p>
                  <div className="buttons-deactivate d-flex">
                    <button className="button-blue">Пополнить баланс</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div className="tab__content-item tab-2">
            2
          </div>
        </div>
      </div>
    </div>
  )
}

export default Programs
