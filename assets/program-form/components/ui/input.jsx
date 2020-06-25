import React from 'react'

import css from './input.scss?module'
import cn from 'classnames'


export const TextInput = ({placeholder = '', value, disabled = false, required = false, setValue}) => {
  return (
    <div className={cn(css.input, {[css.required]: required})}>
      <input
        type="text"
        value={value}
        placeholder={placeholder}
        required={required}
        disabled={disabled}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export const Textarea = ({placeholder = '', value, setValue, disableResize = true, large = false}) => {
  return (
    <textarea
      className={cn(
        css.textarea,
        {[css.resizeDisabled]: disableResize},
        {[css.large]: large},
      )}
      placeholder={placeholder}
      value={value}
      onChange={(event) => setValue(event.target.value)}
    />
  )
}
