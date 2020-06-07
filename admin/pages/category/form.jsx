import React from 'react'
import { NumberInput, SaveButton, TextInput } from '../../components/ui/inputs'

const CategoryForm = ({name, setName, sort, setSort, disable, parentCategory = null, save}) => {
  const renderParentCategoryInput = () => {
    if (parentCategory === null) {
      return <></>
    }

    return (
      <TextInput
        value={parentCategory.name}
        setValue={() => {
        }}
        label="Родительская категория"
        disabled={true}
      />
    )
  }

  return (
    <form>
      {renderParentCategoryInput()}

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

export default CategoryForm
