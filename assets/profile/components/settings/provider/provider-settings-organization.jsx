import React from 'react'

import css from './provider-settings-organization.scss'


const ProviderSettingsOrganization = () => {
  return (
    <div className="organ">
      <h3 className="result-title w-100">Настройки организации</h3>
      <div className="container-0">
        <div className="col-lg-12 col-md-12 col-sm-4">
          <div className="container-0">
            <div className="col-lg-2 col-md-12 col-sm-4">
              <div className="logo-organization">
                <img src="../../../../img/orig_(1).jpg" alt=""/>
                <div className="buttons">
                  <button className="button-b">Изменить</button>
                  <button className="button-r">Удалить</button>
                </div>
              </div>
            </div>
            <div className="col-lg-7 col-md-12 col-sm-4">
              <input className="input" type="text" placeholder="Название организации *"/>
              <textarea className="textarea" placeholder="Описание организации" rows="8"></textarea>
            </div>
          </div>
          <div className="container-0">
            <div className="col-lg-12 col-md-12 col-sm-4">
              <strong>Выберите <a href="#">основные категории</a> программ обучения (не более 3-х) и
                подкатегории (без ограничений): <span className="accent">*</span></strong>
            </div>
            <div className="container-0 mt-20">
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Выбрать категорию</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                      <span className="custom-option category-option selected" data-value="tesla">Архитектура и строительство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Безопасность и военное дело</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Гуманитарные науки</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Дизайн</span>
                      <span className="custom-option category-option selected" data-value="tesla">Информационные технологии</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Искусство и творчество</span>
                      <span className="custom-option category-option selected" data-value="tesla">История и культурология</span>
                      <span className="custom-option category-option selected" data-value="tesla">Кулинария и гастрономия</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Маркетинг</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медиа и коммуникации</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медицина</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Мода и красота</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Науки о земле</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Офис, делопроизводство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Педагогика и психология</span>
                    </div>
                  </div>
                </div>
                <div className="currentSelect">
                  <div className="item">
                    <p className="text">Геология и разведка полезных ископаемых</p>
                    <span className="delete"></span>
                  </div>
                  <div className="item">
                    <p className="text">Геология и разведка полезных ископаемых</p>
                    <span className="delete"></span>
                  </div>
                  <a className="add-category" href="javscript:void(0);">Добавить подкатегорию</a>
                  <div className="block-add-category">
                    <form className="container-0">
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <button className="button-b">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Выбрать категорию</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                      <span className="custom-option category-option selected" data-value="tesla">Архитектура и строительство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Безопасность и военное дело</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Гуманитарные науки</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Дизайн</span>
                      <span className="custom-option category-option selected" data-value="tesla">Информационные технологии</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Искусство и творчество</span>
                      <span className="custom-option category-option selected" data-value="tesla">История и культурология</span>
                      <span className="custom-option category-option selected" data-value="tesla">Кулинария и гастрономия</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Маркетинг</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медиа и коммуникации</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медицина</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Мода и красота</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Науки о земле</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Офис, делопроизводство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Педагогика и психология</span>
                    </div>
                  </div>
                </div>
                <div className="currentSelect">
                  <a className="add-category" href="javscript:void(0);">Добавить подкатегорию</a>
                  <div className="block-add-category">
                    <form className="container-0">
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <button className="button-b">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Выбрать категорию</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                      <span className="custom-option category-option selected" data-value="tesla">Архитектура и строительство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Безопасность и военное дело</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Гуманитарные науки</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Дизайн</span>
                      <span className="custom-option category-option selected" data-value="tesla">Информационные технологии</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Искусство и творчество</span>
                      <span className="custom-option category-option selected" data-value="tesla">История и культурология</span>
                      <span className="custom-option category-option selected" data-value="tesla">Кулинария и гастрономия</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Маркетинг</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медиа и коммуникации</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медицина</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Мода и красота</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Науки о земле</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Офис, делопроизводство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Педагогика и психология</span>
                    </div>
                  </div>
                </div>
                <div className="currentSelect">
                  <a className="add-category" href="javscript:void(0);">Добавить подкатегорию</a>
                  <div className="block-add-category">
                    <form className="container-0">
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <button className="button-b">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="container-0">
            <div className="col-lg-12 col-md-12 col-sm-4">
              <strong>Выберите <a href="#">дополнительные категории</a> программ обучения и подкатегории
                (без ограничений): </strong>
            </div>
            <div className="container-0 mt-20 mb-20">
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Выбрать категорию</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                      <span className="custom-option category-option selected" data-value="tesla">Архитектура и строительство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Безопасность и военное дело</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Гуманитарные науки</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Дизайн</span>
                      <span className="custom-option category-option selected" data-value="tesla">Информационные технологии</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Искусство и творчество</span>
                      <span className="custom-option category-option selected" data-value="tesla">История и культурология</span>
                      <span className="custom-option category-option selected" data-value="tesla">Кулинария и гастрономия</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Маркетинг</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медиа и коммуникации</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медицина</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Мода и красота</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Науки о земле</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Офис, делопроизводство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Педагогика и психология</span>
                    </div>
                  </div>
                </div>
                <div className="currentSelect">
                  <div className="item">
                    <p className="text">Геология и разведка полезных ископаемых</p>
                    <span className="delete"></span>
                  </div>
                  <div className="item">
                    <p className="text">Геология и разведка полезных ископаемых</p>
                    <span className="delete"></span>
                  </div>
                  <a className="add-category" href="javscript:void(0);">Добавить подкатегорию</a>
                  <div className="block-add-category">
                    <form className="container-0">
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <button className="button-b">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Выбрать категорию</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                      <span className="custom-option category-option selected" data-value="tesla">Архитектура и строительство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Безопасность и военное дело</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Гуманитарные науки</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Дизайн</span>
                      <span className="custom-option category-option selected" data-value="tesla">Информационные технологии</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Искусство и творчество</span>
                      <span className="custom-option category-option selected" data-value="tesla">История и культурология</span>
                      <span className="custom-option category-option selected" data-value="tesla">Кулинария и гастрономия</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Маркетинг</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медиа и коммуникации</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медицина</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Мода и красота</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Науки о земле</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Офис, делопроизводство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Педагогика и психология</span>
                    </div>
                  </div>
                </div>
                <div className="currentSelect">
                  <a className="add-category" href="javscript:void(0);">Добавить подкатегорию</a>
                  <div className="block-add-category">
                    <form className="container-0">
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <button className="button-b">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Выбрать категорию</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                      <span className="custom-option category-option selected" data-value="tesla">Архитектура и строительство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Безопасность и военное дело</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Гуманитарные науки</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Дизайн</span>
                      <span className="custom-option category-option selected" data-value="tesla">Информационные технологии</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Искусство и творчество</span>
                      <span className="custom-option category-option selected" data-value="tesla">История и культурология</span>
                      <span className="custom-option category-option selected" data-value="tesla">Кулинария и гастрономия</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Маркетинг</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медиа и коммуникации</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медицина</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Мода и красота</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Науки о земле</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Офис, делопроизводство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Педагогика и психология</span>
                    </div>
                  </div>
                </div>
                <div className="currentSelect">
                  <a className="add-category" href="javscript:void(0);">Добавить подкатегорию</a>
                  <div className="block-add-category">
                    <form className="container-0">
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <button className="button-b">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Выбрать категорию</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                      <span className="custom-option category-option selected" data-value="tesla">Архитектура и строительство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Безопасность и военное дело</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Гуманитарные науки</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Дизайн</span>
                      <span className="custom-option category-option selected" data-value="tesla">Информационные технологии</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Искусство и творчество</span>
                      <span className="custom-option category-option selected" data-value="tesla">История и культурология</span>
                      <span className="custom-option category-option selected" data-value="tesla">Кулинария и гастрономия</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Маркетинг</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медиа и коммуникации</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Медицина</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Мода и красота</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Науки о земле</span>
                      <span className="custom-option category-option selected"
                            data-value="tesla">Офис, делопроизводство</span>
                      <span className="custom-option category-option selected" data-value="tesla">Педагогика и психология</span>
                    </div>
                  </div>
                </div>
                <div className="currentSelect">
                  <a className="add-category" href="javscript:void(0);">Добавить подкатегорию</a>
                  <div className="block-add-category">
                    <form className="container-0">
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <label htmlFor="">
                          <input type="checkbox"/>
                          Бизнес в сфере моды
                        </label>
                      </div>
                      <div className="col-lg-12 no-gutter">
                        <button className="button-b">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4 pl-0">
                <button className="add-new-category">
                  Добавить категорию
                  <i className="icon-plus"><span className="path1"></span><span
                    className="path2"></span></i>
                </button>
              </div>
            </div>
          </div>
          <div className="container-0">
            <div className="col-lg-12 col-md-12 col-sm-4">
              <strong>Выберите регион показа программ обучения:</strong>
            </div>
            <div className="container-0 mt-20">
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Страна</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                                  <span className="custom-option category-option selected"
                                        data-value="tesla">Россия</span>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Регион</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                                  <span className="custom-option category-option selected"
                                        data-value="tesla">Алтай</span>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <div className="select custom-select-wrapper">
                  <div className="custom-select">
                    <div className="custom-select__trigger"><span>Город</span>
                      <div className="arrow"></div>
                    </div>
                    <div className="custom-options scrollbar">
                                  <span className="custom-option category-option selected"
                                        data-value="tesla">Москва</span>
                      <span className="custom-option category-option"
                            data-value="volvo">Санкт-Петербург</span>
                      <span className="custom-option category-option"
                            data-value="mercedes">Нижний Новгород</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="container-0">
            <div className="col-lg-12 col-md-12 col-sm-4">
              <strong>Реквизиты организации:</strong>
            </div>
            <div className="container-0 mt-20">
              <div className="col-lg-4 col-md-12 col-sm-4">
                <input type="text" className="input" placeholder="Наименование организации *"/>
              </div>
              <div className="col-lg-4 col-md-12 col-sm-4">
                <input type="text" className="input" placeholder="Юридический адрес *"/>
              </div>
              <div className="col-lg-4 col-md-12 col-sm-4 pr-0">
                <input type="text" className="input" placeholder="Почтовый адрес"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4 pl-0">
                <input type="text" className="input" placeholder="ИНН *"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <input type="text" className="input" placeholder="КПП"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <input type="text" className="input" placeholder="ОГРН *"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4 pr-0">
                <input type="text" className="input" placeholder="ОКПО"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4 pl-0">
                <input type="text" className="input" placeholder="Р/с *"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <input type="text" className="input" placeholder="К/с *"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <input type="text" className="input" placeholder="БИК *"/>
              </div>
              <div className="col-lg-3 col-md-12 col-sm-4">
                <input type="text" className="input" placeholder="Банк *"/>
              </div>
            </div>
            <div className="container-0 button-block">
              <div className="col-lg-3 col-md-12 col-sm-4">
                <button className="button-blue">
                  Сохранить настройки
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default ProviderSettingsOrganization