import React  from 'react'

import Modal from '../ui/modal'
import { Textarea, TextInput } from '../ui/input'
import Button from '../ui/button'

import css from './scss/new-provider-popup.scss?module'
import noImage from './../../../img/provider-image.png'
import reloadImg from '../../../img/svg/reload.svg'
import deleteTeacherImg from '../../../img/svg/delete.svg'


const ProviderFormPopup = ({active, close, provider, setProvider, submit, update = false}) => {
  const imageId = `add-new-provider-${update ? 'update' : 'create'}`

  const handleUploadImage = (event) => {
    const file = event.target.files[0]

    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/svg+xml') {
      return
    }

    setProvider({...provider, image: file})
  }

  const renderImage = () => {
    if (provider.image !== null) {
      return (
        <img src={URL.createObjectURL(provider.image)}/>
      )
    }

    return (
      <label className={css.noImage} htmlFor={imageId}>
        <img src={noImage}/>
      </label>
    )
  }

  const renderImageActions = () => {
    if (provider.image === null) {
      return <></>
    }

    return (
      <div className={css.actions}>
        <label htmlFor={imageId} className={css.reload}>
          <img src={reloadImg}/>
        </label>
        <img src={deleteTeacherImg} onClick={() => setProvider({...provider, image: null})}/>
      </div>
    )
  }

  return (
    <Modal
      active={active}
      close={close}
      title={update ? 'Редактирование провайдера' : 'Добавить нового провайдера'}
    >
      <div className={css.newProviderPopup}>
        <div className={css.mainContainer}>
          <div className={css.logoWrap}>
            {renderImage()}
            <input
              id={imageId}
              type="file"
              onChange={handleUploadImage}
            />
            {renderImageActions()}
          </div>
          <div className={css.mainInfo}>
            <div className={css.fieldWrap}>
              <TextInput
                placeholder={'Название организации'}
                value={provider.name}
                setValue={(name) => setProvider({...provider, name: name})}
              />
            </div>
            <div className={css.fieldWrap}>
              <TextInput
                placeholder={'Ссылка на интернет-ресурс организации'}
                value={provider.link}
                setValue={(link) => setProvider({...provider, link: link})}
              />
            </div>
          </div>
        </div>
        <div className={css.commentContainer}>
          <Textarea
            placeholder={'Комментарий'}
            medium={true}
            value={provider.comment}
            setValue={(comment) => setProvider({...provider, comment: comment})}
          />
        </div>
        <div className={css.buttonContainer}>
          <Button
            text={update ? 'Обновить' : 'Добавить'}
            red={!update}
            blue={update}
            click={submit}
          />
        </div>
      </div>
    </Modal>
  )
}

export default ProviderFormPopup
