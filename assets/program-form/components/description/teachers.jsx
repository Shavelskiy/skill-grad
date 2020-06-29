import React from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { addTeacher, deleteTeacher, setTeacherName, setTeacherImage, deleteTeacherImage } from '../../redux/actions'

import css from './teachers.scss?module'
import { Textarea } from '../ui/input'

import deleteImage from './../../img/delete.svg'
import addImage from './../../img/teacher-add.svg'
import noImage from './../../img/teacher-no-img.svg'
import realoadImg from './../../img/reload.svg'
import deleteTeacherImg from './../../img/delete-image.svg'


const Teachers = () => {
  const dispatch = useDispatch()
  const teachers = useSelector(state => state.teachers)

  const handleImageUpdate = (key, event) => {
    const file = event.target.files[0]

    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/svg+xml') {
      return
    }

    dispatch(setTeacherImage(key, file))
  }

  const renderImage = (image, imageId) => {
    if (image !== null) {
      return (
        <img src={URL.createObjectURL(image)}/>
      )
    }

    return (
      <label className={css.noImage} htmlFor={imageId}>
        <img src={noImage}/>
        Загрузить фото
      </label>
    )
  }

  const renderImageActions = (key, image, imageId) => {
    if (image === null) {
      return <></>
    }

    return (
      <div className={css.actions}>
        <label htmlFor={imageId} className={css.reload}>
          <img src={realoadImg}/>
        </label>
        <img src={deleteTeacherImg} onClick={() => dispatch(deleteTeacherImage(key))}/>
      </div>
    )
  }

  const renderTeacherList = () => {
    return teachers.map((teacher, key) => {
      const imageId = `image-teacher-${key}`
      return (
        <div key={key} className={css.teacher}>
          <div className={css.imageContainer}>
            <div className={css.imageWrap}>
              {renderImage(teacher.image, imageId)}
            </div>
            <input
              id={imageId}
              type="file"
              onChange={(event) => handleImageUpdate(key, event)}
            />
            {renderImageActions(key, teacher.image, imageId)}
          </div>
          <Textarea
            placeholder={'ФИО'}
            setValue={(name) => dispatch(setTeacherName(key, name))}
            large={true}
            value={teacher.name}
          />
          <img
            className={css.deleteButton}
            src={deleteImage}
            onClick={() => dispatch(deleteTeacher(key))}
          />
        </div>
      )
    })
  }

  const renderAddButton = () => {
    if (teachers.length > 3) {
      return
    }

    return (
      <button onClick={() => dispatch(addTeacher())} className={css.addButton}>
        <img src={addImage}/>
        Добавить преподавателя
      </button>
    )
  }

  return (
    <>
      <h3>Преподаватели:</h3>
      <div className={css.teacherContainer}>
        {renderTeacherList()}
        {renderAddButton()}
      </div>
    </>
  )
}

export default Teachers
