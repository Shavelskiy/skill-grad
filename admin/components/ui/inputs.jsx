import React, { useState } from 'react'

import Button from './button'
import ReactQuill from 'react-quill'

import css from './inputs.scss?module'
import './wysiwyg.scss'
import cn from 'classnames'

export function TextInput({label, value, setValue, disabled = false}) {
  return (
    <div className={css.input}>
      <span className={css.label}>{label}</span>
      <input
        type="text"
        value={value}
        disabled={disabled}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  )
}

export function NumberInput({label, value, setValue, step = 100}) {
  return (
    <div className={css.input}>
      <span className={css.label}>{label}</span>
      <input
        type="number"
        value={value}
        step={step}
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

export function ImageInput({id = 1, label, uploadImage, setUploadImage}) {
  const handleImageUpdate = (event) => {
    const file = event.target.files[0]

    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/svg+xml') {
      return
    }

    setUploadImage(file)
  }

  const renderImage = () => {
    if (uploadImage === null) {
      return <></>
    }

    return <div className={css.imageContainer}><img src={URL.createObjectURL(uploadImage)}/></div>
  }

  const renderDeleteButton = () => {
    if (uploadImage === null) {
      return <></>
    }

    return (
      <Button
        text={'Удалить картинку'}
        danger={true}
        click={() => setUploadImage(null)}
      />
    )
  }

  return (<>
      <span className={css.label}>{label}</span>
      <div className={cn(css.input, css.img)}>
        {renderImage()}
        <div>
          <label htmlFor={`image-input-${id}`} className={css.imageInputBtn}>
            {uploadImage === null ? 'Выберите картинку' : 'Заменить картинку'}
          </label>
          {renderDeleteButton()}
          <input
            id={`image-input-${id}`}
            type="file"
            value=""
            onChange={(event) => handleImageUpdate(event)}
          />
        </div>
      </div>
    </>
  )
}

export function Wysiwyg({label, value, setValue}) {
  return (
    <div className={css.input}>
      <span className={css.label}>{label}</span>
      <ReactQuill theme="snow" value={value} onChange={setValue}/>
    </div>
  )
}
