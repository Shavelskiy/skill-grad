import React from 'react'
import {  NumberInput, SaveButton, TextInput } from '../../components/ui/inputs'


const LocationForm = ({item, setItem, disable, save}) => {
  return (
    <form>
      <TextInput
        value={item.title}
        setValue={() => {}}
        disabled={true}
        label="Название"
      />

      <NumberInput
        value={item.price}
        setValue={(price) => setItem({...item, price: price})}
        label="Цена"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default LocationForm
