import React from 'react'

const NotFound = ({message = ''}) => {
  const msg = message ? message : 'Not found 404!!!'

  return (
    <div>
      <h1>{msg}</h1>
    </div>
  )
}

export default NotFound
