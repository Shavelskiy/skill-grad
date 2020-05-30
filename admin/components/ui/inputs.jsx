import React from 'react'

import Button from './button'

import css from './inputs.scss?module'


export function TextInput({label, value, setValue}) {
  return (
    <div className={css.input}>
      <label>{label}</label>
      <input
        type="text"
        value={value}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export function NumberInput({label, value, setValue}) {
  return (
    <div className={css.input}>
      <label>{label}</label>
      <input
        type="number"
        value={value}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export function SaveButton({handler, disable}) {
  return (
    <div className={css.saveWrap}>
      <Button
        text={'Сохранить'}
        success={true}
        disabled={disable}
        click={handler}
      />
    </div>
  )
}
