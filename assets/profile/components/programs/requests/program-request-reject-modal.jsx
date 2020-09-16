import React from 'react'
import Modal from '../../modal/modal'

const ProgramRequestRejectModal = ({active, close, reason, setReason, submit}) => {
  return (
    <Modal
      active={active}
      close={close}
      title={'Отклонить заявку'}
    >
      <div className="textarea-box">
        <textarea
          className="textarea"
          rows="5"
          placeholder="Укажите причину отказа"
          value={reason}
          onChange={(event) => setReason(event.target.value)}
        ></textarea>
      </div>
      <button className="button-red" onClick={submit}>Отклонить заявку</button>
    </Modal>
  )
}

export default ProgramRequestRejectModal
