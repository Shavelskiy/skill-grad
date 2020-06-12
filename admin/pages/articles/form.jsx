import React, { useState } from 'react'
import { NumberInput, SaveButton, TextInput, Wysiwyg, ImageInput } from '../../components/ui/inputs'
import translate from '../../helpers/translate'

const ArticuleForm = ({item, setItem, uploadImage, setUploadImage, disable, save}) => {
  const [enableTranslate, setEnableTranslate] = useState(true)

  const setName = (name) => {
    if (enableTranslate) {
      setItem({...item, slug: translate(name), name: name})
    } else {
      setItem({...item, name: name})
      setEnableTranslate(translate(name) === item.slug)
    }
  }

  const setSlug = (slug) => {
    setEnableTranslate(translate(item.name) === slug)
    setItem({...item, slug: slug})
  }

  return (
    <form>
      <TextInput
        value={item.name}
        setValue={(name) => setName(name)}
        label="Заголовок"
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

      <ImageInput
        label="Картинка"
        uploadImage={uploadImage}
        imageSrc={item.image}
        deleteImageSrc={() => setItem({...item, image: null})}
        setUploadImage={setUploadImage}
      />

      <Wysiwyg
        value={item.detailText}
        setValue={(detailText) => setItem({...item, detailText: detailText})}
        label="Детальное описание"
      />

      <SaveButton handler={save} disable={disable}/>
    </form>
  )
}

export default ArticuleForm
