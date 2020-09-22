import React from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setTeachers } from '../../redux/program/actions'

import { Textarea } from '@/components/react-ui/program-form/input'

import css from './scss/teachers.scss?module'

import deleteImage from '@/img/svg/delete.svg'
import addImage from '@/img/svg/teacher-add.svg'
import noImage from '@/img/svg/teacher-no-img.svg'
import reloadImg from '@/img/svg/reload.svg'
import deleteTeacherImg from '@/img/svg/delete-image.svg'


const Teachers = () => {
  const dispatch = useDispatch()
  const teachers = useSelector(state => state.program.teachers)

  const handleImageUpdate = (key, event) => {
    const file = event.target.files[0]

    if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/svg+xml') {
      return
    }

    dispatch(setTeachers(teachers.map((item, itemKey) => key === itemKey ? {name: item.name, image: file} : item)))
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
          <img src={reloadImg}/>
        </label>
        <img src={deleteTeacherImg} onClick={() => dispatch(setTeachers(teachers.map((item, itemKey) => key === itemKey ? {
          name: item.name,
          image: null,
        } : item)))}/>
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
            medium={true}
            setValue={(name) => dispatch(setTeachers(teachers.map((item, itemKey) => key === itemKey ? {
              name: name,
              image: item.image,
            } : item)))}
            value={teacher.name}
          />
          <img
            className={css.deleteButton}
            src={deleteImage}
            onClick={() => dispatch(setTeachers(teachers.filter((item, itemKey) => key !== itemKey)))}
          />
        </div>
      )
    })
  }

  const renderAddButton = () => {
    if (teachers.length > 5) {
      return
    }

    return (
      <button onClick={() => dispatch(setTeachers([...teachers, {image: null, name: ''}]))} className={css.addButton}>
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
