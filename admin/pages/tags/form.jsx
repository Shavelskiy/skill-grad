import React from 'react'
import { NumberInput, SaveButton, TextInput } from '../../components/ui/inputs'

const TagForm = ({name, setName, sort, setSort, disable, save}) => {
  return (
    <form>
      <TextInput
        value={name}
        setValue={setName}
        label="Название"
      />

      <NumberInput
        value={sort}
        setValue={setSort}
        label="Сортировка"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default TagForm
