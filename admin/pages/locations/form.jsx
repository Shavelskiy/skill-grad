import React, { useEffect, useState } from 'react'
import { BooleanInput, NumberInput, SaveButton, SelectInput, TextInput } from '../../components/ui/inputs'
import translate from '../../helpers/translate'
import { hideLoader, showLoader } from '../../redux/actions'
import axios from 'axios'
import { FETCH_ALL_LOCATIONS } from '../../utils/api/endpoints'
import { useDispatch } from 'react-redux'

const types = [
  {
    title: 'Страна',
    value: 'country',
  },
  {
    title: 'Регион',
    value: 'region',
  },
  {
    title: 'Город',
    value: 'city',
  },
]

const LocationForm = ({item, setItem, disable, save}) => {
  const dispatch = useDispatch()

  const [enableTranslate, setEnableTranslate] = useState(true)
  const [locations, setLocations] = useState([])

  useEffect(() => {
    dispatch(showLoader())

    axios.get(FETCH_ALL_LOCATIONS)
      .then(({data}) => {
        setLocations(data.locations)
        dispatch(hideLoader())
      })
  }, [])

  const setName = (name) => {
    if (enableTranslate) {
      setItem({...item, code: translate(name), name: name})
    } else {
      setItem({...item, name: name})
    }
  }

  const setCode = (code) => {
    setEnableTranslate(translate(item.name) === code)
    setItem({...item, code: code})
  }

  return (
    <form>
      <TextInput
        value={item.name}
        setValue={(name) => setName(name)}
        label="Название"
      />

      <TextInput
        value={item.code}
        setValue={(code) => setCode(code)}
        label="Символьный код"
      />

      <NumberInput
        value={item.sort}
        setValue={(sort) => setItem({...item, sort: sort})}
        label="Сортировка"
      />

      <BooleanInput
        checed={item.showInList}
        setValue={(showInList) => setItem({...item, showInList: showInList})}
        label="Показывать в списке"
      />

      <SelectInput
        options={types}
        value={item.type}
        setValue={(type) => setItem({...item, type: type})}
        label="Тип"
      />

      <SelectInput
        options={locations}
        value={item.parentLocation}
        setValue={(parentLocation) => setItem({...item, parentLocation: parentLocation})}
        label="Родительское местоположение"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default LocationForm
