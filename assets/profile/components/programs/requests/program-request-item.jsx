import React, {useState} from 'react'

import axios from 'axios'
import {AGREE_PROGRAM_REQUEST, REJECT_PROGRAM_REQUEST} from '../../../utils/api/endpoints'

import dateFormat from '../../../helpers/date-fromater'

import ProgramRequestRejectModal from './program-request-reject-modal'

import css from './program-request-item.scss?module'


const ProgramRequestItem = ({request, reload}) => {
  const [rejectModalActive, setRejectModalActive] = useState(false)
  const [rejectReason, setRejectReason] = useState('')

  const renderButtons = () => {
    switch (request.status) {
      case 'new':
        return (
          <div className={css.buttons}>
            <button className={css.buttonR} onClick={() => setRejectModalActive(true)}>Отклонить</button>
            <button className={css.buttonB} onClick={() => agreeRequest()}>Подтвердить</button>
          </div>
        )
      case 'agree':
        return (
          <div className={css.supported}>
            Заявка подтверждена <i className="icon-correct"></i>
          </div>
        )
      case 'reject':
        return (
          <div className={css.rejected}>
            Заявка отклонена <i className="icon-cancel"></i>
          </div>
        )
    }
  }

  const agreeRequest = () => {
    axios.post(AGREE_PROGRAM_REQUEST.replace(':id', request.id))
      .finally(() => reload())
  }

  const rejectRequest = () => {
    axios.post(REJECT_PROGRAM_REQUEST.replace(':id', request.id), {
      reason: rejectReason
    })
      .finally(() => {
        setRejectModalActive(false)
        reload()
      })
  }

  return (
    <tr>
      <td>{dateFormat(new Date(request.date))} <br/> 19:33</td>
      <td className="name-block">
        <a href="#">{request.user_name}</a>
      </td>
      <td className="contact">
        <a className="d-flex" href="#">{request.contacts.email}</a>
        +7 (900) 644-66-98
      </td>
      <td className="reviews-text">
        <p className="text">{request.comment}</p></td>
      <td>
        {renderButtons()}
      </td>
      <td>
        <ProgramRequestRejectModal
          active={rejectModalActive}
          reason={rejectReason}
          setReason={setRejectReason}
          submit={rejectRequest}
        />
      </td>
    </tr>
  )
}

export default ProgramRequestItem
