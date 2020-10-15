import React, { useState } from 'react'
import { SaveButton, TextInput, Wysiwyg } from '../../components/ui/inputs'
import translate from '../../helpers/translate'

const PageForm = ({item, setItem, disable, save}) => {
  const [enableTranslate, setEnableTranslate] = useState(true)

  const setTitle = (title) => {
    if (enableTranslate) {
      setItem({...item, slug: translate(title), title: title})
    } else {
      setItem({...item, title: title})
      setEnableTranslate(translate(title) === item.slug)
    }
  }

  const setSlug = (slug) => {
    setEnableTranslate(translate(item.title) === slug)
    setItem({...item, slug: slug})
  }

  return (
    <form>
      <TextInput
        value={item.title}
        setValue={(title) => setTitle(title)}
        label="Заголовок"
      />

      <TextInput
        value={item.slug}
        setValue={(slug) => setSlug(slug)}
        label="Символьный код"
      />

      <Wysiwyg
        value={item.content}
        setValue={(content) => setItem({...item, content: content})}
        label="Контент"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default PageForm
