import React from 'react'
import { SaveButton, TextInput, TextAreaInput } from '../../components/ui/inputs'
import MultipleSelect from '../../components/ui/multiple-select'


const ProviderForm = ({item, setItem, categories, disable, save}) => {
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

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default ProviderForm
