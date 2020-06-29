import React, { useRef } from 'react'

import { GALLERY } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { setGallery } from '../../redux/actions'

import Block from '../ui/block'

import css from './gallery.scss?module'

import deleteImage from './../../img/delete.svg'
import { Textarea } from '../ui/input'


const Gallery = () => {
  const imageInputId = 'gallery-image-input'

  const ref = useRef()
  const dispatch = useDispatch()

  const gallery = useSelector(state => state.gallery)

  const handleImageUpdate = (event) => {
    let newItems = []
    event.target.files.forEach(file => {
      if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/svg+xml') {
        return
      }

      newItems.push({name: '', image: file})
    })

    dispatch(setGallery([...gallery, ...newItems]))
  }

  const renderImageList = () => {
    return gallery.map((item, key) => {
      return (
        <div key={key} className={css.item}>
          <img src={URL.createObjectURL(item.image)} className={css.image}/>
          <img
            className={css.deleteImage}
            onClick={() => dispatch(setGallery(gallery.filter((item, itemKey) => itemKey !== key)))}
            src={deleteImage}
          />
          <Textarea
            placeholder={'Название фото'}
            value={item.name}
            setValue={(value) => dispatch(setGallery(gallery.map((item, itemKey) => itemKey === key ? {
              name: value,
              image: item.image
            } : item)))}
          />
        </div>
      )
    })
  }

  return (
    <Block
      title={GALLERY}
      link={'Добавить фотографии'}
      linkClick={() => ref.current.click()}
    >
      <input
        ref={ref}
        id={imageInputId}
        type={'file'}
        onChange={(event) => handleImageUpdate(event)}
        multiple={true}
      />
      <span>Качественные фотографии с мероприятий значительно повышают шанс выбора именно вашей программы</span>
      <div className={css.gallery}>
        {renderImageList()}
      </div>
    </Block>
  )
}

export default Gallery
