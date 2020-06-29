import React from 'react'

import { RESULTS } from '../../utils/titles'

import { useSelector, useDispatch } from 'react-redux'
import { setCertificate, setGainedKnowledge } from '../../redux/program/actions'

import Block from '../ui/block'
import { Textarea, TextInput } from '../ui/input'

import css from './result.scss?module'
import cn from 'classnames'

import addImage from './../../img/teacher-no-img.svg'
import realoadImg from './../../img/reload.svg'
import deleteImg from './../../img/delete-image.svg'


const Result = () => {
  const dispatch = useDispatch()

  const certificate = useSelector(state => state.program.certificate)

  const certificateImageId = 'add-certificate-image'

  const handleImageUpdate = (event) => {
    const file = event.target.files[0]

    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'application/pdf') {
      return
    }

    dispatch(setCertificate({name: certificate.name, file: file}))
  }

  const renderCertificateImage = () => {
    if (certificate.file === null) {
      return (
        <>
          <label className={css.addButton} htmlFor={certificateImageId}>
            <img src={addImage}/>
            Загрузить пример (jpg, pdf)
          </label>
        </>
      )
    }

    const imageUrl = certificate.file.type !== 'application/pdf' ? URL.createObjectURL(certificate.file) : addImage

    return (
      <>
        <img src={imageUrl}/>
        <div className={css.actions}>
          <label htmlFor={certificateImageId} className={css.reload}>
            <img src={realoadImg}/>
          </label>
          <img src={deleteImg} onClick={() => dispatch(setCertificate({name: certificate.name, file: null}))}/>
        </div>
      </>
    )
  }

  return (
    <Block title={RESULTS} containerClass={css.container}>
      <div>
        <Textarea
          placeholder={'Полученные знания, приобретенные навыки'}
          value={useSelector(state => state.program.gainedKnowledge)}
          setValue={(value) => dispatch(setGainedKnowledge(value))}
        />
      </div>

      <div className={cn(css.inputContainer, css.certificateContainer)}>
        <h3>Выдаваемый документ:</h3>
        <TextInput
          placeholder={'Название'}
          value={certificate.name}
          setValue={(value) => dispatch(setCertificate({name: value, file: certificate.file}))}
        />
        <div className={css.imageWrap}>
          {renderCertificateImage()}
          <input
            id={certificateImageId}
            type="file"
            onChange={(event) => handleImageUpdate(event)}
          />
        </div>
      </div>
    </Block>
  )
}

export default Result
