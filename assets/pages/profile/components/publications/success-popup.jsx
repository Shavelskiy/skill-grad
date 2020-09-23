import React from 'react'

const SuccessPopup = () => {
  return (
    <div id="callback" className="modal callback">
      <div className="modal-content">
        <span className="close">&times;</span>
        <div className="content">
          <p className="text-bold">
            Ваша статья направлена модератору.
          </p>
          <p className="text-bold">
            После модерации она будет опубликована.
          </p>
        </div>
      </div>
    </div>
  )
}

export default SuccessPopup
