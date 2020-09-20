import React from 'react'


const Input = ({type, placeholder, value, setValue}) => {
  return (
    <input
      type={type}
      className="input"
      placeholder={placeholder}
      value={value}
      onChange={({target}) => setValue(target.value)}
      autoComplete={'off'}
    />
  )
}

export default Input
