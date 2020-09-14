import React from 'react'

import css from './program-reviews.scss'

const ProgramReviews = () => {
  return (
    <>
      <div className="container-0 table-programs assessment mt-20">
        <h3 className="result-title"><span className="back"><i className="icon-left"></i><span className="back-text">Вернуться<br/>к программам</span></span>Оценки
          к программе<br className="show-mobile"/>«Производственный менеджмент»</h3>
        <table className="table">
          <thead>
          <tr>
            <th className="column__date">Дата/время</th>
            <th className="column__author">Автор заявки</th>
            <th>Оценка по параметрам</th>
            <th className="column__assessment">Средняя оценка</th>
            <th>Отзыв</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td className="name-block"><a href="#">Петракова Александра Анатольевна</a></td>
            <td className="review-block">
              <div className="reviews">
                <div className="value">
                  <div className="text">
                    <span className="title">Программа</span>
                    <span>
                                                            5
                                                            <span className="tooltip">
                                                                Полученные знания, навыки будут использованы мною
                                                                в рабочей практике
                                                            </span>
                                                        </span>

                    <span>5</span>
                    <span>4</span>
                  </div>
                  <div className="text">
                    <span className="title">Преподаватель</span>
                    <span>
                                                            5
                                                            <span className="tooltip">
                                                                Полученные знания, навыки будут использованы мною
                                                                в рабочей практике
                                                            </span>
                                                        </span>

                    <span>5</span>
                    <span>4</span>
                  </div>
                  <div className="text">
                    <span className="title">Организация обучения </span>
                    <span>
                                                            5
                                                            <span className="tooltip">
                                                                Полученные знания, навыки будут использованы мною
                                                                в рабочей практике
                                                            </span>
                                                        </span>

                    <span>5</span>
                    <span>4</span>
                  </div>
                  <div className="text average-text">
                    <span className="title accent">Средняя оценка </span>
                    <span className="accent">4.7</span>
                  </div>
                </div>
              </div>
            </td>
            <td className="average"><strong className="fz-18 accent">4.7</strong></td>
            <td>
                 <span className="reviews-text">Программа замечательная! Полностью соответствует заявленному описанию, преподаватель - настоящий знаток своего дела. Получила не только знания и навыки, но и массу впечатлений!
                <a className="hide-desktop" href="#">Скрыть отзыв</a>
                </span>
            </td>
            <td>
              <div className="buttons">
                <button className="open-reviews button-b">Ответить</button>
              </div>
            </td>
          </tr>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td className="name-block"><a href="#">Петракова Александра Анатольевна</a></td>
            <td className="review-block">
              <div className="reviews">
                <div className="value">
                  <div className="text">
                    <span className="title">Программа</span>
                    <span>
                                                            5
                                                            <span className="tooltip">
                                                                Полученные знания, навыки будут использованы мною
                                                                в рабочей практике
                                                            </span>
                                                        </span>

                    <span>5</span>
                    <span>4</span>
                  </div>
                  <div className="text">
                    <span className="title">Преподаватель</span>
                    <span>
                                                            5
                                                            <span className="tooltip">
                                                                Полученные знания, навыки будут использованы мною
                                                                в рабочей практике
                                                            </span>
                                                        </span>

                    <span>5</span>
                    <span>4</span>
                  </div>
                  <div className="text">
                    <span className="title">Организация обучения </span>
                    <span>
                                                            5
                                                            <span className="tooltip">
                                                                Полученные знания, навыки будут использованы мною
                                                                в рабочей практике
                                                            </span>
                                                        </span>

                    <span>5</span>
                    <span>4</span>
                  </div>
                  <div className="text average-text">
                    <span className="title accent">Средняя оценка </span>
                    <span className="accent">4.7</span>
                  </div>
                </div>
              </div>
            </td>
            <td className="average"><strong className="fz-18 accent">4.7</strong></td>
            <td className="reviews-text">
              Программа замечательная! Полностью соответствует заявленному описанию, преподаватель - настоящий знаток
              своего дела. Получила не только знания и навыки, но и массу впечатлений!
              <a className="hide-desktop" href="#">Скрыть отзыв</a>
            </td>
            <td className="support-block">
              <div className="supported">
                На отзыв дан ответ <i className="icon-correct"></i>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <div id="reviews" className="modal-review modal">
        <div className="modal-content">
          <span className="close">&times;</span>
          <div className="content">
            <h4>Ответить на отзыв</h4>
            <div className="textarea-box">
              <textarea className="textarea" rows="5" placeholder="Введите текст ответа"></textarea>
            </div>
            <button className="open-pay-account button-blue">Отправить ответ</button>
          </div>
        </div>
      </div>

      <div id="pay-account" className="modal-pay modal">
        <div className="modal-content">
          <span className="close">&times;</span>
          <div className="content">
            <div className="container-0">
              <div className="col-lg-12">
                <p className="text">Чтобы писать ответы на отзывы необходимо приобрести тариф Pro. Цена 1990 руб. с НДС
                  в месяц</p>
              </div>
              <div className="col-lg-6 col-sm-2">
                <button className="button-red">Отменить</button>
              </div>
              <div className="col-lg-6 col-sm-2">
                <button className="open-no-money button-blue">Купить</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="no-money" className="modal-money modal">
        <div className="modal-content">
          <span className="close">&times;</span>
          <div className="content">
            <div className="container-0">
              <div className="col-lg-12">
                <p className="text">На вашем счету<br/>недостаточно средств</p>
              </div>
              <div className="col-lg-6 col-sm-2">
                <button className="button-red">Отменить</button>
              </div>
              <div className="col-lg-6 col-sm-2">
                <button className="open-no-balance button-blue">Пополнить</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </>
  )
}

export default ProgramReviews
