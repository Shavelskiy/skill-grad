import React  from 'react'
import { NumberInput, SaveButton, TextInput } from '../../components/ui/inputs'


const ProgramLevelForm = ({item, setItem, disable, save}) => {
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

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default ProgramLevelForm
