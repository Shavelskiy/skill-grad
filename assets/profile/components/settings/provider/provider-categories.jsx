import React, {useState, useEffect} from 'react'

import axios from 'axios'
import {ALL_CATEGORIES_URL} from '../../../utils/api/endpoints'

import Select from '../../../../components/react-ui/select'

import css from './provider-categories.scss?module'
import cn from 'classnames'


const ProviderCategories = ({selectedCategories, setSelectedCategories, selectedSubcategories, setSelectedSubcategories}) => {
  const [categories, setCategories] = useState([])
  const [openedChildCategory, setOpenedChildCategory] = useState(null)
  const [currentSelectedSubcategories, setCurrentSelectedSubcategories] = useState([])

  useEffect(() => {
    axios.get(ALL_CATEGORIES_URL)
      .then(({data}) => setCategories(data.categories))
  }, [])

  useEffect(() => {
    if (openedChildCategory === null) {
      setCurrentSelectedSubcategories([])
    }
  }, [openedChildCategory])

  useEffect(() => {
    setCurrentSelectedSubcategories(selectedSubcategories)
  }, openedChildCategory)

  const renderCategorySelect = (key) => {
    return (
      <div className="col-lg-3 col-md-12 col-sm-4" key={key}>
        <div className="select custom-select-wrapper">
          <Select
            placeholder={'Выбрать категорию'}
            value={selectedCategories[key]}
            options={
              categories.filter(
                category => selectedCategories.filter(
                  (selectedCategory, selectedCategoryKey) => (selectedCategoryKey !== key && selectedCategory === category.value)).length < 1
              )
            }
            setValue={(value) => setSelectedCategories(
              (selectedCategories) => selectedCategories.map(
                (category, categoryKey) => categoryKey === key ? value : category
              )
            )}
          />
        </div>
        {renderChildCategoriesSelect(key)}
      </div>
    )
  }

  const renderChildCategoriesSelect = (key) => {
    if (selectedCategories[key] === null) {
      return
    }

    const category = categories.filter(currentCategory => currentCategory.value === selectedCategories[key])[0]

    return (
      <div className={css.currentSelect}>
        {renderSelectedChildCategories(selectedCategories[key])}

        <span
          className={'blue-text'}
          onClick={() => setOpenedChildCategory(
            (openedChildCategory) => openedChildCategory === selectedCategories[key] ? null : selectedCategories[key])
          }
        >
            Добавить подкатегорию
          </span>

        <div className={cn(css.blockAddCategory, {[css.active]: openedChildCategory === selectedCategories[key]})}>
          <div className={css.container}>
            {renderChildCategoriesList(category)}
            <div className="col-lg-12 no-gutter">
              <button
                className={css.saveButton}
                onClick={() => {
                  setSelectedSubcategories(
                    (selectedSubcategories) => {
                      const newCategories = [...selectedSubcategories, ...(currentSelectedSubcategories.filter(
                        (selectedSubcategory) => !selectedSubcategories.includes(selectedSubcategory)
                      ))]

                      return newCategories.filter(
                        (selectedSubcategory) =>
                          category.child_items.filter(childItem => childItem.value === selectedSubcategory).length < 1 ||
                          currentSelectedSubcategories.includes(selectedSubcategory)
                      )
                    }
                  )

                  setOpenedChildCategory(null)
                }}
              >
                Сохранить
              </button>
            </div>
          </div>
        </div>
      </div>
    )
  }

  const renderSelectedChildCategories = (categoryId) => {
    if (categoryId === null) {
      return <></>
    }

    const category = categories.filter(currentCategory => currentCategory.value === categoryId)[0]

    return category.child_items.filter(childItem => selectedSubcategories.includes(childItem.value))
      .map((childItem, key) => (
          <div className={css.item} key={key}>
            <p className={css.text}>{childItem.title}</p>
            <span
              className={cn('icon', 'delete', css.delete)}
              onClick={() => setSelectedSubcategories(
                (selectedSubcategories) => selectedSubcategories.filter(
                  (selectedSubcategory) => selectedSubcategory !== childItem.value
                )
              )}
            ></span>
          </div>
        )
      )
  }

  const renderChildCategoriesList = (category) => {
    return category.child_items.map((childItem, key) => (
      <div
        key={key}
        className={cn('col-lg-12', 'no-gutter', css.childListItem)}
        onClick={() => setCurrentSelectedSubcategories(
          currentSelectedSubcategories => currentSelectedSubcategories.includes(childItem.value) ?
            currentSelectedSubcategories.filter(value => value !== childItem.value) :
            [...currentSelectedSubcategories, childItem.value]
        )}
      >
        <div
          className={cn(css.checkbox, {[css.selected]: currentSelectedSubcategories.includes(childItem.value)})}
        ></div>
        <div className={css.value}>
          {childItem.title}
        </div>
      </div>
    ))
  }

  return (
    <div className="container-0">
      <div className="col-lg-12 col-md-12 col-sm-4">
        <strong>Выберите <span className={'blue-text'}>основные категории</span> программ обучения и подкатегории
          (без ограничений): </strong>
      </div>
      <div className="container-0 mt-20 mb-20">
        {selectedCategories.map((category, key) => renderCategorySelect(key))}
        <div className="col-lg-3 col-md-12 col-sm-4 pl-0">
          <button
            className={css.addNewCategory}
            onClick={() => setSelectedCategories((selectedCategories) => [...selectedCategories, null])}
          >
            Добавить категорию
            <i className="icon-plus">
              <span className="path1"></span>
              <span className={cn('path2', css.path2)}></span>
            </i>
          </button>
        </div>
      </div>
    </div>
  )
}

export default ProviderCategories
