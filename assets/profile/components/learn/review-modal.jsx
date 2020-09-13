import React from 'react'

import Modal from '../modal/modal'

import cn from 'classnames'
import css from './review-modal.scss'

const ReviewModal = ({active, close}) => {
  return (
    <Modal
      active={active}
      close={close}
      width={true}
      title={'Поставить оценку'}
    >
      <div className="modal-learn">
        <div className="container-0">
          <div className="modal-learn-header">
            <span className="text">Программа</span>
          </div>
          <div className="modal-body">
            <div className="container item">
              <div className="col-lg-9 col-sm-4">
                <p className="text">
                  1) Программа полностью соответствовала поставленным задачам обучения <span
                  className="red">*</span>
                </p>
              </div>
              <div className="col-lg-3 col-sm-4">
                <div className="block-level">
                  <div className="level">
                    <span data-tippy-content="Совсем нет" className="fill"></span>
                    <span data-tippy-content="В малой степени"></span>
                    <span></span>
                    <span data-tippy-content="В значительной степени"></span>
                    <span></span>
                  </div>
                  <p className="text-small">Выберите уровень</p>
                </div>
              </div>
            </div>
            <div className="container item">
              <div className="col-lg-9 col-sm-4">
                <p className="text">
                  2) Полученные знания, навыки будут использованы мною в рабочей практике <span
                  className="red">*</span>
                </p>
              </div>
              <div className="col-lg-3 col-sm-4">
                <div className="block-level">
                  <div className="level">
                    <span data-tippy-content="Совсем нет" className="fill"></span>
                    <span data-tippy-content="В малой степени" className="fill"></span>
                    <span className="fill"></span>
                    <span data-tippy-content="В значительной степени" className="fill"></span>
                    <span></span>
                  </div>
                  <p className="text-small accent">В значительной<br/>степени</p>
                </div>
              </div>
            </div>
            <div className="container item">
              <div className="col-lg-9 col-sm-4">
                <p className="text">
                  3) Качество контентного сопровождения до и после обучения очень высокое (ответы на вопросы,
                  консультации, предварительные задания, поддержка после обучения и т.д.) <span
                  className="red">*</span>
                </p>
              </div>
              <div className="col-lg-3 col-sm-4">
                <div className="block-level">
                  <div className="level">
                    <span data-tippy-content="Совсем нет" className="fill"></span>
                    <span data-tippy-content="В малой степени"></span>
                    <span></span>
                    <span data-tippy-content="В значительной степени"></span>
                    <span></span>
                  </div>
                  <p className="text-small accent">Совсем нет</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="container-0">
          <div className="modal-learn-header">
            <span className="text">Преподаватель</span>
          </div>
          <div className="modal-body">
            <div className="container item">
              <div className="col-lg-9 col-sm-4">
                <p className="text">
                  1) Программа полностью соответствовала поставленным задачам обучения <span
                  className="red">*</span>
                </p>
              </div>
              <div className="col-lg-3 col-sm-4">
                <div className="block-level">
                  <div className="level">
                    <span data-tippy-content="Совсем нет" className="fill"></span>
                    <span data-tippy-content="В малой степени"></span>
                    <span></span>
                    <span data-tippy-content="В значительной степени"></span>
                    <span></span>
                  </div>
                  <p className="text-small">Выберите уровень</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="container-0">
          <div className="modal-learn-header">
            <span className="text">Организация обучения</span>
          </div>
          <div className="modal-body">
            <div className="container item">
              <div className="col-lg-9 col-sm-4">
                <p className="text">
                  1) Программа полностью соответствовала поставленным задачам обучения <span
                  className="red">*</span>
                </p>
              </div>
              <div className="col-lg-3 col-sm-4">
                <div className="block-level">
                  <div className="level">
                    <span data-tippy-content="Совсем нет" className="fill"></span>
                    <span data-tippy-content="В малой степени"></span>
                    <span></span>
                    <span data-tippy-content="В значительной степени"></span>
                    <span></span>
                  </div>
                  <p className="text-small">Выберите уровень</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="container-0">
          <textarea placeholder="Введите ваш отзыв в данном поле" className="textarea" rows="7"></textarea>
        </div>
        <div className="container">
          <div className="col-lg-12 col-sm-4">
            <div className="shared">
              <span>Поделиться оценкой в соцсетях:</span>
              <ul>
                <li><a href="#">
                  <img src="/img/svg/vk.svg" alt=""/>
                </a></li>
                <li><a href="#">
                  <img src="/img/svg/facebook.svg" alt=""/>
                </a></li>
                <li><a href="#">
                  <img src="/img/svg/ok.svg" alt=""/>
                </a></li>
              </ul>
            </div>
          </div>
        </div>
        <div className="container j-c-center">
          <div className="col-lg-6 col-sm-4">
            <button className="button-blue">Опубликовать</button>
          </div>
        </div>
      </div>
    </Modal>
  )
}

export default ReviewModal
