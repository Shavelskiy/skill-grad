import React from 'react'
import {Link} from 'react-router-dom'

import css from './request.scss?module'
import cn from 'classnames'


const Request = ({link, programId, values, name}) => {
  return (
    <td className="col-sm-1">
      {/*<strong className="accent mobile">{name}</strong>*/}
      <Link to={link.replace(':id', programId)}>
        <div className={css.iconButton}>
          <span className={cn('icon', 'mail')}></span>
          <span className={css.buttonNotification}>12</span>
        </div>
      </Link>
      <p className={css.iconTotalText}>
        Всего: {values.total}
      </p>
    </td>
  )
}

export default Request
