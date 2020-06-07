import React, { useState } from 'react'
import { NumberInput, SaveButton, TextInput } from '../../components/ui/inputs'
import translate from '../../helpers/translate'

const CategoryForm = ({item, setItem, disable, parentCategory = null, save}) => {
  const [enableTranslate, setEnableTranslate] = useState(true)

  const setName = (name) => {
    if (enableTranslate) {
      setItem({...item, slug: translate(name), name: name})
    } else {
      setItem({...item, name: name})
    }
  }

  const setSlug = (slug) => {
    setEnableTranslate(translate(item.name) === slug)
    setItem({...item, slug: slug})
  }

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
        value={item.name}
        setValue={(name) => setName(name)}
        label="Название"
      />

      <TextInput
        value={item.slug}
        setValue={(slug) => setSlug(slug)}
        label="Символьный код"
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

export default CategoryForm
