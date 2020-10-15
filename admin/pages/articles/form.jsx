import React  from 'react'
import { NumberInput, SaveButton, TextInput, Wysiwyg, ImageInput, BooleanInput } from '../../components/ui/inputs'

const ArticleForm = ({item, setItem, uploadImage, setUploadImage, disable, save}) => {
  return (
    <form>
      <TextInput
        value={item.name}
        setValue={(name) => setItem({...item, name: name})}
        label="Заголовок"
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

      <BooleanInput
        checked={item.showOnMain}
        setValue={(value) => setItem({...item, showOnMain: value})}
        label="Показывать на главной"
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

export default ArticleForm
