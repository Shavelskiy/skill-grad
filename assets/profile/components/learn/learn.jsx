import React from 'react'


const Learn = () => {
  return (
    <>
      <table className="table">
        <thead>
        <tr>
          <th>Название программы</th>
          <th>Категории</th>
          <th>Образовательная орг-я</th>
          <th>Дата</th>
          <th>Оценка</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>
            <a className="title-link" href="/pages/card-program.html">
              Маркетинг (многопрофильный бакалавриат «Маркетинг и управление продажами»)
            </a>
          </td>
          <td>Маркетинг, Офис, делопроизводство, Управление и бизнес</td>
          <td><a href="#">Колледж Московского финансово-юридического университета</a></td>
          <td><span className="date">12.02.2020</span></td>
          <td>
            <button className="open-learn button">Оставить оценку</button>
          </td>
        </tr>
        <tr>
          <td>
            <a className="title-link" href="/pages/card-program.html">
              Маркетинг (многопрофильный бакалавриат «Маркетинг и управление продажами»)
            </a>
          </td>
          <td>Маркетинг, Офис, делопроизводство, Управление и бизнес</td>
          <td><a href="#">Колледж Московского финансово-юридического университета</a></td>
          <td><span className="date">12.02.2020</span></td>
          <td>
            <div className="success-block">
              <div className="success">
                <span>Оценка поставлена</span>
                <i className="icon-correct"></i>
              </div>
              <a className="open-learn">посмотреть</a>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <div className="pagination mt-20">
        <a href="#">
          <span className="prev"></span>
        </a>
        <a href="#">1</a>
        <a className="active" href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">
          <span className="next"></span>
        </a>
      </div>

      {/*<div id="learn" className="modal">*/}
      {/*  <div className="modal-content">*/}
      {/*    <span className="close">&times;</span>*/}
      {/*    <div className="content">*/}
      {/*      <h4>Поставить оценку</h4>*/}
      {/*      <div className="modal-learn">*/}
      {/*        <div className="container-0">*/}
      {/*          <div className="modal-learn-header">*/}
      {/*            <span className="text">Программа</span>*/}
      {/*          </div>*/}
      {/*          <div className="modal-body">*/}
      {/*            <div className="container item">*/}
      {/*              <div className="col-lg-9 col-sm-4">*/}
      {/*                <p className="text">*/}
      {/*                  1) Программа полностью соответствовала поставленным задачам обучения <span*/}
      {/*                  className="red">*</span>*/}
      {/*                </p>*/}
      {/*              </div>*/}
      {/*              <div className="col-lg-3 col-sm-4">*/}
      {/*                <div className="block-level">*/}
      {/*                  <div className="level">*/}
      {/*                    <span data-tippy-content="Совсем нет" className="fill"></span>*/}
      {/*                    <span data-tippy-content="В малой степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                    <span data-tippy-content="В значительной степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                  </div>*/}
      {/*                  <p className="text-small">Выберите уровень</p>*/}
      {/*                </div>*/}
      {/*              </div>*/}
      {/*            </div>*/}
      {/*            <div className="container item">*/}
      {/*              <div className="col-lg-9 col-sm-4">*/}
      {/*                <p className="text">*/}
      {/*                  2) Полученные знания, навыки будут использованы мною в рабочей практике <span*/}
      {/*                  className="red">*</span>*/}
      {/*                </p>*/}
      {/*              </div>*/}
      {/*              <div className="col-lg-3 col-sm-4">*/}
      {/*                <div className="block-level">*/}
      {/*                  <div className="level">*/}
      {/*                    <span data-tippy-content="Совсем нет" className="fill"></span>*/}
      {/*                    <span data-tippy-content="В малой степени" className="fill"></span>*/}
      {/*                    <span className="fill"></span>*/}
      {/*                    <span data-tippy-content="В значительной степени" className="fill"></span>*/}
      {/*                    <span></span>*/}
      {/*                  </div>*/}
      {/*                  <p className="text-small accent">В значительной<br/>степени</p>*/}
      {/*                </div>*/}
      {/*              </div>*/}
      {/*            </div>*/}
      {/*            <div className="container item">*/}
      {/*              <div className="col-lg-9 col-sm-4">*/}
      {/*                <p className="text">*/}
      {/*                  3) Качество контентного сопровождения до и после обучения очень высокое (ответы на вопросы,*/}
      {/*                  консультации, предварительные задания, поддержка после обучения и т.д.) <span*/}
      {/*                  className="red">*</span>*/}
      {/*                </p>*/}
      {/*              </div>*/}
      {/*              <div className="col-lg-3 col-sm-4">*/}
      {/*                <div className="block-level">*/}
      {/*                  <div className="level">*/}
      {/*                    <span data-tippy-content="Совсем нет" className="fill"></span>*/}
      {/*                    <span data-tippy-content="В малой степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                    <span data-tippy-content="В значительной степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                  </div>*/}
      {/*                  <p className="text-small accent">Совсем нет</p>*/}
      {/*                </div>*/}
      {/*              </div>*/}
      {/*            </div>*/}
      {/*          </div>*/}
      {/*        </div>*/}
      {/*        <div className="container-0">*/}
      {/*          <div className="modal-learn-header">*/}
      {/*            <span className="text">Преподаватель</span>*/}
      {/*          </div>*/}
      {/*          <div className="modal-body">*/}
      {/*            <div className="container item">*/}
      {/*              <div className="col-lg-9 col-sm-4">*/}
      {/*                <p className="text">*/}
      {/*                  1) Программа полностью соответствовала поставленным задачам обучения <span*/}
      {/*                  className="red">*</span>*/}
      {/*                </p>*/}
      {/*              </div>*/}
      {/*              <div className="col-lg-3 col-sm-4">*/}
      {/*                <div className="block-level">*/}
      {/*                  <div className="level">*/}
      {/*                    <span data-tippy-content="Совсем нет" className="fill"></span>*/}
      {/*                    <span data-tippy-content="В малой степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                    <span data-tippy-content="В значительной степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                  </div>*/}
      {/*                  <p className="text-small">Выберите уровень</p>*/}
      {/*                </div>*/}
      {/*              </div>*/}
      {/*            </div>*/}
      {/*          </div>*/}
      {/*        </div>*/}
      {/*        <div className="container-0">*/}
      {/*          <div className="modal-learn-header">*/}
      {/*            <span className="text">Организация обучения</span>*/}
      {/*          </div>*/}
      {/*          <div className="modal-body">*/}
      {/*            <div className="container item">*/}
      {/*              <div className="col-lg-9 col-sm-4">*/}
      {/*                <p className="text">*/}
      {/*                  1) Программа полностью соответствовала поставленным задачам обучения <span*/}
      {/*                  className="red">*</span>*/}
      {/*                </p>*/}
      {/*              </div>*/}
      {/*              <div className="col-lg-3 col-sm-4">*/}
      {/*                <div className="block-level">*/}
      {/*                  <div className="level">*/}
      {/*                    <span data-tippy-content="Совсем нет" className="fill"></span>*/}
      {/*                    <span data-tippy-content="В малой степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                    <span data-tippy-content="В значительной степени"></span>*/}
      {/*                    <span></span>*/}
      {/*                  </div>*/}
      {/*                  <p className="text-small">Выберите уровень</p>*/}
      {/*                </div>*/}
      {/*              </div>*/}
      {/*            </div>*/}
      {/*          </div>*/}
      {/*        </div>*/}
      {/*        <div className="container-0">*/}
      {/*          <textarea placeholder="Введите ваш отзыв в данном поле" className="textarea" rows="7"></textarea>*/}
      {/*        </div>*/}
      {/*        <div className="container">*/}
      {/*          <div className="col-lg-12 col-sm-4">*/}
      {/*            <div className="shared">*/}
      {/*              <span>Поделиться оценкой в соцсетях:</span>*/}
      {/*              <ul>*/}
      {/*                <li><a href="#">*/}
      {/*                  <img src="/img/svg/vk.svg" alt=""/>*/}
      {/*                </a></li>*/}
      {/*                <li><a href="#">*/}
      {/*                  <img src="/img/svg/facebook.svg" alt=""/>*/}
      {/*                </a></li>*/}
      {/*                <li><a href="#">*/}
      {/*                  <img src="/img/svg/odnoklassniki.svg" alt=""/>*/}
      {/*                </a></li>*/}
      {/*              </ul>*/}
      {/*            </div>*/}
      {/*          </div>*/}
      {/*        </div>*/}
      {/*        <div className="container j-c-center">*/}
      {/*          <div className="col-lg-6 col-sm-4">*/}
      {/*            <button className="button-blue">Опубликовать</button>*/}
      {/*          </div>*/}
      {/*        </div>*/}
      {/*      </div>*/}
      {/*    </div>*/}
      {/*  </div>*/}
      {/*</div>*/}
    </>
  )
}

export default Learn
