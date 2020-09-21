import React  from 'react'
import { NumberInput, SaveButton, TextInput, BooleanInput } from '../../components/ui/inputs'


const ProgramFormatForm = ({item, setItem, disable, save}) => {
  return (
    <form>
      <TextInput
        value={item.name}
        setValue={(name) => setItem({...item, name: name})}
        label="Название"
      />

      <NumberInput
        value={item.sort}
        setValue={(sort) => setItem({...item, sort: sort})}
        label="Сортировка"
      />

      <BooleanInput
        checked={item.active}
        setValue={(value) => setItem({...item, active: value})}
        label="Активность"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default ProgramFormatForm
