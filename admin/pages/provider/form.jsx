import React, { useEffect, useState } from 'react'
import { useDispatch } from 'react-redux'
import { hideLoader, showLoader } from '../../redux/actions'

import axios from 'axios'
import { FETCH_ALL_CATEGORIES, FETCH_ALL_LOCATIONS } from '../../utils/api/endpoints'

import { SaveButton, TextInput, TextAreaInput, ImageInput, SelectInput, NumberInput } from '../../components/ui/inputs'
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

      <NumberInput
        label={'Баланс'}
        value={item.balance}
        setValue={(balance) => setItem({...item, balance: balance})}
      />

      <MultipleSelect
        options={getCategories()}
        values={item.categories}
        setValue={(categories) => setItem({...item, categories: categories})}
        high={false}
        label="Подкатегории"
      />

      <SelectInput
        options={locations}
        value={item.location}
        setValue={(location) => setItem({...item, location: location})}
        label="Метоположение"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default ProviderForm
