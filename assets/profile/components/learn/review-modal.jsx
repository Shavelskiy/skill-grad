import React, {useState} from 'react'


import Modal from '../modal/modal'
import ModalRow from './modal-row'

import css from './review-modal.scss?module'


const ReviewModal = ({active, close, review, setReview, submit, isNew}) => {
  const [error, setError] = useState('')

  const changeRating = (group, index, value) => {
    if (!isNew) {
      return
    }

    setReview({
      ...review, rating: review.rating.map((groupValues, groupKey) => groupKey !== group ? groupValues :
        groupValues.map((currentValue, key) => key !== index ? currentValue : value)
      )
    })
  }

  const changeReview = (value) => {
    setReview({...review, review: value})
  }

  const saveReview = () => {
    setError('')

    if (review.rating.filter(item => item.filter(rating => rating === 0).length > 0).length > 0) {
      setError('Поставьте оценку всем параметрам')
      return
    }

    if (review.review.length < 1) {
      setError('Заполнить отзыв')
      return
    }

    submit()
  }

  const renderSaveButton = () => {
    if (!isNew) {
      return <></>
    }

    return (
      <div className="container j-c-center">
        <div className="col-lg-6 col-sm-4">
          <button
            className="button-blue"
            onClick={() => saveReview()}
          >
            Опубликовать
          </button>
        </div>
      </div>
    )
  }

  return (
    <Modal
      active={active}
      close={close}
      width={true}
      title={'Поставить оценку'}
      error={error}
    >
      <div className="container-0">
        <div className={css.header}>
          <span className={css.text}>Программа</span>
        </div>
        <div className={css.modalBody}>
          <ModalRow
            number={1}
            description={'Программа полностью соответствовала поставленным задачам обучения'}
            value={review.rating[0][0]}
            setValue={(value) => changeRating(0, 0, value)}
          />
          <ModalRow
            number={2}
            description={'Полученные знания, навыки будут использованы мною в рабочей практике'}
            value={review.rating[0][1]}
            setValue={(value) => changeRating(0, 1, value)}
          />
          <ModalRow
            number={3}
            description={'Качество контентного сопровождения до и после обучения очень высокое (ответы на вопросы, консультации, предварительные задания, поддержка после обучения и т.д.)'}
            value={review.rating[0][2]}
            setValue={(value) => changeRating(0, 2, value)}
          />
        </div>
      </div>

      <div className="container-0">
        <div className={css.header}>
          <span className={css.text}>Преподаватель</span>
        </div>
        <div className={css.modalBody}>
          <ModalRow
            number={1}
            description={'Преподаватель является экспертом в заявленной теме'}
            value={review.rating[1][0]}
            setValue={(value) => changeRating(1, 0, value)}
          />
        </div>
      </div>

      <div className="container-0">
        <div className={css.header}>
          <span className="text">Организация обучения</span>
        </div>
        <div className={css.modalBody}>
          <ModalRow
            number={1}
            description={'Раздаточные материалы программы понятны'}
            value={review.rating[2][0]}
            setValue={(value) => changeRating(2, 0, value)}
          />
          <ModalRow
            number={2}
            description={'Качество технического сопровождения (информирование, регистрация, навигация, аудитория, техническая поддержка) соотвествует высокому уровню'}
            value={review.rating[2][1]}
            setValue={(value) => changeRating(2, 1, value)}
          />
        </div>
      </div>
      <div className="container-0">
          <textarea
            placeholder="Введите ваш отзыв в данном поле"
            className="textarea"
            rows="7"
            value={review.review}
            disabled={!isNew}
            onChange={(event) => changeReview(event.target.value)}
          ></textarea>
      </div>
      <div className="container">
        <div className="col-lg-12 col-sm-4">
          <div className={css.shared}>
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
      {renderSaveButton()}
    </Modal>
  )
}

export default ReviewModal
