import React, { useEffect, useState } from 'react'
import { useDispatch } from 'react-redux'
import { hideLoader, showLoader } from '../../redux/actions'

import axios from 'axios'
import { FETCH_ALL_CATEGORIES, FETCH_ALL_LOCATIONS } from '../../utils/api/endpoints'

import { SaveButton, TextInput, TextAreaInput, ImageInput } from '../../components/ui/inputs'
import MultipleSelect from '../../components/ui/multiple-select'


const ProviderForm = ({item, setItem, uploadImage, setUploadImage, disable, save}) => {
  const dispatch = useDispatch()

  const [categories, setCategories] = useState([])
  const [locations, setLocations] = useState([])

  useEffect(() => {
    dispatch(showLoader())

    axios.get(FETCH_ALL_CATEGORIES)
      .then(({data}) => {
        setCategories(data.categories)
        dispatch(hideLoader())
      })
  }, [])

  useEffect(() => {
    dispatch(showLoader())

    axios.get(FETCH_ALL_LOCATIONS)
      .then(({data}) => {
        setLocations(data.locations)
        dispatch(hideLoader())
      })
  }, [])

  const getMainCategories = () => {
    return categories.filter(item => item.is_parent).map(item => {
      return {
        value: item.id,
        title: item.name,
      }
    })
  }

  const getCategories = () => {
    return categories.filter(item => !item.is_parent).map(item => {
      return {
        value: item.id,
        title: item.name,
      }
    })
  }

  return (
    <form>
      <TextInput
        value={item.name}
        setValue={(name) => setItem({...item, name: name})}
        label="Название организации"
      />

      <TextAreaInput
        value={item.description}
        setValue={(description) => setItem({...item, description: description})}
        label="Описание организации"
      />

      <ImageInput
        label="Картинка"
        uploadImage={uploadImage}
        imageSrc={item.image}
        deleteImageSrc={() => setItem({...item, image: null})}
        setUploadImage={setUploadImage}
      />

      <MultipleSelect
        options={getMainCategories()}
        values={item.mainCategories}
        setValue={(mainCategories) => setItem({...item, mainCategories: mainCategories})}
        high={false}
        label="Основные категории"
      />

      <MultipleSelect
        options={getCategories()}
        values={item.categories}
        setValue={(categories) => setItem({...item, categories: categories})}
        high={false}
        label="Подкатегории"
      />

      <MultipleSelect
        options={locations}
        values={item.locations}
        setValue={(locations) => setItem({...item, locations: locations})}
        high={false}
        label="Метоположения"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default ProviderForm
