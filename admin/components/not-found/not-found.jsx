import React from 'react'
import css from './not-found.scss?module'

const NotFound = ({message = ''}) => {
  const msg = message ? message : 'Not found 404!!!'

  return (
    <div>
      <h1>{msg}</h1>
    </div>
  )
}

export default NotFound
